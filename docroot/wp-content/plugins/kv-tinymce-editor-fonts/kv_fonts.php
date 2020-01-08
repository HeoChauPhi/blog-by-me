<?php
/**
Plugin Name: KVTinyMCE Editor Add Fonts
Plugin URI: http://wordpress.org/plugins/kv-tinymce-editor-fonts/
Description: Add Extra buttons fonts and its size with your  WordPress admin post editor i.e TinyMCE Editor. <a href="http://www.kvcodes.com" target="_blank" > Read more </a> 
Author: Kvvaradha
Version: 1.1
Author URI: http://profiles.wordpress.org/kvvaradha
*/

define('KV_FONT_TINYMCE_URL', plugin_dir_url( __FILE__ ));

if(!function_exists('kv_tinymce_fonts_deactivate')) {
	function kv_tinymce_fonts_deactivate(){
	    if ( ! current_user_can( 'activate_plugins' ) )
	        return;
	    $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	    check_admin_referer( "deactivate-plugin_{$plugin}" );
	    update_option( 'ShowDefaultFonts', '1');
	    add_filter("mce_buttons_3", "kv_add_font_family_size");
	}

	register_deactivation_hook( __FILE__, 'kv_tinymce_fonts_deactivate' );
}

if(!function_exists('kv_admin_menu')) {
	function kv_admin_menu() { 		
		add_menu_page('Kvcodes', 'Kvcodes', 'manage_options', 'kvcodes' , 'kv_codes_plugins', KV_FONT_TINYMCE_URL.'/images/kv_logo.png', 66);	
		add_submenu_page( 'kvcodes', 'Kv TinyMCE Fonts', 'Kv TinyMCE Fonts', 'manage_options', 'kv_tinymce_fonts', 'kv_tinymce_editor_fonts_list' );
	}
	add_action('admin_menu', 'kv_admin_menu');



	function kv_codes_plugins() {

	?>
	 <div class="wrap">
		<div class="icon32" id="icon-tools"><br/></div>
		<h2><?php _e('KvCodes', 'kvcodes') ?></h2>		
		<div class="welcome-panel">
			<p> Thank you for using Kvcodes Plugins . Here is my few Plugins work .My plugins are very light weight and Simple.  
			<a href="http://www.kvcodes.com/" target="_blank" > Visit My Blog</a></p> 
		</div> 
		
		<div id="poststuff" > 
			<div id="post-body" class="metabox-holder columns-2" >
				<div id="post-body-content" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle"  ><img src="<?php echo KV_FONT_TINYMCE_URL.'/images/kv_logo.png'; ?>" >  My plugins </h3> 
							<div class="inside" style="padding: 10px; "> 								
								<?php /*$kv_wp =  kv_get_web_page('https://profiles.wordpress.org/kvvaradha'); 
										
										$kv_first_pos = strpos($kv_wp['content'], '<div id="content-plugins" class="info-group plugin-theme main-plugins inactive">');
										
										$kv_first_trim = substr($kv_wp['content'] , $kv_first_pos ); 
											
										$kv_sec_pos = strpos($kv_first_trim, '</div>');
										
										$kv_sec_trim = substr($kv_first_trim ,0, $kv_sec_pos );  
										
										echo $kv_sec_trim; */	?> 
										<iframe src="http://www.kvcodes.com/" width="100%" height="800px"></iframe>
							</div>
						</div>
					</div>							
				</div>
				
				<div id="postbox-container-1" class="postbox-container" > 
			<div class="meta-box-sortables"> 
				<div id="postbox-container-2" class="postbox-container" >
					<div id="dashboard_right_now" class="postbox">
						<div class="handlediv" > <br> </div>
						<h3 class="hndle" ><img src="<?php echo KV_FONT_TINYMCE_URL.'/images/kv_logo.png'; ?>" >  Donate </h3> 
						<div class="inside" style="padding: 10px; " > 
							<b>If i helped you, you can buy me a coffee, just press the donation button :)</b> 
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
								<input type="hidden" name="cmd" value="_donations" />
								<input type="hidden" name="business" value="<?php echo 'kvvaradha@gmail.com'; ?>" />
								<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
								<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
							</form>
						</div> 
					</div> 
				</div>
				<div id="postbox-container-2" class="postbox-container" > 
					<div id="dashboard_quick_press" class="postbox">
						<div class="handlediv" > <br> </div>
						<h3 class="hndle" ><img src="<?php echo KV_FONT_TINYMCE_URL.'/images/kv_logo.png'; ?>" >  Support me from Facebook </h3> 
						<div class="inside" style="padding: 10px; "> 
							<p><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fkvcodes&amp;width=180&amp;height=300&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;appId=117935585037426" style="border:none; overflow:hidden; width:250px; height:300px;"></iframe></p>
						</div> 
					</div> 
				</div>
			</div>
		</div> 	
		
		
			</div>
		</div> 			
					
	</div> <!-- /wrap -->
	<style> 
	._2p3a { width: 100% !important; } 
	</style>
	<?php

	}

	function kv_get_web_page( $url )
	{
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle compressed
			CURLOPT_USERAGENT      => "spider", // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}
	add_action( 'admin_print_styles', 'kv_admin_css' );
	function kv_admin_css() {
		if ( get_option( 'KvcodesGoogleFonts' ) !== false ){
			wp_enqueue_style("kvcodes_admin", KV_FONT_TINYMCE_URL."/kv_admi_style.css", false, "1.0", "all");
			$KvcodesGoogleFonts   = get_option( 'KvcodesGoogleFonts' );
			$KvGoogleFonts=str_replace(' ','+', $KvcodesGoogleFonts);
			$implodedGoogleFonts=implode("|", $KvGoogleFonts);
			wp_enqueue_style('Gfonts', 'https://fonts.googleapis.com/css?family='.$implodedGoogleFonts );
		}
	}
} else {
	function kv_admin_submenu_kv_fonts() { 		
		add_submenu_page( 'kvcodes', 'Kv TinyMCE Fonts', 'Kv TinyMCE Fonts', 'manage_options', 'kv_tinymce_fonts', 'kv_tinymce_editor_fonts_list' );
	}
add_action('admin_menu', 'kv_admin_submenu_kv_fonts');
	
}



function kv_add_font_family_size($buttons) {
	 $buttons[] = 'fontselect';
	 $buttons[] = 'fontsizeselect';
	 
	 return $buttons;
}
add_filter("mce_buttons_3", "kv_add_font_family_size");


// helps you to add the custom font to your tinyMCE editor. 
function kv_add_google_webfonts_to_editor() {
	if ( get_option( 'KvcodesGoogleFonts' ) !== false ){
		$KvcodesGoogleFonts   = get_option( 'KvcodesGoogleFonts' );
		$kvfont_formats= '';
		foreach($KvcodesGoogleFonts  as $singleFont){
			//$kvfont_formats .= $singleFont.'='.$singleFont.';';
			$kv_font=str_replace(' ','+', $singleFont);
			$font_url = 'http://fonts.googleapis.com/css?family='.$kv_font.':300,400,700';
			add_editor_style( str_replace( ',', '%2C', $font_url ) );
		}
		$in['font_formats']= $kvfont_formats;
	}else{
		$kv_google_selected_fonts_list = array('Open+Sans', 'Josefin+Slab', 'Arvo' , 'Lato', 'Vollkorn', 'Ubuntu', 'Old+Standard+TT' , 'Droid+Sans' , 'Roboto', 'Oswald' , 'Source+Sans+Pro');
		foreach($kv_google_selected_fonts_list as $kv_font) { 
			$font_url = 'http://fonts.googleapis.com/css?family='.$kv_font.':300,400,700';
			add_editor_style( str_replace( ',', '%2C', $font_url ) );
		}
	}
}
add_action( 'init', 'kv_add_google_webfonts_to_editor' );


function kv_custom_font_list($in){ 

	if(get_option('ShowDefaultFonts') == 1 ){
		$in['font_formats'] = "Arial=arial,helvetica,sans-serif;".
	        "Arial Black=arial black,avant garde;".
	        "Comic Sans MS=comic sans ms,sans-serif;".
	        "Courier New=courier new,courier;".
	        "Georgia=georgia,palatino;".
	        "Helvetica=helvetica;".
	        "Tahoma=tahoma,arial,helvetica,sans-serif;".
	        "Terminal=terminal,monaco;".
	        "Times New Roman=times new roman,times;".
	        "Trebuchet MS=trebuchet ms,geneva;".
	        "Verdana=verdana,geneva;";
    } else {
    	$in['font_formats'] = '';
    }
	if ( get_option( 'KvcodesGoogleFonts' ) !== false ){
		$KvcodesGoogleFonts   = get_option( 'KvcodesGoogleFonts' );
		$kvfont_formats= '';
		foreach($KvcodesGoogleFonts  as $singleFont){
			$kvfont_formats .= $singleFont.'='.$singleFont.';';
		}
		$in['font_formats'] .= $kvfont_formats;
	}else
		$in['font_formats'] .= 'Open Sans=Open Sans; Josefin=Josefin; Slab=Slab; Arvo=Arvo; Lato=Lato; Vollkorn=Vollkorn; Ubuntu=Ubuntu; Old Standard TT=Old Standard TT; Droid Sans=Droid Sans; Roboto=Roboto; Oswald=Oswald; Source Sans Pro=Source Sans Pro' ;		
	
	$in['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
 return $in;
}

        
add_filter('tiny_mce_before_init', 'kv_custom_font_list' );


function kv_tinymce_editor_fonts_list() {
	
	if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['submit'])) {
		//print_r($_POST);
		$fontsList = get_option('KvcodesGoogleFonts');
		if ( get_option( 'KvcodesGoogleFonts' ) !== false ) {
			update_option( 'KvcodesGoogleFonts', $_POST['KvcodesGoogleFonts'] );			
		} else{
			add_option( 'KvcodesGoogleFonts', $_POST['KvcodesGoogleFonts'] );			
		}

		$fontsList = get_option('ShowDefaultFonts');
		if ( get_option( 'ShowDefaultFonts' ) !== false ) {
			update_option( 'ShowDefaultFonts', (isset($_POST['ShowDefaultFonts']) ? '1' : '0')  );
		} else {
			add_option( 'ShowDefaultFonts', (isset($_POST['ShowDefaultFonts']) ? '1' : '0') );
		}
	}
	$gFile = 'googlefonts.php';
    $gFonts= include $gFile;   
	$arrayFonts = array_keys($gFonts);
?>
<script type="text/javascript" src="<?php echo KV_FONT_TINYMCE_URL.'/select2.full.js'; ?>"></script>
<link href="<?php echo KV_FONT_TINYMCE_URL.'/select2.min.css'; ?>" type="text/css" rel="stylesheet" />
 <div class="wrap">
    <div class="icon32" id="icon-tools"><br/></div>
    <h2><?php _e('Kv TinyMce Fonts Selector', 'kvcodes') ?></h2>		
	<div class="welcome-panel">
		I have collected Some of the Google Web fonts Here in setup.You can select the fonts which you need it on your editor.<p>		
	</div> 
	
	<div id="poststuff" > 
		<div id="post-body" class="metabox-holder columns-2" >
			<div id="post-body-content" > 
				<div class="meta-box-sortables"> 
					<div id="dashboard_right_now1" class="postbox">
						<div class="handlediv" > <br> </div>
						<h3 class="hndle"  ><img src="<?php echo KV_FONT_TINYMCE_URL.'/images/kv_logo.png'; ?>" >  Google Webfonts</h3> 
						<form action="" method="post"> 
						<table class="form-table" style="margin-left: 5%;">
							<tbody>
							<tr>
							<th scope="row"><label for="default_role">Select Desired Fonts </label></th>
							<td>
							<select name="KvcodesGoogleFonts[]" id="KvcodesFontsSelector" multiple="multiple" >
							<?php foreach($arrayFonts as $font){
								if ( get_option( 'KvcodesGoogleFonts' ) !== false ) {
									$KvcodesGoogleFonts = get_option( 'KvcodesGoogleFonts' );
									echo '<option value="'.$font.'" '.(in_array($font, $KvcodesGoogleFonts) ? "selected" : "" ).'>'.$font.'</option>';
								}else
									echo '<option value="'.$font.'">'.$font.'</option>';
								
								} ?>
							</select>
							<p > Select multiple fonts from the list and save it. it will be available in the editor to use.</p>
							</td> 
							</tr>
							<tr> 
								<td> Show Default Fonts </td>
								<td> <input type="checkbox" name="ShowDefaultFonts" value="1" <?php echo ((get_option('ShowDefaultFonts') !== false && get_option('ShowDefaultFonts') == 1 )? 'checked' : '') ; ?> > </td>
							</tr>
							</tbody>
						</table>

						<p class="submit" style="margin-left: 5%;"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
						</form>
						<div class="inside" style="padding: 10px; display: none;"> 								
							<ul> <li> Open+Sans</li> <li>Josefin+Slab</li> <li>Arvo</li> <li>Lato</li> <li>Vollkorn</li> <li>Ubuntu</li> <li>Old+Standard+TT</li> <li>Droid+Sans</li> <li> Roboto</li> <li>Oswald</li> <li> Source+Sans+Pro</li> </ul> 
						</div>
						<script type="text/javascript">
						jQuery(document).ready(function() {
						  jQuery("#KvcodesFontsSelector").select2();
						});
						</script>
					</div>
				</div>							
			</div>
		</div>
	</div> 		
</div><?php 

}


function kvcodes_TinyMCE_EditorFonts() {
	if ( get_option( 'KvcodesGoogleFonts' ) !== false ){
		$KvcodesGoogleFonts   = get_option( 'KvcodesGoogleFonts' );
		$KvGoogleFonts=str_replace(' ','+', $KvcodesGoogleFonts);
		$implodedGoogleFonts=implode("|", $KvGoogleFonts);
		wp_enqueue_style('Gfonts', 'https://fonts.googleapis.com/css?family='.$implodedGoogleFonts );
	}
}
add_action( 'wp_enqueue_scripts', 'kvcodes_TinyMCE_EditorFonts' );

?>