<?php 
/*
* Plugin Name: Logged in AND Logged out Shortcodes
* Plugin URI: 
* Description: Adds the ability to display content specifically to loggedin users and loggedout users
* Version: 1.0
* Author: UBC CMS, Enej
* Author URI:http://cms.ubc.ca
*
*
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU
* General Public License as published by the Free Software Foundation; either version 2 of the License,
* or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
* You should have received a copy of the GNU General Public License along with this program; if not, write
* to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/


/**
 * CTLT_Logged_in_Logged_Out class.
 */
class CTLT_Logged_in_Logged_Out {
	static $instance;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	function __construct() {
		self::$instance = $this;
		add_action( 'init', array( $this, 'init' ) );
	}
	
	/**
	 * init function.
	 * 
	 * @access public
	 * @return void
	 */
	function init() {
		$this->add_shortcode( 'loggedin', 'loggedin' );
		$this->add_shortcode( 'loggedout', 'loggedout' );
	}
	
	/**
	* has_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @return void
	*/
	function has_shortcode( $shortcode ) {
		global $shortcode_tags;
		
		return ( in_array( $shortcode, array_keys ( $shortcode_tags ) ) ? true : false);
	}
	
	/**
	* add_shortcode function.
	*
	* @access public
	* @param mixed $shortcode
	* @param mixed $shortcode_function
	* @return void
	*/
	function add_shortcode( $shortcode, $shortcode_function ) {
		
		if( !$this->has_shortcode( $shortcode ) )
			add_shortcode( $shortcode, array( &$this, $shortcode_function ) );
	}
	
	/**
	 * loggedin function.
	 * 
	 * @access public
	 * @param mixed $atts
	 * @param mixed $content (default: null)
	 * @return void
	 */
	function loggedin( $atts, $content = null ) {

		 if ( is_user_logged_in() && !is_null( $content ) && !is_feed() )
			return do_shortcode($content);
		
		return '';
	}
	
	/**
	 * loggedout function.
	 * 
	 * @access public
	 * @param mixed $atts
	 * @param mixed $content (default: null)
	 * @return void
	 */
	function loggedout( $atts, $content = null ) {
	
		if ( is_user_logged_in() && !is_feed() )
			return '';
		return do_shortcode($content);
	}
}

$ctlt_loggedin_loggedout = New CTLT_Logged_in_Logged_Out();