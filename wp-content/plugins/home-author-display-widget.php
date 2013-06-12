<?php
/*
Plugin Name: Home Page Author Display Widget
Plugin URI: http://ajency.in/
Description: Home Page Author Display Widget adds a box with 3 author images.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class HomeAuthorDisplayWidget extends WP_Widget
{
  function HomeAuthorDisplayWidget()
  {
    $widget_ops = array('classname' => 'HomeAuthorDisplayWidget', 'description' => 'Displays a box with 3 author images' );
    $this->WP_Widget('HomeAuthorDisplayWidget', 'Home Page Author Display Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'author1' => '', 'author2' => '', 'author3' => '' ) );
    $title = $instance['title'];
    $author1 = $instance['author1'];
    $author2 = $instance['author2'];
    $author3 = $instance['author3'];
	
	?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<?php _e( 'Author 1' ); ?>:
				<?php wp_dropdown_users( array( 'name' => $this->get_field_name('author1'), 'selected' => $instance['author1'] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select an Author to display.</p>
		
		<p>
			<label>
				<?php _e( 'Author 2' ); ?>:
				<?php wp_dropdown_users( array( 'name' => $this->get_field_name('author2'), 'selected' => $instance['author2'] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select an Author to display.</p>
		
		<p>
			<label>
				<?php _e( 'Author 3' ); ?>:
				<?php wp_dropdown_users( array( 'name' => $this->get_field_name('author3'), 'selected' => $instance['author3'] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Please select an Author to display.</p>
	<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['author1'] = $new_instance['author1'];
    $instance['author2'] = $new_instance['author2'];
    $instance['author3'] = $new_instance['author3'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    global $post;
	$post_old = $post; // Save the post object.
	
	extract($args, EXTR_SKIP);
 
    echo '<li class="widget fix">';
	
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $author1 = empty($instance['author1']) ? ' ' : apply_filters('widget_author', $instance['author1']);
    $author2 = empty($instance['author2']) ? ' ' : apply_filters('widget_author', $instance['author2']);
    $author3 = empty($instance['author3']) ? ' ' : apply_filters('widget_author', $instance['author3']);
    	
    // WIDGET CODE GOES HERE
	
	
	// Start Code	
	echo '<div class="f-box">';
		?>				
			<div class="images row-fluid">
				<div class="span8">
					<?php 
						echo '<a class="thumbnail" href="' . get_author_posts_url( $author1 ) . '" title="' . get_the_author_meta( display_name, $author1 ) . '">';
						echo get_avatar( $author1, 300 );
						echo '</a>';
					?>
				</div>
				<div class="span4">
					<?php 
						echo '<a class="thumbnail" href="' . get_author_posts_url( $author2 ) . '" title="' . get_the_author_meta( display_name, $author2 ) . '">';
						echo get_avatar( $author2, 200 );
						echo '</a>';
					?>
				</div>
				<div class="span4">
					<?php 
						echo '<a class="thumbnail" href="' . get_author_posts_url( $author3 ) . '" title="' . get_the_author_meta( display_name, $author3 ) . '">';
						echo get_avatar( $author3, 200 );
						echo '</a>';
					?>
				</div>
			</div>
			<div class="info row-fluid">
				<div class="span12">
					<h4><?php echo $instance["title"]; ?></h4>
				</div>
			</div>
		<?php
	echo '</div>';
	
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("HomeAuthorDisplayWidget");') );?>