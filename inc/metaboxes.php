<?php
/**
 * Custom meta boxes
 *
 * @package Memberlite
 */

/* Adds a Memberlite settings meta box to the side column on the Page edit screens. */
function memberlite_settings_add_meta_box() {
	$screens = array('page');
	foreach ($screens as $screen) {
		add_meta_box(
			'memberlite_settings_section',
			__('Memberlite Settings', 'memberlite'),
			'memberlite_settings_meta_box_callback',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action('add_meta_boxes', 'memberlite_settings_add_meta_box');

/* Meta box for Memberlite settings */
function memberlite_settings_meta_box_callback($post) {
	wp_nonce_field('memberlite_settings_meta_box', 'memberlite_settings_meta_box_nonce');
	$memberlite_page_template = get_post_meta($post->ID, '_wp_page_template', true);
	$memberlite_banner_desc = get_post_meta($post->ID, '_memberlite_banner_desc', true);
	$memberlite_banner_hide_title = get_post_meta($post->ID, '_memberlite_banner_hide_title', true);
	$memberlite_banner_hide_breadcrumbs = get_post_meta($post->ID, '_memberlite_banner_hide_breadcrumbs', true);
	$memberlite_banner_right = get_post_meta($post->ID, '_memberlite_banner_right', true);
	$memberlite_banner_bottom = get_post_meta($post->ID, '_memberlite_banner_bottom', true);
	$memberlite_landing_page_checkout_button = get_post_meta($post->ID, '_memberlite_landing_page_checkout_button', true);
	$memberlite_landing_page_level = get_post_meta($post->ID, '_memberlite_landing_page_level', true);
	$memberlite_landing_page_upsell = get_post_meta($post->ID, '_memberlite_landing_page_upsell', true);
	
	echo '<h2>' . __('Page Banner Settings', 'memberlite') . '</h2>';
	echo '<p style="margin: 1rem 0 0 0;"><strong>' . __('Banner Description', 'memberlite') . '</strong> <em>Shown in the masthead banner below the page title.</em>';
	if(($memberlite_page_template == 'templates/landing.php') && function_exists('pmpro_getAllLevels'))
		echo ' <em>Leave blank to show landing page level description as banner description.</em>';
	echo '</p>';
	echo '<label class="screen-reader-text" for="memberlite_banner_desc">';
	_e('Banner Description', 'memberlite');
	echo '</label>';
	echo '<textarea class="large-text" rows="3" id="memberlite_banner_desc" name="memberlite_banner_desc">';
		echo $memberlite_banner_desc;
	echo '</textarea>';		
	echo '<input type="hidden" name="memberlite_banner_hide_title_present" value="1" />';
	echo '<label for="memberlite_banner_hide_title" class="selectit"><input name="memberlite_banner_hide_title" type="checkbox" id="memberlite_banner_hide_title" value="1" '. checked( $memberlite_banner_hide_title, 1, false) .'>' . __('Hide Page Title on Single View', 'memberlite') . '</label>';
	echo '<input type="hidden" name="memberlite_banner_hide_breadcrumbs_present" value="1" />';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="memberlite_banner_hide_breadcrumbs" class="selectit"><input name="memberlite_banner_hide_breadcrumbs" type="checkbox" id="memberlite_banner_hide_breadcrumbs" value="1" '. checked( $memberlite_banner_hide_breadcrumbs, 1, false) .'>' . __('Hide Breadcrumbs', 'memberlite') . '</label>';
	echo '<p style="margin: 1rem 0 0 0;"><strong>' . __('Banner Right Column', 'memberlite') . '</strong> <em>Right side of the masthead banner. (i.e. Video Embed, Image or Action Button)</em></p>';
	echo '<label class="screen-reader-text" for="memberlite_banner_right">';
	_e('Banner Right Column', 'memberlite');
	echo '</label> ';
	echo '<textarea class="large-text" rows="3" id="memberlite_banner_right" name="memberlite_banner_right">';
		echo $memberlite_banner_right;
	echo '</textarea>';
	echo '<p style="margin: 1rem 0 0 0;"><strong>' . __('Page Bottom Banner', 'memberlite') . '</strong> <em>Banner shown above footer on pages. (i.e. call to action)</em></p>';	
	echo '<label class="screen-reader-text" for="memberlite_banner_bottom">';
	_e('Page Bottom Banner', 'memberlite');
	echo '</label> ';
	echo '<textarea class="large-text" rows="3" id="memberlite_banner_bottom" name="memberlite_banner_bottom">';
		echo $memberlite_banner_bottom;
	echo '</textarea>';
	if(($memberlite_page_template == 'templates/landing.php') && function_exists('pmpro_getAllLevels'))
	{
		echo '<hr />';
		echo '<h2>' . __('Landing Page Settings', 'memberlite') . '</h2>';
		$membership_levels = pmpro_getAllLevels();
		if(empty($membership_levels))
			echo '<div class="inline notice error"><p><a href="' . admin_url('admin.php?page=pmpro-membershiplevels') . '">Add a Membership Level to Use These Landing Page Features &raquo;</a></p>';
		else
		{
			echo '<table class="form-table"><tbody>';
			echo '<tr><th scope="row">' . __('Membership Level', 'memberlite') . '</th>';
			echo '<td><label class="screen-reader-text" for="memberlite_landing_page_level">';
				_e('Landing Page Membership Level', 'memberlite');
			echo '</label> ';
			echo '<select id="memberlite_landing_page_level" name="memberlite_landing_page_level">';
			echo '<option value="blank" ' . selected( $memberlite_landing_page_level, "blank" ) . '>- Select -</option>';
			foreach($membership_levels as $level)
			{			
				echo '<option value="' . $level->id . '"' . selected( $memberlite_landing_page_level, $level->id ) . '>' . $level->name . '</option>';
			}
			echo '</select></td></tr>';	
			echo '<tr><th scope="row">' . __('Checkout Button Text', 'memberlite') . '</th>';
			echo '<td><label class="screen-reader-text" for="memberlite_landing_page_checkout_button">';
				_e('Checkout Button Text', 'memberlite');
			echo '</label> ';
			echo '<input type="text" id="memberlite_landing_page_checkout_button" name="memberlite_landing_page_checkout_button" value="' . $memberlite_landing_page_checkout_button . '"> <em>(default: "Select")</em></td></tr>';
			echo '<tr><th scope="row">' . __('Membership Level Upsell', 'memberlite') . '</th>';
			echo '<td><label class="screen-reader-text" for="memberlite_landing_page_upsell">';
				_e('Landing Page Membership Level Upsell', 'memberlite');
			echo '</label> ';
			echo '<select id="memberlite_landing_page_upsell" name="memberlite_landing_page_upsell">';
			echo '<option value="blank" ' . selected( $memberlite_landing_page_upsell, "blank" ) . '>- Select -</option>';
			foreach($membership_levels as $level)
			{			
				echo '<option value="' . $level->id . '"' . selected( $memberlite_landing_page_upsell, $level->id ) . '>' . $level->name . '</option>';
			}
			echo '</select></td></tr>';
			echo '</tbody></table>';
		}
	}
}

/* Save custom sidebar selection */
function memberlite_settings_save_meta_box_data($post_id) {
	if(!isset($_POST['memberlite_settings_meta_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['memberlite_settings_meta_box_nonce'], 'memberlite_settings_meta_box')) {
		return;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} 
	else
	{
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}
	
	//banner description
	if(isset($_POST['memberlite_banner_desc'])) {
		$memberlite_banner_desc = $_POST['memberlite_banner_desc'];
		update_post_meta($post_id, '_memberlite_banner_desc', $memberlite_banner_desc);
	}
		
	//banner hide title checkbox	
	if(isset($_POST['memberlite_banner_hide_title_present'])) {
		if(!empty($_POST['memberlite_banner_hide_title']))
			$memberlite_banner_hide_title = 1;
		else
			$memberlite_banner_hide_title = 0;
			
		update_post_meta($post_id, '_memberlite_banner_hide_title', $memberlite_banner_hide_title);
	}
	
	//banner hide breadcrumbs checkbox
	if(isset($_POST['memberlite_banner_hide_breadcrumbs_present']))	{
		if(!empty($_POST['memberlite_banner_hide_breadcrumbs']))
			$memberlite_banner_hide_breadcrumbs = 1;
		else
			$memberlite_banner_hide_breadcrumbs = 0;
			
		update_post_meta($post_id, '_memberlite_banner_hide_breadcrumbs', $memberlite_banner_hide_breadcrumbs);
	}
	
	//banner right content
	if(isset($_POST['memberlite_banner_right'])) {
		$memberlite_banner_right = $_POST['memberlite_banner_right'];
		
		update_post_meta($post_id, '_memberlite_banner_right', $memberlite_banner_right);
	}
	
	//banner bottom content
	if(isset($_POST['memberlite_banner_bottom'])) {
		$memberlite_banner_bottom = $_POST['memberlite_banner_bottom'];
		
		update_post_meta($post_id, '_memberlite_banner_bottom', $memberlite_banner_bottom);
	}
	
	//landing page level
	if(isset($_POST['memberlite_landing_page_level'])) {
		$memberlite_landing_page_level = $_POST['memberlite_landing_page_level'];
		
		update_post_meta($post_id, '_memberlite_landing_page_level', $memberlite_landing_page_level);
	}
	
	//landing page checkout button
	if(isset($_POST['memberlite_landing_page_checkout_button'])) {
		$memberlite_landing_page_checkout_button = $_POST['memberlite_landing_page_checkout_button'];
		
		update_post_meta($post_id, '_memberlite_landing_page_checkout_button', $memberlite_landing_page_checkout_button);
	}
	
	//landing page upsell content
	if(isset($_POST['memberlite_landing_page_upsell'])) {
		$memberlite_landing_page_upsell = $_POST['memberlite_landing_page_upsell'];
		
		update_post_meta($post_id, '_memberlite_landing_page_upsell', $memberlite_landing_page_upsell);
	}	
}
add_action('save_post', 'memberlite_settings_save_meta_box_data');

/* Adds a Custom Sidebar meta box to the side column on the Post and Page edit screens. */
function memberlite_sidebar_add_meta_box() {
	$screens = array('post', 'page', 'forum', 'event', 'event-recurring');
	foreach ($screens as $screen) {
		add_meta_box(
			'memberlite_sidebar_section',
			__('Custom Sidebar', 'memberlite'),
			'memberlite_sidebar_meta_box_callback',
			$screen,
			'side',
			'core'
		);
	}
}
add_action('add_meta_boxes', 'memberlite_sidebar_add_meta_box');

/* Meta box for custom sidebar selection */
function memberlite_sidebar_meta_box_callback($post) {
	global $wp_registered_sidebars;
	wp_nonce_field('memberlite_sidebar_meta_box', 'memberlite_sidebar_meta_box_nonce');
	$memberlite_custom_sidebar = get_post_meta($post->ID, '_memberlite_custom_sidebar', true);
	$memberlite_default_sidebar = get_post_meta($post->ID, '_memberlite_default_sidebar', true);
	echo '<p>' . __('Swap the default sidebar.', 'memberlite');
	echo ' <a href="' . admin_url( 'custom-sidebars.php') . '">' . __('Manage Custom Sidebars','memberlite') . '</a></p>';
	echo '<p><strong>' . __('Select Sidebar', 'memberlite') . '</strong></p>';
	echo '<label class="screen-reader-text" for="memberlite_custom_sidebar">';
	_e('Select Sidebar', 'memberlite');
	echo '</label> ';
	echo '<select id="memberlite_custom_sidebar" name="memberlite_custom_sidebar">';
	foreach($wp_registered_sidebars as $wp_registered_sidebar)
	{
		echo '<option value="' . $wp_registered_sidebar['id'] . '"' . selected( $memberlite_custom_sidebar, $wp_registered_sidebar['id'] ) . '>' . $wp_registered_sidebar['name'] . '</option>';
	}
		echo '<option value="memberlite_sidebar_blank"' . selected( $memberlite_custom_sidebar, 'memberlite_sidebar_blank' ) . '>- Hide Sidebar -</option>';
	echo '</select>';	
	echo '<hr />';
	echo '<p><strong>' . __('Default Sidebar Behavior', 'memberlite') . '</strong></p>';
	echo '<label class="screen-reader-text" for="memberlite_default_sidebar">';
	_e('Default Sidebar', 'memberlite');
	echo '</label> ';
	echo '<select id="memberlite_default_sidebar" name="memberlite_default_sidebar">';
	echo '<option value="default_sidebar_above"' . selected( $memberlite_default_sidebar, 'default_sidebar_above' ) . '>' . __('Show Default Sidebar Above', 'memberlite') . '</option>';
	echo '<option value="default_sidebar_below"' . selected( $memberlite_default_sidebar, 'default_sidebar_below' ) . '>' . __('Show Default Sidebar Below', 'memberlite') . '</option>';
	echo '<option value="default_sidebar_hide"' . selected( $memberlite_default_sidebar, 'default_sidebar_hide' ) . '>' . __('Hide Default Sidebar', 'memberlite') . '</option>';
	echo '</select>';
}

/* Save custom sidebar selection */
function memberlite_sidebar_save_meta_box_data($post_id) {
	if(!isset($_POST['memberlite_sidebar_meta_box_nonce'])) {
		return;
	}
	if(!wp_verify_nonce($_POST['memberlite_sidebar_meta_box_nonce'], 'memberlite_sidebar_meta_box')) {
		return;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $post_id)) {
			return;
		}
	} 
	else
	{
		if(!current_user_can('edit_post', $post_id)) {
			return;
		}
	}
	
	if(!isset($_POST['memberlite_custom_sidebar'])) {
		return;
	}
	$memberlite_custom_sidebar = sanitize_text_field($_POST['memberlite_custom_sidebar']);
	
	if(!isset($_POST['memberlite_default_sidebar'])) {
		return;
	}
	$memberlite_default_sidebar = sanitize_text_field($_POST['memberlite_default_sidebar']);

	// Update the meta field in the database.
	update_post_meta($post_id, '_memberlite_custom_sidebar', $memberlite_custom_sidebar);
	update_post_meta($post_id, '_memberlite_default_sidebar', $memberlite_default_sidebar);
}
add_action('save_post', 'memberlite_sidebar_save_meta_box_data');

/* Add Setting in Featured Images meta box */
function memberlite_featured_image_meta( $content ) {
    global $post;
	if(in_array( get_post_type($post->ID), array('post','page')))
	{
		$id = 'memberlite_hide_image_banner';
		$value = esc_attr( get_post_meta( $post->ID, $id, true ) );
		$label = '<label for="' . $id . '" class="selectit"><input name="' . $id . '" type="checkbox" id="' . $id . '" value="' . $value . ' "'. checked( $value, 1, false) .'>' . __('Hide Image Banner on Single View', 'memberlite') . '</label>';
		return $content .= $label;
	}
	else
		return $content;
}
add_filter( 'admin_post_thumbnail_html', 'memberlite_featured_image_meta' );

/* Save Setting in Featured Images meta box */
function memberlite_save_featured_image_meta( $post_id, $post, $update ) {  
	$value = 0;
	if ( isset( $_REQUEST['memberlite_hide_image_banner'] ) ) {
		$value = 1;
	}
	// Set meta value to either 1 or 0
	update_post_meta( $post_id, 'memberlite_hide_image_banner', $value );
}
add_action( 'save_post', 'memberlite_save_featured_image_meta', 10, 3 );