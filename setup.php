<?php 
if(isset($_POST['checkfront_host'])) {

	update_option('checkfront_mode',$_POST['checkfront_mode']);
	update_option('checkfront_interface',$_POST['checkfront_interface']);
	update_option('checkfront_view',$_POST['checkfront_view']);
	update_option('checkfront_theme',$_POST['checkfront_theme']);
	update_option('checkfront_style_background-color',$_POST['checkfront_style_background-color']);
	update_option('checkfront_style_color',$_POST['checkfront_style_color']);
	update_option('checkfront_style_font-faimly',$_POST['checkfront_style_font-family']);
	update_option('checkfront_options-tabs',$_POST['checkfront_options-tabs']);
	update_option('checkfront_options-compact',$_POST['checkfront_options-compact']);
	update_option('checkfront_view',$_POST['checkfront_view']);
	update_option('checkfront_shortcode',$_POST['checkfront_shortcode']);

	$Checkfront->mode = $_POST['checkfront_mode'];
	$Checkfront->interface = $_POST['checkfront_interface'];
	if($host = $Checkfront->valid_host($_POST['checkfront_host'])) {
		update_option('checkfront_host',$host);
		$Checkfront->host = $host;
		$cf_msg = "Updated!";
	} else {
		$cf_msg = "Invalid URL!";
	}
}

$checkfront_args['view']= get_option('checkfront_view');
$checkfront_args['theme']= get_option('checkfront_theme');
$checkfront_args['style_background-color']= get_option('checkfront_style_background-color');
$checkfront_args['style_color']= get_option('checkfront_style_color');
$checkfront_args['style_font-family']= get_option('checkfront_style_font-family');
$checkfront_args['options-tabs']= get_option('checkfront_options-tabs');
$checkfront_args['options-compact']= get_option('checkfront_options-compact');
$checkfront_args['shortcode']= get_option('checkfront_shortcode');
if(!$checkfront_args['shortcode']) $checkfront_args['shortcode'] = '[checkfront]';
?>
<div style="width: 800px">
<script src="<?php print WP_PLUGIN_URL . '/' . basename(dirname(__FILE__))?>/setup.js?v=3" type="text/javascript"></script>
<br />
<div style="width: 500px; float: left">
<p>Checkfront is a powerful online booking system that allows businesses to manage their inventories, centralize reservations, and process payments. </p>

<h3>Quick Start</h3>
<ul style="font-size: 16px">
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #86C620; border-radius: 10px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">1</strong> Create <a href="https://www.checkfront.com/start/" target="_blank">your Checkfront account</a>.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #86C620; border-radius: 10px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">2</strong> Supply your Checkfront URL and optional settings <a href="#checkfront_setup">below</a>.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #86C620; border-radius: 10px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">3</strong> Create a new page and supply the <a href="#shortcode">short code</a> you created.</li>
<li style="padding: 5px 0; height: 25px; line-height: 25px;"><strong style="margin-right: 10px; background-color: #86C620; border-radius: 10px; clear: none; color: #000; display: inline-block; float: left; font-style: normal; height: 25px; font-weight: bold; line-height: 25px;font-size:14px; text-align: center; width: 25px;">4</strong> Start accepting online bookings.</li>
</ul>
</div>
<div style="float: right; width: 275px; bmx-shadow: 0 0 2px #ddd; border-radius: 6px; background-color: #fff; border: solid 1px #ddd; padding: 10px;">
<a href="http://www.checkfront.com/"><img src="//www.checkfront.com/images/brand/Checkfront-Logo-40.png" alt="Checkfront" /></a><br />
<strong>Smart, Simplified Online Bookings</strong><br /><br />
<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fcheckfront.bookings&amp;send=false&amp;layout=button_count&amp;width=250&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=132896805841" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:290px; margin-bottom: 10px; height:21px;" allowTransparency="true"></iframe>
<!-- Place this tag in your head or just before your close body tag -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<!-- Place this tag where you want the +1 button to render -->
<div class="g-plusone" data-size="small" data-annotation="inline" data-href="http://www.checkfront.com/"></div>
<br />
<a href="http://twitter.com/Checkfront" style="background: url('https://www.checkfront.com/images/twitter.png') left center no-repeat; padding: 5px 5px 5px 20px">Follow us on Twitter</a><br /><br />
<a href="http://www.checkfront.com/support/" style="background: url('https://www.checkfront.com/images/brand/Checkfront-Icon-16.png') left center no-repeat; padding: 5px 5px 5px 20px;">Support Library</a><br /><br />
<a href="http://www.checkfront.com/wordpress/" style="background: url('http://s.wordpress.org/favicon.ico?3') left center no-repeat; padding: 5px 5px 5px 20px;">Checkfront Wordpress Setup Guide</a>
</div>
<br style="clear: both" />
<form method="post" action="">
	<div class="metabox-holder meta-box-sortables pointer">
		<div class="postbox">
			<h3 class="hndle"><span  style="background: url('//media.checkfront.com/images/menu/manage.png') left center no-repeat; padding: 1em 1em 1em 24px;">Setup</span></h3>
<?php
if(isset($cf_msg)){?>
<div style="background-color: rgb(255, 251, 204); margin:1em 1em 0em 1em" id="message" class="updated fade"><p><strong><?php echo $cf_msg?></strong></p></div>
<?php }?>
			<div class="inside" style="padding: 0 10px">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="checkfront_email">Checkfront Host Url:</label></th>
						<td nowrap>https://<input name="checkfront_host" style="width: 20em" id="CF_id" value="<?php echo $Checkfront->host?>" class="regular-text" type="text" /> </td>
						<td id="CF_status"><em>Location of your Checkfront Management Console [<a href="https://www.checkfront.com/start">Create</a>]</em></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="v2">Interface:</label></th>
						<td>
<input type="radio" value="v2" id="v2" name="checkfront_interface"  class="checkfront_opt_interface" <?php if($Checkfront->interface== 'v2') print 'checked="checked"';?> /> <label for="v2">2.0 (Recommended)</label> &nbsp; &nbsp; &nbsp; <input type="radio" name="checkfront_interface" id="v1" value="v1" <?php if($Checkfront->interface == 'v1') print 'checked="checked"';?> class="checkfront_opt_interface" /> <label for="v1">1.0</label> 
				</td>
						<td><em></em></td>
					</tr>
					<tr valign="top" class="checkfront_v1" <?php if($Checkfront->interface == 'v2') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_mode">Render mode:</label></th>
						<td><input type="radio" name="checkfront_mode" id="inline" value="inline" <?php if($Checkfront->legacy_mode == 'inline') print 'checked="checked"';?> /> <label for="inline">Inline</label> &nbsp;&nbsp; <input type="radio" value="framed" id="framed" name="checkfront_mode"  <?php if($Checkfront->mode == 'framed') print 'checked="checked"';?> /> <label for="framed">Framed</label></td>
						<td><em>In-line will blend better with your existing layout, but is not compatible with some themes.  </em></td>
					</tr>
					<tr>
					<td>
						<input type="submit" name="submit" class="button-primary" value=" Update " /> 
				</td>
					</tr>
				</tbody>
			</table>

			</div>
		</div>
	</div>
<style type="text/css">
#CF_inv  {
padding: 5px;
border-radius: 5px;
max-height: 200px;
overflow: auto;
border: solid 1px #DFDFDF;
}
#CF_inv ul {
padding: .2em 0 .2em 2em;
}
</style>
<a name="checkfront_setup"></a>
<div class="metabox-holder meta-box-sortables pointer" id="checkfront_shortcode_builder">
        <div class="postbox">
			<h3 class="hndle"><span  style="background: url('//media.checkfront.com/images/menu/booking.png') left center no-repeat; padding: 1em 1em 1em 24px;">Generate Booking Page Shortcode</span></h3>
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><a name="shortcode"></a><label for="checkfront_email">Checkfront Shortcode:</label></th>
						<td><input  id="checkfront_shortcode" name="checkfront_shortcode" value="<?php echo stripslashes($checkfront_args['shortcode'])?>" class="regular-text" type="text" readonly="readonly" /></td>
						<td><em>Copy this code into a <a href="post-new.php?post_type=page">new</a> or existing page.</em></td>
					</tr>
					<tr valign="top" class="checkfront_v2" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_view_D">View:</label></th>
						<td>
							<input type="radio" name="checkfront_view" class="checkfront_view" id="checkfront_view_D" value="D" <?php if($checkfront_args['view'] == 'D') print ' checked="checked"'?>/> <label for="checkfront_view_D">Detail</label> &nbsp;&nbsp;&nbsp;
							<input type="radio" name="checkfront_view" class="checkfront_view" id="checkfront_view_L" value="L" <?php if($checkfront_args['view'] == 'L') print ' checked="checked"'?>/> <label for="checkfront_view_L">List</label>
						</td>
						<td><em>Detailed or list style layout</em></td>
					</tr>
					<tr valign="top" class="checkfront_v2" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_style_background-color">Background Color:</label></th>
						<td><input name="checkfront_style_background-color" id="checkfront_style_background-color" value="<?php echo $checkfront_args['style_background-color']?>" class="regular-text" type="text"  /></td>
						<td><em>Optional background color: eg: #FFFFFF</em></td>
					</tr>

					<tr valign="top" class="checkfront_v2" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_style_color">Text Color:</label></th>
						<td><input name="checkfront_style_color" id="checkfront_style_color" value="<?php echo $checkfront_args['style_color']?>" class="regular-text" type="text"  /></td>
						<td><em>Optional foreground color, eg: #000000</em></td>
					</tr>
					<tr valign="top" class="checkfront_v2" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_style_font-family">Font Family:</label></th>
						<td><input name="checkfront_style_font-family" id="checkfront_style_font-family" value="<?php echo $checkfront_args['style_font-family']?>" class="regular-text" type="text"  /></td>
						<td><em>Optional font family, eg: Arial</em></td>
					</tr>
					<tr valign="top" class="checkfront_v2" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="checkfront_theme">Theme:</label></th>
						<td>
						<!-- TBR -->
						<select disabled="diasbled" name="checkfront_theme" id="checkfront_theme">
							<option value="">Default &nbsp; </option>
						</select>
						</td>
						<td><em></em></td>
					</tr>
					<tr valign="top" <?php if($Checkfront->interface == 'v1') print ' style="display: none"'?>>
						<th scope="row"><label for="v2">Options:</label></th>
						<td>
		<input type="checkbox" value="1" id="checkfront_tabs" name="checkfront_tabs"   <?php if($checkfront_args['options-tabs']) print 'checked="checked"';?> /> <label for="checkfront_tabs">Tabs for categories</label> &nbsp; &nbsp; &nbsp; 
		<input type="checkbox" value="1" id="checkfront_compact" name="checkfront_compact"   <?php if($checkfront_args['options-compact']) print 'checked="checked"';?> /> <label for="checkfront_compact">Compact layout</label> &nbsp; &nbsp; &nbsp; 
</td>
						<td><em>See the <a href="http://www.checkfront.com/support/wordpress/" target="_blank">Checkfront Wordpress Setup Guide</a> for more options.</em></td>
					</tr>
		<tr valign="top">
						<th scope="row"><label for="checkfront_inventory">Inventory:</label></th>
						<td>
            <ul id="CF_inv">
            <li><input type="radio" value="*" name="inventory" id="inventory_all" checked="checked" /><label for="inventory_all"> <strong>All items and categories</strong></label></li>
            </ul>
						</td>
						<td><em></em></td>
					</tr>
<tr><td colspan="3">
				<p style="padding-left: .5em"> Create a <a href="post-new.php?post_type=page">new Wordpress page</a> and embed the Checkfront booking system by pasting in the shortcode above.</p>
</td></tr>
					<tr>
					<td>
						<input type="submit" name="submit" class="button-primary" value=" Save as Default" /> 
				</td>
					</tr>
							</tbody>
				</table>
</ul>
</div>
</div>
</div>
</form>
<p style="color: #555">&copy; Checkfront Inc <?php print date('Y')?> &nbsp; &nbsp;  API Version: <?php print $Checkfront->api_version?></p>
