<?php
/*
Plugin Name: Regional Categories Widget
Plugin URI: http://ajency.in/
Description: Regional Categories Widget displays categories that are sub-categories of States.
Author: Ajency
Version: 1
Author URI: http://ajency.in/
*/
 
 
class RegionalCatsWidget extends WP_Widget
{
  function RegionalCatsWidget()
  {
    $widget_ops = array('classname' => 'RegionalCatsWidget', 'description' => 'Displays categories that are sub-categories of States.' );
    $this->WP_Widget('RegionalCatsWidget', 'Regional Categories Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'cat' => '' ) );
    $title = $instance['title'];
	?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<?php _e( 'Category' ); ?>: States
				<?php //wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			</label>
		</p>
		<p style="font-size:0.8em;font-style:italic;">Category States with ID of 10.</p>
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
	
	// If no title, use the name Regions
	if( !$instance["title"] ) {
		$instance["title"] = 'Regions';
	}
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
	// Get array of categories.
	$query = array(
		'parent' => 10,
		'orderby' => 'count',
		'order' => 'DESC'
	);
	$cats = get_categories($query);
	
    // WIDGET CODE GOES HERE
	
	// Start Code	
	echo '<div id="regional-cats" class="widget-pad">';
		?>	
			<div class="header">
				<h3><?php echo $instance["title"]; ?></h3>
			</div>
			<div class="accordion regions" id="cat-accordion">
				<?php 
				foreach ( $cats as $cat ) {
					?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#cat-accordion" href="#<?php echo $cat->slug; ?>">
									<?php echo $cat->name; ?>
								</a>
							</div>
							<div id="<?php echo $cat->slug; ?>" class="accordion-body collapse">
								<div class="accordion-inner">
									<?php $children = array(
										'show_option_all'    => '',
										'orderby'            => 'name',
										'order'              => 'ASC',
										'style'              => 'list',
										'show_count'         => 0,
										'hide_empty'         => 0,
										'child_of'           => $cat->cat_ID,
										'title_li'           => '',
										'show_option_none'   => __('No States'),
									); ?>
									<ul>
										<?php wp_list_categories( $children ); ?> 
									</ul>
								</div>
							</div>
						</div>
					<?php
				}
				?>
			</div>
		<?php
	echo '</div>';
	
    echo '</li>';
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("RegionalCatsWidget");') );?>