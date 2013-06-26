<?php
// Setup  -- Probably want to keep this stuff... 

/**
 * Hello and welcome to Base! First, lets load the PageLines core so we have access to the functions 
 */	
require_once( dirname(__FILE__) . '/setup.php' );
	
// For advanced customization tips & code see advanced file.
	//--> require_once(STYLESHEETPATH . "/advanced.php");
	
// ====================================================
// = YOUR FUNCTIONS - Where you should add your code  =
// ====================================================


// ABOUT HOOKS --------//
	// Hooks are a way to easily add custom functions and content to PageLines. There are hooks placed strategically throughout the theme 
	// so that you insert code and content with ease.


// ABOUT FILTERS ----------//

	// Filters allow data modification on-the-fly. Which means you can change something after it was read and compiled from the database,
	// but before it is shown to your visitor. Or, you can modify something a visitor sent to your database, before it is actually written there.

// FILTERS EXAMPLE ---------//

	// The following filter will add the font  Ubuntu into the font array $thefoundry.
	// This makes the font available to the framework and the user via the admin panel.

function output_css_js() {
	
	echo '<link href="http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700,300,800" rel="stylesheet" type="text/css">';
	echo '<script src="'. get_bloginfo('stylesheet_directory') .'/js/isotope.js"></script>';
	
}

add_action('pagelines_head_last','output_css_js',10);	
	
	
/****Header Bar Output****/
function output_header_bar() {
	echo '<div class="texture"><div class="content"><div class="content-pad"><div class="logo-bar fix">';
	echo '<a href="'. get_bloginfo('url') .'" class="logo-link"><img src="'. get_bloginfo('stylesheet_directory') .'/images/site-logo.png" alt="Video Volunteers" /></a>';
	echo '<div class="impact fix">';
	echo '<div class="impact-image">';
	echo '<a href="'. get_bloginfo('url') .'/about-videovolunteers/impact/"><img src="'. get_bloginfo('stylesheet_directory') .'/images/impact.png" alt="Video Volunteers" /></a>';
	echo '</div>';
	echo '<div class="impact-desc">';
	
	// Get Latest Impact Post
		$args = array (
			'cat' => 4212,
			'posts_per_page' => 1,
		);
		$query = new WP_Query( $args );
		while ( $query->have_posts() ) : $query->the_post();
			$snippet = substr( get_the_excerpt(), 0, 100 );
			echo '<h6>';
			echo the_title();
			echo '</h6>';
			echo '<p>';
			echo $snippet;
			echo '...</p>';
			echo '<a href="'. get_permalink() .'" class="more-link"><i class="icon-plus"></i>&nbsp;More</a>';
		endwhile;
		wp_reset_postdata();
		
	echo '</div>';
	echo '</div></div></div></div></div>';
}

add_action('pagelines_before_navbar','output_header_bar',10);

/****Search Form Icon****/
function search_form_icon() {
	echo '<span class="search-icon"><i class="icon-search"></i></span>';
}

add_action('get_search_form','search_form_icon',10);

/****Tag Line Output****/
function output_tag_line() {
	if ( is_front_page() ) {
		echo '<div class="texture"><div class="content"><div class="content-pad"><div class="tag-line fix">';
		echo '<h3>We train marginalised communities to produce</h3>';
		echo '<h1><em>News</em>, <em>Watch It</em>, <em>Take Action</em> &amp; <em>Devise Solutions</em>.</h1>';
		echo '</div></div></div></div></div>';
	}
	else {
		//Do not output Tag Line
	}
}

add_action('pagelines_after_navbar','output_tag_line',10);

function output_category_line() {
	
		echo '<div class="texture"><div class="content"><div class="content-pad"><div class="tag-line fix">';
		echo '<h3>We train marginalised communities to produce</h3>';
		echo '<h1><em>News</em>, <em>Watch It</em>, <em>Take Action</em> &amp; <em>Devise Solutions</em>.</h1>';
		echo '</div></div></div></div></div>';

}

add_action('pagelines_before_videofilter','output_category_line',10);

/****Output Titles for Homepage Boxes****/
function output_homepage_titles() {
	echo '<div class="action-titles"><h3 class="main-title hide">What Can You Do?</h3>';
}

add_action('pagelines_inside_bottom_boxes', 'output_homepage_titles',1);

/****Plus One Script****/
function add_social_scripts() {
	echo '<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>';
	echo '<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>';
}
add_action('wp_footer', 'add_social_scripts');

/****Output Social Bar in Content****/
function insertSocial($content) {
	if( is_single() && in_the_loop() ) {
		$content = trim($content);
		$content_array = explode(">",$content);
		$content_new = '<div class="social-bar">';
		$content_new.= '<h4>Think this issue needs more voices? <small>Help spread the word, Share this story.</small></h4>';
		$content_new.= '<div class="social-buttons">';
		// Twitter Tweet Button
		$content_new.= '<div class="social-button"><a href="http://twitter.com/share?url='. urlencode(get_permalink()) .'&via=videovolunteers&count=vertical" class="twitter-share-button">Tweet</a></div>';
		// Facebook Button
		$content_new.= '<div class="social-button"><iframe src="//www.facebook.com/plugins/like.php?href='. urlencode(get_permalink()) .'&amp;send=false&amp;layout=box_count&amp;width=45&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:45px; height:65px;" allowTransparency="true"></iframe></div>';
		// Google+ Button
		$content_new.= '<div class="social-button"><g:plusone size="tall" href="'. urlencode(get_permalink()) .'"></g:plusone></div>';

		$content_new.= '</div>';
		$content_new.= '</div';

		$temp_content_array = array();
		$content_para_count = count($content_array );	
	
		if($content_para_count<=2)
		{
			if($content_para_count===0)
				$content_new .= '>';
				
			$content_array[] = $content_new;
		}
		else
		{
			for($i=0;$i<$content_para_count;$i++)
				{	
					$temp_content_array[]  = $content_array[$i];
					if($i==9)
					{
						$temp_content_array[] = $content_new;
					}	
				}
				
				$content_array = $temp_content_array;
		}
		$content = implode(">",$content_array);	
	  
	}
	return $content;
}

add_filter ('the_content', 'insertSocial');

/****Function to add Read more to the content of a Page with child Pages****/
function page_readmore_script() {
	if ( is_page() ) {
	$post = get_post();
	$children = get_pages('child_of='.$post->ID);
	$vv_after_loop = did_action( 'loop_start' );
		
		if( count( $children ) != 0 && $vv_after_loop === 2 ) { 
			?>
				<style type="text/css">#post-<?php echo $post->ID; ?> {display: none;}</style>
				<div class="post-meta">
					<h1 class="entry-title"><?php echo $post->post_title; ?></h1>
				</div>
				<div class="excerpt-spl entry_content">
					<p><?php echo $post->post_excerpt; ?></p>
				</div>
				<a class="read-full-content btn btn-mini" href="#"><i class="icon-caret-up"></i> / <i class="icon-caret-down"></i></a>
				<script>
					jQuery('.read-full-content').click(function() {
					  jQuery('#post-<?php echo $post->ID; ?>').slideToggle('slow', function() {
						// Animation complete.
						jQuery('.excerpt-spl').slideToggle('slow');
					  });
					  return false;
					});
				</script>
			<?php 
		}
	}
}

add_action('loop_start','page_readmore_script',10);

/****Function appending a list of child pages****/
function append_child_pages() {
	global $wpdb;
    global $post;
 
    /*
     * create a query that will locate all children of THIS page keeping
     * the ORDER in specified in this page.
     */
    $sql = "SELECT * FROM $wpdb->posts WHERE post_parent = " . $post->ID . " AND post_type = 'page' ORDER BY menu_order";
 
    // do the query
    $child_pages = $wpdb->get_results( $sql, 'OBJECT' );
   
    $html .= "<hr>";
		
    // walk the pages we have found
    if ( $child_pages ) {
		
		$html .= "<div class='child-pages row-fluid'>\n";
		
        /*
         * The $first variable is used to select the div elements that start
         * a new row, this is strictly for styling (.css) purposes.
         *
         * this is all within the context of the 'columns' .css selectors provided
         * by StudioPress.  You can roll your own, it's simple.  Ask me if you like.
         */
        $first = true;
 
        /*
         * every child page we have we are going to create a grid element (is that
         * the right word?)
         */  
        foreach ( $child_pages as $cp ) {

            setup_postdata( $cp );
 
            // Get a 'medium' size featured image
            $th = get_the_post_thumbnail( $cp->ID, 'medium' );
            $permalink = get_permalink( $cp->ID );
 
            /*
             * This is where we create an alternating selector by turning the
             * 'first' class on and off to create a two column grid.
             */
			
            $class = 'child span6';
            if ( $first ) {
                $class .= ' first';
            }

            // set the column selector
            $html .= "<div class='" . $class . "'>\n";

            // Link the thumbnail image to the child page.
            $html .=
                "<a href='" . $permalink . "' rel='bookmark' title='" . $cp->post_title . "'>" .
                $th .
                "</a><br/>\n";
 
            // Might as well link the page title to the page as well.
            $html .= "<h5 class='child_entry-title'>" .
                "<a href='" . $permalink . "' rel='bookmark' title='" . $cp->post_title . "'>" .
                $cp->post_title .
            "</a></h5>\n";
			$html .= "<div class='page_excerpt'><span> ".$cp->post_excerpt."</span> <br> <a class='continue_reading_link' href='". $permalink ."' >Read More -></a> </div>\n";
			$html .=""; 
			$html .= "</div>\n";

            // Toggle between being first and not first
            $first = ! $first;
       
		}
    $html .= "</div>\n";
	}
    
    // spit it out
    echo $html;
}
add_action('pagelines_inside_bottom_postloop','append_child_pages',10);

/**
 * Function to get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
function youtube_id_from_url($link){

	$regexstr = '~
		# Match Youtube link and embed code
		(?:                             # Group to match embed codes
			(?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
			|(?:                        # Group to match if older embed
				(?:<object .*>)?      # Match opening Object tag
				(?:<param .*</param>)*  # Match all param tags
				(?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
			)?                          # End older embed code group
		)?                              # End embed code groups
		(?:                             # Group youtube url
			https?:\/\/                 # Either http or https
			(?:[\w]+\.)*                # Optional subdomains
			(?:                         # Group host alternatives.
			youtu\.be/                  # Either youtu.be,
			| youtube\.com              # or youtube.com
			| youtube-nocookie\.com     # or youtube-nocookie.com
			)                           # End Host Group
			(?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
			([\w\-]{11})                # $1: VIDEO_ID is numeric
			[^\s]*                      # Not a space
		)                               # End group
		"?                              # Match end quote if part of src
		(?:[^>]*>)?                       # Match any extra stuff up to close brace
		(?:                             # Group to match last embed code
			</iframe>                 # Match the end of the iframe
			|</embed></object>          # or Match the end of the older embed
		)?                              # End Group of last bit of embed code
		~ix';

	preg_match($regexstr, $link, $matches);

	return $matches[1];

}

/****Function to get Video View Count****/
function count_views( $youtube_id ) {
	$video_ID = youtube_id_from_url($youtube_id);
	$JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_ID}?v=2&alt=json");
	$JSON_Data = json_decode($JSON);
	$views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
	echo $views;
}

/****Output Single Video Posts****/
function output_single_video() {
	if ( is_single() )
	{
	$video = get_post_meta(get_the_ID(), 'Video', true); 
	if($video !== '') 
	//loop here
		{ 
		?>
			<style>
				section.post-meta {display: none;}
			</style>
			<div class="single-vid-container">
				<div class="row-fluid">
					<div class="span8">
						<div class="single-vid">
							<div class="single-vid-title-bar">
								<div class="meta">
									<?php echo get_the_category_list( __( ' | ' ) ); ?>
								</div>
								<h1 class="title"><?php the_title(); ?></h1>
							</div>
							<div class="vid-con">
								<?php echo do_shortcode('[pl_video type="youtube" id="'.youtube_id_from_url($video).'"] '); ?>
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="single-vid-info">
							<div class="action-box-arrow"></div>
							<div class="action-box">
								<h2>This issue needs your voice! <small>Share this story.</small></h2>
								<!-- Views/Shares Counter
								<h2 class="views">500<small>Views</small></h2>
								<h2 class="shares">50<small>Shares</small></h2>
								
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Facebook Like/Share</a>
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Tweet This</a>
								<a class="more-link" href="#"><i class="icon-plus"></i>&nbsp;Email This</a>
								-->
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
							<?php
							//Add a Hook for author info
							do_action( 'vv_video_sidebar' );
							
							$highlight_text = get_post_meta( get_the_ID(), '_higlight_text', true);
							if ($highlight_text !== '') {
							?>
								<div class="info-box-arrow"></div>
								<div class="info-box">
									<p><?php echo get_post_meta( get_the_ID(), '_higlight_text', true); ?></p>
								</div>
								<script>
									jQuery(document).ready(function(){
										jQuery('.info-box p').mCustomScrollbar();
									});
								</script>
							<?php
								//Enqueue Custom Scroll Scripts
								wp_enqueue_script(
									'custom-scroll',
									get_stylesheet_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js',
									array( 'jquery' )
								);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	//end loop here
	}
}

add_action('pagelines_content_before_columns', 'output_single_video',1);

/****Output Single Video Author Meta****/
function output_single_video_author() {
	if ( is_single() )
	{
	$video = get_post_meta(get_the_ID(), 'Video', true); 
	if($video !== '') 
	//loop here
		{ 
		$curauth = get_queried_object()->post_author;
		?>
			<div class="about-vid">
				<div class="author-info">
					<h3>Video By Community Correspondent</h3>
					<div class="row-fluid">
						<div class="avatar span1">
							<?php echo get_avatar( get_the_author_meta('ID', $curauth), 150 ); ?>
						</div>
						<div class="details span11">
							<h4>
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID', $curauth) ); ?>"><?php echo get_the_author_meta('display_name', $curauth); ?></a>
							</h4>
						</div>
					</div>
					<span class="desc"><?php echo substr( get_the_author_meta('description', $curauth), 0, 160 ); ?>...</span>
					<span class="connect">Connect with <?php echo get_the_author_meta('display_name', $curauth); ?>&nbsp;
					<!--	<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-fb.png" alt="connect-fb" width="16" height="16" class="alignnone size-full wp-image-233" /></a>
						<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-twitter.png" alt="connect-twitter" width="16" height="16" class="alignnone size-full wp-image-234" /></a>-->
						<a href="#auth-<?php echo get_the_author_meta('ID', $curauth); ?>" data-toggle="modal"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-email.png" alt="connect-email" width="16" height="16" class="alignnone size-full wp-image-232" /></a>
					</span>
				</div>
			</div>
			<?php 	
			//Contact Author Form					
			if ($_POST["email2"]<>'') { 

				$admin_email = get_the_author_meta('email', $curauth);	
				$admin2_email = get_option('admin_email');;
				$ToEmail2 =$admin2_email; 
				$ToEmail =$admin_email; 
				$EmailSubject = 'Site contact form'; 
				$MESSAGE_BODY = "Name: ".$_POST["name2"].""; 
				$MESSAGE_BODY .= "Email: ".$_POST["email2"].""; 
				$MESSAGE_BODY .= "Comment: ".nl2br($_POST["comment2"]).""; 
				
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
				wp_mail($ToEmail, $EmailSubject, $MESSAGE_BODY, "From: videovolunteers.org");
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
				wp_mail($ToEmail2, $EmailSubject, $MESSAGE_BODY, "From: videovolunteers.org");
				global $post ;
				?> 
					<input type="text" name="redirect_to" id="redirect_to" value="<?php echo site_url().$post->slug;?>">
					<input type="text" name="hdn_mail_sent" id="hdn_mail_sent" value="Your message was sent">
				<?php 
			} 
			else { 
			?> 			
			<div id="auth-<?php echo get_the_author_meta('ID', $curauth); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times; </button>
					<h3 id="myModalLabel">Contact <?php echo get_the_author_meta('display_name', $curauth); ?></h3>
				</div>
				<div class="modal-body">
					<form action="" method="post"  >
						<table width="400" border="0" cellspacing="2" cellpadding="0">
							<tr>
								<td width="29%" class="bodytext">Your name:</td>
								<td width="71%"><input name="name2" type="text" id="name" size="32"></td>
							</tr>
							<tr>
								<td class="bodytext">Email address:</td>
								<td><input name="email2" type="text" id="email" size="32"></td>
							</tr>
							<tr>
								<td class="bodytext">Comment:</td>
								<td><textarea name="comment2" cols="45" rows="6" id="comment" class="bodytext"></textarea></td>
							</tr>
							<tr>
								<td class="bodytext"> </td>
								<td align="left" valign="top"><input type="submit" name="Submit" value="Send"></td>
							</tr>
						</table>
					</form> 
				</div>
				<script>
					jQuery(document).ready(function($){
						if($("#hdn_mail_sent").length)
						{
							if($("#hdn_mail_sent").val()=="Your message was sent")
							{
								// setTimeout(window.location = $('#redirect_to').val(), 5000); 
							}
						}
					}
				</script>
			</div>

			<?php 
			}; 
		}
	//end loop here
	}
}

add_action('vv_video_sidebar', 'output_single_video_author',1);

/****Function to Output Single Video Thumbnail****/
function output_single_video_thumbnail() {
	if ( is_single() )
	{
	$video = get_post_meta(get_the_ID(), 'Video', true); 
	$thumb_img = get_post_meta(get_the_ID(), 'Thumbnail', true);
	if($video !== '') 
	//loop here
		{ 
		?>
			<style>
				.entry_content {padding: 0 1em;}
				.entry_content p, .entry_content div {font-size: 0.9em;} 
			</style>
			<div class="thumb-image">
				<img src="http://indiaunheard.videovolunteers.org<?php echo $thumb_img; ?>" alt="<?php the_title_attribute(); ?>" />
			</div>
		<?php
		}
	//end loop here
	}
}

add_action('pagelines_loop_before_post_content', 'output_single_video_thumbnail',1);				

/****Output Single Author Bio****/
function output_single_author_bio() {
	if ( is_author() )
	{
	$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	?>
		<div class="author-section">
			<h1>Community Correspondent</h1>
			<div class="row-fluid">
				<div class="span3">
					<?php echo get_avatar( $curauth, 512 ); ?>
				</div>
				<div class="span9">
					<div class="details">
						<h3><?php echo $curauth->display_name; ?></h3>
						<div class="bio">
							<h4>Bio:</h4>
							<p><?php echo $curauth->description; ?></p>
						</div>
						<span>Connect with <?php echo $curauth->display_name; ?>&nbsp;
						<!--	<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-fb.png" alt="connect-fb" width="16" height="16" class="alignnone size-full wp-image-233" /></a>
							<a href="#"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-twitter.png" alt="connect-twitter" width="16" height="16" class="alignnone size-full wp-image-234" /></a>-->
							<a href="#auth-<?php echo $curauth->ID ?>"  data-toggle="modal"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2013/02/connect-email.png" alt="connect-email" width="16" height="16" class="alignnone size-full wp-image-232" /></a>
						</span>
						<?php 				
						//Contact Author Form							
						if ($_POST["email1"]<>'') { 

							$admin_email = get_the_author_meta('email');	
							$admin1_email = get_option('admin_email');;
							$ToEmail1 =$admin1_email; 
							$ToEmail =$admin_email; 
							$EmailSubject = 'Site contact form'; 
							$MESSAGE_BODY = "Name: ".$_POST["name1"].""; 
							$MESSAGE_BODY .= "Email: ".$_POST["email1"].""; 
							$MESSAGE_BODY .= "Comment: ".nl2br($_POST["comment1"]).""; 
						   
							add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
							wp_mail($ToEmail, $EmailSubject, $MESSAGE_BODY, "From: videovolunteers.org");
							add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
							wp_mail($ToEmail1, $EmailSubject, $MESSAGE_BODY, "From: videovolunteers.org");
							global $post ;
							?> 
								<h3>Message was sent</h3>
								<input type="hidden" name="redirect_to" id="redirect_to" value="<?php echo site_url().$post->slug;?>/author/<?php echo get_query_var('author_name') ?>/">
								<input type="hidden" name="hdn_mail_sent" id="hdn_mail_sent" value="Your message was sent">
								<script>
									jQuery(document).ready(function($){
									alert ("hi");
										if(jQuery("#hdn_mail_sent").length)
										{
											if(jQuery("#hdn_mail_sent").val()=="Your message was sent")
											{
												setTimeout(window.location = jQuery('#redirect_to').val(), 5000); 
											}
										}
									}
								</script>
						<?php 
						} 
						else { 
						?> 
						<div id="auth-<?php echo $curauth->ID ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times; </button>
								<h3 id="myModalLabel">Contact <?php echo $curauth->display_name; ?></h3>
							</div>
							<div class="modal-body">
								<form action="" method="post" >
									<table width="400" border="0" cellspacing="2" cellpadding="0">
										<tr>
											<td width="29%" class="bodytext">Your name:</td>
											<td width="71%"><input name="name1" type="text" id="name" size="32"></td>
										</tr>
										<tr>
											<td class="bodytext">Email address:</td>
											<td><input name="email1" type="text" id="email" size="32"></td>
										</tr>
										<tr>
											<td class="bodytext">Comment:</td>
											<td><textarea name="comment1" cols="45" rows="6" id="comment" class="bodytext"></textarea></td>
										</tr>
										<tr>
											<td class="bodytext"> </td>
											<td align="left" valign="top"><input type="submit" name="Submit" value="Send" ></td>
										</tr>
									</table>
								</form> 
							</div>
						</div>
						<?php 
						}; 
						?>
						<div class="auth-video">
							<?php
							$video = $curauth->wpum_video_profile;
							?>
							<?php if($video != NULL) {?>

							<div id="x-video-0" class="video-player">
								<object width="400" height="405" standby="Introducing VideoPress for WordPress.com" style="visibility: visible; ">
								<param name="seamlesstabbing" value="true"></param>
								<param name="allowFullScreen" value="true"></param>
								<param name="allowscriptaccess" value="always" width="500" height="405"></param>
								<!--[if !IE]>-->	
								<?php echo htmlspecialchars_decode($video); ?>
								</object>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

add_action('pagelines_before_videoloop', 'output_single_author_bio',1);

/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}

/****Output Category Info****/
function output_category_info() {
	
	$cat = get_category( get_query_var( 'cat' ) );
	$cat_name = $cat->name;
	$cat_desc = $cat->description;
	
	if ( is_author() ) {
		//Do Nothing!
	}
	else {
		if ( ( in_category( 'videos' ) || post_is_in_descendant_category( 16 ) ) )
		{
			?>
				<div class="issue-section">
					<?php if ( is_category( 'videos' ) ) { ?>
						<h1><?php echo $cat_name; ?></h1>
					<?php } else { ?>
						<h1><span>Issue: </span><?php echo $cat_name; ?></h1>
						<p><?php echo $cat_desc; ?></p>
					<?php } ?>
				</div>
			<?php
		}
	}
}

add_action('pagelines_before_videoloop', 'output_category_info',1);

/****Check if is Page or Child****/
function is_tree($pid) {
	global $post;
	$ancestors = get_post_ancestors($post->$pid);
	$root = count($ancestors) - 1;
	$parent = $ancestors[$root];

	if(is_page() && (is_page($pid) || $post->post_parent == $pid || in_array($pid, $ancestors))) {
		return true;
	}
	else {
		return false;
	}
};

/****Display Sticky Post on Blog Page****/
function display_blog_sticky() {
	if ( is_front_page() || is_single() || is_category( 'videos' ) || ( in_category( 'videos' ) || post_is_in_descendant_category( 16 ) ) || is_tree('8333') )
	{
		//Do Nothing
	}
	else {
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1
		);
		query_posts( $args );
			if ( $sticky[0] ) {
				while ( have_posts() ) : the_post(); ?>
					<div id="sticky-post-div">
						<div class="pad">
							<?php if ( has_post_thumbnail() ) { ?>
								<a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail( array(600,450) ); ?></a>
							<?php } ?>
							<h2>
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</h2>
							<p><?php the_excerpt(); ?></p>
							<div class="clearfix"></div>
						</div>
					</div>
				<?php endwhile;
			}
		wp_reset_query();
	}
}

add_action('pagelines_content_before_columns', 'display_blog_sticky',1);

/****Register Author Sidebar****/
register_sidebar(array(
	'name'          => __( 'Author Sidebar' ),
	'id'            => 'author-sidebar',
	'description'   => 'Sidebar for the Author Page',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>' 
));

/****Function to Set Featured Users****/
add_action( 'edit_user_profile', 'show_featured_auth_field' );

function show_featured_auth_field( $user ) { ?>

<h3>Featured Author</h3>
<table class="form-table">
	<tr>
		<th><label>Featured Settings</label></th>
		<td>
			<input type="checkbox" name="featured_auth" id="featured_auth" value="true" <?php if (esc_attr( get_the_author_meta( "featured_auth", $user->ID )) == "true") echo "checked"; ?> />
			<label for="featured_auth">Author is Featured</label>
		</td>
	</tr>
</table>
<?php }

add_action( 'edit_user_profile_update', 'save_featured_auth_field' );

function save_featured_auth_field( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	
	if (!isset($_POST['featured_auth'])) $_POST['featured_auth'] = "false"; 

	update_user_meta( $user_id, 'featured_auth', $_POST['featured_auth'] );
}

/****Function to output Blog Sub-categories****/
function output_blog_cats() {
	if ( is_category( 'videos' ) || ( in_category( 'videos' ) || post_is_in_descendant_category( 16 ) ) ) {
		//Do Nothing
	}
	else {
		$cat = get_category( get_query_var( 'cat' ) );
		$args = array (
			'parent' => $cat->cat_ID,
			'hide_empty' => 0
		);
		$categories = get_categories($args);
			echo '<div class="category-boxes clearfix">';
			foreach($categories as $category) { 
				echo '<div class="box">';
				echo '<h3> <a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </h3> ';
				echo '<div class="boxtext">'. $category->description . '</div>';
				echo '</div>';
			} 
			
			echo '</div>';
	}
}

add_action('pagelines_before_videoloop', 'output_blog_cats',1);

/* FUNCTION TO LOAD POSTS BASED ON CATEGORIES */
 function abc_get_posts(){
 	if($_POST['cat_id']== '' || $_POST['cat_id']== -1 )
 	{	
 		$args = array (
			'cat' => (get_query_var('cat')),
			'posts_per_archive_page' => 12,
			'category__in' => 16
		);
 		$query = new WP_Query($args);
 	}
 	else 
 	{ 	
		$args = array (
			'cat' => (get_query_var('cat')),
			'posts_per_archive_page' => 12,
			'category__in' => array($_POST['cat_id'] )
		);
 		$query = new WP_Query($args);
 	} 		
	
 	ob_start();
 	?> 		
 		
		<?php if ( $query->have_posts() ) : ?>
			
			<style type="text/css">.video-list .videos li .info {height: 165px;}</style>
			
			<ul class="videos clearfix">
			<?php /* Start the Loop */ ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); 
				$thumb = get_post_meta(get_the_ID(), 'Thumbnail', true);
			?>
				<li>
					<div class="thumb">
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
							<img src="http://indiaunheard.videovolunteers.org<?php echo $thumb; ?>" alt="<?php the_title_attribute(); ?>" />
						</a>
					</div>
					<div class="info">
						<div class="item-title">
							<h5><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
							<span class="author-link">By <?php the_author_posts_link(); ?></span>
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
			<?php endwhile; ?>
			</ul>
			
		<?php else : ?>

			<h1>Nothing!</h1>

		<?php endif; // end have_posts() check 
		
	$html=ob_get_clean();
	echo json_encode(array('html'=>$html,'success'=>true));
	die;
}
add_action('wp_ajax_abc_get_posts','abc_get_posts');
add_action('wp_ajax_nopriv_abc_get_posts','abc_get_posts');

/****Functions for Story Stream****/
// Add the Meta Box
function add_custom_meta_box() {
	add_meta_box(
			'custom_meta_box', // $id
			'Updates Meta Box', // $title
			'show_custom_meta_box', // $callback
			'post', // $page
			'normal', // $context
			'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');


// The Callback
function show_custom_meta_box() {
	
	$meta = get_post_meta( get_the_ID() );
	
	echo "Belongs To ";
	$posts= get_main_stories();
	
	echo '<input type="hidden" name="vv_belongs_to_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	echo "&nbsp;<select name='vv_belongs_to' id='vv_belongs_to'>";
	echo "<option value='none'>Parent Story with Updates</option>";
	foreach ($posts as $ps)
	{
		if($meta['vv_belongs_to'][0]==$ps->ID)
			echo"<option value='$ps->ID' selected>$ps->post_title</option>";
		else 
			echo"<option value='$ps->ID'>$ps->post_title</option>";
	}
	echo "</select>";
}

function get_main_stories()
{
	$args = array(
		'post_type' => 'post',
		'meta_query' => array(
			array(
			   'key' => 'vv_belongs_to',
			   'value' => 'none',			           
			)
		)
	);
	
	$query= new WP_Query($args);
	
	$arr= array();
	
	if($query->have_posts())
	{
		while($query->have_posts()) :$query->the_post();
			global $post;
		$arr[] = $post;
			
		endwhile;	
	}	
	return $arr;
}

// Save the Data
function save_custom_meta($post_id) {
	
	// verify nonce
	if (!wp_verify_nonce($_POST['vv_belongs_to_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;

	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	
	}
	
	//save your value to DB
	update_post_meta($post_id, 'vv_belongs_to', $_POST['vv_belongs_to']);
	
}	
add_action('save_post', 'save_custom_meta');

/* FUNCTION TO CHECK IF CURRENT POST HAS ANY UPDATE POSTS */
function check_for_updates($id) {
	global $wpdb;

	$post_tbl= $wpdb->base_prefix."posts";
	$post_meta_tbl= $wpdb->base_prefix."postmeta";
	$q="SELECT * FROM $post_tbl as p,$post_meta_tbl as m WHERE p.id=m.post_id AND m.meta_key='vv_belongs_to' AND m.meta_value=$id";
	$res=$wpdb->get_results($q);

	return $res;
}

/****Function to Output Story Stream Updates****/
function output_story_updates() {
	if ( is_single() ) {
		//Start updates
		echo '<div id="story-stream">';
		$updates=check_for_updates(get_the_id());
		if($updates) {
			?>
			<h2 class="updates-header"><span><?php echo count($updates); ?> Updates</span> for <?php echo get_the_title(get_the_id()); ?></h2>
			<ol class="updates">
				<?php foreach ($updates as $up) { 
				setup_postdata( $up );
				?>
				<li>
					<div class="row-fluid">
						<div class="span2">
							<div class="meta">
								<span><?php echo human_time_diff( get_the_time('U', $up), current_time('timestamp') ) . ' ago'; ?></span>
								<span class="comments"><em><?php echo $up->comment_count; ?></em>comments</span>
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
			<?php
		}
		echo '</div>';
		//End Updates
	}
}
add_action('pagelines_inside_bottom_postloop', 'output_story_updates',1);

/* FUNCTION TO ADD FIELD FOR VIDEO_PROFILE */

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Video Field </h3>

	<table class="form-table">

		<tr>
			<th><label for="vv_video_profile">Video Profile</label></th>
			<td>
			<textarea name='wpum_video_profile' id='wpum_video_profile' >
			<?php echo esc_attr( get_the_author_meta( 'wpum_video_profile', $user->ID ) ); ?>
			</textarea>
			<br>
			<span class="description">(Embed the video (code) with 600px of WIDTH ) .</span>
			</td>
		</tr>

	</table>
<?php }
//save new field added
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) )
return false;

update_usermeta( $user_id, 'wpum_video_profile', $_POST['wpum_video_profile'] );
}

/****Highlight Text for Videos****/
add_action( 'add_meta_boxes', 'highlight_meta' );
function highlight_meta() {
	add_meta_box( 'highlight_meta', 'Highlight Text For Video', 'highlight_video_meta', 'post', 'side', 'high' );
}

function highlight_video_meta( $post ) {
	$higlight_text = get_post_meta( $post->ID, '_higlight_text', true);
	echo 'Please enter the highlight text for a single video below. This is only seen on the single video page.';
	?>
	<textarea name="higlight_text" style="display: block; width: 100%; min-height: 100px;"><?php echo esc_attr( $higlight_text ); ?></textarea>
	<?php
}

add_action( 'save_post', 'save_highlight_meta' );
function save_highlight_meta( $post_ID ) {
	global $post;
	if( $post->post_type == "post" ) {
		if (isset( $_POST ) ) {
			update_post_meta( $post_ID, '_higlight_text', strip_tags( $_POST['higlight_text'] ) );
		}
	}
}

/****Add Excerpt On Pages****/
function add_excerpts_section_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

add_action( 'init', 'add_excerpts_section_to_pages' );

/****Function to add Updates to Campaign Page****/
// Add the Meta Box
function add_page_updates_meta_box() {
	add_meta_box(
			'page_updates_meta_box', // $id
			'Updates Meta Box - Story Stream for this Campaign', // $title
			'show_page_updates_meta_box', // $callback
			'page', // $page
			'normal', // $context
			'high'); // $priority
}
add_action('add_meta_boxes', 'add_page_updates_meta_box');


// The Callback
function show_page_updates_meta_box() {
	
	$meta = get_post_meta( get_the_ID() );
	
	echo "Story Stream ";
	$posts= get_main_stories();
	
	echo '<input type="hidden" name="vv_belongs_to_display_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	echo "&nbsp;<select name='vv_belongs_to_display' id='vv_belongs_to_display'>";
	echo "<option value='none'>none</option>";
	foreach ($posts as $ps)
	{
		if($meta['vv_belongs_to_display'][0]==$ps->ID)
			echo"<option value='$ps->ID' selected>$ps->post_title</option>";
		else 
			echo"<option value='$ps->ID'>$ps->post_title</option>";
	}
	echo "</select>";
}

// Save the Data
function save_page_updates_meta($post_id) {
	
	// verify nonce
	if (!wp_verify_nonce($_POST['vv_belongs_to_display_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;

	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	
	}
	
	//save your value to DB
	update_post_meta($post_id, 'vv_belongs_to_display', $_POST['vv_belongs_to_display']);
	
}	
add_action('save_post', 'save_page_updates_meta');

/****Function to Add Change.org Widget****/
// Add the Meta Box
function add_change_petition_box() {
	add_meta_box(
			'change_petition_box', // $id
			'Change.org Petition - For this Campaign', // $title
			'show_change_petition_box', // $callback
			'page', // $page
			'normal', // $context
			'high'); // $priority
}
add_action('add_meta_boxes', 'add_change_petition_box');


// The Callback
function show_change_petition_box($post, $metabox) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'vv_change_petition_nonce' );

	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	$value = get_post_meta( $post->ID, 'vv_change_petition', true );
	echo '<label for="vv_change_petition_field">';
	   _e("Change.org Petition URL" );
	echo '</label> ';
	echo '<input type="text" id="vv_change_petition_field" name="vv_change_petition_field" value="'.esc_attr($value).'" style="width:95%;" />';
}

// Save the Data
function save_change_petition_meta($post_id) {
	
	// First we need to check if the current user is authorised to do this action. 
	if ( 'page' == $_POST['post_type'] ) {
	if ( ! current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	}

	// Secondly we need to check if the user intended to change this value.
	if ( ! isset( $_POST['vv_change_petition_nonce'] ) || ! wp_verify_nonce( $_POST['vv_change_petition_nonce'], plugin_basename( __FILE__ ) ) )
	  return;

	// Thirdly we can save the value to the database

	//if saving in a custom table, get post_ID
	$post_ID = $_POST['post_ID'];
	//sanitize user input
	$mydata = sanitize_text_field( $_POST['vv_change_petition_field'] );

	// Do something with $mydata 
	// either using 
	add_post_meta($post_ID, 'vv_change_petition', $mydata, true) or
	update_post_meta($post_ID, 'vv_change_petition', $mydata);
	// or a custom table (see Further Reading section below)
	
}	
add_action('save_post', 'save_change_petition_meta');


/**
 * Adds Campaign_Widget widget.
 */
class Campaign_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'Campaign_widget', // Base ID
			'Campaign widget', // Name
			array( 'description' => __( 'A Campaign widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		// The Query
$query = new WP_Query(	array('post_type' => 'page', 'posts_per_page' => 1, 'orderby' => 'menu_order', 'meta_query' => array(array(
					'value' => 'page.campaign.php',
					'compare' => 'LIKE'
					)) ) );

/*echo '<pre>';
print_r($query);
echo '</pre>';
*/
// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<div class="videowidget">';
		echo the_post_thumbnail();
		echo '<div class="campaignwidget"><a href="'.$query->post->guid.'">' . get_the_title() . '</a><br></div><p>'.$query->post->post_excerpt.'</p></div>';
	}
} else {
	echo "no posts found";
}
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Campaign_Widget

// register Campaign_Widget widget
add_action( 'widgets_init', function() { register_widget( 'Campaign_Widget' ); } );



function agc_campaign_video_meta_box() 
{
	add_meta_box(
			'campaign_video_box', // $id
			'video - For this Campaign', // $title
			'show_campaign_video_box', // $callback
			'page', // $page
			'normal', // $context
			'high'); // $priority
}

add_action('add_meta_boxes','agc_campaign_video_meta_box');
/**
 * Add video.
 */
function show_campaign_video_box($event)
{
	$nonce 		= wp_create_nonce('agc_video_campaign');
	$videos 	= get_post_meta($event->ID, 'agc_video_campaign', true);
	/*echo '<pre>';
	print_r($videos);
	echo '</pre>';*/

	?>
    
<div class="videofeild">
<?php
if($videos == "")
{
	?>
    <input type="hidden" id="agc_video_campaign_nonce"	name="agc_video_campaign_nonce" value="<?php echo $nonce;?>">
<table width="100%">
		<tbody>
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video Title"; ?>
				</span>
				</td>
				<td> <input type="text" name="txtname[]" size="50" value="<?php echo (isset($val['name']))? $val['name'] :''?>" />
					
				</td>

				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Type";?>
				</span>
				</td>
				<td><input type="text" name="txttype[]" size="50" value="CampaignVideo" readonly=readonly />
					
				</td>
			</tr>
			
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video link";?>
				</span></td>
				<td colspan="3" class="agc-time-date-label"><span class="agc-time-date-title"><textarea name="video[]" rows="2" cols="60"><?php echo (isset($val['videolink']))? $val['videolink'] :''?></textarea>
				</span>
				</td>
				
				
			</tr>
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video Description";?>
				</span></td>
				<td colspan="3" class="agc-time-date-label"><span class="agc-time-date-title">
                <textarea name="video-description[]" rows="4" cols="60"><?php echo (isset($val['video-description']))? $val['video-description'] :''?></textarea>
				</span>
				</td>
			</tr>
		</tbody>
	</table>
    <?php
}
	else
	{
foreach($videos as $val)
{ 
?>
<input type="hidden" id="agc_video_campaign_nonce"	name="agc_video_campaign_nonce" value="<?php echo $nonce;?>">
<table width="100%">
		<tbody>
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video Title"; ?>
				</span>
				</td>
				<td> <input type="text" name="txtname[]" size="50" value="<?php echo (isset($val['name']))? $val['name'] :''?>" />
					
				</td>

				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Type";?>
				</span>
				</td>
				<td><input type="text" name="txttype[]" size="50" value="CampaignVideo" readonly=readonly />
					
				</td>
			</tr>
			
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video link";?>
				</span></td>
				<td colspan="3" class="agc-time-date-label"><span class="agc-time-date-title"><textarea name="video[]" rows="2" cols="60"><?php echo (isset($val['videolink']))? $val['videolink'] :''?></textarea>
				</span>
				</td>
				
				
			</tr>
			<tr>
				<td class="agc-time-date-label"><span class="agc-time-date-title"><?php echo "Video Description";?>
				</span></td>
				<td colspan="3" class="agc-time-date-label"><span class="agc-time-date-title">
                <textarea name="video-description[]" rows="4" cols="60"><?php echo (isset($val['video-description']))? $val['video-description'] :''?></textarea>
				</span>
				</td>
			</tr>
		</tbody>
	</table>
    <?php }
	}?>
</div>

<input type="button" id="addvideo" value="Add Video" />
<script>
jQuery("#addvideo").click(function()
{
	jQuery(".videofeild").append("<table width='100%'><tbody><tr><td class='agc-time-date-label'><span class='agc-time-date-title'><?php echo 'Video Title'; ?></span></td><td> <input type='text' name='txtname[]' size='50' value='<?php echo (isset($videos['title']))? $videos['title'] :''?>' /></td><td class='agc-time-date-label'><span class='agc-time-date-title'><?php echo 'Type';?></span></td><td><input type='text' name='txttype[]' size='50' value='CampaignVideo' readonly=readonly /></td></tr><tr><td class='agc-time-date-label'><span class='agc-time-date-title'><?php echo 'Video link';?></span></td><td colspan='3' class='agc-time-date-label'><span class='agc-time-date-title'><textarea name='video[]' rows='2' cols='60'><?php echo (isset($videos['videolink']))? $videos['videolink'] :''?></textarea></span></td></tr><tr><td class='agc-time-date-label'><span class='agc-time-date-title'><?php echo 'Video Description';?>			</span></td><td colspan='3' class='agc-time-date-label'><span class='agc-time-date-title'><textarea name='video-description[]' rows='4' cols='60'><?php echo (isset($videos['video-description']))? $videos['video-description'] :''?></textarea></span></td></tr></tbody></table>");});
</script>


<?php
}

add_action( 'save_post', 'agc_video_campaign_box_save',10 );
function agc_video_campaign_box_save( $event_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	if ( !wp_verify_nonce( $_POST['agc_video_campaign_nonce'],'agc_video_campaign' ) )
		return;

	// Check permissions
	if ( 'page' == $_POST['post_type'] )
	{
		if ( !current_user_can( 'edit_page', $event_id ) )
			return;
	}
	else
	{
		if ( !current_user_can( 'edit_post', $event_id ) )
			return;
	}
	/*$data = array(array(
			'title' => $_POST['txtname'],
			'type' => $_POST['txttype'],
			'videolink' => $_POST['video'],
			'video-description' => $_POST['video-description']
	));*/
	$data=array();
	$i=0;
	foreach($_POST['txtname'] as $name)
	{
		$items=array();
		$items["name"]=$name;
		$items["videolink"]= $_POST['video'][$i];
		$items["type"]= $_POST['txttype'][$i];
		$items["video-description"]= $_POST['video-description'][$i];
		$data[]=$items;
		$i++;
	}
	update_post_meta($event_id, 'agc_video_campaign', $data);
}

