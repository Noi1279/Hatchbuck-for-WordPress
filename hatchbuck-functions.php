<?php
if(!function_exists('hatchbuck_trim_deep')) {
	function hatchbuck_trim_deep($value) {
		if ( is_array($value) ) {
			$value = array_map('hatchbuck_trim_deep', $value);
		} elseif ( is_object($value) ) {
			$vars = get_object_vars( $value );
			foreach ($vars as $key=>$data) {
				$value->{$key} = hatchbuck_trim_deep( $data );
			}
		} else {
			$value = trim($value);
		}

		return $value;
	}
}


add_action( 'add_meta_boxes', 'wpsites_register_metabox' );
function wpsites_register_metabox() {
	add_meta_box(
		'wpsites_sectionid',
		'Hatchbuck Website Tracking Code',
		'wpsites_meta_box_callback',
		'post',
		'normal',
		'high'
	);
	add_meta_box(
		'wpsites_sectionid',
		'Hatchbuck Website Tracking Code',
		'wpsites_meta_box_callback',
		'page',
		'normal',
		'high'
	);	
	add_meta_box(
		'wpsites_sectionid',
		'Hatchbuck Website Tracking Code',
		'wpsites_meta_box_callback',
		'custom_post_type',
		'normal',
		'high'
	);	
    
}

//add javascript
function my_scripts_method() {
	wp_enqueue_script('hatchbuck','//app.hatchbuck.com/OnlineForm/js/cdn/jotform.js','',PLUGIN_VERSION);
	wp_enqueue_script('hatchbuckloc',plugins_url('js/hatchbuck.js', __FILE__),'',PLUGIN_VERSION);
}
add_action('wp_enqueue_scripts', 'my_scripts_method'); // wp_enqueue_scripts action hook to link only on the front-end
 
/**
 * Prints the box content.
 */
function wpsites_meta_box_callback( $post ) {
 
// Add an nonce field so we can check for it later.
wp_nonce_field( 'wpsites_meta_box', 'wpsites_meta_box_nonce' );
 
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
$value = get_post_meta( $post->ID, 'metabox', true );
?>
<p><label for="metabox" class="screen-reader-text"><b><?php _e( 'Genesis Style Meta Box', 'genesis' ); ?></b></label></p>
<p><textarea class="widefat" rows="4" cols="4" name="metabox" class="inside"><?php echo esc_textarea( get_post_meta($post->ID, 'metabox', true) ); ?></textarea></p>
<p>Copy and paste Hatchbuck's website tracking code for this page. It will be inserted before <code>&lt;\body&gt;</code></p>
<?php
 
}
 
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wpsites_save_meta_box_data( $post_id ) {
 
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */
 
// Check if our nonce is set.
if ( ! isset( $_POST['wpsites_meta_box_nonce'] ) ) {
		return;
}
 
// Verify that the nonce is valid.
if ( ! wp_verify_nonce( $_POST['wpsites_meta_box_nonce'], 'wpsites_meta_box' ) ) {
	return;
}
 
// If this is an autosave, our form has not been submitted, so we don't want to do anything.
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
}
 
// Check the user's permissions.
if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
 
if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
}
 
} else {
 
if ( ! current_user_can( 'edit_post', $post_id ) ) {
	return;
	}
}
 
/* OK, its safe for us to save the data now. */
	
// Make sure that it is set.
if ( ! isset( $_POST['metabox'] ) ) {
		return;
}

// Sanitize user input.
$my_data = $_POST['metabox'];
 
// Update the meta field in the database.
update_post_meta( $post_id, 'metabox', $my_data );


}
add_action( 'save_post', 'wpsites_save_meta_box_data' );
 
// Hook in & Display The Value Conditionally
add_action( 'loop_start', 'custom_field_before_content', 5 );
 
function custom_field_before_content() {
	add_action('wp_footer','hatchbuckCode');
}

function hatchbuckCode() {
	echo get_post_custom_values('metabox')[0];
}
?>