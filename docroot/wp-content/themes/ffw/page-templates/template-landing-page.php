<?php
/**
 * Template Name: Template for Front page
 *
 * @package WordPress
 * @subpackage FFW
 * @since FFW 1.0
 */

$context = Timber::get_context();
$post = new TimberPost();
$protected = post_password_required($post->ID);
$context['protected_label'] = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
$context['post'] = $post;

if ( framework_page('bottom_panel') != "on" ) {
  $context['bottom_panel'] = Timber::get_widgets('bottom-panel-block');
}

if ($protected) {
  Timber::render( 'single-protected.twig', $context );
} else {
  Timber::render( 'template-front-page.twig', $context );
}