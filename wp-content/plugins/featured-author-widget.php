<?php
/*
Plugin Name: VV Featured Authors Widget
Plugin URI: http://ajency.in/
Description: Featured Authors Widget pulls the featured authors to display on your sidebar
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class FeatAuthWidget extends WP_Widget
{
  function FeatAuthWidget()
  {
    $widget_ops = array('classname' => 'FeatAuthWidget', 'description' => 'Displays a list of featured authors' );
    $this->WP_Widget('FeatAuthWidget', 'VV Featured Authors Widget', $widget_ops);
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
 
    echo '<li class="widget_flexible-recent-posts-widget author-list widget fix">';
    echo '<div class="widget-pad">';
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	$feat_args = array(
		'meta_key'     => 'featured_auth',
		'meta_value'   => 'true',
		'fields'       => 'all',
		'number'       => '5'
	 );
	 
	$users = get_users($feat_args);
	
	// Start Code	
	echo '<ul class="frp-widget">';
	foreach ( $users as $user ) 
		{
			?>
				<li class="frp-news">
					<div class="row-fluid">
						<div class="thumb span3 zmb">
							<a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo get_avatar( $user->ID , 220 ); ?></a>
						</div>
						<div class="listing-info span9 zmb">
							<h5><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo get_the_author_meta( 'display_name', $user->ID ); ?></a></h5>
							<div class="excerpt">
								<?php echo get_the_author_meta( 'description', $user->ID ); ?>
							</div>
							<a class="profile-link" href="<?php echo get_author_posts_url( $user->ID ); ?>"><i class="icon-plus"></i>&nbsp;View Profile</a>	
						</div>
					</div>
				</li>
			<?php
		}
	echo '</ul>';
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("FeatAuthWidget");') );?>