<?php
/*
Section: uTestimonials
Author: Urbanimatic
Author URI: http://www.urbanimatic.com
Version: 1.1.2
Description: The best way to show Testimonials, Comments or Information from people, staff, team and clients.
Demo: http://demos.urbanimatic.com/utestimonials/demo/
External: http://demos.urbanimatic.com/utestimonials/
Class Name: uTestimonialsSection
Workswith: templates, main, header, morefoot, footer, sidebar_wrap, sidebar1, sidebar2
Cloning: true
*/

// Helper functions:
function helper_limit_char($excerpt, $substr=0, $strmore = "..."){
	$string = strip_tags(str_replace('...', '...', $excerpt));
	if ($substr>0) {
		$string = substr($string, 0, $substr);
	}
	if(strlen($excerpt)>=$substr){
		$string .= $strmore;
	}
	return $string;
}

function helper_url_hyperlinks($string){
	$pattern = '/\b((http|https):\/\/\S+)/i';
	preg_match($pattern, $string, $matches);
	if (count($matches) > 0) {
		$result = $string;
	} else {
		$result = 'http://' . $string;
	}
	return $result;	
}


class uTestimonialsSection extends PageLinesSection {

	var $taxID = 'testimonials-category';
	var $ptID = 'testimonials';

	var $imagesizes;
	var $types;
	var	$type;
	var	$longdesc;
	var $avatar;
	var	$langval;
	var	$version;
	var $defaultattr;
	var $posttypename;

	function section_admin(){
		add_action( 'in_admin_header', array( &$this, 'testimonials_in_admin_header' ) );
	}
	
	function testimonials_in_admin_header() {
		?>
		<script type='text/javascript'>
		/*<![CDATA[*/
			
			jQuery(document).ready(function() {
				jQuery('select').has('option[value=plain]').change(function(){
					var types = jQuery(this).val();
					var id = jQuery(this).attr('id');
					var parts = id.split('_');
					var clone_id = parseInt(parts[parts.length - 1]);
					if (isNaN(clone_id)) {
						clone_id = '';
					} else {
						clone_id = '_' + clone_id;
					}
					
					if (types == 'plain') {
						jQuery('.optionrow').has('#pagelines_testimonials_sliderfx' + clone_id).hide();
						
						jQuery('.optionrow').has('#pagelines_testimonials_col' + clone_id).show();
						jQuery('.optionrow').has('#pagelines_testimonials_type' + clone_id).show();
						jQuery('.optionrow').has('#pagelines_testimonials_showthumb' + clone_id).show();
					
					}
					
					if (types == 'slider') {
						jQuery('.optionrow').has('#pagelines_testimonials_col' + clone_id).hide();
						jQuery('.optionrow').has('#pagelines_testimonials_type' + clone_id).hide();
						jQuery('.optionrow').has('#pagelines_testimonials_showthumb' + clone_id).hide();

						jQuery('.optionrow').has('#pagelines_testimonials_sliderfx' + clone_id).show();
					}
				});

				
				jQuery('select').has('option[value=plain]').change();
				
			});
		/*]]>*/	
		</script>
		
		<?php
	}		
	
	function section_persistent(){
		$this->post_type_setup();
		$this->post_meta_setup();
	}

	function post_type_setup(){
			$args = array(
					'label' 			=> __('Testimonials', 'pagelines'),  
					'singular_label' 	=> __('Testimonial', 'pagelines'),
					'description' 		=> 'Custom Post Type for creating Testimonials.',
					'menu_icon'			=> $this->icon
			);
			$taxonomies = array(
				$this->taxID => array(	
						'label' => __('Categories', 'pagelines'), 
						'singular_label' => __('Category', 'pagelines'), 
					)
			);
	
			$columns = array(
				'cb'	 		=> "<input type=\"checkbox\" />",
				'title' 		=> 'Name',
				'description' 	=> 'Testimonial',
				'avatar'		=> 'Avatar',
				$this->taxID 	=> 'Category'
			);
		
			$this->post_type = new PageLinesPostType( $this->ptID, $args, $taxonomies, $columns, array(&$this, 'testimonials_column_display'));
	}
	
	function post_meta_setup(){
		
			$type_meta_array = array(
				'testimonial_avatar' => array(
					'type' 		=> 'image_upload',					
					'title' 	=> 'Avatar',
					'shortexp' 	=> 'Upload an image to be used as an avatar for the testimonial.',
				), 
				'testimonial_info' => array(
					'type' => 'text',					
					'title' => 'Info',
					'shortexp' => 'Enter any useful information such as company\'s name or position.'
				),
				'testimonial_url' => array(
					'type' => 'text',					
					'title' => 'Website',
					'shortexp' => 'Enter the URL of the Website. Example: http://www.google.com'
				),
				'testimonial_hide_url' => array(
					'type' => 'check',
					'inputlabel'	=> 'Hide URL',
					'title' => 'Hide URL',
					'shortexp' => 'If "Hide URL" is checked then the URL is not visible and the word "Website" becomes a link.'
				)
			);

			$post_types = array($this->ptID); 
			
			$type_metapanel_settings = array(
					'id' 		=> 'testimonials-metapanel',
					'name' 		=> 'Testimonial Options',
					'posttype' 	=> $post_types,
					'hide_tabs'	=> true
			);
			
			global $testimonials_meta_panel;
			
			$testimonials_meta_panel =  new PageLinesMetaPanel( $type_metapanel_settings );
			
			$type_metatab_settings = array(
				'id' 		=> 'testimonials-type-metatab',
				'name' 		=> 'Optional Testimonial Options',
				'icon' 		=> $this->icon,
			);

			$testimonials_meta_panel->register_tab( $type_metatab_settings, $type_meta_array );
		
	}

	function testimonials_column_display($column){
		global $post;
		switch ($column){
			case 'description':
				the_excerpt();
				break;
			case 'avatar':
				if(get_post_meta($post->ID, 'testimonial_avatar', true ))
					echo '<img src="'.get_post_meta($post->ID, 'testimonial_avatar', true ).'" style="max-width:200px;" class="pagelines_image_preview" />';	
				break;
			case $this->taxID:
				echo get_the_term_list($post->ID, $this->taxID, '', ', ','');
				break;
		}
	}

	function section_head($clone_id) {
		$types = ( ploption( 'testimonials_types', $this->oset ) ) ? ploption( 'testimonials_types', $this->oset ) : 'plain';
		$prefix = ($clone_id != '')? '.clone_'.$clone_id : '';
		$color = ploption('testimonials_color', $this->oset);
		$background_color = ( ploption( 'testimonials_background_color', $this->oset ) ) ? ploption( 'testimonials_background_color', $this->oset ) : '#FFFFFF';
		$background_section_color = ( ploption( 'testimonials_section_background_color', $this->oset ) ) ? ploption( 'testimonials_section_background_color', $this->oset ) : 'transparent';
		
		if ($types == 'plain') {
			$selector = $prefix . ' div.testimonials';
			$background_selector = $prefix . ' div.testimonials-quote';
		}	
		if ($types == 'slider') {
			$selector = $prefix . ' div.testimonials-slider';
			$background_selector = $prefix . ' div.testimonials-slider-quotecontainer';
		}	
		echo(load_custom_font(ploption('testimonials_font', $this->oset), $selector));
		if( $color ){
			$rule = sprintf('%s{color: %s;}', $selector, $color);
			echo( sprintf('<style type="text/css">%s</style>', $rule));
		}
		if($background_section_color){
			$rule = sprintf('%s{background-color: %s;}', $selector, $background_section_color);
			echo( sprintf('<style type="text/css">%s</style>', $rule));
		}
		if($background_color){
			$rule = sprintf('%s{background-color: %s;}', $background_selector, $background_color);
			echo( sprintf('<style type="text/css">%s</style>', $rule));
		}
		
	}
	
	function section_optionator( $settings ){
		
		// Compare w/ Optionator defaults. (Required, but doesn't change -- needed for cloning/special)
		$settings = wp_parse_args($settings, $this->optionator_default);

		/**
		 *
		 * Section Page Options
		 * 
		 * Section optionator is designed to handle section cloning.
		 */
		 
		$page_metatab_array = array(
			'testimonials_types' => array(
				'default'		=> 'plain',
				'type' 			=> 'select',
				'selectvalues'	=> array(
					'plain'	=> array('name' => 'Plain'),
					'slider'	=> array('name' => 'Slider')
				), 					
				'inputlabel'	=> 'Type',
				'title' 		=> 'Type',
				'shortexp'		=> 'Plain or Slider ?',
			),
			'testimonials_sliderfx' => array(
				'default'		=> 'scrollHorz',
				'type' 			=> 'select',
				'selectvalues'	=> array(
					'scrollHorz'	=> array('name' => 'Default'),
					'fade'	=> array('name' => 'Fade'),
					'scrollUp'	=> array('name' => 'Scroll Up'),
					'scrollDown'	=> array('name' => 'Scroll Down'),
				), 					
				'inputlabel'	=> 'Slider Effects',
				'title' 		=> 'Slider Effects',
				'shortexp'		=> 'Select the effect for Testimonials Slider.',
			),
			'testimonials_col' 	=> array(
				'default'		=> 1,				
				'type'			=> 'text_small',					
				'inputlabel'	=> 'Columns',
				'title' 		=> 'Columns',
				'shortexp'		=> 'Specify how many columns you want to use for Testimonials',
			),
			'testimonials_postperpage' => array(
				'type'			=> 'text_small',					
				'inputlabel'	=> 'Testimonials per Page',
				'title' 		=> 'Testimonials per Page',
				'shortexp'		=> 'Specify the number of testimonials to be displayed in every page. - Supports wp-pagenavi.',
			), 
			'testimonials_cat' => array(
				'type' 			=> 'text',
				'inputlabel'	=> 'Category',
				'title' 		=> 'Category',
				'shortexp'		=> 'Specify a category name if you want to show testimonials only from a certain category. You can add multiple categories seperated by commas.',
			), 
			'testimonials_testiid' => array(
				'type' 			=> 'text',
				'inputlabel'	=> 'Testimonial ID',
				'title' 		=> 'Testimonial ID',
				'shortexp'		=> 'Specify a testimonial ID if you want to show a specific testimonial. You can add multiple testimonial IDs seperated by commas.',
			), 
			'testimonials_type' => array(
				'default'		=> '1',
				'type' 			=> 'select',
				'selectvalues'	=> array(
					'1'	=> array('name' => 'Avatar at the Left of the testimonial'),
					'2'	=> array('name' => 'Avatar at the Bottom of the testimonial')
				), 					
				'inputlabel'	=> 'Style',
				'title' 		=> 'Style',
				'shortexp'		=> 'Select a style for the testimonials.',
			), 
			'testimonials_frame' => array(
				'default'		=> 'square',
				'type' 			=> 'select',
				'selectvalues'	=> array(
					'square'	=> array('name' => 'Square'),
					'rounded'	=> array('name' => 'Rounded')
				), 					
				'inputlabel'	=> 'Frame',
				'title' 		=> 'Frame',
				'shortexp'		=> 'Square or Rounded frame?',
			), 
			'testimonials_customclass' => array(
				'type' 			=> 'text',
				'inputlabel'	=> 'Custom Class',
				'title' 		=> 'Custom Class',
				'shortexp'		=> 'You can add a custom class, if you want to customize this section even further using CSS.',
			), 
			'testimonials_showname' => array(
				'version' => 'pro',
				'default' 		=> true,				
				'type' 			=> 'check',
				'inputlabel'	=> 'Show Name',
				'title' 		=> 'Show Name',
				'shortexp'		=> 'Check if you want to show the name.',
			), 
			'testimonials_showinfo' => array(
				'default' 		=> true,				
				'type' 			=> 'check',
				'inputlabel'	=> 'Show Info',
				'title' 		=> 'Show Info',
				'shortexp'		=> 'Check if you want to show the info.',
			), 
			'testimonials_showthumb' => array(
				'default' 		=> true,				
				'type' 			=> 'check',
				'inputlabel'	=> 'Show Avatar',
				'title' 		=> 'Show Avatar',
				'shortexp'		=> 'Check if you want to show the avatar.',
			),
			'testimonials_font' => array(
				'type' => 'fonts',
				'inputlabel' => 'Font',
				'title' => 'Font',
				'shortexp' => 'Select a font for the tesimonials'
			),
			'testimonials_color' => array(
				'type' => 'colorpicker',
				'inputlabel' => 'Text Color',
				'title' => 'Text Color',
				'shortexp' => 'Pick a color for testimonials text.'
			),
			'testimonials_section_background_color' => array(
				'type' => 'colorpicker',
				'inputlabel' => 'Section Background Color',
				'title' => 'Section Background Color',
				'shortexp' => 'Pick a color for uTestimonials Section container - The default is transparent.'
			),
			
			
		);

		$metatab_settings = array(
			'id' 		=> $this->ptID . '_meta',
			'name' 		=> $this->name,
			'icon' 		=> $this->icon, 
			'clone_id'	=> $settings['clone_id'], 
			'active'	=> $settings['active']
		);

		register_metatab($metatab_settings, $page_metatab_array);			
		
	}

	function getlangval(){
		$this->langval = "testimonial";
		return $this->langval;
	}

	//Get the image size for every column
	function setsize(){
		//set image size for every column in here.
		$this->imagesizes = array(
			array(
				"num"		=> 'custom',
				"namesize"	=> 'testimonial_avatar',
				"width" 	=> 60,
				"height" 	=> 60
			)
			
		);
		return $this->imagesizes;
	}
	
	function getdefattr($typeattr){
		if(!isset($typeattr)) return false;
		//Specify default attributes
		$this->defaultattr = array();
		$this->defaultattr["plain"] = array(
			"col" => '1',
			"cat" => '',
			"postperpage" => '-1',
			"type" => '1',
			"frame" => 'square',
			"testiid" => '',
			"longtext" => '',
			"showthumb" => true,
			"showname"	=> true,
			"showinfo"	=> true,
			"customclass" => '',
			"widthimg" => 60,
			"heightimg" => 60
		);
		$this->defaultattr["slider"] = array(
			"sliderfx" => 'scrollHorz',
			"cat" => '',
			"postperpage" => '-1',
			"frame" => 'square', //
			"testiid" => '',
			"longtext" => '',
			"showname"	=> true,
			"showinfo"	=> true,
			"customclass" => '',
			"widthimg" => 60,
			"heightimg" => 60
		);
		if(array_key_exists($typeattr,$this->defaultattr)){
			return $this->defaultattr[$typeattr];
		}else{
			return false;
		}
	}
	
	function getposttype(){
		$this->posttypename	= $this->ptID;
		return $this->posttypename;
	}
	
	function gettypes(){
		$this->types = array("1","2");
		return $this->types;
	}
	
	function getframes(){
		$this->frames = array("square","rounded");
		return $this->frames;
	}
	
	function geteffects(){
		$this->effects = array("fade","scrollVert","scrollHorz","zoom","scrollUp","scrollDown","shuffle");
		return $this->effects;
	}
	
	function setup(){
		add_theme_support( 'post-thumbnails' );
		$imagesizes = $this->setsize();
		foreach($imagesizes as $imgsize){
			add_image_size( $imgsize["namesize"], $imgsize["width"], $imgsize["height"], true ); // 
		}
	}
	
	function getthumbinfo($col){
		$imagesizes = $this->setsize();
		foreach($imagesizes as $imgsize){
			if($col==$imgsize["num"]){
				return $imgsize;
			}
		}
		return false;
	}
	
	function getavatar(){
		$this->avatar =  $this->base_url . "/images/avatar.gif";
		return $this->avatar;
	}

	function section_template( $clone_id = null ) {
		if( post_password_required() )
			return;	
			
		$types = ( ploption( 'testimonials_types', $this->oset ) ) ? ploption( 'testimonials_types', $this->oset ) : 'plain';				
		if ($types == 'plain') {
			 echo($this->section_template_plain( $clone_id ));
		}	
		if ($types == 'slider') {
			 echo($this->section_template_slider( $clone_id ));
		}	
	}
	
	
	function section_template_plain( $clone_id = null ) {
		global $post, $more;				

		$langval = $this->getlangval();
		$avatar = $this->getavatar();
		$defframes = $this->getframes();
		$deftypes = $this->gettypes();
		$defattr = $this->getdefattr('plain');		
		extract($defattr);
		
	// Options
		$col = ( ploption( 'testimonials_col', $this->oset) ) ? ploption( 'testimonials_col', $this->oset) : $col; 
		$postperpage = ( ploption( 'testimonials_postperpage', $this->oset ) ) ? ploption( 'testimonials_postperpage', $this->oset ) : $postperpage; 
		
		$cat = ( ploption( 'testimonials_cat', $this->oset ) ) ? ploption( 'testimonials_cat', $this->oset ) : $cat;
		$testiid = ( ploption( 'testimonials_testiid', $this->oset ) ) ? ploption( 'testimonials_testiid', $this->oset ) : $testiid;
		$type = ( ploption( 'testimonials_type', $this->oset ) ) ? ploption( 'testimonials_type', $this->oset ) : $type;
		$frame = ( ploption( 'testimonials_frame', $this->oset ) ) ? ploption( 'testimonials_frame', $this->oset ) : $frame;
		$customclass = ( ploption( 'testimonials_customclass', $this->oset ) ) ? ploption( 'testimonials_customclass', $this->oset ) : $customclass;

		$showname = (ploption('testimonials_showname', $this->oset)) ? true : false;		
		$showinfo = (ploption('testimonials_showinfo', $this->oset)) ? true : false;		
		$showthumb = (ploption('testimonials_showthumb', $this->oset)) ? true : false;		
		
		//validate the postperpage, default value is -1.
		$postperpage = (is_numeric($postperpage)&& $postperpage >=-1)? $postperpage : -1;
				
		//validate the type, default value is 'plain'.
		$type = (in_array($type,$deftypes))? $type : $defattr["type"];
		$frame = (in_array($frame,$defframes))? $frame : $defattr["frame"];
		$longdesc = (is_numeric($longtext) && $longtext > 0)? $longtext : 0;
		
		//validates the Testimonial ID, default is 0
		$testiid = (strlen($testiid)>0 && $testiid!=0)? $testiid : $defattr["testiid"];
		
		//validates the image dimensions.
		$widthimg = (!is_numeric($widthimg))? $defattr["widthimg"] : $widthimg;
		$heightimg = (!is_numeric($heightimg))? $defattr["heightimg"] : $heightimg;
		
		$picwidth = $widthimg;
		$picheight = $heightimg;
		
		$thumbinfo = $this->getthumbinfo("custom");
		$thumbwidth 	= $picwidth;
		$thumbheight 	= $picheight;
		$thumbname		= $thumbinfo["namesize"];
//		$paged = (get_query_var('paged'))? get_query_var('paged') : 1 ;
		if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
		} else {
		$paged = 1;
		}
		
		//define all used variable for the query.
		$arrinclude = array();
		$arrinclude['post_type'] = $this->getposttype();
		if($postperpage>=0){
			$arrinclude['paged'] = $paged;
		}
		$arrinclude['posts_per_page'] = $postperpage;
		$arrinclude['orderby'] = 'date';
		if(strlen($cat)){
			$arrinclude[$this->taxID] = $cat;
		}
		
		if(strlen($testiid)>0 && $testiid!=0){
			$arrinclude['post__in'] = explode(",",$testiid);
		}
		
		query_posts($arrinclude);
		global $wp_query;
		
		//make a appologies content if the posts is zero or null
		if ( ! have_posts() ){
			echo setup_section_notify( $this, 'Add Testimonials to activate.', admin_url('post-new.php?post_type='.$this->ptID), 'Add Testimonial' );
			return;
		}
		
		//generate uTestimonials HTML
		$htmldisp = "";
		
		$htmldisp .=	'
		<div class="testimonials '.$customclass.'">
			<ul class="testimonials-list testimonials-'.$type.'">
			';
			$i=0;
			$addclass = "plain";
			if($col==1){
				$addclass = "nomargin";
			}
			if (have_posts()){
				while ( have_posts() ){ 
					the_post(); 
					$custom = get_post_custom($post->ID);
					$cf_thumb = (isset($custom["tb-thumb"][0])) ? $custom["tb-thumb"][0] : '';
					$tb_name = get_the_title($post->ID);
					$tb_info = (isset($custom["testimonial_info"][0])) ? $custom["testimonial_info"][0] : '';
					$imginfos = $custom['testimonial_avatar'];
					$tb_url = (isset($custom["testimonial_url"][0])) ? $custom["testimonial_url"][0] : '';
					$tb_hide_url = (isset($custom["testimonial_hide_url"][0])) ? $custom["testimonial_hide_url"][0] : '';
					
					if($i%$col==0 && $col > 1){
						$htmldisp .= '</ul><ul class="testimonials-list testimonials-'.$type.'">';
					}
					
					$stylelist = '';
					$percentage = intval(100/$col)-2;
					$stylelist = 'width:'.$percentage.'%;';
					
					
					$widthheightimg = 'width:'.$thumbwidth.'px;height:'.$thumbheight.'px;';
					if($cf_thumb!=""){
						$cf_thumb = '<img src="'.$cf_thumb.'" alt="" style="'.$widthheightimg.'"/>';
					}elseif($imginfos!=false){
						$cf_thumb = '<img src="'.$imginfos[0].'" alt="" style="'.$widthheightimg.'"/>';
					}else{
						$cf_thumb = '<img src="'.$avatar.'" alt="" style="'.$widthheightimg.'"/>';
					}
					
					$htmldisp .= '<li class="'.$addclass.'" style="'.$stylelist.'">';
					
					$textquote = "";
					$text = get_the_content();
					if($longdesc>0){
						$text = helper_limit_char($text,$longdesc);
					}
					$textquote .='<blockquote>'.$text.'</blockquote>';

					$textinfo = "";
					if($showname && $tb_name!=""){
						$textinfo .= '<span class="testimonial-name">'. $tb_name.'</span>&nbsp;&nbsp;';
					}					
					if($showinfo && $tb_info!=""){
						$textinfo .= '<span class="testimonials-info">' . $tb_info . '</span>&nbsp;&nbsp;';
					}
					if($tb_url!=""){
						if($tb_hide_url!=""){
							$textinfo .= '<div><a target="_blank" title="Website" href="' . helper_url_hyperlinks($tb_url) . '">Website</a></div>';
						} else {
							$textinfo .= '<div class="testimonial-url">Website: <a target="_blank" title="Website" href="' . helper_url_hyperlinks($tb_url) . '">' . $tb_url . '</a></div>';
						}					
					}					
					
					if($textinfo!=""){
						$textinfo = '<div class="testimonials-textinfo">'.$textinfo.'</div>';
					}
					
					$marginquote = '';
					if($type=="1"){
						$pointer = "";
						$thinkboxthumb = "";
						if($showthumb){
							$thinkboxthumb .= '<div class="testimonials-thumb" style="'.$widthheightimg.'">'.$cf_thumb.'</div>';
							$pointer .= '<div class="testimonials-leftpointer"></div>';
							$totalmargin = $thumbwidth + 6 + 2 + 28;
							$marginquote .= 'margin-left:'.$totalmargin.'px;';
						}
						
						$htmldisp .= $thinkboxthumb;
						$htmldisp .= '<div class="testimonials-quote testimonials-'.$frame.'" style="'.$marginquote.'">';
						$htmldisp .= $pointer;
						$htmldisp .= $textinfo;
						$htmldisp .= $textquote;
						$htmldisp .= '</div>';
						
					}elseif($type=="2"){
						$pointer = "";
						$thinkboxthumb = "";
						if($showthumb){
							$totalmargin = 30;
							$pointer = '<div class="testimonials-bottompointer"></div>';
							$thinkboxthumb .= '<div class="testimonials-thumb" style="'.$widthheightimg.'">'.$cf_thumb.'</div>';
							$marginquote = 'margin-bottom:'.$totalmargin.'px;';
						}
						
						$htmldisp .= '<div class="testimonials-quote testimonials-'.$frame.'" style="'.$marginquote.'">';
						$htmldisp .= $textquote;
						$htmldisp .= $pointer;
						$htmldisp .= '</div>';
						$htmldisp .= $thinkboxthumb;
						$htmldisp .= $textinfo;
					}
					
					$displayclear = "";
					if($col==1){
						$displayclear .= '<div class="testimonials-clear"></div>';
					}
					$htmldisp .= $displayclear.'</li>';
					$i++;
					$addclass=""; 
				}//---------------end While(have_posts())--------------
			}//----------------end if(have_posts())-----------------
				
			$htmldisp .= '
				</ul>
				<div class="testimonials-clr"></div>
			</div>';
			
			if (  $wp_query->max_num_pages > 1 ){
				 if(function_exists('wp_pagenavi')) {
					 ob_start();
					 
					 wp_pagenavi();
					 $htmldisp .= ob_get_contents();
						 
					 ob_end_clean();
				 }else{
					$htmldisp .= '
					<div id="nav-below" class="navigation nav2">
						<div class="nav-previous">'.get_next_posts_link( __( '<span class="prev"><span class="meta-nav">&laquo;</span> Prev</span>', $this->langval ) ).'</div>
						<div class="nav-next">'.get_previous_posts_link( __( '<span class="prev">Next <span class="meta-nav">&raquo;</span></span>', $this->langval ) ).'</div>
					</div><!-- #nav-below -->';
				}
			}
			wp_reset_query();
			return $htmldisp;
	}
	
	function section_template_slider( $clone_id = null ) {
		global $post, $more;				

		$prefix = ($clone_id != '')? 'clone_'.$clone_id : '';
		$sliderPointerID = ($prefix != '')? '' : ' id="testimonials-slider-pointer" ';
		
		$langval = $this->getlangval();
		$avatar = $this->getavatar();
		$defeffects = $this->geteffects();
		$defframes = $this->getframes(); //
		$defattr = $this->getdefattr("slider");	
		
		//make all options attributes into single variable
		extract($defattr);
		
		$more = 0;

		$postperpage = ( ploption( 'testimonials_postperpage', $this->oset ) ) ? ploption( 'testimonials_postperpage', $this->oset ) : $postperpage; 
		$sliderfx = ( ploption( 'testimonials_sliderfx', $this->oset) ) ? ploption( 'testimonials_sliderfx', $this->oset) : $sliderfx; 
		$cat = ( ploption( 'testimonials_cat', $this->oset ) ) ? ploption( 'testimonials_cat', $this->oset ) : $cat;
		$testiid = ( ploption( 'testimonials_testiid', $this->oset ) ) ? ploption( 'testimonials_testiid', $this->oset ) : $testiid;

		$frame = ( ploption( 'testimonials_frame', $this->oset ) ) ? ploption( 'testimonials_frame', $this->oset ) : $frame; //
		$frame = (in_array($frame,$defframes))? $frame : $defattr["frame"]; //
		
		$showname = (ploption('testimonials_showname', $this->oset)) ? true : false;		
		$showinfo = (ploption('testimonials_showinfo', $this->oset)) ? true : false;		
		
		//validate the postperpage, default value is -1.
		$postperpage = (is_numeric($postperpage)&& $postperpage >=-1)? $postperpage : -1;
				
		//validate the slider effects, default value is 'scrollHorz'.
		$sliderfx = (in_array($sliderfx,$defeffects))? $sliderfx : $defattr["sliderfx"];
		$longdesc = $this->longdesc;
		
		//validates the Testimonial ID, default is 0
		$testiid = (strlen($testiid)>0 && $testiid!=0)? $testiid : $defattr["testiid"];
		
		//validates the image dimensions.
		$widthimg = (!is_numeric($widthimg))? $defattr["widthimg"] : $widthimg;
		$heightimg = (!is_numeric($heightimg))? $defattr["heightimg"] : $heightimg;
		
		$picwidth = $widthimg;
		$picheight = $heightimg;
		
		$thumbinfo = $this->getthumbinfo("custom");
		$thumbwidth 	= $picwidth;
		$thumbheight 	= $picheight;
		$thumbname		= $thumbinfo["namesize"];
//		$paged = (get_query_var('paged'))? get_query_var('paged') : 1 ;
		if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
		} else {
		$paged = 1;
		}


		//define all used variable for the query.
		$arrinclude = array();
		$arrinclude['post_type'] = $this->getposttype();
		if($postperpage>=0){
			$arrinclude['paged'] = $paged;
		}
		$arrinclude['posts_per_page'] = $postperpage;
		$arrinclude['orderby'] = 'date';
		if(strlen($cat)){
			$arrinclude[$this->taxID] = $cat;
		}
		if(strlen($testiid)>0 && $testiid!=0){
			$arrinclude['post__in'] = explode(",",$testiid);
		}
		
		query_posts($arrinclude);
		global $wp_query;
		
		//make a appologies content if the posts is zero or null
		if ( ! have_posts() ){
			echo setup_section_notify( $this, 'Add Testimonials to activate.', admin_url('post-new.php?post_type='.$this->ptID), 'Add Testimonial' );
			return;
		}
		
		//generate the uTestimonials slider HTML
		$htmldisp = "";
		
				$i=1;
				$addclass = "slider";
				$htmlthumb = "";
				$htmlquote = "";
				if (have_posts()){
					while ( have_posts() ){ 
						the_post(); 
						$custom = get_post_custom($post->ID);
						
						$cf_thumb = (isset($custom["tb-thumb"][0])) ? $custom["tb-thumb"][0] : '';
						$tb_name = get_the_title($post->ID);
						$tb_info = (isset($custom["testimonial_info"][0])) ? $custom["testimonial_info"][0] : '';
						$imginfos = $custom['testimonial_avatar'];
						$tb_url = (isset($custom["testimonial_url"][0])) ? $custom["testimonial_url"][0] : '';
						$tb_hide_url = (isset($custom["testimonial_hide_url"][0])) ? $custom["testimonial_hide_url"][0] : '';

						$widthheightimg = 'width:'.$thumbwidth.'px;height:'.$thumbheight.'px;';
						if($cf_thumb!=""){
							$cf_thumb = '<img src="'.$cf_thumb.'" alt="" style="'.$widthheightimg.'"/>';
						}elseif($imginfos!=false){
							$cf_thumb = '<img src="'.$imginfos[0].'" alt="" style="'.$widthheightimg.'"/>';
						}else{
							$cf_thumb = '<img src="'.$avatar.'" alt="" style="'.$widthheightimg.'"/>';
						}
						
						$htmlthumb .= '<a href="#" id="thumbslide-'.$i.'" rel="' . $prefix . '" title="'.($i-1).'" class="' . $prefix . ' testimonials-slider-thumbslide" style="'.$widthheightimg.'">'.$cf_thumb.'</a>';
						
						$htmlquote .= '<div class="' . $prefix . ' testimonials-slider-quotecontent">';
						
							$text = get_the_content();
							if($longdesc>0){
								$text = helper_limit_char($text,$longdesc);
							}
							$htmlquote .='<div class="testimonials-slider-quote">'.$text.'</div>';
							
							$textinfo = "";
							if($showname && $tb_name!=""){
								$textinfo .= '<span class="testimonial-name">'. $tb_name.'</span>&nbsp;&nbsp;';
							}					
							if($showinfo && $tb_info!=""){
								$textinfo .= '<span class="testimonials-slider-info">'. $tb_info.'</span>&nbsp;&nbsp;';
							}
							if($tb_url!=""){
								if($tb_hide_url!=""){
									$textinfo .= '<div><a target="_blank" title="Website" href="' . helper_url_hyperlinks($tb_url) . '">Website</a></div>';
								} else {
									$textinfo .= '<div class="testimonial-url">Website: <a target="_blank" title="Website" href="' . helper_url_hyperlinks($tb_url) . '">' . $tb_url . '</a></div>';
								}					
							}					
							
							if($textinfo!=""){
								$htmlquote .= '<div class="testimonials-slider-textinfo">'.$textinfo.'</div>';
							}
						$htmlquote .='</div>';
						$i++;
						$addclass=""; 
					}//---------------end While(have_posts())--------------
					$htmldisp .= '<div class="' . $prefix . ' testimonials-slider">';
						$htmldisp .= '<div class="' . $prefix . ' testimonials-slider-cont">';
							$htmldisp .= '<div class="' . $prefix . ' testimonials-slider-quotecontainer testimonials-slider-'.$sliderfx.' testimonials-'.$frame.'" id="testimonials-slider-quotecontainer">';
							$htmldisp .= $htmlquote;
							$htmldisp .= '</div>';
							$htmldisp .= '<div class="' . $prefix . ' testimonials-slider-pointer"' . $sliderPointerID . '></div>';
						$htmldisp .= '</div>';
						$htmldisp .= '<div class="' . $prefix . ' testimonials-slider-thumbcont">'.$htmlthumb.'</div>';
						$htmldisp .= '<div class="testimonials-clear"></div>';
					$htmldisp .= '</div>';
					
				}//----------------end if(have_posts())-----------------
				
				if (  $wp_query->max_num_pages > 1 ){
					 if(function_exists('wp_pagenavi')) {
						 ob_start();
						 
						 wp_pagenavi();
						 $htmldisp .= ob_get_contents();
							 
						 ob_end_clean();
					 }else{
						$htmldisp .= '
						<div id="nav-below" class="navigation nav2">
							<div class="nav-previous">'.get_next_posts_link( __( '<span class="prev"><span class="meta-nav">&laquo;</span> Prev</span>', $this->langval ) ).'</div>
							<div class="nav-next">'.get_previous_posts_link( __( '<span class="prev">Next <span class="meta-nav">&raquo;</span></span>', $this->langval ) ).'</div>
						</div><!-- #nav-below -->';
					}
				}
				wp_reset_query();
				
				return $htmldisp;
	}

	function section_styles( $clone_id = null ) {
		//Register and use this plugin main CSS
		wp_register_style('testimonials-main', $this->base_url . '/style.css');

		//Register jQuery with all plugins and use it
		wp_enqueue_script("testimonials-fade", $this->base_url . '/js/fade.js', array('jquery'));
		wp_enqueue_script("testimonials-cornerz", $this->base_url . '/js/cornerz.js', array('jquery'));
		wp_enqueue_script('testimonials-cycle', $this->base_url . '/js/jquery.cycle.all.min.js', array('jquery'));
		wp_enqueue_script('testimonials-slider', $this->base_url . '/js/testimonials-slider.js.php', array('jquery'));
		
	}
	
} /* End of section class - No closing php tag needed */