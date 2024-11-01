<?php
require_once('youtube_plugin_admin.php');
require_once('youtube_widget.php');

if(!class_exists('youtube_expert_admin')) {
	
	class youtube_expert_admin extends youtube_plugin_admin_dcsmt {
	
		var $hook = 'youtube';
		var $longname = 'YouTube watch  Configuration';
		var $shortname = 'YouTube watch';
		var $filename = 'youtube/youtube_tabs.php';
		var $homepage = 'http://wpdeveloper.info/youtube-subscription-widget';
		var $homeshort = '';
		var $twitter = '';
		var $title = 'Wordpress plugin YouTube watch';
		var $description = 'YouTube watch widget, put your video on site with stylish sliding tabs. Option also to have the tabs slide out from the side of the browsers';

		function __construct() {

			parent::__construct();
			
			add_action('admin_init', array(&$this,'settings_init'));

		}
		 
		function settings_init() {
		
			register_setting('dcsmt_options_group', 'dcsmt_options');
		}
		
		// Plugin specific side info box
		function info_box() {}
		
		function option_page() {
			
			$this->setup_admin_page('YouTube Tabs Settings','YouTube Tabs Configuration Settings');
			
		?>
		<?php if (!empty($message)) : ?>
			<div id="message" class="updated fade"><p><strong><?php echo $message ?></strong></p></div>
		<?php endif; ?>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#dcsmt_redirect').change(function(){
				var redirect = $('#dcsmt_redirect option:selected').val();
				$('.redirect-hide').hide();
				$('.redirect-'+redirect).show();
			});
			$('.hide-init').hide();
		});
		</script>
		<style>
		.dcsmt-icon {position: relative;}
		.dcsmt-icon img {position: absolute; top: 0; right: 0;}
		</style>
		<p class="youtube-intro">For instructions on how to configure this plugin check out the <a target="_blank" href="http://wpdeveloper.info/youtube-subscription-widget"><?php echo $this->shortname; ?> project page</a>.</p>
		
		<form method="post" id="dcsmt_settings_page" class="youtube-form" action="options.php">

			<?php
				settings_fields('dcsmt_options_group'); $options = get_option('dcsmt_options');
				$plugin_url = youtube_expert::get_plugin_directory();
				$icon_url = $plugin_url.'/css/images/';

				$skin = $options['skin'] ;
				$links = $options['links'] ? $options['links'] : 'true' ;

				$icon_youtube = $options['icon_youtube'] == '' ? '<img src="'.$icon_url.'youtube.png" alt="" />' : '<img src="'.$options['icon_youtube'].'" alt="" />';
			?>
				<ul>

					<li>
					  <label for="dcsmt_links">Open Links In New Window</label>
					  <input type="checkbox" value="true" class="checkbox" id="dcsmt_links" name="dcsmt_options[links]"<?php checked( $links, 'true'); ?> />
					</li>
					<li><h4>Put Your YouTube Icons ( http:// ) - or - Leave blank to use default images</h4></li>

					<li class="dcsmt-icon">
						<label for="dcsmt_icon_youtube">YouTube</label>
						<input type="text" id="dcsmt_icon_youtube" name="dcsmt_options[icon_youtube]" value="<?php echo $options['icon_youtube']; ?>" size="30" />
						<?php echo $icon_youtube; ?>


				</ul>

				<p class="submit">

					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

				</p>

		</form>

			<?php

			$this->close_admin_page();

		}
	}
}