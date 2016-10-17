<?php
/*
Plugin Name: WP Job Listing
Plugin URI:  http://web2dezine.com
Description: A plugin to display job listings
Version:     1.5
Author:      Wayne Ramshaw
Author URI:  http://web2dezine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wp-job-listing
*/

/*  Copyright 2016  Wayne Ramshaw  (email : wayne@web2dezine.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ( plugin_dir_path(__FILE__) . 'wp-job-cpt.php' );
require_once ( plugin_dir_path(__FILE__) . 'wp-job-settings.php' );
require_once ( plugin_dir_path(__FILE__) . 'wp-job-fields.php' );


function w2dwp_admin_enqueue_scripts() {
	global $pagenow, $typenow;
	if ( $typenow == 'job') {
		wp_enqueue_style( 'w2dwp-admin-css', plugins_url( 'css/admin-jobs.css', __FILE__ ) );
	}
	if ( ($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job' ) {
		
		wp_enqueue_script( 'w2dwp-job-js', plugins_url( 'js/admin-jobs.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '20150204', true );
		wp_enqueue_script( 'w2dwp-custom-quicktags', plugins_url( 'js/w2dwp-quicktags.js', __FILE__ ), array( 'quicktags' ), '20150206', true );
		wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
	}
	if ( $pagenow =='edit.php' && $typenow == 'job') {
		wp_enqueue_script( 'reorder-js', plugins_url( 'js/reorder.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '20150626', true );
		wp_localize_script( 'reorder-js', 'WP_JOB_LISTING', array(
			'security' => wp_create_nonce( 'wp-job-order' ),
			'success' => __( 'Jobs sort order has been saved.' ),
			'failure' => __( 'There was an error saving the sort order, or you do not have proper permissions.' )
		) );
	}
}
add_action( 'admin_enqueue_scripts', 'w2dwp_admin_enqueue_scripts' );


