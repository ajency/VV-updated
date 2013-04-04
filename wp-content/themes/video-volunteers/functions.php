<?php
// Setup  -- Probably want to keep this stuff... 

/**
 * Hello and welcome to Base! First, lets load the PageLines core so we have access to the functions 
 */	
require_once( dirname(__FILE__) . '/setup.php' );
	
// For advanced customization tips & code see advanced file.
	//--> require_once(STYLESHEETPATH . "/advanced.php");
	
// ====================================================
// = YOUR FUNCTIONS - Where you should add your code  =
// ====================================================


// ABOUT HOOKS --------//
	// Hooks are a way to easily add custom functions and content to PageLines. There are hooks placed strategically throughout the theme 
	// so that you insert code and content with ease.


// ABOUT FILTERS ----------//

	// Filters allow data modification on-the-fly. Which means you can change something after it was read and compiled from the database,
	// but before it is shown to your visitor. Or, you can modify something a visitor sent to your database, before it is actually written there.

// FILTERS EXAMPLE ---------//

	// The following filter will add the font  Ubuntu into the font array $thefoundry.
	// This makes the font available to the framework and the user via the admin panel.

function output_css_js() {
	
	echo '<link href="http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700,300,800" rel="stylesheet" type="text/css">';
	
	
}

add_action('pagelines_head_last','output_css_js',10);	
	
	
/****Header Bar Output****/
function output_header_bar() {
	echo '<div class="texture"><div class="content"><div class="content-pad"><div class="logo-bar fix">';
	echo '<a href="'. get_bloginfo('url') .'" class="logo-link"><img src="'. get_bloginfo('stylesheet_directory') .'/images/site-logo.png" alt="Video Volunteers" /></a>';
	echo '<div class="impact fix">';
	echo '<div class="impact-image">';
	echo '<a href="#"><img src="'. get_bloginfo('stylesheet_directory') .'/images/impact.png" alt="Video Volunteers" /></a>';
	echo '</div>';
	echo '<div class="impact-desc">';
	echo '<p>If I were you, I would try to stick a gnome in sideways so Sally can sell sea shells by the sea shore. Westside.</p><a href="'. get_bloginfo('url') .'" class="more-link"><i class="icon-plus"></i>&nbsp;More</a>';
	echo '</div>';
	echo '</div></div></div></div></div>';
}

add_action('pagelines_before_navbar','output_header_bar',10);

/****Search Form Icon****/
function search_form_icon() {
	echo '<span class="search-icon"><i class="icon-search"></i></span>';
}

add_action('get_search_form','search_form_icon',10);

/****Tag Line Output****/
function output_tag_line() {
	if ( is_front_page() ) {
		echo '<div class="texture"><div class="content"><div class="content-pad"><div class="tag-line fix">';
		echo '<h3>We train marginalised communities to produce</h3>';
		echo '<h1><em>News</em>, <em>Watch It</em>, <em>Take Action</em> &amp; <em>Devise Solutions</em>.</h1>';
		echo '</div></div></div></div></div>';
	}
	else {
		//Do not output Tag Line
	}
}

add_action('pagelines_after_navbar','output_tag_line',10);

/****Output Titles for Homepage Boxes****/
function output_homepage_titles() {
	echo '<div class="action-titles"><h3 class="main-title hide">What Can You Do Here?</h3>';
}

add_action('pagelines_inside_bottom_boxes', 'output_homepage_titles',1);

/****Output Social Bar in Content****/
add_filter ('the_content', 'insertSocial');

function insertSocial($content) {
   if(is_single()) {
	  $content = trim($content);
      $content_array = explode(">",$content);
	  $content_new = '<div class="social-bar">';
      $content_new.= '<h4>Think this issue needs more voices? <small>Help spread the word, Share this story.</small></h4>';
      
	  $content_new.= '<div class="social-buttons"><div class="social-button"><iframe scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1362636220.html#_=1363001285231&amp;count=vertical&amp;id=twitter-widget-1&amp;lang=en&amp;original_referer=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;size=m&amp;text=Test%20Sticky%20Post&amp;url=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;via=socializeWP" class="twitter-share-button twitter-count-vertical" style="width: 58px; height: 62px;" title="Twitter Tweet Button" data-twttr-rendered="true"></iframe></div><div class="social-button"><iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:45px; height:65px;" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;send=false&amp;layout=box_count&amp;width=45&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=65"></iframe></div><div class="social-button"><div style="height: 60px; width: 50px; display: inline-block; text-indent: 0px; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% transparent; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline;" id="___plusone_1"><iframe width="100%" scrolling="no" frameborder="0" hspace="0" marginheight="0" marginwidth="0" style="position: static; top: 0px; width: 50px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 60px;" tabindex="0" vspace="0" id="I1_1363001287924" name="I1_1363001287924" src="https://plusone.google.com/_/+1/fastbutton?bsv&amp;size=tall&amp;hl=en-US&amp;origin=http%3A%2F%2Fwww.vv.ajency.in&amp;url=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.en.IOaFQMAHVRI.O%2Fm%3D__features__%2Fam%3DUQE%2Frt%3Dj%2Fd%3D1%2Frs%3DAItRSTNYuZ6HDkdZho3xDZgOVYkx4qGWPQ#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled&amp;id=I1_1363001287924&amp;parent=http%3A%2F%2Fwww.vv.ajency.in&amp;rpctoken=22999206" allowtransparency="true" data-gapiattached="true" title="+1"></iframe></div></div></div>';
	  
	  $content_new.= '</div';
	  
	  $temp_content_array = array();
	  $content_para_count = count($content_array );	
	
		if($content_para_count<=2)
		{
			if($content_para_count===0)
				$content_new .= '>';
				
			$content_array[] = $content_new;
		}
		else
		{
			for($i=0;$i<$content_para_count;$i++)
				{	
					$temp_content_array[]  = $content_array[$i];
					if($i==9)
					{
						$temp_content_array[] = $content_new;
					}	
				}
				
				$content_array = $temp_content_array;
		}
		$content = implode(">",$content_array);	
	  
   }
   return $content;
}

/*appending a list of child pages*/
function append_child_pages() {
global $wpdb;
    global $post;
 
    /*
     * create a query that will locate all children of THIS page keeping
     * the ORDER in specified in this page.
     */
    $sql = "SELECT * FROM $wpdb->posts WHERE post_parent = " .
        $post->ID . " AND post_type = 'page' ORDER BY menu_order";
 
    // do the query
    $child_pages = $wpdb->get_results( $sql, 'OBJECT' );
   
    $html = "<hr />";

    // walk the pages we have found
	$html .= "<div class='row-fluid'>";
    if ( $child_pages ) {

        /*
         * The $first variable is used to select the div elements that start
         * a new row, this is strictly for styling (.css) purposes.
         *
         * this is all within the context of the 'columns' .css selectors provided
         * by StudioPress.  You can roll your own, it's simple.  Ask me if you like.
         */
        $first = true;
 
        /*
         * every child page we have we are going to create a grid element (is that
         * the right word?)
         */  
        foreach ( $child_pages as $cp ) {

            setup_postdata( $cp );
 
            // Get a 'medium' size featured image
            $th = get_the_post_thumbnail( $cp->ID, 'medium' );
            $permalink = get_permalink( $cp->ID );
 
            /*
             * This is where we create an alternating selector by turning the
             * 'first' class on and off to create a two column grid.
             */
			
            $class = 'span6';
            if ( $first ) {
                $class .= ' first';
            }

            // set the column selector
            $html .= "<div class='" . $class . "'>\n";

            // Link the thumbnail image to the child page.
            $html .=
                "<a href='" . $permalink . "' rel='bookmark' title='" . $cp->post_title . "'>" .
                $th .
                "</a><br/>\n";
 
            // Might as well link the page title to the page as well.
            $html .= "<h5 class='child_entry-title'>" .
                "<a href='" . $permalink . "' rel='bookmark' title='" . $cp->post_title . "'>" .
                $cp->post_title .
            "</a></h5>\n";
  $html .= "<div class='page_excerpt'><span> ".$cp->post_content."</span> </div>\n";
           $html .="<a class='continue_reading_link' href='". $permalink ."' >Read More -></a>"; 
			$html .= "
			</div>\n";

            // Toggle between being first and not first
            $first = ! $first;
       
	   }
   
	}
     $html .= "</div>";
    // spit it out
    echo $html . "<br class='clear' />";
}
add_action('pagelines_inside_bottom_postloop','append_child_pages',10);

/**
 * Function to get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
function youtube_id_from_url($link){

	$regexstr = '~
		# Match Youtube link and embed code
		(?:                             # Group to match embed codes
			(?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
			|(?:                        # Group to match if older embed
				(?:<object .*>)?      # Match opening Object tag
				(?:<param .*</param>)*  # Match all param tags
				(?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
			)?                          # End older embed code group
		)?                              # End embed code groups
		(?:                             # Group youtube url
			https?:\/\/                 # Either http or https
			(?:[\w]+\.)*                # Optional subdomains
			(?:                         # Group host alternatives.
			youtu\.be/                  # Either youtu.be,
			| youtube\.com              # or youtube.com
			| youtube-nocookie\.com     # or youtube-nocookie.com
			)                           # End Host Group
			(?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
			([\w\-]{11})                # $1: VIDEO_ID is numeric
			[^\s]*                      # Not a space
		)                               # End group
		"?                              # Match end quote if part of src
		(?:[^>]*>)?                       # Match any extra stuff up to close brace
		(?:                             # Group to match last embed code
			</iframe>                 # Match the end of the iframe
			|</embed></object>          # or Match the end of the older embed
		)?                              # End Group of last bit of embed code
		~ix';

	preg_match($regexstr, $link, $matches);

	return $matches[1];

}

/****Output Single Video Posts****/
function output_single_video() {
	if ( is_single() )
	{
	$video = get_post_meta(get_the_ID(), 'Video', true); 
	if($video !== '') 
	//loop here
		{ 
		?>
			<style>
				section.post-meta {display: none;}
			</style>
			<div class="single-vid-container">
				<div class="row-fluid">
					<div class="span8">
						<div class="single-vid">
							<div class="single-vid-title-bar">
								<div class="meta">
									<?php echo get_the_category_list( __( ' | ' ) ); ?>
								</div>
								<h1 class="title"><?php the_title(); ?></h1>
							</div>
							<div class="vid-con">
								<?php echo do_shortcode('[pl_video type="youtube" id="'.youtube_id_from_url($video).'"] '); ?>
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="single-vid-info">
							<div class="action-box-arrow"></div>
							<div class="action-box">
								<h2 class="views">500<small>Views</small></h2>
								<h2 class="shares">50<small>Shares</small></h2>
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Facebook Like/Share</a>
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Tweet This</a>
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Email This</a>
							</div>
							<div class="info-box-arrow"></div>
							<div class="info-box">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eu facilisis arcu. Vestibulum a massa nulla, in fermentum augue. Curabitur mattis eleifend aliquam. Phasellus at nunc nisl. Praesent venenatis enim id dui porta sit amet bibendum quam hendrerit. </p>
								<a class="more-link"><i class="icon-plus"></i> More</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	//end loop here
	}
}

add_action('pagelines_content_before_columns', 'output_single_video',1);

/****Output Single Video Author Meta****/
function output_single_video_author() {
	if ( is_single() )
	{
	$video = get_post_meta(get_the_ID(), 'Video', true); 
	$thumb_img = get_post_meta(get_the_ID(), 'Thumbnail', true);
	if($video !== '') 
	//loop here
		{ 
		?>
			<style>
				.entry_content {padding: 0 1em;}
				.entry_content p, .entry_content div {font-size: 0.9em;} 
			</style>
			<div class="about-vid">
				<div class="author-info">
					<h3>Video By Community Correspondent</h3>
					<div class="row-fluid">
						<div class="avatar span1">
							<?php echo get_avatar( get_the_author_meta('ID'), 150 ); ?>
						</div>
						<div class="details span11">
							<h4><?php the_author_posts_link(); ?></h4>
							<span>Connect with him&nbsp;
								<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-fb.png" alt="connect-fb" width="16" height="16" class="alignnone size-full wp-image-233" /></a>
								<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-twitter.png" alt="connect-twitter" width="16" height="16" class="alignnone size-full wp-image-234" /></a>
								<a href="mailto:<?php echo get_the_author_meta('email'); ?>"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-email.png" alt="connect-email" width="16" height="16" class="alignnone size-full wp-image-232" /></a>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="thumb-image">
				<img src="http://indiaunheard.videovolunteers.org<?php echo $thumb_img; ?>" alt="<?php the_title_attribute(); ?>" />
			</div>
		<?php
		}
	//end loop here
	}
}

add_action('pagelines_loop_before_post_content', 'output_single_video_author',1);

/****Output Single Author Bio****/
function output_single_author_bio() {
	if ( is_author() )
	{
	$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	?>
		<div class="author-section">
			<h1>Community Correspondent</h1>
			<div class="row-fluid">
				<div class="span3">
					<?php echo get_avatar( $curauth, 512 ); ?>
				</div>
				<div class="span9">
					<div class="details">
						<h3><?php echo $curauth->nickname; ?></h3>
						<div class="bio">
							<h4>Bio:</h4>
							<p><?php echo $curauth->description; ?></p>
						</div>
						<span>Connect with him&nbsp;
								<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-fb.png" alt="connect-fb" width="16" height="16" class="alignnone size-full wp-image-233" /></a>
								<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-twitter.png" alt="connect-twitter" width="16" height="16" class="alignnone size-full wp-image-234" /></a>
								<a href="mailto:<?php echo get_the_author_meta('email'); ?>"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-email.png" alt="connect-email" width="16" height="16" class="alignnone size-full wp-image-232" /></a>
							</span>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

add_action('pagelines_before_videoloop', 'output_single_author_bio',1);

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}

/****Output Category Info****/
function output_category_info() {
	
	$cat = get_category( get_query_var( 'cat' ) );
	$cat_name = $cat->name;
	$cat_desc = $cat->description;
	
	if ( ( in_category( 'videos' ) || post_is_in_descendant_category( 16 ) ) )
	{
		?>
			<div class="issue-section">
				<?php if ( is_category( 'videos' ) ) { ?>
					<h1><?php echo $cat_name; ?></h1>
				<?php } else { ?>
					<h1><span>Issue: </span><?php echo $cat_name; ?></h1>
					<p><?php echo $cat_desc; ?></p>
				<?php } ?>
			</div>
		<?php
	}
	else
	{
		
	}
}

add_action('pagelines_before_videoloop', 'output_category_info',1);

/****Display Sticky Post on Blog Page****/
function display_blog_sticky() {
	if ( is_category('blog') ) {
		$args = array(
			'posts_per_page' => 1,
			'post__in'  => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1
		);
		query_posts( $args );
			while ( have_posts() ) : the_post(); ?>
				<div id="sticky-post-div">
					<div class="pad">
						<h2>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
						<?php if ( has_post_thumbnail() ) { ?>
							<a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail( array(600,450) ); ?></a>
						<?php } ?>
						<div class="clearfix"></div>
						<p><?php the_excerpt(); ?></p>
					</div>
				</div>
			<?php endwhile;
		wp_reset_query();
	}
}

add_action('pagelines_content_before_columns', 'display_blog_sticky',1);

/****Register Author Sidebar****/
register_sidebar(array(
	'name'          => __( 'Author Sidebar' ),
	'id'            => 'author-sidebar',
	'description'   => 'Sidebar for the Author Page',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>' 
));

/****Function to Set Featured Users****/
add_action( 'edit_user_profile', 'show_featured_auth_field' );

function show_featured_auth_field( $user ) { ?>

<h3>Featured Author</h3>
<table class="form-table">
	<tr>
		<th><label>Featured Settings</label></th>
		<td>
			<input type="checkbox" name="featured_auth" id="featured_auth" value="true" <?php if (esc_attr( get_the_author_meta( "featured_auth", $user->ID )) == "true") echo "checked"; ?> />
			<label for="featured_auth">Author is Featured</label>
		</td>
	</tr>
</table>
<?php }

add_action( 'edit_user_profile_update', 'save_featured_auth_field' );

function save_featured_auth_field( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	
	if (!isset($_POST['featured_auth'])) $_POST['featured_auth'] = "false"; 

	update_user_meta( $user_id, 'featured_auth', $_POST['featured_auth'] );
}
