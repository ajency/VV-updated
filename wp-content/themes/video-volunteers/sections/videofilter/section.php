<?php
/*
	Section: VideoFilter
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The Video filter. Includes video posts & information.
	Class Name: PageLinesVideoFilter
	Workswith: main
	Failswith: 404_page
*/

/**
 * Main Video Filter Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class PageLinesVideoFilter extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		
		if ( is_author() )
		{
			$args = array (
				'author_name' => (get_query_var('author_name')),
				'posts_per_page' => 6
			);
		}
		elseif ( get_cat_ID('issue') )
		{
			$args = array (
			   
				'cat' => (get_cat_ID('issue')),
				'posts_per_archive_page' => 6
			);
		}
		
		
		$theposts = new WP_Query();
		$theposts -> query($args); ?>
			<div class="video-list">
				<?php if ( is_author() )
				{
					echo '<h2>Videos</h2>';
				}
				elseif ( is_category() )
				{
					
				} ?>
					<h3>Filter your results</h3>
			<?php
				//
			
				$cat_ID = get_cat_ID('issue');
				$results = get_categories('&child_of='.$cat_ID.'&hide_empty');
			?>	

			<select id="division-select" name="sub-filter" ONCHANGE="location = this.options[this.selectedIndex].value;">
			<?php
				foreach ($results as $res){
					
					echo '<option value= "';
					echo network_site_url() . '/category/' . $mylink->slug . '/' . $res->slug ;
					echo '"'. '>';
					echo $res->name;
					echo '</option>';

					var_dump($mylink);
				}
			?>
			</select>
		

 



<script type="text/javascript">
jQuery( function () {

  var jQuerycontainer = jQuery('#isocontent');

  jQuerycontainer.isotope({})

  jQuery('#filter-select,#filter-select2').change( function() {
    jQuerycontainer.isotope({
      filter: this.value
    });
  });

});
</script>
			
			
			
				
				<ul id="isocontent" class="videos clearfix">
			
				<?php while ( $theposts -> have_posts() ) : $theposts -> the_post();  
				
				$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true); ?>
						
					<li class="<?php
foreach( get_the_category($post->ID) as $cat ) { echo $cat->slug . '' ; }; ?>">
						<div class="thumb " >
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
