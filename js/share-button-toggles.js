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