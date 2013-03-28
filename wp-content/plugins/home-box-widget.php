<?php
/*
Plugin Name: Home Box Widget
Plugin URI: http://ajency.in/
Description: Home Box Widget puts a box and a link plus content with a full size background image
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class HomeBoxWidget extends WP_Widget
{
  function HomeBoxWidget()
  {
    $widget_ops = array('classname' => 'HomeBoxWidget', 'description' => 'Displays a box and a link plus content with a full size background image' );
    $this->WP_Widget('HomeBoxWidget', 'Home Box Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'link' => '', 'link_text' => '', 'image' => '', 'desc' => '' ) );
    $title = $instance['title'];
    $link = $instance['link'];
    $link_text = $instance['link_text'];
    $image = $instance['image'];
    $desc = $instance['desc'];
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('link'); ?>">Link: <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo attribute_escape($link); ?>" /></label></p>
		<p style="font-size:0.8em;font-style:italic;">Please enter the full url of your link.</p>
		
		<p><label for="<?php echo $this->get_field_id('link_text'); ?>">Link Text: <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo attribute_escape($link_text); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('image'); ?>">Background Image: <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo attribute_escape($image); ?>" /></label></p>
		<p style="font-size:0.8em;font-style:italic;">Please enter the full url to your image.</p>
		
		<p><label for="<?php echo $this->get_field_id('desc'); ?>">Description: <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo attribute_escape($desc); ?>" /></label></p>
		<p style="font-size:0.8em;font-style:italic;">Please keep the description short.</p>
	<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['link'] = $new_instance['link'];
    $instance['link_text'] = $new_instance['link_text'];
    $instance['image'] = $new_instance['image'];
    $instance['desc'] = $new_instance['desc'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo '<li class="widget fix">';
    echo '<div class="widget-pad">';
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	
	// Start Code	
	echo '<div class="vv_widget_boxes_container row-fluid">';
	foreach ( $users as $user ) 
		{
			?>				
				<div class="span6 vv_widget_box">
					<div class="vv_widget_title"><?php echo $title; ?></div>
					<div class="vv_widget_excerpt"><a href="<?php echo $link; ?>"><?php echo $link_text; ?></a></div>
					<div class="vv_widget_text"><?php echo $desc; ?></div>
					<div><img src="<?php echo $image; ?>"/></div>
				</div>
			<?php
		}
	echo '</div>';
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("HomeBoxWidget");') );?>