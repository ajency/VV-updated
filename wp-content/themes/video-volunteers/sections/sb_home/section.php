<?php
/*
	Section: Home Page Widget Area
	Author: PageLines
	Author URI: http://www.ajency.in
	Description: A widgetized area on the homepage
	Class Name: HomePageSidebar
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
class HomePageSidebar extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
	 	 pagelines_draw_sidebar($this->id, $this->name);
	}

}