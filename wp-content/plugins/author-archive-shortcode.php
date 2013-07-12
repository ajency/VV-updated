<?php
/*
Plugin Name: VV Author Listing
Plugin URI: http://ajency.in
Description: Create a simple shortcode to list our WordPress authors.
Author: Ajency
Version: 1.0
Author URI: http://ajency.in
Modified Code Source: http://wp.smashingmagazine.com/2012/06/05/front-end-author-listing-user-search-wordpress/
*/

function sul_user_listing($atts, $content = null) {
	global $post;
	
	extract(shortcode_atts(array(
		"role" => '',
		"number" => '10'
	), $atts));
	
	$role = sanitize_text_field($role);
	$number = sanitize_text_field($number);

	// We're outputting a lot of HTML, and the easiest way 
	// to do it is with output buffering from PHP.
	ob_start();
	
	// Get the Search Term
	$search = ( isset($_GET["as"]) ) ? sanitize_text_field($_GET["as"]) : false ;
	
	// Get Query Var for pagination. This already exists in WordPress
	$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	// Calculate the offset (i.e. how many users we should skip)
	$offset = ($page - 1) * $number;
	
	if ($search){
		// Generate the query based on search field
		$my_users = new WP_User_Query( 
			array( 
				'role' => $role, 
				'search' => '*' . $search . '*' 
			));
	} else {
		// Generate the query 
		$my_users = new WP_User_Query( 
			array( 
				'role' => 'author', 
				'offset' => $offset ,
				'number' => $number
			));
	}
	
	
	// Get the total number of authors. Based on this, offset and number 
	// per page, we'll generate our pagination. 
	$total_authors = $my_users->total_users;

	// Calculate the total number of pages for the pagination
	$total_pages = intval($total_authors / $number) + 1;

	// The authors object. 
	$authors = $my_users->get_results();
?>
	
	<div class="author-search">
		<h5>Search authors by name</h5>
		<form method="get" id="sul-searchform" action="<?php the_permalink() ?>" class="form-inline">
			<div class="input-append">
				<input type="text" class="span4" name="as" id="sul-s" placeholder="Search Authors" />
				<button type="submit" class="btn" name="submit" id="sul-searchsubmit" style="line-height:22px;"><i class="icon-search"></i></button>
			</div>
		</form>
		<?php 
		if($search){ ?>
			<h5>Search Results for: <em style="color: #2B6A78;"><?php echo $search; ?></em></h5>
			<a href="<?php the_permalink(); ?>"><i class="icon-angle-left"></i> Back To Author Listing</a>
		<?php } ?>
	</div><!-- .author-search -->
	
<?php if (!empty($authors))	 { ?>
	<ul class="author-gallery">
<?php
	// loop through each author
	foreach($authors as $author){
		$author_info = get_userdata($author->ID);
		?>
		<li>
			<a href="<?php echo get_author_posts_url($author->ID); ?>" class="author-pic"><?php echo get_avatar( $author->ID, 'thumbnail' ); ?></a>
			<h6><a href="<?php echo get_author_posts_url($author->ID); ?>"><?php echo $author_info->display_name; ?></a></h6>
		</li>
		<?php
	}
?>
	</ul> <!-- .author-list -->
<?php } else { ?>
	<h2>No authors found</h2>
<?php } //endif ?>

	<nav id="nav-single" style="clear:both; float:none; margin-top:20px; border-top: 1px solid #efefef;">
		<ul class="pager" style="margin-left: 0;">
		<?php if ($page != 1) { ?>
			<li class="previous">
				<a rel="prev" href="<?php the_permalink() ?>page/<?php echo $page - 1; ?>/"><i class="icon-angle-left"></i> Previous</a>
			</li>
		<?php } ?>
		
		<?php if ($page < $total_pages ) { ?>
			<li class="next">
				<a rel="next" href="<?php the_permalink() ?>page/<?php echo $page + 1; ?>/">Next <i class="icon-angle-right"></i></a>
			</li>
		<?php } ?>
		</ul>
	</nav>

	
	<?php 
	// Output the content.
	$output = ob_get_contents();
	ob_end_clean();

	
	// Return only if we're inside a page. This won't list anything on a post or archive page. 
	if (is_page()) return  $output;

}

// Add the shortcode to WordPress. 
add_shortcode('userlisting', 'sul_user_listing');
?>