jQuery(document).ready(function() {

	jQuery('#CF_shortcode').focus(function() {
		jQuery(this).select();
	});

	if(jQuery('#CF_id').val()) {
    var checkfront_url = 'http://' + jQuery('#CF_id').val() + '/api/inv/list?callback=?';


    // Enable caching
    // Send JSON request
    // The returned JSON object will have a property called "results" where we find
    // a list of the tweets matching our request query
    jQuery.getJSON(
        checkfront_url,
        function(data) {
			if(data.company) {
			    jQuery('#CF_status').html('<strong>' + data.company + '</strong>');
			    jQuery('#CF_id').css('background','#c6ffaf');
			} else {
			}
            jQuery.each(data.inv, function(category_id, inv) {
            	jQuery('#CF_inv').append('<li><input type="radio" id="cf_categroy_id_' + category_id + '" name="inventory" value="category_id=' + category_id + '"><label for="cf_category_' + category_id + '"><strong>' + inv.name + '</strong></h2></label><ul id="CF_' + category_id +  '"></ul></li>');
            	jQuery.each(inv.items, function(item_id, item) {
            			jQuery('#CF_' + category_id).append('<li><input type="radio" name="inventory" id="cf_item_' + item_id + '" value="item_id=' + item_id + '" id="cf_item_id_' + item_id + '" /><label for="cf_item_' + item_id + '">' + item.name + '</label></li>');
				});

			});

			jQuery('#CF_inv input').change(function(){
				jQuery('#CF_shortcode').val('[checkfront ' + jQuery(this).val() + ']');	
			});
        }
    );
	}
});
