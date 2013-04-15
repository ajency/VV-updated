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
			<div class="row-fluid">
				<div class="span8">
					<div id="story-stream">
						<h1 class="stream-header">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h1>
						<div class="meta">
							<em>
								<?php the_time('F j, Y'); ?>
							</em>
						</div>
						<div class="meta-share">
								<a href="http://twitter.com/share?url='. urlencode(get_permalink()) .'&via=videovolunteers&count=horizontal" class="twitter-share-button">Tweet</a>
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=standard&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=25" scrolling="no" frameborder="0" style="border:none; overflow:hidden;  height:25px;" allowTransparency="true"></iframe>
								<g:plusone href="'. urlencode(get_permalink()) .'"></g:plusone>
						</div>
						<div class="excerpt">
							<?php echo $post->post_content; ?>
						</div>
						<div class="video-list">
							<h2 style="text-transform: none; border-top: 1px dotted #ccc; padding-top: 18px;">UPDATE, 12th February: PPSS Leader Abhaya Sahoo Ends Hunger Strike</h2>
							<ul class="videos clearfix">
								<li>
									<div class="thumb">
										<a href="#"><img class="alignnone size-full wp-image-76" alt="pic-2" src="http://www.vv.ajency.in/wp-content/uploads/2013/02/pic-2.jpg" width="255" height="118" /></a>
									</div>
									<div class="info">
										<div class="item-title">
											<h5><a href="#">22 Workers Waiting for their Wage</a></h5>
											<span class="item-details">
												21/01/2012<i class="icon-angle-right"></i><a href="#">Development</a><i class="icon-angle-right"></i><a href="#">Belapur</a>
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
							</ul>
							<!--<div class="vid-pagination"><a class="prev" href="#">Prev</a>
								<a href="#">1</a>
								<a class="selected" href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
								<a href="#">5</a>
								<a href="#">6</a>
								<a href="#">...</a>
								<a href="#">22</a>
								<a class="next" href="#">Next</a>
							</div>-->
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="single-vid-info widget">
						<div class="action-box-arrow"></div>
						<div class="action-box">
							<h2>Click Below to Support <?php the_title(); ?></h2>
							<button class="btn btn-large btn-warning" type="button">Click Here</button>
							<div class="share-button">
								<a href="http://twitter.com/share?url='. urlencode(get_permalink()) .'&via=videovolunteers&count=horizontal" class="twitter-share-button">Tweet</a>
							</div>
							<div class="share-button">
								<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=standard&amp;width=250&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:35px;" allowTransparency="true"></iframe>
							</div>
							<div class="share-button">
								<g:plusone href="'. urlencode(get_permalink()) .'"></g:plusone>
							</div>
						</div>
					</div>
					<div style="clear: both;"></div>
					<div class="widget_stream" id="story-stream">
						<h2 class="updates-header"><span>3 Updates</span> in this Stream</h2>
						<ol class="updates">
							<li>
								<div class="row-fluid">
									<div class="span3">
										<div class="meta"><span>2</span> days ago
										<span class="comments"><em>220</em> comments</span></div>
									</div>
									<div class="span9">
										<h3><a href="#">Update 1: This is the first update</a></h3>
										<div class="excerpt">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer gravida risus id nisl pellentesque eu mattis nisl venenatis. Nulla vitae purus sapien, vitae sodales tellus. Aenean vestibulum odio at felis lobortis faucibus. Nulla facilisi.
										</div>
									</div>
								</div>
							</li>								
						</ol>
					</div>
				</div>
			</div>
		<?php
	}

}
