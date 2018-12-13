<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function guten_load_hbForms_editor_assets() { // phpcs:ignore
	// Scripts.
	
	// Register the script
	wp_register_script(
		'guten_load_hbForms-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api' ), // Dependencies, defined above.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: File modification time.
		true // Enqueue the script in the footer.
	);
	
	// Localize the script with new data
	global $wpdb;
	$translation_array = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."hatchbuck_shortcode"."  ORDER BY id DESC" );
	
	wp_localize_script( 'guten_load_hbForms-block-js', 'hatchbuck_forms', $translation_array );
	
	
	wp_enqueue_script('guten_load_hbForms-block-js');
	

	// Styles.
	wp_enqueue_style(
		'guten_load_hbForms-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'guten_load_hbForms_editor_assets' );
