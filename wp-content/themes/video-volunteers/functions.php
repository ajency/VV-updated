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
	
	
}

add_action('pagelines_head_last','output_css_js',10);	
	
	
/****Header Bar Output****/
function output_header_bar() {
	echo '<div class="texture"><div class="content"><div class="content-pad"><div class="logo-bar fix">';
	echo '<a href="'. get_bloginfo('url') .'" class="logo-link"><img src="'. get_bloginfo('stylesheet_directory') .'/images/site-logo.png" alt="Video Volunteers" /></a>';
	echo '<div class="impact fix">';
	echo '<div class="impact-image">';
	echo '<a href="#"><img src="'. get_bloginfo('stylesheet_directory') .'/images/impact.png" alt="Video Volunteers" /></a>';
	echo '</div>';
	echo '<div class="impact-desc">';
	echo '<p>If I were you, I would try to stick a gnome in sideways so Sally can sell sea shells by the sea shore. Westside.</p><a href="'. get_bloginfo('url') .'" class="more-link"><i class="icon-plus"></i>&nbsp;More</a>';
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

/****Output Titles for Homepage Boxes****/
function output_homepage_titles() {
	echo '<div class="action-titles"><h3 class="main-title hide">What Can You Do Here?</h3>';
	echo '<h4 class="sub-title-individual hide">As an Individual</h4>';
	echo '<h4 class="sub-title-company hide">As a Company</h4></div>';
}

add_action('pagelines_inside_bottom_boxes', 'output_homepage_titles',1);

/****Output Social Bar in Content****/
add_filter ('the_content', 'insertSocial');

function insertSocial($content) {
   if(is_single()) {
	  $content = trim($content);
      $content_array = explode("</p>",$content);
	  $content_new = '<p><div class="social-bar">';
      $content_new.= '<h4>Think this issue needs more voices? <small>Help spread the word, Share this story.</small></h4>';
      
	  $content_new.= '<div class="social-buttons"><div class="social-button"><iframe scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1362636220.html#_=1363001285231&amp;count=vertical&amp;id=twitter-widget-1&amp;lang=en&amp;original_referer=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;size=m&amp;text=Test%20Sticky%20Post&amp;url=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;via=socializeWP" class="twitter-share-button twitter-count-vertical" style="width: 58px; height: 62px;" title="Twitter Tweet Button" data-twttr-rendered="true"></iframe></div><div class="social-button"><iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:45px; height:65px;" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;send=false&amp;layout=box_count&amp;width=45&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=65"></iframe></div><div class="social-button"><div style="height: 60px; width: 50px; display: inline-block; text-indent: 0px; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% transparent; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline;" id="___plusone_1"><iframe width="100%" scrolling="no" frameborder="0" hspace="0" marginheight="0" marginwidth="0" style="position: static; top: 0px; width: 50px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 60px;" tabindex="0" vspace="0" id="I1_1363001287924" name="I1_1363001287924" src="https://plusone.google.com/_/+1/fastbutton?bsv&amp;size=tall&amp;hl=en-US&amp;origin=http%3A%2F%2Fwww.vv.ajency.in&amp;url=http%3A%2F%2Fwww.vv.ajency.in%2Ftest-sticky-post%2F&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.en.IOaFQMAHVRI.O%2Fm%3D__features__%2Fam%3DUQE%2Frt%3Dj%2Fd%3D1%2Frs%3DAItRSTNYuZ6HDkdZho3xDZgOVYkx4qGWPQ#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled&amp;id=I1_1363001287924&amp;parent=http%3A%2F%2Fwww.vv.ajency.in&amp;rpctoken=22999206" allowtransparency="true" data-gapiattached="true" title="+1"></iframe></div></div></div>';
	  
	  $content_new.= '</div>';
	  
	  $temp_content_array = array();
	  $content_para_count = count($content_array );	
	
		if($content_para_count<=2)
		{
			if($content_para_count===0)
				$content_new .= '</p>';
				
			$content_array[] = $content_new;
		}
		else
		{
			for($i=0;$i<$content_para_count;$i++)
				{	
					$temp_content_array[]  = $content_array[$i];
					if($i==2)
					{
						$temp_content_array[] = $content_new;
					}	
				}
				
				$content_array = $temp_content_array;
			}
		$content = implode("</p>",$content_array);	
	  
   }
   return $content;
}