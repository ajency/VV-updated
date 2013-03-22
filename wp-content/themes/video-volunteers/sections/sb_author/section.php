<?php
/*
	Section: Author Sidebar
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The author page widgetized sidebar.
	Class Name: AuthorSidebar	
	Workswith: sidebar1, sidebar2, sidebar_wrap
	Persistant: true
*/

/**
 * Author Sidebar Section
 *
 * @package PageLines Framework
 * @author PageLines
*/
class AuthorSidebar extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() { 
	 	 pagelines_draw_sidebar($this->id, $this->name, 'includes/widgets.default');
	}

}
