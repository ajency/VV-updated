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
				<div class="span12">
					<div id="campaign-page">
						<h1 class="stream-header">
							<?php the_title(); ?>
						</h1>
						<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							?>
							<div class="featured-image-header">
								<?php the_post_thumbnail('full'); ?>
							</div>
						<?php } ?>
						<div class="row-fluid">
							<div class="span8">
								<div class="excerpt">
									<?php echo $post->post_content; ?>
								</div>
							</div>
							<div class="span4 side-vid">
								<?php
									$nonce 		= wp_create_nonce('agc_video_campaign');
									$campaign_vids 	= get_post_meta($post->ID, 'agc_video_campaign', true);
								?>
									<?php if($campaign_vids!='')
									{
										foreach ( $campaign_vids as $c_vid ) { 
										
											$videoID = youtube_id_from_url($c_vid['videolink']);
									?>
										<div class="vid-thumb">
											<?php echo do_shortcode('[pl_video type="youtube" id="'.$videoID.'"]'); ?>
										</div>
										<?php break;
										} 
									} ?>
							</div>
						</div>
						<div class="grey-bg">
							<div class="arrow"></div>
							<h3 class="goal">Our Goals</h3>
							<h5 class="achieve">We want to achieve</h5>
							<div class="campaign-goal-list">
								<?php
									$nonce = wp_create_nonce('agc_goals_campaign');
									$campaign_goals = get_post_meta($post->ID, 'agc_goals_campaign', true);
								?>
								<ul class="goals clearfix">
									<?php if($campaign_goals!='')
									{
										foreach ( $campaign_goals as $c_goal ) { 	
											if($c_goal['goals']!='') {
											?>
												<li>
				                                	<div class="title"><?php echo $c_goal['goals']?></div>
				                                    <div class="desc"><?php echo $c_goal['goals-description']?></div>
												</li>
											<?php } 
										} 
									}?>
								</ul>
							</div>
						</div>
						<div class="arrow"></div>
						
						<div class="social-actions">
							<h3>Voices of <?php the_title(); ?></h3>
							<h5>Help Spread the word, Share a Story</h5>
							<?php
								$Path = $_SERVER['REQUEST_URI'];
								$source_url = "http://videovolunteers.org".$Path;
								$url = "http://api.facebook.com/restserver.php?method=links.getStats&urls=".urlencode($source_url);
								$xml = file_get_contents($url);
								$xml = simplexml_load_string($xml);
								
								// Facebook
								$shares = $xml->link_stat->share_count;
								$likes = $xml->link_stat->like_count;
								$comments = $xml->link_stat->comment_count; 
								$total = $xml->link_stat->total_count;

								// Twitter
								// Add our current post's URL to the end of Twitter's API URL
								$twitter_url = file_get_contents( 'http://urls.api.twitter.com/1/urls/count.json?url=' . $source_url );
								 
								// Decode the URL in json
								$twitter_shares = json_decode( $twitter_url, true );
								 
								// Set our variable
								$tweet_count = $twitter_shares['count'];
							?>
							<div class="row-fluid">
								<div class="span4">
									<h6 class="soc-head">Facebook</h6>
									<div class="socialcount">
										<div class="count"><?php echo $total; ?></div>
										<span>Likes and Shares</span>
									</div>
									<div class="soc-action">
										<div class="fb-share-button" data-href="http://developers.facebook.com/docs/plugins/" data-type="button"></div>
									</div>
								</div>
								<div class="span4">
									<h6 class="soc-head">Twitter</h6>
									<div class="socialcount">
										<div class="count"><?php echo $tweet_count; ?></div>
										<span>Tweets</span>
									</div>
									<div class="soc-action">
										<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="none" data-size="medium">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									</div>
								</div>
								<div class="span4">
									<h6 class="soc-head">Google+</h6>
									<div class="socialcount">
										<div class="count"><?php echo get_plusones($source_url); ?></div>
										<span>PlusOnes</span>
									</div>
									<div class="soc-action">
										<!-- Place this tag where you want the +1 button to render. -->
										<div class="g-plusone" data-size="medium" data-annotation="none"></div>

										<!-- Place this tag after the last +1 button tag. -->
										<script type="text/javascript">
										  (function() {
										    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										    po.src = 'https://apis.google.com/js/platform.js';
										    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										  })();
										</script>
									</div>
								</div>
							</div>
							<div class="ormail">
								<h5>OR<br>share via email</h5>
								<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
								<a class="addthis_button_email"></a>
								</div>
								<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52ccfe38091ce4f2"></script>
								<!-- AddThis Button END -->
							</div>
						</div>

						<div class="grey-bg gradient">
							<div class="arrow"></div>
							<div class="campaign-videos">
								<h3>Voices of <?php the_title(); ?></h3>
								<h5>Help Spread the word, Share a Story</h5>
								<?php
									$nonce = wp_create_nonce('agc_video_campaign');
									$campaign_vids 	= get_post_meta($post->ID, 'agc_video_campaign', true);
								?>
								<div id="grid" class="clearfix">
									<?php if($campaign_vids!='')
									{
										foreach ( $campaign_vids as $c_vid ) { 
										
										 $videoID = youtube_id_from_url($c_vid['videolink']);
										 if($c_vid['name']!='') {
											?>
											<div class="box">
												<div class="vid-thumb">
													<?php echo do_shortcode('[pl_video type="youtube" id="'.$videoID.'"]'); ?>
												</div>
											</div>
											<?php } 
										}
									}?>
								</div>
								<div id="fillers">
									<div class="fillerBox"></div>
									<div class="fillerBox grey"></div>
									<div class="fillerBox lgrey"></div>
								</div>
							</div>
						</div>

						<div class="widget_stream" id="campaign-story-stream">
						<?php 
							$stream_id = get_post_meta($post->ID, 'vv_belongs_to_display', true);
							$updates = check_for_updates($stream_id);
							if($updates) {
						?>
						<h2 class="updates-header">
							<span><?php echo count($updates); ?> Stories About</span> <?php echo get_the_title($stream_id); ?>
						</h2>
						<h5 class="sub-head">Help Spread the word, Share a Story</h5>
						<ol class="updates">
							<?php foreach ($updates as $up) { 
							setup_postdata( $up );
							?>
							<li>
								<div class="row-fluid">
									<div class="span1">
										<div class="meta">
											<?php echo get_the_time( '\<\s\p\a\n\>d\<\/\s\p\a\n\> M Y', $up->ID ); ?> 
										</div>
									</div>
									<div class="span11">
										<h3><a href="<?php echo get_permalink($up); ?>"><?php echo $up->post_title; ?> </a><small><?php echo human_time_diff( get_the_time('U', $up), current_time('timestamp') ) . ' ago'; ?></small></h3>
										<div class="excerpt"><?php echo substr(get_the_content($up), 0, 360); ?>...</div>
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
		</div>
		<script>
		jQuery(function(){
			jQuery("#grid").mason({
				itemSelector: ".box",
				ratio: 1.5,
				sizes: [
					[1,1],
					[2,2]
				],
				columns: [
					[0,480,1],
					[480,780,2],
					[780,1080,3],
					[1080,1320,4],
					[1320,1680,5]
				],
				filler: {
					itemSelector: '.fillerBox',
					filler_class: 'custom_filler'
				},
				layout: 'fluid',
				gutter: 2
			});
		});
		</script>
		<?php
	}
}
