<?php

//* Widget areas
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'header-right' );

//* Remove Unused Page Layouts
//genesis_unregister_layout( 'full-width-content' );
//genesis_unregister_layout( 'content-sidebar' );	
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Reposition Genesis Metaboxes
// remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );

//* Remove Unused User Settings
remove_action( 'show_user_profile', 'genesis_user_options_fields' );
remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );	

//* Manage Genesis Settings and widgets
add_action( 'genesis_theme_settings_metaboxes', 'be_remove_genesis_metaboxes' );
function be_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) 
{
	// remove_meta_box( 'genesis-theme-settings-feeds',      $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-header',     $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-nav',        $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-comments',   $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-posts',      $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-blogpage',   $_genesis_theme_settings_pagehook, 'main' );
	// remove_meta_box( 'genesis-theme-settings-scripts',    $_genesis_theme_settings_pagehook, 'main' );
}

//* Widgets (Wordpress & Genesis)
add_action( 'widgets_init', 'ejo_remove_genesis_widgets', 20 ); 
function ejo_remove_genesis_widgets() 
{
	//* Wordpress
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	// unregister_widget('WP_Widget_Categories');
	// unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	// unregister_widget('WP_Nav_Menu_Widget');

	// if (class_exists( 'Black_Studio_TinyMCE_Plugin' ))
	// 	unregister_widget('WP_Widget_Text');

	//* Genesis
    // unregister_widget( 'Genesis_Featured_Page' );
    // unregister_widget( 'Genesis_Featured_Post' );
    unregister_widget( 'Genesis_User_Profile_Widget' );

    //* Plugins
    unregister_widget( 'bcn_widget' );
}

//* Contact methods in profile page
add_filter( 'user_contactmethods', 'be_contactmethods' );
function be_contactmethods( $contactmethods ) 
{
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );
	
	return $contactmethods;
}

//* Remove Genesis Page Templates
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );
function be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}


/* ======================================================= */


// add style selector drop down 
// add_filter( 'mce_buttons_2', 'ejo_mce_buttons_2' );

// add styles
// add_filter( 'tiny_mce_before_init', 'ejo_mce_before_init' );

//* Editor Styles
// add_editor_style( 'editor-style.css' );

//* Editor buttons

function wps_mce_buttons_2( $buttons ) {

    // Check if style select has not already been added
    if ( isset( $buttons['styleselect'] ) )
        return;

    // Appears not, so add it ourselves.
    array_unshift( $buttons, 'styleselect' );
    return $buttons;

}

// add_filter( 'tiny_mce_before_init', 'wps_mce_before_init' );
// function wps_mce_before_init( $settings ) {

//     $style_formats = array(

// 		array(
// 			'title' => __( 'More Link', 'text-domain' ),
// 			'selector' => 'a',
// 			'classes' => 'more-link',
// 			),
// 		);

// 	// Check if there are some styles already
// 	if ( $settings['style_formats'] )
// 		$settings['style_formats'] = array_merge( $settings['style_formats'], json_encode( $style_formats ) );
// 	else
// 		$settings['style_formats'] = json_encode( $style_formats );

// 	return $settings;

// }

