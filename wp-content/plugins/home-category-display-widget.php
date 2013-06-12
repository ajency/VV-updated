<?php
/*
Plugin Name: Home Page Category Display Widget
Plugin URI: http://ajency.in/
Description: Home Page Category Display Widget puts a box with 3 categories and category titles.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class HomeCatDisplayWidget extends WP_Widget
{
  function HomeCatDisplayWidget()
  {
    $widget_ops = array('classname' => 'HomeCatDisplayWidget', 'description' => 'Displays aa box with 3 categories and category titles' );
    $this->WP_Widget('HomeCatDisplayWidget', 'Home Page Category Display Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'cat' => '', 'cat1' => '', 'cat2' => '', 'cat3' => '' ) );
    $title = $instance['title'];
    $cat = $instance['cat'];
    $cat1 = $instance['cat1'];
    $cat2 = $instance['cat2'];
    $cat3 = $instance['cat3'];
	?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<?php _e( 'Title Links To' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select a Category to use as title link.</p>
		
		<p>
			<label>
				<?php _e( 'Category 1' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat1"), 'selected' => $instance["cat1"] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select a Category to display.</p>
		
		<p>
			<label>
				<?php _e( 'Category 2' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat2"), 'selected' => $instance["cat2"] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select a Category to display.</p>
		
		<p>
			<label>
				<?php _e( 'Category 3' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat3"), 'selected' => $instance["cat3"] ) ); ?>
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
    $instance['cat1'] = $new_instance['cat1'];
    $instance['cat2'] = $new_instance['cat2'];
    $instance['cat3'] = $new_instance['cat3'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    global $post;
	$post_old = $post; // Save the post object.
	
	extract($args, EXTR_SKIP);
 
    echo '<li class="widget fix">';
	
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $cat = empty($instance['cat']) ? ' ' : apply_filters('widget_cat', $instance['cat']);
    $cat1 = empty($instance['cat1']) ? ' ' : apply_filters('widget_cat', $instance['cat1']);
    $cat2 = empty($instance['cat2']) ? ' ' : apply_filters('widget_cat', $instance['cat2']);
    $cat3 = empty($instance['cat3']) ? ' ' : apply_filters('widget_cat', $instance['cat3']);
    	
    // WIDGET CODE GOES HERE
	
	
	// Start Code	
	echo '<div class="f-box">';
		?>				
			<div class="images row-fluid">
				<div class="span8">
					<?php 
						$cat_name1 = get_category( $cat1 );
						echo '<a class="thumbnail" href="' . get_category_link($instance['cat1']) . '" title="' . $cat_name1->name . '">';
						$image_src = s8_get_taxonomy_image( get_term($cat1, 'category'), 'full'); 
						echo $image_src;
						echo '</a>';
					?>
				</div>
				<div class="span4">
					<?php 
						$cat_name2 = get_category( $cat2 );
						echo '<a class="thumbnail" href="' . get_category_link($instance['cat2']) . '" title="' . $cat_name2->name . '">';
						$image_src2 = s8_get_taxonomy_image( get_term($cat2, 'category'), 'full'); 
						echo $image_src2;
						echo '</a>';
					?>
				</div>
				<div class="span4">
					<?php 
						$cat_name3 = get_category( $cat3 );
						echo '<a class="thumbnail" href="' . get_category_link($instance['cat3']) . '" title="' . $cat_name3->name . '">';
						$image_src3 = s8_get_taxonomy_image( get_term($cat3, 'category'), 'full'); 
						echo $image_src3;
						echo '</a>';
					?>
				</div>
			</div>
			<div class="info row-fluid">
				<div class="span9">
					<h4><a href="<?php echo get_category_link($instance["cat"]); ?>"><?php echo $instance["title"]; ?></a></h4>
				</div>
			</div>
		<?php
	echo '</div>';
	
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("HomeCatDisplayWidget");') );?>