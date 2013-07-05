<?php
/*
Plugin Name: PagesTree Widget
Plugin URI: http://ajency.in/
Description: PagesTree Widget lists pages and subpages in a tree structure for navigation in the sidebar.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
class PagesTree extends WP_Widget
{
  function PagesTree()
  {
    $widget_ops = array('classname' => 'PagesTree', 'description' => 'Lists pages and subpages in a tree structure for navigation in the sidebar' );
    $this->WP_Widget('PagesTree', 'PagesTree Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$post_id = esc_attr( $instance['post_id'] );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label>
		</p>
		<p class="pages-tree-select">
			<style type="text/css">
				.pages-tree-select select {width: 100%;}
			</style>
			<label for="<?php echo $this->get_field_id('post_id'); ?>"><?php _e( 'Parent Page:' ); ?></label> 
			<?php 
			  $args = array(
				'name' => $this->get_field_name('post_id'),
				'selected' => $post_id
			  );
			  wp_dropdown_pages($args);

			?>
		</p>
	<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['post_id'] = strip_tags( $new_instance['post_id'] );
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo '<li class="widget_flexible-recent-posts-widget pages-tree-widget widget fix">';
    echo '<div class="widget-pad">';
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
	
	// Start Code
		
		// use wp_list_pages to display parent and all child pages all generations (a tree with parent)
		$post_id = empty( $instance['post_id'] ) ? '' : $instance['post_id'];
		$parent = $post_id; 
		$args = array(
			'child_of' => $parent
		);
		$pages = get_pages($args);  
		if ($pages) {
			$pageids = array();
			foreach ($pages as $page) {
				$pageids[]= $page->ID;
			}
			global $post; $thispage = $post->ID; // grabs the current post id from global  
			$pagekids = get_pages("child_of=".$thispage."&sort_column=menu_order"); // gets a list of page that are sub pages of the current page 

			if ($pagekids) {
				$args=array(
					'title_li' => '',
					'include' =>  $parent . ',' . implode(",", $pageids),
					'depth' => 2,
				);
			}
			else {
				$args=array(
					'title_li' => '',
					'include' =>  $parent . ',' . implode(",", $pageids),
					'depth' => 3,
				);
			}
			
			
			echo '<ul>';
			wp_list_pages($args);
			echo '</ul>'; 
		}
 
    echo '</div>';
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("PagesTree");') );?>