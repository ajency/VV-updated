<?php
/*
	Section: Campaign Page
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The Video Campaign Section. Includes videos & campaign information.
	Class Name: VVCampaign	
	Workswith: templates, main, header, morefoot
	Failswith: 404_page
*/

/**
 * Video Campaign Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class VVCampaign extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		global $post;		
		?>
		<div class="campaign-container">
			<div class="row-fluid">
				<div class="span8">
					<div id="campaign-page">
						<h1 class="stream-header">
							<?php the_title(); ?>
						</h1>
						<div class="meta">
							Posted on <b><?php the_time('F j, Y'); ?></b>
						</div>
						<div class="meta-share">
								<a href="http://twitter.com/share?url='. urlencode(get_permalink()) .'&via=videovolunteers&count=horizontal" class="twitter-share-button">Tweet</a>
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=standard&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=25" scrolling="no" frameborder="0" style="border:none; overflow:hidden;  height:25px;" allowTransparency="true"></iframe>
								<g:plusone href="'. urlencode(get_permalink()) .'"></g:plusone>
						</div>
						<div class="excerpt">
							<?php echo $post->post_content; ?>
						</div>
						<div class="campaign-video-list">
							<?php
								$campaign_vids = get_post_custom_values('CampaignVideo', $post->ID);
							?>
							<ul class="videos clearfix">
								<?php 
									foreach ( $campaign_vids as $c_vid ) { 
									
									$videoID = youtube_id_from_url($c_vid);
								?>
								<li>
									<div class="vid-thumb">
										<?php echo do_shortcode('[pl_video type="youtube" id="'.$videoID.'"]'); ?>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="single-campaign-info widget">
						<div class="action-box-arrow visible-desktop"></div>
						<div class="action-box">
							<h2>Share to Support <?php the_title(); ?></h2>
							<!--<button class="btn btn-large btn-warning" type="button">Click Here</button>-->
							<div class="share-button">
								<a href="http://twitter.com/share?url='. urlencode(get_permalink()) .'&via=videovolunteers&count=horizontal" class="twitter-share-button">Tweet</a>
							</div>
							<div class="share-button">
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>
							</div>
							<div class="share-button">
								<g:plusone href="'. urlencode(get_permalink()) .'"></g:plusone>
							</div>
						</div>
					</div>
					<div style="clear: both;margin: 10px 0 0;"></div>
					<div class="widget_stream" id="story-stream">
						<?php 
							$stream_id = get_post_meta($post->ID, 'vv_belongs_to_display', true);
							$updates = check_for_updates($stream_id);
							if($updates) {
						?>
						<h2 class="updates-header">
							<span><?php echo count($updates); ?> Updates</span> for <?php echo get_the_title($stream_id); ?>
						</h2>
						<ol class="updates">
							<?php foreach ($updates as $up) { 
							setup_postdata( $up );
							?>
							<li>
								<div class="row-fluid">
									<div class="span2">
										<div class="meta">
											<span><?php echo human_time_diff( get_the_time('U', $up), current_time('timestamp') ) . ' ago'; ?></span>
											<span class="comments"><em><?php echo $up->comment_count; ?></em><i class="icon-comments" style="font-size: 1.5em;"></i></span>
										</div>
									</div>
									<div class="span10">
										<h3><a href="<?php echo get_permalink($up); ?>"><?php echo $up->post_title; ?> </a></h3>
										<div class="excerpt"><?php echo the_excerpt($up); ?></div>
									</div>
								</div>
							</li>
							<?php } ?>
						</ol>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
