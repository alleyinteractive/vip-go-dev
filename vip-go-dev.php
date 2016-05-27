<?php
/*
	Plugin Name: VIP Go Developer
	Plugin URI: https://github.com/alleyinteractive/vip-go-dev
	Description: A WordPress plugin to help with VIP Go development
	Version: 0.1
	Author: Alley Interactive
	Author URI: http://www.alleyinteractive.com/
*/
/*
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
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Allow admins to view query monitor.
 */
add_filter( 'map_meta_cap', function( $caps, $cap ) {
	if ( 'view_query_monitor' === $cap ) {
		return [ 'manage_options' ];
	}
	return $caps;
}, 10, 2 );

/**
 * mu-plugins forces Jetpack to be in staging site mode; disable that.
 */
add_filter( 'jetpack_is_staging_site', '__return_false', 20 );

/**
 * Enable photon, which gets disabled in mu-plugins.
 */
add_filter( 'jetpack_get_available_modules', function( $modules ) {
	$modules['photon'] = '2.0';
	return $modules;
}, 1000 );

/**
 * Remove the "You must enter your registration key" VaultPress notice.
 */
add_action( 'admin_head', function() {
	if ( class_exists( 'VaultPress' ) ) {
		remove_action( 'user_admin_notices', [ VaultPress::init(), 'connect_notice' ] );
		remove_action( 'admin_notices', [ VaultPress::init(), 'connect_notice' ] );
	}
}, 20 );

/**
 * Bypass Image downsize hooks and use the {prefix}_photon_url function directly.
 */
add_filter( 'photonfill_bypass_image_downsize', '__return_true' );
