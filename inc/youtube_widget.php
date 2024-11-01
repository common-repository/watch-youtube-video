<?php
class youtube_expert_widget extends WP_Widget {
	
	/** constructor */
    function youtube_expert_widget() {
	
		$name =			'YouTube Tabs';
		$desc = 		'Sliding  YouTube ';
		$id_base = 		'youtube_expert_widget';
		$css_class = 	'dcsmt_widget';
		$alt_option = 	'widget_dcjq_social_media_tabs';

		$widget_ops = array(
			'classname' => $css_class,
			'description' => __( $desc, 'dcjq-social-tabs' ),
		);
		
		$this->WP_Widget($id_base, __($name, 'dcjqsocialtabs'), $widget_ops);
		$this->alt_option_name = $alt_option;
		
		add_action( 'wp_head', array(&$this, 'styles'), 10, 1 );
		add_action( 'wp_footer', array(&$this, 'footer'), 10, 1 );
		add_action('init', array(&$this, 'my_init_method'));
		
		$options = get_option('dcsmt_options');
		$this->defaults = array(
			'method' => 'slide',
			'direction' => 'horizontal',
			'width' => 260,
			'height' => 290,
			'speedMenu' => 600,
			'position' => 'right',
			'offset' => 50,
			'autoClose' => '1',
			'start' => 0,









			'youtubeId' => '',
			'videoId' => '',
			'tab1' => 'facebook',


		);
    }

	function my_init_method(){
			
		if ( version_compare( get_bloginfo( 'version' ) , '3.0' , '<' ) && is_ssl() ) {
			$wp_content_url = str_replace( 'http://' , 'https://' , get_option( 'siteurl' ) );
		} else {
			$wp_content_url = get_option( 'siteurl' );
		}
		$wp_content_url .= '/wp-content';
		$wp_plugin_url = $wp_content_url . '/plugins';

		wp_register_style('youtube_plugin_admin_dcsmt_css', $wp_plugin_url .'/youtube/css/admin.css');
		wp_enqueue_style('youtube_plugin_admin_dcsmt_css');
	}    

	function widget($args, $instance){
		extract( $args );
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		
		$options = get_option('dcsmt_options');
		$plugin_url = youtube_expert::get_plugin_directory();
		$icon_url = $plugin_url.'/css/images/';
		
		$check = '';
		
		if($tab1 != 'none'){
			$tab1 = $widget_options['tab1'] == '' ? 'facebook' : $widget_options['tab1'];
			$checkTab = strlen(strstr($check,$tab1)) > 0 ? 1 : 0 ;
			if($checkTab == 0){
				$icon1 = $options['icon_'.$tab1] == '' ? '<img src="'.$icon_url.$tab1.'.png" alt="" />' : '<img src="'.$options['icon_'.$tab1].'" alt="" />';
				$f_tab1 = 'dcsmt_inc_'.$tab1;
				$tabContent1 = $this->$f_tab1($args, $instance);
				$check .= ','.$tab1;
			} else {
				$tab1 = 'none';
			}
		}
		




		?>
		<div id="<?php echo $this->id.'-item'; ?>">
        	<ul class="social-tabs">
                <?php
				$rel = 0;
				if($tab1 != 'none'){ ?>
				<li class="first dcsmt-<?php echo $tab1; ?>"><a href="#" rel="<?php echo $rel; ?>"><?php echo $icon1; ?></a></li>
				<?php
				$rel = $rel+1;
				} if($tab2 != 'none'){ ?>
				<li class="dcsmt-<?php echo $tab2; ?>"><a href="#" rel="<?php echo $rel; ?>"><?php echo $icon2; ?></a></li>
				<?php
				$rel = $rel+1;
				} if($tab3 != 'none'){ ?>
				<li class="dcsmt-<?php echo $tab3; ?>"><a href="#" rel="<?php echo $rel; ?>"><?php echo $icon3; ?></a></li>
				<?php
				$rel = $rel+1;
				} if($tab4 != 'none'){ ?>
				<li class="dcsmt-<?php echo $tab4; ?>"><a href="#" rel="<?php echo $rel; ?>"><?php echo $icon4; ?></a></li>
				<?php
				$rel = $rel+1;
				} if($tab5 != 'none'){
					if($tabContent5 != '') { ?>
				<li class="last dcsmt-<?php echo $tab5; ?>"><a href="#" rel="<?php echo $rel; ?>"><?php echo $icon5; ?></a></li>
				<?php } } ?>
			</ul>
			<ul class="dcsmt <?php echo $this->id.'-slide'; ?>">
				<?php if($tab1 != 'none'){ ?>
				<li class="tab-content <?php echo $this->id.'-tab'; ?>">
					<?php echo $tabContent1; ?>
                </li>
				<?php } if($tab2 != 'none'){ ?>
				<li class="tab-content <?php echo $this->id.'-tab'; ?>">
					<?php echo $tabContent2; ?>
				</li>
				<?php } if($tab3 != 'none'){ ?>
				<li class="tab-content <?php echo $this->id.'-tab'; ?>">
					<?php echo $tabContent3; ?>
				</li>
				<?php } if($tab4 != 'none'){ ?>
				<li class="tab-content <?php echo $this->id.'-tab'; ?>">
					<?php echo $tabContent4; ?>
				</li>
				<?php } if($tab5 != 'none'){
					if($tabContent5 != '') {
					 ?>
				<li class="tab-content <?php echo $this->id.'-tab'; ?>">
					<?php echo $tabContent5 ; ?>
				</li>
				<?php } } ?>
			</ul>
		</div>

		<?php
	}

    /** @see WP_Widget::update */
    function update( $new_instance, $old_instance ) {
	
		$instance['method'] = $new_instance['method'];
		$instance['direction'] = $new_instance['direction'];
		$instance['width'] = (int) strip_tags( stripslashes($new_instance['width']) );
		$instance['height'] = (int) strip_tags( stripslashes($new_instance['height']) );
		$instance['speedMenu'] = (int) strip_tags( stripslashes($new_instance['speedMenu']) );
		$instance['position'] = $new_instance['position'];
		$instance['offset'] = (int) strip_tags( stripslashes($new_instance['offset']) );
		$instance['skin'] = $new_instance['skin'];
		$instance['autoClose'] = $new_instance['autoClose'];
		$instance['loadOpen'] = $new_instance['loadOpen'];



		$instance['nBuzz'] = (int) strip_tags( stripslashes($new_instance['nBuzz']) );





		$instance['youtubeId'] = strip_tags( stripslashes($new_instance['youtubeId']) );
		$instance['videoId'] = strip_tags( stripslashes($new_instance['videoId']) );
		$instance['tab1'] = strip_tags( stripslashes($new_instance['tab1']) );


		return $instance;
	}

    /** @see WP_Widget::form */
    function form($instance) {
	
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		
		// Get default values
		settings_fields('dcsmt_options_group'); $options = get_option('dcsmt_options');



		$nBuzz = isset( $instance['nBuzz'] ) ? $instance['nBuzz'] : '5';
		$method = isset( $instance['method'] ) ? $instance['method'] : 'static';
		$direction = isset( $instance['direction'] ) ? $instance['direction'] : 'horizontal';
		$tab1 = isset( $instance['tab1'] ) ? $instance['tab1'] : 'twitter';

		
		?>
	<p>
		<label for="<?php echo $this->get_field_id('method1'); ?>"><?php _e('') ?></label>
		<input type="radio" id="<?php echo $this->get_field_id('method1'); ?>" name="<?php echo $this->get_field_name('method'); ?>" value="slide"<?php checked( $method, 'slide' ); ?> class="method-slide" /> 
		<label for="<?php echo $this->get_field_id('method1'); ?>"><?php _e( 'Slide Out' , 'dcjq-social-tabs' ); ?></label> <br />
		<input type="radio" id="<?php echo $this->get_field_id('method2'); ?>" name="<?php echo $this->get_field_name('method'); ?>" value="static"<?php checked( $method, 'static' ); ?> class="method-static" /> 
		<label for="<?php echo $this->get_field_id('method2'); ?>"><?php _e( 'Static' , 'dcjq-social-tabs' ); ?></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('direction1'); ?>"><?php _e('') ?></label>
		<input type="radio" id="<?php echo $this->get_field_id('direction1'); ?>" name="<?php echo $this->get_field_name('direction'); ?>" value="horizontal"<?php checked( $direction, 'horizontal' ); ?> />
		<label for="<?php echo $this->get_field_id('direction1'); ?>"><?php _e( 'Horizontal' , 'dcjq-social-tabs' ); ?></label> <br />
		<input type="radio" id="<?php echo $this->get_field_id('direction2'); ?>" name="<?php echo $this->get_field_name('direction'); ?>" value="vertical"<?php checked( $direction, 'vertical' ); ?> /> 
		<label for="<?php echo $this->get_field_id('direction2'); ?>"><?php _e( 'Vertical' , 'dcjq-social-tabs' ); ?></label>
	</p>
	<p class="youtube-row">
		Width: 
		<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $widget_options['width']; ?>" size="4" /> 
	     <br />
		Height:
		<input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $widget_options['height']; ?>" size="4" />
	</p>
	
	<p class="youtube-row">
	  <label for="<?php echo $this->get_field_id('position'); ?>"><?php _e( 'Positons' , 'dcjq-social-tabs' ); ?></label>
		<select name="<?php echo $this->get_field_name('position'); ?>" id="<?php echo $this->get_field_id('position'); ?>" >
			<option value='top-left' <?php selected( $widget_options['position'], 'top-left'); ?> >Top Left</option>
			<option value='top-right' <?php selected( $widget_options['position'], 'top-right'); ?> >Top Right</option>
			<option value='bottom-left' <?php selected( $widget_options['position'], 'bottom-left'); ?> >Bottom Left</option>
			<option value='bottom-right' <?php selected( $widget_options['position'], 'bottom-right'); ?> >Bottom Right</option>
			<option value='left' <?php selected( $widget_options['position'], 'left'); ?> >Left</option>
			<option value='right' <?php selected( $widget_options['position'], 'right'); ?> >Right</option>
		</select>
	</p>
	
	<p class="youtube-row">

	<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e( 'Positons up-down:' , 'dcjq-social-tabs' ); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" value="<?php echo $widget_options['offset']; ?>" size="4" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('speedMenu'); ?>"><?php _e('Slide Speed:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('speedMenu'); ?>" name="<?php echo $this->get_field_name('speedMenu'); ?>" value="<?php echo $widget_options['speedMenu']; ?>" size="5" /> (ms)
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('autoClose'); ?>"><?php _e( 'Auto-Close' , 'dcjq-social-tabs' ); ?></label>
		<input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('autoClose'); ?>" name="<?php echo $this->get_field_name('autoClose'); ?>"<?php checked( $widget_options['autoClose'], 'true'); ?> style="margin-right: 5px;" /> 
	      <br />
		<label for="<?php echo $this->get_field_id('loadOpen'); ?>"><?php _e( 'Load Open' , 'dcjq-social-tabs' ); ?></label>
		<input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('loadOpen'); ?>" name="<?php echo $this->get_field_name('loadOpen'); ?>"<?php checked( $widget_options['loadOpen'], 'true'); ?> />
	</p>
	<p class="youtube-row"><strong></strong></p>
	<p class="youtube-row">
	   <?php echo $this->dcsmt_tab_options('tab1', 'Tab 1', $tab1); ?>

	</p>


	<p class="youtube-row">

	</p>














	<p class="youtube-row">
		<strong>YouTube</strong>
	</p>
	<p class="youtube-row">
		<label for="<?php echo $this->get_field_id('youtubeId'); ?>"><?php _e('Username:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('youtubeId'); ?>" name="<?php echo $this->get_field_name('youtubeId'); ?>" value="<?php echo $youtubeId; ?>" />
	</p>
	<p class="youtube-row">
		<label for="<?php echo $this->get_field_id('videoId'); ?>"><?php _e('Video ID:') ?></label>
		<input type="text" id="<?php echo $this->get_field_id('videoId'); ?>" name="<?php echo $this->get_field_name('videoId'); ?>" value="<?php echo $videoId; ?>" />
	</p>
	<div class="widget-control-actions alignright">
		<p><a href="http://wpdeveloper.info/wppostnews-word-press-themes"><?php esc_attr_e('Visit plugin site', 'dcjq-social-tabs'); ?></a></p>
	</div>
	
	<?php 
	}
	
	/** Creates tab options. */
	function dcsmt_tab_options($id, $label, $value){




		$youtube = $value == 'youtube' ? '<option value="youtube" selected="selected">':'<option value="youtube">';



		$select = '<select name="'.$this->get_field_name($id).'" id="'.$this->get_field_id($id).'" class="dcsmt-select">';



		$select .= $rss.'RSS Feed</option>';
		$select .= $youtube.'YouTube</option>';
		$select .= $none.'None</option>';
		$select .= '</select>';
		
		return $select;
	}
	
	/** Adds ID based slick skin to the header. */
	function styles(){
		
		if(!is_admin()){

			$options = get_option('dcsmt_options');
			$skin = $options['skin'];
			if($skin != 'true'){
				echo "\n\t<link rel=\"stylesheet\" href=\"".youtube_expert::get_plugin_directory()."/css/dcsmt.css\" type=\"text/css\" media=\"screen\"  />";
			}
		}
	}

	/** Adds ID based activation script to the footer */
	function footer(){
		
		if(!is_admin()){
		
		$all_widgets = $this->get_settings();
		
		foreach ($all_widgets as $key => $wpdcjqsocialtabs){
		
			$widget_id = $this->id_base . '-' . $key;
		
			if(is_active_widget(false, $widget_id, $this->id_base)){
			
				$method = $wpdcjqsocialtabs['method'] == '' ? 'static' : $wpdcjqsocialtabs['method'];
				$direction = $wpdcjqsocialtabs['direction'] == '' ? 'horizontal' : $wpdcjqsocialtabs['direction'];
				
				$position = $wpdcjqsocialtabs['position'];
				if($position == 'top-left'){
					$location = 'top';
					$align = 'left';
				}
				if($position == 'top-right'){
					$location = 'top';
					$align = 'right';
				}
				if($position == 'bottom-left'){
					$location = 'bottom';
					$align = 'left';
				}
				if($position == 'bottom-right'){
					$location = 'bottom';
					$align = 'right';
				}
				
				if($position == 'left'){
					if($method == 'float'){
						$location = 'top';
						$align = 'left';
					} else {
						$location = 'left';
						$align = 'top';
					}
				}
				
				if($position == 'right'){
					if($method == 'float'){
						$location = 'top';
						$align = 'right';
					} else {
						$location = 'right';
						$align = 'top';
					}
				}
				
				$width = $wpdcjqsocialtabs['width'] == '' ? 260 : $wpdcjqsocialtabs['width'];
				$height = $wpdcjqsocialtabs['height'] == '' ? 260 : $wpdcjqsocialtabs['height'];
				$speedMenu = $wpdcjqsocialtabs['speedMenu'] == '' ? 600 : $wpdcjqsocialtabs['speedMenu'];
				$offset = $wpdcjqsocialtabs['offset'] == '' ? 0 : $wpdcjqsocialtabs['offset'];
				$autoClose = $wpdcjqsocialtabs['autoClose'] == '' ? 'false' : $wpdcjqsocialtabs['autoClose'];
				$loadOpen = $wpdcjqsocialtabs['loadOpen'] == '' ? 'false' : $wpdcjqsocialtabs['loadOpen'];
				$start = $wpdcjqsocialtabs['start'] == '' ? 0 : $wpdcjqsocialtabs['start'];
				
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('#<?php echo $widget_id.'-item'; ?>').dcSlickTabs({
						location: '<?php echo $location; ?>',
						align: '<?php echo $align; ?>',
						offset: <?php echo $offset; ?>,
						speed: <?php echo $speedMenu; ?>,
						width: <?php echo $width; ?>,
						height: <?php echo $height; ?>,
						slider: '<?php echo $widget_id.'-slide'; ?>',
						slides: '<?php echo $widget_id.'-tab'; ?>',
						tabs: 'social-tabs',
						slideWrap: '<?php echo $widget_id.'-wrap'; ?>',
						direction: '<?php echo $direction; ?>',
						autoClose: <?php echo $autoClose; ?>,
						method: '<?php echo $method; ?>',
						start: <?php echo $start; ?>
					});
					<?php
						if($this->get_dcsmt_default('links') == 'true') {
					?>
					$('.dc-social .tab-content a').click(function(){
						this.target = "_blank";
					});
					<?php } ?>
				});
			</script>
		
			<?php

			}
		}
		}
	}

	function get_dcsmt_default($option){

		$options = get_option('dcsmt_options');
		$default = $options[$option];
		return $default;
	}





	


	


	/* YouTube */
	function dcsmt_inc_youtube($args, $instance){
	
		extract( $args );
		$widget_options = wp_parse_args( $instance, $this->defaults );
		extract( $widget_options, EXTR_SKIP );
		$options = get_option('dcsmt_options');
		$youtubeId = $widget_options['youtubeId'];
		$videoId = $widget_options['videoId'];
		$height = $widget_options['height'];
		$width = $widget_options['width'];
		$ratio = 1.641;
		$maxwidth = $width - 20;
		$maxheight = $height - 125;
		$height = $maxwidth/$ratio;
		$width = $maxwidth;
		$tab = '';

		if($youtubeId != ''){

		if($height > $maxheight){
			$height = $maxheight;
			$width = $height * $ratio;
		}
		$padLeft = ($maxwidth-$width)/2;

		$tab .= '<div class="tab-youtube tab-inner"><iframe src="http://www.youtube.com/subscribe_widget?p='.$youtubeId.'" style="overflow: hidden; height: 105px; width: 100%; border: 0;" scrolling="no" frameBorder="0"></iframe>';
		if($videoId != ''){
			$tab .= '<div style="padding-left: '.$padLeft.'px;"><iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'px" height="'.$height.'px" src="http://www.youtube.com/embed/'.$videoId.'" frameborder="0" allowFullScreen></iframe></div>';
		}
		$tab .= '</div>';
		
		}
		
		return $tab;
	}
	
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	
	// Truncate text
		function youtube_truncate($str, $length=10, $trailing='...'){
			$length-=strlen($trailing);
			if (strlen($str) > $length) {
				 return substr($str,0,$length).$trailing;
			} 
			else { 
				 $res = $str; 
			}
			return $res;
		}
		
} // class youtube_expert_widget