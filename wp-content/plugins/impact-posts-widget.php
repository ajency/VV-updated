<?php
/*
Plugin Name: Impact Posts Widget
Plugin URI: http://ajency.in/
Description: Impact Posts Widget puts 2 posts from the selected category and category title.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class ImpactPostsWidget extends WP_Widget
{
  function ImpactPostsWidget()
  {
    $widget_ops = array('classname' => 'ImpactPostsWidget', 'description' => 'Displays 2 posts from the selected category and category title.' );
    $this->WP_Widget('ImpactPostsWidget', 'Impact Posts Widget', $widget_ops);
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
 
    echo '<li class="impact-widget widget fix">';
	
	// If no title, use the name of the category.
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $cat = empty($instance['cat']) ? ' ' : apply_filters('widget_cat', $instance['cat']);
		
	// Get array of post info.
	$query = array(
		'posts_per_page' => 2,
		'orderby' => 'date',
		'order' => 'DESC',
		'cat' => $instance["cat"]
	);
	$posts = new WP_Query($query);
	
    // WIDGET CODE GOES HERE
	
	// Start Code	
	echo '<div id="impactloop">';
		?>	
			<div class="header">
				<h4><?php echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>'; ?></h4>
			</div>
			<div class="impact row-fluid">
				<?php 
				while ( $posts->have_posts() ) :
					$posts->the_post();
					$thumb_url = get_post_meta($post->ID, 'Thumbnail', true);
					?>
						<div class="span6">
							<h5><?php echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>'; ?></h5>
							<div class="meta">
								On <b><?php the_time('F j, Y'); ?></b> By <?php echo the_author_posts_link(); ?> In <?php echo get_the_category_list( ', ' ); ?>
							</div>
							<div class="excerpt">
								<?php echo get_the_post_thumbnail($post->ID, array(80,80)); ?>
								<?php echo get_the_excerpt(); ?>
							</div>
							<?php echo '<a class="more-link" href="' . get_permalink() . '" title="' . get_the_title() . '">Read More &rarr;</a>'; ?>
						</div>
					<?php
				endwhile;
				wp_reset_postdata(); 
				?>
			</div>
		<?php
	echo '</div>';
	
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("ImpactPostsWidget");') );?>