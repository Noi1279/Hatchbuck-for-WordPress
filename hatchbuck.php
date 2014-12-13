<?php 
/*
Plugin Name: Hatchbuck for WordPress
Plugin URI: https://www.projectarmy.net
Description: Hatchbuck for WordPress allows you to easily embed Hatchbuck forms inside any pages or posts using simple shortcodes. Plus, it makes it very easy to insert website tracking code on any page or post to enable tracking of these pages in Hatchbuck. ProjectArmy is an official Hatchbuck partner.      
Version: 1.0
Author: ProjectArmy
Author URI: https://www.projectarmy.net
Text Domain: Hatchbuck
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// if ( !function_exists( 'add_action' ) ) {
// 	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
// 	exit;
// }

ob_start();

// error_reporting(E_ALL);
define('PLUGIN_NAME','Hatchbuck for WordPress');
define('HATCHBUCK_PLUGIN_FILE',__FILE__);
define('HATCHBUCK_VERSION','1.0');
define('HATCHBUCK_TABLE','hatchbuck_shortcode');

require( dirname( __FILE__ ) . '/hatchbuck-functions.php' );

require( dirname( __FILE__ ) . '/add_shortcode_tynimce.php' );

require( dirname( __FILE__ ) . '/admin/install.php' );

require( dirname( __FILE__ ) . '/admin/menu.php' );

require( dirname( __FILE__ ) . '/shortcode-handler.php' );

require( dirname( __FILE__ ) . '/ajax-handler.php' );

require( dirname( __FILE__ ) . '/admin/uninstall.php' );

require( dirname( __FILE__ ) . '/widget.php' );

require( dirname( __FILE__ ) . '/direct_call.php' );

?>