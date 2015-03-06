jQuery(document).ready(function() {

	/*********************************
     * Sortable
     *********************************/
	jQuery( "table.view_settings tbody" ).sortable({
		revert: true,
		handle: ".ejo-move",
	});

});