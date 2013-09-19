<?php
/*
	Section: All Campaigns Page
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The Campaigns View. Shows a list of campaigns.
	Class Name: VVAllCampaigns	
	Workswith: templates, main, header, morefoot
	Failswith: 404_page
*/

/**
 * All Campaigns Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class VVAllCampaigns extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		global $post;		
		?>
		<div class="campaign-container">
			<div class="row-fluid">
				<div class="span12">
					<div id="all-campaigns-page">
						<h1 class="stream-header">
							<?php the_title(); ?>
						</h1>
						<div class="excerpt">
							<?php echo $post->post_content; ?>
						</div>
						<div class="campaign-list clearfix">
							<?php
							$pageid=$post->ID;
							// The Query
							$query = new WP_Query(	array('post_type' => 'page', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'meta_query' => array(array(
								'value' => 'page.campaign.php',
								'compare' => 'LIKE'
								)) ) );

							// The Loop
							echo '<h2 class="list-title">Stories that need your help to get the word out...</h2>';
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();
									if($query->post->ID!=$pageid)
									{
										echo '<div class="campaign">';
										echo '<h3><a href="'.get_permalink($query->post->ID).'">' . get_the_title() . '</a></h3><div class="img">';
										echo the_post_thumbnail();
										echo '</div><div class="excerpt"><p>'.$query->post->post_excerpt.'</p></div>';
										echo '<a href="'.get_permalink($query->post->ID).'" class="read-more">Read More &rarr;</a></div>';
									}
								}
							} else {
								echo "No Campaigns Found!";
							}
			
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
