jQuery(document).ready(function(){
jQuery('#share-email-widget').live('click', function(event) {
				jQuery('#email-widget').toggle();
});
jQuery('#share-tip').live('click', function(event) {
				jQuery('#share-tip-info').toggle();
});
jQuery('#tip-bitcoin').live('click', function(event) {
			jQuery('#bitcointips-widget').toggle('show');
});
jQuery('#tip-flattr').live('click', function(event) {
			FlattrLoader.setup();
			jQuery('#flattr-widget').toggle('show');
});
jQuery('#alt-tip-method').live('click', function(event) {
			jQuery('#bitcointips-widget').toggle('show');
});
});

// Used to load sharing services in a popup window
function share_button_popup(a){window.open(a,"_blank","width=500,height=300,toolbar=0,menubar=0,location=0,resizable=0,scrollbars=0,status=0")}