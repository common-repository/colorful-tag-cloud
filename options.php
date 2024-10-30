<?php
function colorful_tag_cloud_register_settings() {
	add_option('colorful_tag_cloud_type', 'random');
	add_option('colorful_tag_cloud_color_code', '#FFFFFF');
	register_setting('colorful_tag_cloud_options', 'colorful_tag_cloud_type');
	register_setting('colorful_tag_cloud_options', 'colorful_tag_cloud_color_code');
}
add_action('admin_init', 'colorful_tag_cloud_register_settings');

function colorful_tag_cloud_register_options_page() {
	add_options_page(__('Colorful Tag Cloud Options Page', COLORFUL_TAG_CLOUD_TEXT_DOMAIN), __('Colorful Tag Cloud', COLORFUL_TAG_CLOUD_TEXT_DOMAIN), 'manage_options', COLORFUL_TAG_CLOUD_TEXT_DOMAIN.'-options', 'colorful_tag_cloud_options_page');
}
add_action('admin_menu', 'colorful_tag_cloud_register_options_page');

function colorful_tag_cloud_get_select_option($select_option_name, $select_option_value, $select_option_id){
	?>
	<select name="<?php echo $select_option_name; ?>" id="<?php echo $select_option_name; ?>"<?php if($select_option_name == "colorful_tag_cloud_type"){ ?> onchange="customise_color_code(this);"<?php } ?>>
		<?php
		for($num = 0; $num < count($select_option_id); $num++){
			$select_option_value_each = $select_option_value[$num];
			$select_option_id_each = $select_option_id[$num];
			?>
			<option value="<?php echo $select_option_id_each; ?>"<?php if (get_option($select_option_name) == $select_option_id_each){?> selected="selected"<?php } ?>>
				<?php echo $select_option_value_each; ?>
			</option>
		<?php } ?>
	</select>
	<?php
}

function colorful_tag_cloud_options_page() {
?>
<script>
function customise_color_code(select){
	var selected_option = select.options[select.selectedIndex].value;
	var version_option = document.getElementById("colorful_tag_cloud_type");
	if(selected_option == "customise"){
		jQuery("#colorful_tag_cloud_customise_div").slideDown();
	}else{
		jQuery("#colorful_tag_cloud_customise_div").slideUp();
	}
}
</script>
<div class="wrap">
	<h2><?php _e("Colorful Tag Cloud Options Page", COLORFUL_TAG_CLOUD_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('colorful_tag_cloud_options'); ?>
		<h3><?php _e("General Options", COLORFUL_TAG_CLOUD_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="colorful_tag_cloud_type"><?php _e("Tag Cloud's Color Type: ", COLORFUL_TAG_CLOUD_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php colorful_tag_cloud_get_select_option("colorful_tag_cloud_type", array(__('Random', COLORFUL_TAG_CLOUD_TEXT_DOMAIN), __('Customise', COLORFUL_TAG_CLOUD_TEXT_DOMAIN)), array('random', 'customise')); ?>
						<div id="colorful_tag_cloud_customise_div"<?php if(get_option("colorful_tag_cloud_type") != "customise"){ ?> style="display: none;"<?php } ?>>
							<br />
							<input type="text" name="colorful_tag_cloud_color_code" id="colorful_tag_cloud_color_code" value="<?php echo get_option('colorful_tag_cloud_color_code'); ?>" title="<?php printf(__('Color code format: %s', COLORFUL_TAG_CLOUD_TEXT_DOMAIN), '#FFFFFF'); ?>" pattern="#[0-9A-z]{6}" size="7" maxlength="7" required="required" />
							<?php printf(__('(Click %shere%s to choose color code)', COLORFUL_TAG_CLOUD_TEXT_DOMAIN), '<a href="http://tools.arefly.com/html-color/" target="_blank">', "</a>"); ?>
						</div>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>