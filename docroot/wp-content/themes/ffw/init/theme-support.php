<?php
/*
**
** Enable Function
**
*/

// menu
add_theme_support( 'menus' );
add_action('init', 'ffw_menu');
function ffw_menu() {
  register_nav_menus(array (
    'main'          => 'Main Menu'
  ));
}

// Theme support custom logo
add_action( 'after_setup_theme', 'ffw_setup' );
function ffw_setup() {
  add_theme_support( 'custom-logo', array(
    'flex-width' => true,
  ) );
}

// Theme support custom logo
add_theme_support( 'post-thumbnails' );

add_action( 'init', 'ffw_remove_default_field' );
function ffw_remove_default_field() {
  remove_post_type_support( 'page', 'thumbnail' );
}

// Unset URL from comment form
add_filter( 'comment_form_fields', 'ffw_move_comment_form_below' );
function ffw_move_comment_form_below( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

// Set per page on each page
add_action( 'pre_get_posts',  'ffw_set_posts_per_page'  );
function ffw_set_posts_per_page( $query ) {
  global $wp_the_query;
  if ( (!is_admin()) && ( $query === $wp_the_query ) && ( $query->is_archive() ) ) {
    $query->set( 'posts_per_page', 1 );
  }
  return $query;
}

add_filter( 'body_class', 'ffw_body_class' );
function ffw_body_class( $classes ) {
  return $classes;
}

add_filter('upload_mimes', 'ffw_theme_support_files_type', 1, 1);
function ffw_theme_support_files_type($mime_types){
  $mime_types['svg'] = 'image/svg+xml';
  return $mime_types;
}


/*
**
** Support Widget Layout
**
*/


/* Add Dynamic Siderbar */
if (function_exists('register_sidebar')) {
  // Define Sidebar
  register_sidebar(array(
    'name' => __('Sidebar'),
    'description' => __('Description for this widget-area...'),
    'id' => 'sidebar-1',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Header block
  register_sidebar(array(
    'name' => __('Header block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'header-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Bottom Panel
  register_sidebar(array(
    'name' => __('Bottom Panel block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'bottom-panel-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  // Define Footer
  register_sidebar(array(
    'name' => __('Footer block'),
    'description' => __('Description for this widget-area...'),
    'id' => 'footer-block',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

// Theme support get widget ID
function ffw_get_widget_id($widget_instance) {
  if ($widget_instance->number=="__i__"){
    echo "<p><strong>Widget ID is</strong>: Pls save the widget first!</p>"   ;
  } else {
    echo "<p><strong>Widget ID is: </strong>" .$widget_instance->id. "</p>";
  }
}
add_action('in_widget_form', 'ffw_get_widget_id');

// Sidebar widget arena
add_action( 'widgets_init', 'ffw_create_sidebar_Widget' );
function ffw_create_sidebar_Widget() {
  register_widget('sidebar_Widget');
}

class sidebar_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'sidebar_widget',
      'description' => __( 'Sidebar widget.', 'ffw_theme'),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'sidebar_widget', __( 'Sidebar Widget', 'ffw_theme' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    if ($instance) {
      $title = esc_attr( $instance['title'] );
    } else {
      $title = null;
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Header widget arena
add_action( 'widgets_init', 'ffw_create_header_Widget' );
function ffw_create_header_Widget() {
  register_widget('header_Widget');
}

class header_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'header_widget',
      'description' => __( 'Custom widget.', 'ffw_theme'),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'header_widget', __( 'Header Widget', 'ffw_theme' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    if ($instance) {
      $title = esc_attr( $instance['title'] );
    } else {
      $title = null;
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Bottom panel widget arena
add_action( 'widgets_init', 'ffw_create_bottom_panel_Widget' );
function ffw_create_bottom_panel_Widget() {
  register_widget('bottom_panel_Widget');
}

class bottom_panel_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'bottom_panel_Widget',
      'description' => __( 'Custom widget.', 'ffw_theme'),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'bottom_panel_Widget', __( 'Bottom Panel Widget', 'ffw_theme' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    if ( function_exists('get_field') ) {
      $acffield = get_field('bottom_panel_components', 'widget_' . $args['widget_id']);
      if ( !empty( $acffield ) ) {
        foreach ($acffield as $field) {
          $layout = $field['acf_fc_layout'];
          
          switch ($layout) {
            case 'block_instagram':
              $ch = curl_init();
              $timeout = 0; // set to zero for no timeout
              curl_setopt ($ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$field['instagram_access_tocken']);
              curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
              $insta_json = curl_exec($ch);
              curl_close($ch);
              
              //$insta_json = file_get_contents('https://api.instagram.com/v1/users/self/media/recent/?access_token='.$field['instagram_access_tocken']);
              $insta_data = json_decode($insta_json, true);

              if ( $insta_data['meta']['code'] == 200 ) {
                $field['instagram_name'] = $insta_data['data'][0]['user']['username'];
                $field['instagram_fullname'] = $insta_data['data'][0]['user']['full_name'];
                $field['instagram_url'] = 'https://www.instagram.com/'.$field['instagram_name'];
                $field['instagram_data'] = $insta_data['data'];
              }

              //print_r($field);
              
              try {
                Timber::render($layout . '.twig', $field);
              } catch (Exception $e) {
                echo 'Could not find a twig file for layout type: ' . $layout . '<br>';
              }
              break;

            default:
              //print_r($field);
              try {
                Timber::render($layout . '.twig', $field);
              } catch (Exception $e) {
                echo 'Could not find a twig file for layout type: ' . $layout . '<br>';
              }
              break;
          }
        }
      }
    } else {
      echo $args['before_widget'];
      if ( $title ) {
        echo $args['before_title'] . $title . $args['after_title'];
      }
      echo $args['after_widget'];
    }
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    if ($instance) {
      $title = esc_attr( $instance['title'] );
    } else {
      $title = null;
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}

// Footer widget arena
add_action( 'widgets_init', 'ffw_create_footer_Widget' );
function ffw_create_footer_Widget() {
  register_widget('footer_Widget');
}

class footer_Widget extends WP_Widget {
  public function __construct() {
    $widget_ops = array(
      'classname' => 'footer_Widget',
      'description' => __( 'Custom widget.', 'ffw_theme'),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'footer_Widget', __( 'Footer Widget', 'ffw_theme' ), $widget_ops, $control_ops );
  }

  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $args['after_widget'];
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    if ($instance) {
      $title = esc_attr( $instance['title'] );
    } else {
      $title = null;
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
}
