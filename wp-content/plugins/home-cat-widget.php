<?php
/*
Plugin Name: Home Page Category Widget
Plugin URI: http://ajency.in/
Description: Home Page Category Widget puts a box with 3 thumbnails from the selected category and category title.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class HomeCatsWidget extends WP_Widget
{
  function HomeCatsWidget()
  {
    $widget_ops = array('classname' => 'HomeCatsWidget', 'description' => 'Displays a box with 3 thumbnails from the selected category and category title.' );
    $this->WP_Widget('HomeCatsWidget', 'Home Page Category Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'cat' => '' ) );
    $title = $instance['title'];
    $cat = $instance['cat'];
	?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<?php _e( 'Category' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select a Category to display.</p>
	<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['cat'] = $new_instance['cat'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    global $post;
	$post_old = $post; // Save the post object.
	
	extract($args, EXTR_SKIP);
 
    echo '<li class="widget fix">';
	
	// If no title, use the name of the category.
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $cat = empty($instance['cat']) ? ' ' : apply_filters('widget_cat', $instance['cat']);
		
	// Get array of post info.
	$query_1 = array(
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
		'cat' => $instance["cat"]
	);
	$thumb_1 = new WP_Query($query_1);
	
	$query_2 = array(
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
		'offset' => 1,
		'cat' => $instance["cat"]
	);
	$thumb_2 = new WP_Query($query_2);
	
	$query_3 = array(
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
		'offset' => 2,
		'cat' => $instance["cat"]
	);
	$thumb_3 = new WP_Query($query_3);
    	
    // WIDGET CODE GOES HERE
	
	// Start Code	
	echo '<div class="f-box">';
		?>				
			<div class="images row-fluid">
				<div class="span8">
					<?php 
					while ( $thumb_1->have_posts() ) :
						$thumb_1->the_post();
						$thumb_url = get_post_meta($post->ID, 'Thumbnail', true);
						echo '<a class="thumbnail" href="' . get_permalink() . '" title="' . get_the_title() . '">';
						?>
						<img alt="<?php echo get_the_title(); ?>" src="http://indiaunheard.videovolunteers.org<?php echo $thumb_url; ?>" />
						<?php
						echo '</a>';
					endwhile;
					wp_reset_postdata(); 
					?>
				</div>
				<div class="span4">
					<?php 
					while ( $thumb_2->have_posts() ) :
						$thumb_2->the_post();
						$thumb_url = get_post_meta($post->ID, 'Thumbnail', true);
						echo '<a class="thumbnail" href="' . get_permalink() . '" title="' . get_the_title() . '">';
						?>
						<img alt="<?php echo get_the_title(); ?>" src="http://indiaunheard.videovolunteers.org<?php echo $thumb_url; ?>" />
						<?php
						echo '</a>';
					endwhile;
					wp_reset_postdata(); 
					?>
				</div>
				<div class="span4">
					<?php 
					while ( $thumb_3->have_posts() ) :
						$thumb_3->the_post();
						$thumb_url = get_post_meta($post->ID, 'Thumbnail', true);
						echo '<a class="thumbnail" href="' . get_permalink() . '" title="' . get_the_title() . '">';
						?>
						<img alt="<?php echo get_the_title(); ?>" src="http://indiaunheard.videovolunteers.org<?php echo $thumb_url; ?>" />
						<?php
						echo '</a>';
					endwhile;
					wp_reset_postdata(); 
					?>
				</div>
			</div>
			<div class="info row-fluid">
				<div class="span9">
					<h4><?php echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>'; ?></h4>
				</div>
				<div class="span3">
					<a href="<?php echo get_category_link($instance["cat"]); ?>"><i class="icon-plus"></i> More</a>
				</div>
			</div>
		<?php
	echo '</div>';
	
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("HomeCatsWidget");') );?>