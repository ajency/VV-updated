<?php
/*
	Section: Homepage Tabs
	Author: Jarryd for Ajency.in
	Author URI: http://www.ajency.in
	Description: Creates a section with tabs of the categories and authors below the homepage banner area
	Class Name: VVHomeTabs
	Workswith: templates, main, header, morefoot
	Cloning: true
*/

/**
 * Homepage Tabs Section
 *
 * @package PageLines Framework
 * @author Ajency.in
 */
class VVHomeTabs extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		global $post;		
		?>
			<div id="home-tabs" class="tabbable tabs-left">
			  <ul class="nav nav-tabs">
			    <li class="active"><a href="#A"><h4>Issues</h4><span>Latest Videos on different Issues</span></a></li>
			    <li><a href="#B"><h4>States</h4><span>Latest Videos from different States</span></a></li>
			    <li><a href="#C"><h4>Community Correspondents</h4><span>Meet our Correspondents</span></a></li>
			  </ul>
			  <div class="tab-content">
			    <div class="tab-pane active" id="A">
			      	<?php
						// The Query
						global $wpdb;
						$sql = "select p.ID as pid, p.post_title as ptitle ,t.name as tname, t.term_id as tid from wp_posts p join wp_term_relationships r on p.ID = r.object_id join wp_terms t on t.term_id = r.term_taxonomy_id where post_type = 'post' and post_status = 'publish'and t.term_id in (select term_id from wp_term_taxonomy where parent = 16 ) order by ID desc";

						$datas = $wpdb->get_results($sql, ARRAY_A);
						$check_category = array();

						$check_post = array();
						$cnt = 0;
						
						// The Loop
						foreach($datas as $data){
							if(!in_array($data["tid"], $check_category) && !in_array($data["pid"], $check_post)  && $cnt <6 ) {
								$check_category[] = $data["tid"];
								$check_post[] = $data["pid"];
								$thumb = get_post_meta($data["pid"], 'Thumbnail', true);

								echo '<div class="home-tab-vid">';
								echo '<a href="'. get_permalink($data["pid"]) .'" class="thumb"><img src="http://videovolunteers.org/'. $thumb .'" /></a>';
								echo '<div class="caption">';
								echo '<div class="cat">Issue: '. $data["tname"] .'</div>';
								echo '<h6 class="title"><a href="'. get_permalink($data["pid"]) .'">'. get_the_title($data["pid"]) .'</a></h6>';
								echo '<div class="date">Posted on '. get_the_time('F j, Y', $data["pid"]) .'</div>';
								echo '<div class="desc">'. human_time_diff( get_the_time('U', $data["pid"]), current_time('timestamp') ) . ' ago</div>';
								echo '</div>';
								echo '</div>';
								$cnt++;
							}
							 else {
								// no posts found
							}
						}
						
						/* Restore original Post Data */
						wp_reset_postdata();
					?>
			    </div>

			    <div class="tab-pane" id="B">
			    	<?php
						// The Query
						global $wpdb;
						$sql = "select p.ID as pid, p.post_title as ptitle ,t.name as tname, t.term_id as tid from wp_posts p join wp_term_relationships r on p.ID = r.object_id join wp_terms t on t.term_id = r.term_taxonomy_id where post_type = 'post' and post_status = 'publish'and t.term_id in (select term_id from wp_term_taxonomy where parent in (select term_id from wp_term_taxonomy where parent = 10) ) order by ID desc";

						$datas = $wpdb->get_results($sql, ARRAY_A);
						$check_category = array();

						$check_post = array();
						$cnt = 0;
						
						// The Loop
						foreach($datas as $data){
							if(!in_array($data["tid"], $check_category) && !in_array($data["pid"], $check_post)  && $cnt <6 ) {
								$check_category[] = $data["tid"];
								$check_post[] = $data["pid"];
								$thumb = get_post_meta($data["pid"], 'Thumbnail', true);

								echo '<div class="home-tab-vid">';
								echo '<a href="'. get_permalink($data["pid"]) .'" class="thumb"><img src="http://videovolunteers.org/'. $thumb .'" /></a>';
								echo '<div class="caption">';
								echo '<div class="cat">State: '. $data["tname"] .'</div>';
								echo '<h6 class="title"><a href="'. get_permalink($data["pid"]) .'">'. get_the_title($data["pid"]) .'</a></h6>';
								echo '<div class="date">Posted on '. get_the_time('F j, Y', $data["pid"]) .'</div>';
								echo '<div class="desc">'. human_time_diff( get_the_time('U', $data["pid"]), current_time('timestamp') ) . ' ago</div>';
								echo '</div>';
								echo '</div>';
								$cnt++;
							}
							 else {
								// no posts found
							}
						}
						
						/* Restore original Post Data */
						wp_reset_postdata();
					?>
			    </div>

			    <div class="tab-pane" id="C">
			    <?php	
				    // Author Query
				    $feat_args = array(
						'meta_key'     => 'featured_auth',
						'meta_value'   => 'true',
						'fields'       => 'all',
						'number'       => '6'
					 );
					 
					$users = get_users($feat_args);
					
					// Start Code	
					foreach ( $users as $user ) { ?>
						<div class="home-tab-vid">
							<div class="row-fluid">
								<a href="<?php echo get_author_posts_url( $user->ID ); ?>" class="thumb"><?php echo get_avatar( $user->ID , 220 ); ?></a>
								<div class="caption">
									<h6 class="title"><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php echo get_the_author_meta( 'display_name', $user->ID ); ?></a></h6>
									<div class="desc">
										<?php echo substr(get_the_author_meta( 'description', $user->ID ), 0, 160); ?>...
									</div>
								</div>
							</div>
						</div>
					<?php }
			    ?>
			    </div>
			  </div>
			</div>
			<script type="text/javascript">
				jQuery('.tabbable .nav-tabs li a').click(function (e) {
				  e.preventDefault();
				  jQuery(this).tab('show');
				})
			</script>
		<?php
	}
}