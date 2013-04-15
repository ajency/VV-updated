<?php
/*
	Section: Campaign Page
	Author: Ajency
	Author URI: http://www.ajency.in
	Description: The Video Campaign Section. Includes videos & campaign information.
	Class Name: PageLinesVVCampaign	
	Workswith: main
	Failswith: 404_page
*/

/**
 * Main Video Loop Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class PageLinesVVCampaign extends PageLinesSection {

	/**
	* Section template.
	*/
   function section_template() {
		
		if ( is_page_template( 'page.campaign-template.php' ) ) {
			
		}
		else {
			//Do Nothing
		}
	}

}
