<?php
/*
Plugin Name: Related Authors Widget
Plugin URI: http://ajency.in/
Description: Related Authors Widget pulls the associated authors to display on your sidebar
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class AuthorWidget extends WP_Widget
{
  function AuthorWidget()
  {
    $widget_ops = array('classname' => 'AuthorWidget', 'description' => 'Displays a list of authors from related categories' );
    $this->WP_Widget('AuthorWidget', 'Related Authors Widget', $widget_ops);
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
	$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	$cat_array = array();
	$args = array(
		'author' => $curauth->id,
		'showposts' => -1,
		'caller_get_posts' => 1
	);
	$author_posts = get_posts($args);
	if( $author_posts ) {
		foreach ($author_posts as $author_post ) {
			foreach(get_the_category($author_post->ID) as $category) {
			$cat_array[$category->term_id] =  $category->term_id;
			}
		}
	}
	$cat_ids = implode(',', $cat_array);
	
	// Start Code
	$auth_args = array(
		'category' => $cat_ids,
		'posts_per_page' => 5
	);
	
    query_posts($auth_args);
	if (have_posts()) : 
		echo '<ul class="frp-widget">';
		while (have_posts()) : the_post();  ?>
			<li class="frp-news">
				<div class="row-fluid">
					<div class="thumb span3 zmb">
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 220 ); ?></a>
					</div>
					<div class="listing-info span9 zmb">
						<h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a></h5>
						<div class="excerpt">
							<?php echo get_the_author_meta( 'description' ); ?>
						</div>
						<a class="profile-link" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="icon-plus"></i>&nbsp;View Profile</a>	
					</div>
				</div>
			</li>
		<?php endwhile;
		echo '</ul>';
	endif; 
	wp_reset_query();
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("AuthorWidget");') );?>