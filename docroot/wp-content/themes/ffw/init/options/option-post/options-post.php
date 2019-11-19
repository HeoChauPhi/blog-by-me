<?php
add_action( 'cmb2_admin_init', 'ct_sidebar_post_metaboxes' );
function ct_sidebar_post_metaboxes() {

  $prefix = '_cmb2_';

  /*$cmb = new_cmb2_box( array(
    'id'            => 'sidebar_menu_options',
    'title'         => __( 'Sidebar Menu Options', 'cmb2' ),
    'object_types'  => array('news'), // Post type or any post type use: ct_list_posttype()
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Sidebar Left
  $cmb->add_field( array(
    'name'             => __( 'Left Sidebar Menus', 'cmb2' ),
    'desc'             => __( 'Choose Menus for Left Sidebar on this page', 'cmb2' ),
    'id'               => $prefix . 'sidebar_menu',
    'type'             => 'multicheck',
    'options'          => ct_list_nav_menus(),
  ) );*/

  $cmb = new_cmb2_box( array(
    'id'            => 'post_option',
    'title'         => __( 'Post Options', 'cmb2' ),
    'object_types'  => array( 'post' ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ) );

  // Disable title
  $cmb->add_field( array(
    'name'       => __( 'Disable Excerpt', 'cmb2' ),
    'desc'       => __( 'Check it if you want disable Post Excerpt', 'cmb2' ),
    'id'         => $prefix . 'post_excerpt',
    'type'       => 'checkbox'
  ) );
}

function framework_post($name = '') {
  global $post;
  $value = get_post_meta( $post->ID, '_cmb2_' . $name, true );
  return $value;
}
