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
		
		if ( is_author() )
		{
		
			$args = array (
				'author_name' => (get_query_var('author_name')),
			);
			$theposts = new WP_Query();
			$theposts -> query($args); ?>
				<div class="video-list">
					<h2>Videos</h2>
					<ul class="videos clearfix">
				
					<?php while ( $theposts -> have_posts() ) : $theposts -> the_post();  
					
					$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true); ?>
							
						<li>
							<div class="thumb">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
									<img src="http://indiaunheard.videovolunteers.org<?php echo $thumb; ?>" alt="<?php the_title_attribute(); ?>" />
								</a>
							</div>
							<div class="info">
								<div class="item-title">
									<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
									<span class="item-details">
										<?php the_time('m/j/y') ?><i class="icon-angle-right"></i><?php the_category(' <i class="icon-angle-right"></i> ') ?>
									</span>
								</div>
								<div class="item-meta">
									<div class="row-fluid">
										<div class="views span6">
											<span>150</span> Views
										</div>
										<div class="shares span6">
											<span>50</span> Shares
										</div>
									</div>
								</div>
							</div>
						</li>
							
					<?php endwhile; 
					wp_reset_query(); ?>
					
					</ul>
				</div>
			<?php 
		}
	}

}
