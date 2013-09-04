<?php
/*
Plugin Name: Featured Community Correspondent Widget
Plugin URI: http://ajency.in/
Description: Featured Community Correspondent Widget pulls a random featured author to display on your sidebar
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class FeatCCWidget extends WP_Widget
{
  function FeatCCWidget()
  {
    $widget_ops = array('classname' => 'FeatCCWidget', 'description' => 'Displays a random featured author' );
    $this->WP_Widget('FeatCCWidget', 'Featured Community Correspondent Widget', $widget_ops);
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
 
    echo '<li class="widget fix">';
    echo '<div class="widget-pad"><a href="'. site_url('/about/indiaunheard/community-correspondent-profiles/') .'">';
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	// Create a function to override the ORDER BY clause
	$randomize_func = create_function( '&$query', '$query->query_orderby = "ORDER BY RAND()";' );

	// Hook pre_user_query
	add_action( 'pre_user_query', $randomize_func );
	
	$feat_args = array(
		'meta_key'     => 'featured_auth',
		'meta_value'   => 'true',
		'fields'       => 'all',
		'number'       => '1',
		'orderby'      => 'rand'
	);
	
	$users = get_users($feat_args);
	
	// Remove the hook
	remove_action( 'pre_user_query', $randomize_func );
	
	// Start Code	
	echo '</a><div class="feat-cc-widget">';
	foreach ( $users as $user ) 
		{
			$auth_desc = substr(get_the_author_meta( 'description', $user->ID ), 0, 200);
			?>
				<div class="featured-cc">
					<a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="auth-avatar"><?php echo get_avatar( $user->ID , 384 ); ?></a>
					<a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo get_the_author_meta( 'display_name', $user->ID ); ?></a>
					<p><?php echo $auth_desc; ?> ... <a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="read-more">read more<i class="icon-double-angle-right"></i></a></p>
				</div>
			<?php
		}
	echo '</div>';
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("FeatCCWidget");') );?>