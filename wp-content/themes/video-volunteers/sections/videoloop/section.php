<?php
/*
	Section: VideoLoop
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The Video Posts Loop. Includes video posts & information.
	Class Name: PageLinesVideoLoop	
	Workswith: main
	Failswith: 404_page
*/

/**
 * Main Video Loop Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class PageLinesVideoLoop extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		
		if ( is_category( 'videos-ajax' ) ) { //CHANGED TO IMPLEMENT NO AJAX DEFAULT
			
			$filter = array(
				'hide_empty' => 0, 
				'name' => 'category_parent', 
				'orderby' => 'name', 
				'selected' => $category->parent, 
				'hierarchical' => true, 
				'show_option_none' => __('All'),
				'child_of' => 16
			);
			
			wp_dropdown_categories($filter);
			
			?>
			<div id="vid-content" class="video-list">
			
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){ 
					get_cat_post('');
				});
				
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

				function get_cat_post(id) {
					jQuery.post(ajaxurl,
						{
							action : 'abc_get_posts',
							cat_id : id
						},
						function(res)
						{
							//if(res.success == 1)	
							jQuery("#vid-content").empty();
							jQuery("#vid-content").html(res.html);
						},'json');
				}
				
				jQuery("#category_parent").change(function(){
					var itm = jQuery(this).val();
					get_cat_post(itm);
				});  
				
				jQuery("#vid-content").on({
					ajaxStart: function() { 
						jQuery(this).addClass("loading"); 
						jQuery(this).html("");
					},
					ajaxStop: function() { 
						jQuery(this).removeClass("loading"); 
					}    
				});
			</script>
			<?php
		}
		elseif ( ( is_author() ) || ( in_category( 'videos' ) || post_is_in_descendant_category( 16 ) ) ) {
			
			if ( is_author() )
			{
				$args = array (
					'author_name' => (get_query_var('author_name')),
					'posts_per_page' => 9,
					'paged' => get_query_var('paged')
				);
			}
			elseif ( is_category() )
			{
				$args = array (
					'cat' => (get_query_var('cat')),
					'posts_per_archive_page' => 12,
					'paged' => get_query_var('paged')
				);
			}
			$theposts = new WP_Query();
			$theposts -> query($args);
			
			// No AJAX Videos
			if ( is_category( 'videos' ) ) {
			?>
			<form action="<?php bloginfo('url'); ?>/" method="get" class="form-inline">
				<?php
					$select = wp_dropdown_categories('show_option_none=All&orderby=name&echo=0&child_of=16');
					$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'>", $select);
					echo $select;
				?>
				<noscript><button type="submit" name="submit" class="btn"><i class="icon-arrow-right"></i></button></noscript>
			</form>
			<?php
			} // end No AJAX Videos
			
			?>
				<div class="video-list">
					<?php if ( is_author() )
					{
						echo '<h2>Videos</h2>';
					}
					elseif ( is_category() )
					{	
						
					} 
					echo '<ul class="videos clearfix">';
				
						while ( $theposts -> have_posts() ) : $theposts -> the_post();  
						
						$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true); ?>
								
							<li>
								<div class="thumb">
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
										<img src="http://indiaunheard.videovolunteers.org<?php echo $thumb; ?>" alt="<?php the_title_attribute(); ?>" />
									</a>
								</div>
								<div class="info">
									<div class="item-title">
										<h5><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
										<span class="item-details">
											<?php the_time('m/j/y'); ?><i class="icon-angle-right"></i><?php the_category(' <i class="icon-angle-right"></i> '); ?>
										</span>
									</div>
									<div class="item-meta">
										<!--<div class="row-fluid">
											<div class="views span6">
												<span>150</span> Views
											</div>
											<div class="shares span6">
												<span>50</span> Shares
											</div>
										</div>-->
									</div>
								</div>
							</li>
								
						<?php endwhile; 
						wp_reset_query(); ?>
						
						</ul>
						
				</div>
			<?php 
		}
		else {
			//Run Regular Post Loop
			$theposts = new PageLinesPosts();
			$theposts->load_loop();
		}
	}

}
