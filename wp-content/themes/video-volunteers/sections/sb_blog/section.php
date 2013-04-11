<?php
/*
	Section: Blog Page Sidebar
	Author: PageLines
	Author URI: http://www.ajency.in
	Description: A widgetized area for the blog page to display widgets.
	Class Name: BlogPageSidebar
	Edition: pro
	Workswith: sidebar1, sidebar2, sidebar_wrap
	Persistant: true
*/

/**
 * Blog Page Sidebar Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class BlogPageSidebar extends PageLinesSection {
	
	function section_persistent() {
		$setup = pagelines_standard_sidebar($this->name, $this->settings['description']);
		pagelines_register_sidebar($setup, 100);
	}
	/**
	* Section template.
	*/
   function section_template() {
	 	 pagelines_draw_sidebar($this->id, $this->name);
	}

}