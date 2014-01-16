<?php
/*
	Section: Homepage Videos
	Author: Jarryd for Ajency.in
	Author URI: http://www.ajency.in
	Description: Creates a section of the videos for the homepage banner area
	Class Name: VVHomeVideos
	Workswith: templates, main, header, morefoot
	Cloning: true
*/

/**
 * Homepage Videos Section
 *
 * @package PageLines Framework
 * @author Ajency.in
 */
class VVHomeVideos extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		global $post;		
		?>
			<div id="home-videos" class="row-fluid">
				<div class="span8">
					<div class="main-video">
						<?php
						// The Arguments
						$args = array(
							'category_name' => 'featured',
							'posts_per_page' => 1
						);

						// The Query
						$query = new WP_Query( $args );

						// The Loop
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();

								$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true);
								$excerpt = strip_tags(get_the_excerpt());

								echo '<div class="home-vid-container" style="background: url(http://videovolunteers.org/'. $thumb .') no-repeat;">';
								echo '<a href="'. get_permalink() .'">';
								echo '<div class="date">'. get_the_time('j\<\s\p\a\n\>F\<\b\r\>Y\<\/\s\p\a\n\>') .'</div>';
								echo '<div class="play"><img src="'. get_stylesheet_directory_uri() .'/images/url.png" /></div>';
								echo '<div class="caption">';
								echo '<h4 class="title">'. get_the_title() .'</h4>';
								echo '<div class="desc">'. $excerpt .'</div>';
								echo '</div>';
								echo '</a>';
								echo '</div>';
								
							}
						} else {
							// no posts found
						}
						/* Restore original Post Data */
						wp_reset_postdata();
						?>
					</div>
				</div>
				<div class="span4">
					<div class="sub-side">
						<div class="sub-video">
							<?php
							// The Arguments
							$args2 = array(
								'category_name' => 'featured',
								'posts_per_page' => 1,
								'offset' => 1
							);

							// The Query
							$query = new WP_Query( $args2 );

							// The Loop
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();

									$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true);
									$excerpt = strip_tags(get_the_excerpt());

									echo '<div class="home-vid-container" style="background: url(http://videovolunteers.org/'. $thumb .') no-repeat;">';
									echo '<a href="'. get_permalink() .'">';
									echo '<div class="date">'. get_the_time('j\<\s\p\a\n\>F\<\b\r\>Y\<\/\s\p\a\n\>') .'</div>';
									echo '<div class="play"><img src="'. get_stylesheet_directory_uri() .'/images/url.png" /></div>';
									echo '<div class="caption">';
									echo '<h5 class="title">'. get_the_title() .'</h5>';
									echo '<div class="desc">'. $excerpt .'</div>';
									echo '</div>';
									echo '</a>';
									echo '</div>';
									
								}
							} else {
								// no posts found
							}
							/* Restore original Post Data */
							wp_reset_postdata();
							?>
						</div>
						<div class="sub-info">
							<h3>IndiaUnheard is the first ever community news service launched by Video Volunteers.</h3>
							<a href="<?php echo home_url('/about/indiaunheard/'); ?>" title="IndiaUnheard">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/IU.png" />
							</a>
						</div>
					</div>
				</div>
			</div>
			<div id="home-vid-carousel" class="jcarousel-wrapper">
				<div class="jcarousel">
					<ul class="covers">
						<?php
						// The Arguments
						$args2 = array(
							'category_name' => 'featured',
							'posts_per_page' => 8
						);

						// The Query
						$query = new WP_Query( $args2 );

						// The Loop
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();

								$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true);

								echo '<li><div class="home-vid-container" style="background: url(http://videovolunteers.org/'. $thumb .') no-repeat;">';
								echo '<a href="'. get_permalink() .'">';
								echo '<div class="date">'. get_the_time('j\<\s\p\a\n\>F\<\b\r\>Y\<\/\s\p\a\n\>') .'</div>';
								echo '<div class="play"><img src="'. get_stylesheet_directory_uri() .'/images/url.png" /></div>';
								echo '<div class="caption">';
								echo '<h5 class="title">'. get_the_title() .'</h5>';
								echo '</div>';
								echo '</a>';
								echo '</div></li>';
								
							}
						} else {
							// no posts found
						}
						/* Restore original Post Data */
						wp_reset_postdata();
						?>
					</ul>
				</div>
				<a class="jcarousel-control-prev" href="#">‹</a><a class="jcarousel-control-next" href="#">›</a>
			</div>
		<?php
	}
}