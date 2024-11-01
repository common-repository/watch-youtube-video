<?php
/**
* Admin DC plugins
* Version 1.0.1
*/

if(!class_exists('youtube_plugin_admin_dcsmt')) {

	class youtube_plugin_admin_dcsmt {

		var $hook 		= '';
		var $filename	= '';
		var $longname	= '';
		var $shortname	= '';
		var $optionname = '';
		var $homepage	= '';
		var $accesslvl	= 'manage_options';

		function __construct() {

			add_filter("plugin_action_links_{$this->filename}", array(&$this,'add_settings_link'));
			add_action('admin_menu', array(&$this,'add_option_page'));
			add_action("admin_print_styles-settings_page_{$this->hook}",array(&$this,'add_admin_styles'));
			add_action("admin_print_scripts-settings_page_{$this->hook}",array(&$this,'add_admin_scripts'));
		}

		function add_admin_styles() {

			wp_enqueue_style("youtube_plugin_admin_dcsmt_css", WP_CONTENT_URL . "/plugins/" . plugin_basename(dirname($this->filename)). "/css/admin.css");

		}

		function add_admin_scripts() {

			wp_enqueue_script('postbox');
			wp_enqueue_script('jquery');
			wp_enqueue_style('youtube_plugin_admin_dcsmt_jquery', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname($this->filename)). '/js/jquery.admin.js');

		}

		function add_option_page() {

			add_options_page($this->longname, $this->shortname, $this->accesslvl, $this->hook, array(&$this,'option_page'));

		}

		function add_settings_link($links) {

			$settings_link = '<a href="options-general.php?page='.$this->hook.'">Settings</a>';

			array_unshift($links, $settings_link);

			return $links;

		}







		function support_box() {

			$content = '<ul class="bullet">';
			$content .= '<li>Trouble installing or setting-up?</li>';
			$content .= '<li>Need help on customising the styles?</li>';
			$content .= '<li>Have a suggestion on how it can be improved?</li></ul>';
			$content .= '<p>Check out some of the solutions or contact us directly via the <a target="_blank" href="'.$this->homepage.'">plugin home page</a>.';

			$this->postbox($this->hook.'-support-box',"Need any help with ".$this->shortname."?",$content);

		}

		function postbox($id,$title,$content){

			?>

			<div id="<?php echo $id; ?>" class="postbox youtube-box">
				<h3 class="hndle"><span><?php echo $title; ?></span></h3>
				<div class="inside">
					<?php echo $content; ?>
				</div>
			</div>

			<?php

		}

		function setup_admin_page($title,$subtitle) {

			?>

			<div class="wrap">
			  <h2><a href="http://www.designchemical.com/blog/" target="_blank" id="youtube-avatar"></a><?php echo $title; ?></h2>
			  <div class="postbox-container" style="width:65%;">
			    <div class="metabox-holder">
				  <div class="meta-box-sortables">
				    <div class="postbox">
					  <h3 class="hndle"><span><?php echo $subtitle; ?></span></h3>
					  <div class="inside">

			<?php

		}

		function close_admin_page() {

		?>

		</div></div></div></div></div>

		<div class="postbox-container" style="width:30%;">
			<div class="metabox-holder">
				<div class="meta-box-sortables">
					<?php




					  
					?>
				</div>
			</div>
		</div>
	</div>

		<?php

		}
	}
}