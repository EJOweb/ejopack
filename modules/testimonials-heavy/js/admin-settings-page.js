jQuery(document).ready(function() {

	jQuery('#ejo-tabs').find('a').click(function() {
		jQuery('#ejo-tabs').find('.nav-tab').removeClass('nav-tab-active');
		jQuery('#ejo-tabs-wrapper').find('.tab-content').removeClass('active');

		// Make tab active
		jQuery(this).addClass('nav-tab-active');

		// Make tab-content active
		var tab_content_target = jQuery(this).attr('href');
		jQuery( tab_content_target ).addClass('active');
	});

	// default active to first tab
	var active_tab = jQuery('#ejo-tabs').find('.nav-tab-active').length;
	if( active_tab == 0 ) {
		jQuery('#ejo-tabs').find('.nav-tab:first').addClass('nav-tab-active');
		jQuery('#ejo-tabs-wrapper').find('.tab-content:first').addClass('active');
	}

	/*********************************
     * Sortable
     *********************************/
	jQuery( "#single-settings table tbody" ).sortable({
        revert: true,
        handle: ".ejo-move",
    });

});