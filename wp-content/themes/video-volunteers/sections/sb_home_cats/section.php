<?php
/*
	Section: Home Page Category Boxes
	Author: PageLines
	Author URI: http://www.ajency.in
	Description: A widgetized area on the homepage to display 3 category widgets.
	Class Name: HomePageCats
	Edition: pro
	Workswith: sidebar1, sidebar2, sidebar_wrap, templates, main, header, morefoot, content
	Persistant: true
*/

/**
 * Home Page Sidebar Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class HomePageCats extends PageLinesSection {
	
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