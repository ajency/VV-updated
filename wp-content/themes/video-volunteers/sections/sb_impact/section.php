<?php
/*
	Section: Impact Page Sidebar
	Author: PageLines
	Author URI: http://www.ajency.in
	Description: A widgetized area for the impact page to display widgets.
	Class Name: ImpactPageSidebar
	Edition: pro
	Workswith: sidebar1, sidebar2, sidebar_wrap
	Persistant: true
*/

/**
 * Impact Page Sidebar Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class ImpactPageSidebar extends PageLinesSection {
	
	function section_persistent() {
		$setup = pagelines_standard_sidebar($this->name, $this->settings['description']);
		pagelines_register_sidebar($setup, 100);
	}
	/**
	* Section template.
	*/
	
	function section_template() {
		if ( is_category( 'Impact' ) || is_page('our-impact') ) {
			pagelines_draw_sidebar($this->id, $this->name);
		}
		else {
			// Do Nothing
		}
	}
	

}