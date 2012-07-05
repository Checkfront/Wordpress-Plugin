jQuery(document).ready(function() {

	jQuery('#CF_shortcode').focus(function() {
		jQuery(this).select();
	});

	if(jQuery('#CF_id').val())  {
		var checkfront_url = 'http://' + jQuery('#CF_id').val() + '/api/inv/list?callback=?';
	}
	jQuery('.checkfront_opt_interface').change(function() {
		if(jQuery(this).val() == 'v1') {
			jQuery('.checkfront_v2').hide();
			jQuery('.checkfront_v1').show();
		} else {
			jQuery('.checkfront_v2').show();
			jQuery('.checkfront_v1').hide();
		}
	});

	jQuery('#checkfront_shortcode_builder :input').change(function(){
		shortcode();
	});


	function shortcode() {
		var shortcode = 'checkfront';
		var theme = jQuery('#checkfront_theme').val();
		var width = jQuery('#checkfront_width').val();
		var color = jQuery('#checkfront_style-color').val();
		var view = jQuery(':input[name=checkfront_view]:checked').val();
		var inv = jQuery(':input[name=inventory]:checked').val();
		if(theme)  shortcode += ' theme=' + theme;
		if(view == 'L')shortcode += ' view=L';
		if(inv && inv != '*')  shortcode += ' ' + inv;
		shortcode += style();
		shortcode += options();

		var code = jQuery('#checkfront_shortcode');
		code.val('[' + shortcode + ']');	
		flashColor(code);
	}

	function style() {
		var style = new Array();
		var background_color = jQuery('#checkfront_style_background-color').val();
		var color = jQuery('#checkfront_style_color').val();
		var font = jQuery('#checkfront_style_font-family').val();
		if(background_color) style.push("background-color:" + clean(background_color));
		if(color) style.push("color:" + clean(background_color));
		if(font) style.push("font-family:" + clean(font));
		if(style.length > 0) {
			return " style='" + style.join(';') + "'";
		} else {
			return '';
		}
	}

	function options () {
		var options = new Array();
		var tabs = jQuery(':input[name=checkfront_tabs]:checked').val();
		var compact = jQuery(':input[name=checkfront_compact]:checked').val();
		if(tabs) options.push('tabs');
		if(compact) options.push('compact');
		if(options.length > 0) {
			return " options=" + options.join(',') + "";
		} else {
			return '';
		}
	}
		
	function clean(str) {
		return str.replace(/[^\d\w\-\_ , "]/ig,'');
	}

	function flashColor(container) {
		if(container.length) {
			var originalColor = container.css('backgroundColor');
			container.animate({backgroundColor:'yellow'},'normal','linear',function(){
				container.animate({
					backgroundColor:originalColor
				});
			});
		}
	}


 // Enable caching
    // Send JSON request
    // The returned JSON object will have a property called "results" where we find
    // a list of the tweets matching our request query
    jQuery.getJSON(
        checkfront_url,
        function(data) {
            if(data.company) {
                jQuery('#CF_status').html('<strong>' + data.company + '</strong>');
                jQuery('#CF_id').css('background','#D3FF8C');
            } else {
            }   
			jQuery.each(data.inv, function(category_id, inv) {
						if(!inv.name) inv.name = '';
				jQuery('#CF_inv').append('<li><input type="radio" id="cf_categroy_id_' + category_id + '" name="inventory" value="category_id=' + category_id + '"> <label for="cf_category_' + category_id + '"><strong>' + inv.name + '</strong></h2></label><ul id="CF_' + category_id +  '"></ul></li>');
				if(inv.items) {
					jQuery.each(inv.items, function(item_id, item) {
						jQuery('#CF_' + category_id).append('<li><input type="radio" name="inventory" id="cf_item_' + item_id + '" value="item_id=' + item_id + '" id="cf_item_id_' + item_id + '" /> <label for="cf_item_' + item_id + '">' + item.name + '</label></li>');
					});
				}
            });
            jQuery('#CF_inv input').change(function(){
				shortcode();
            });
        }
    );
});

