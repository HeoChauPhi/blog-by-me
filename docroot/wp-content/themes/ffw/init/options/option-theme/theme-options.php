<?php
/**
 * Admin settings page.
 */

class FFWSettingsPage {
  /**
  * Holds the values to be used in the fields callbacks
  */
  private $options;

  /**
  * Start up
  */
  public function __construct() {
    add_action('admin_menu', array($this, 'ffw_add_setting_page' ));
    add_action('admin_init', array($this, 'ffw_page_init'));
  }

  /**
  * Add options page
  */
  public function ffw_add_setting_page() {
    // This page will be under "Settings"
    add_options_page(
      __('FFW Theme Setting', 'ffw'),
      __('Theme Setting', 'ffw'),
      'manage_options',
      'ffw-setting-admin',
      array($this, 'ffw_reate_admin_page')
    );
  }

  /**
  * Options page callback
  */
  public function ffw_reate_admin_page() {
    // Set class property
    $this->options = get_option('ffw_board_settings');

    ?>
    <div class="wrap">
      <h1><?php echo __('Theme settings', 'ffw') ?></h1>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields('ffw_option_config');
        do_settings_sections('ffw-setting-admin');
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }

  /**
  * Register and add settings
  */
  public function ffw_page_init() {
    register_setting(
      'ffw_option_config', 
      'ffw_board_settings',
      array( $this, 'ffw_sanitize' )
    );

    // Setting Stie
    add_settings_section(
      'ffw_setting_started', // ID
      __('Setting Started', 'ffw'), // Title
      array( $this, 'ffw_google_print_section_info' ), // Callback
      'ffw-setting-admin' // Page
    );

    add_settings_field(
      'ffw_popup_image',
      __('Upload Popup Banner', 'ffw_theme'),
      array( $this, 'ffw_form_filefield' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_setting_started',
      'ffw_popup_image'
    ); 

    add_settings_field(
      'ffw_popup_started',
      __('Popup Started', 'ffw'),
      array( $this, 'ffw_form_wp_editor' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_setting_started',
      'ffw_popup_started'
    );

    // Setting 3rt ID
    add_settings_section(
      'ffw_google_api', // ID
      __('Google API', 'ffw'), // Title
      array( $this, 'ffw_google_print_section_info' ), // Callback
      'ffw-setting-admin' // Page
    );

    add_settings_field(
      'ffw_google_api_key',
      __('Google API Key', 'ffw'),
      array( $this, 'ffw_form_textfield' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_google_api',
      'ffw_google_api_key'
    );

    add_settings_field(
      'ffw_header_code',
      __('Header Code', 'ffw'),
      array( $this, 'ffw_form_textarea' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_google_api',
      'ffw_header_code'
    );

    add_settings_field(
      'ffw_body_content_code',
      __('Body Code', 'ffw'),
      array( $this, 'ffw_form_textarea' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_google_api',
      'ffw_body_content_code'
    );

    add_settings_field(
      'ffw_footer_code',
      __('Footer Code', 'ffw'),
      array( $this, 'ffw_form_textarea' ), // Callback
      'ffw-setting-admin', // Page
      'ffw_google_api',
      'ffw_footer_code'
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function ffw_sanitize( $input ) {
    $new_input = array();

    if( isset( $input['ffw_popup_image'] ) )
      $new_input['ffw_popup_image'] = sanitize_text_field( $input['ffw_popup_image'] );

    if( isset( $input['ffw_popup_started'] ) )
      $new_input['ffw_popup_started'] = sanitize_text_field( htmlentities($input['ffw_popup_started']) );

    if( isset( $input['ffw_google_api_key'] ) )
      $new_input['ffw_google_api_key'] = sanitize_text_field( $input['ffw_google_api_key'] );

    if( isset( $input['ffw_header_code'] ) )
      $new_input['ffw_header_code'] = sanitize_text_field( htmlentities($input['ffw_header_code']) );

    if( isset( $input['ffw_body_content_code'] ) )
      $new_input['ffw_body_content_code'] = sanitize_text_field( htmlentities($input['ffw_body_content_code']) );

    if( isset( $input['ffw_footer_code'] ) )
      $new_input['ffw_footer_code'] = sanitize_text_field( htmlentities($input['ffw_footer_code']) );

    return $new_input;
  }

  /**
  * Print the Section text
  */
  public function ffw_google_print_section_info() {
    echo __("", 'ffw');
  }

  /**
  * Get the settings option array and print one of its values
  */
  public function ffw_form_checkbox($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    $checked = "";
    if($value){
      $checked = " checked='checked' ";
    }
    printf('<input type="checkbox" id="form-id-%s" name="ffw_board_settings[%s]" value="1" %s/>', $name, $name, $checked);
  }

  public function ffw_form_textfield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<input type="text" size=60 id="form-id-%s" name="ffw_board_settings[%s]" value="%s" />', $name, $name, $value);
  }

  public function ffw_form_textarea($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<textarea cols="100%%" rows="8" type="textarea" id="form-id-%s" name="ffw_board_settings[%s]">%s</textarea>', $name, $name, $value);
  }

  public function ffw_form_filefield($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    printf('<div class="banner-wrapper %s"><img class="upload_media_thumb" src="%s" /><button class="remove_media_button" type="button" value="Remove Image"><i class="fa fa-times-circle" aria-hidden="true"></i></button></div>', empty($value) ? 'hidden' : '', $value);
    printf('<input class="upload_media_url" type="hidden" size=60 id="form-id-%s" name="ffw_board_settings[%s]" value="%s" />', $name, $name, $value);
    echo '<button class="upload_media_button" type="button" value="Upload Image"><i class="fa fa-upload" aria-hidden="true"></i> Upload Banner</button>';
  }

  public function ffw_form_wp_editor($name) {
    $value = isset($this->options[$name]) ? esc_attr($this->options[$name]) : '';
    wp_editor( html_entity_decode(stripslashes($value)), 'my_option', array(
      'wpautop'       => true,
      'media_buttons' => false,
      'textarea_name' => 'my_option',
      'editor_class'  => 'my_custom_class',
      'textarea_rows' => 10
    ));
    printf('<textarea cols="100%%" rows="8" type="textarea" id="form-id-%s" name="ffw_board_settings[%s]" style="display: none;">%s</textarea>', $name, $name, $value);
    ?>
    <script>
    //get the content from the WYSIWYG and display it another element
    window.onload = function () {
      tinymce.get('my_option').on('keyup change',function(e){
        jQuery("#<?php echo 'form-id-' . $name ?>").html(this.getContent());
      });
    }
    </script>
    <?php
  }
}
