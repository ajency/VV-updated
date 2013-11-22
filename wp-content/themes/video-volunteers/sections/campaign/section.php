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
						<div class="featured-image-header">
							<?php 
							if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
							  the_post_thumbnail('full');
							} 
							?>
						</div>
						<h1 class="stream-header">
							<?php the_title(); ?>
						</h1>
						<div class="meta">
							Posted on <b><?php the_time('F j, Y'); ?></b>
						</div>
						<div class="meta-share">
								<a href="http://twitter.com/share?url=<?php urlencode(get_permalink()); ?>&via=videovolunteers&count=horizontal" class="twitter-share-button">Tweet</a>
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=standard&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=25" scrolling="no" frameborder="0" style="border:none; overflow:hidden;  height:25px;" allowTransparency="true"></iframe>
								<g:plusone href="'. urlencode(get_permalink()) .'"></g:plusone>
						</div>
						<div class="excerpt">
							<?php echo $post->post_content; ?>
						</div>
						<div class="campaign-video-list">
							<?php
								//$campaign_vids = get_post_custom_values('agc_video_campaign', $post->ID);
								$nonce 		= wp_create_nonce('agc_video_campaign');
								$campaign_vids 	= get_post_meta($post->ID, 'agc_video_campaign', true);
								/*echo '<pre>';
								print_r($campaign_vids);
								echo '</pre>';*/
							?>
							<ul class="videos clearfix">
								<?php if($campaign_vids!='')
								{
									foreach ( $campaign_vids as $c_vid ) { 
									
									 $videoID = youtube_id_from_url($c_vid['videolink']);
								?>
								<li>
                                <div class="videotitle"><?php echo $c_vid['name']?></div>
									<div class="vid-thumb">
										<?php echo do_shortcode('[pl_video type="youtube" id="'.$videoID.'"]'); ?>
									</div>
                                    <div class="videodesc"><?php echo $c_vid['video-description']?></div>
								</li>
								<?php } 
								}?>
							</ul>
						</div>
					</div>
				</div>
				<div class="span4">
					<!--<div class="single-campaign-info widget">
						<div class="action-box-arrow visible-desktop"></div>
						<div class="action-box">
							<h2>Share to Support <?php the_title(); ?></h2>
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
					</div>-->
					<?php
						//Get Change.org Petition ID
						$change_id = get_post_meta($post->ID, 'vv_change_petition', true);
						if (!empty($change_id)) {
						
							$API_KEY = '3ac98f5d260b8758b9e19a759f83bef44ab00da2cf16f0d6eb1ab336dae158b8';
							$REQUEST_URL = 'http://api.change.org/v1/petitions/get_id';
							$PETITION_URL = $change_id;

							$parameters = array(
							  'api_key' => $API_KEY,
							  'petition_url' => $PETITION_URL
							);

							$query_string = http_build_query($parameters);
							$final_request_url = "$REQUEST_URL?$query_string";
							$response = file_get_contents($final_request_url);

							$json_response = json_decode($response, true);
							$petition_id = $json_response['petition_id'];
						
						?>
						<div id="change-widget">
							<div id="change_BottomBar">
								<span id="change_Powered"><a href="http://www.change.org" target="_blank">Petitions</a> by Change.org</span>
								<a>|</a>
								<span id="change_Start">Start a <a href="http://www.change.org/petition" target="_blank">Petition</a> &raquo;</span>
							</div>
							<?php //var_dump($petition_id); ?>
							<script type="text/javascript" src="http://e.change.org/flash_petitions_widget.js?width=300&color=F26B26&petition_id=<?php echo $petition_id; ?>"></script>
						</div>
					<?php } ?>
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
                    
                    <div class="campaign-single-pagewidget">
                    <?php
					$pageid=$post->ID;
					// The Query
$query = new WP_Query(	array('post_type' => 'page', 'posts_per_page' => 3, 'orderby' => 'menu_order', 'meta_query' => array(array(
					'value' => 'page.campaign.php',
					'compare' => 'LIKE'
					)) ) );

/*echo '<pre>';
print_r($query);
echo '</pre>';*/

// The Loop
echo '<h3 class="widget-title">CAMPAIGNS</h3>';
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		if($query->post->ID!=$pageid)
		{
		echo '<div class="videowidget"><div class="img">';
		echo the_post_thumbnail();
		echo '</div><div class="campaignwidget"><a href="'.get_permalink($query->post->ID).'">' . get_the_title() . '</a><br></div><p>'.$query->post->post_excerpt.'</p></div>';
		}
	}
} else {
	echo "no posts found";
}
	
					?>
                    </div>
                    
				</div>
			</div>
		</div>
		<?php
	}
}
