<?php
/*
Plugin Name: DropDown Authors Widget
Plugin URI: http://ajency.in/
Description: DropDown Authors Widget pulls the authors in a drop-down and lets you go to their page
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
class DropDownAuthors extends WP_Widget
{
  function DropDownAuthors()
  {
    $widget_ops = array('classname' => 'DropDownAuthors', 'description' => 'Displays a drop-down list of authors' );
    $this->WP_Widget('DropDownAuthors', 'DropDown Authors Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
	<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo '<li class="widget_flexible-recent-posts-widget drop-down-authors widget fix">';
    echo '<div class="widget-pad">';
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	$args = array(
		'show_option_all'         => null, // string
		'show_option_none'        => null, // string
		'hide_if_only_one_author' => null, // string
		'orderby'                 => 'display_name',
		'order'                   => 'ASC',
		'include'                 => null, // string
		'exclude'                 => '165', // string
		'multi'                   => false,
		'show'                    => 'display_name',
		'echo'                    => true,
		'selected'                => false,
		'include_selected'        => false,
		'name'                    => 'author', // string
		'id'                      => null, // integer
		'class'                   => null, // string 
		'blog_id'                 => $GLOBALS['blog_id'],
		'who'                     => 'authors' // string
	);
	
	// Start Code
		?>
			<form action="<?php bloginfo('url'); ?>" method="get" class="form-inline">
			<?php wp_dropdown_users( $args ); ?>
			<input type="submit" name="submit" value="View Author Posts" class="btn" />
			</form>
		<?php 
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("DropDownAuthors");') );?>