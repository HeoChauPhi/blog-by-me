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

    // Setting ID
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
}
