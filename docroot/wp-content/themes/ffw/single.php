<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$protected = post_password_required($post->ID);
$context['protected_label'] = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
$context['post'] = $post;
$context['post_excerpt_option'] = framework_post('post_excerpt');
$context['post_excerpt'] = apply_filters('the_excerpt', get_post_field('post_excerpt', $post->ID));

if ( is_singular('post') ) {
  $post_magazine_ids = get_field('post_magazines', $post->ID);

  if ( $post_magazine_ids ) {
    $args_magazines = array(
      'post_type' => 'any',
      'post__in'  => $post_magazine_ids,
      'orderby' => 'post__in'
    );

    $post_magazines = Timber::get_posts($args_magazines);
    $context['post_magazines'] = $post_magazines;
  }
}

if ( isset($_COOKIE['viewed_posts']) ) {
  $cookie_post_ids = unserialize($_COOKIE['viewed_posts'], ["allowed_classes" => false]);
  array_push($cookie_post_ids, $post->ID);
  $post_ids = array_unique($cookie_post_ids);
  setcookie('viewed_posts', serialize($post_ids), time()+86400, '/');
} else {
  $post_ids = [$post->ID];
  setcookie('viewed_posts', serialize($post_ids), time()+86400, '/');
}

if ($protected) {
  Timber::render( 'single-protected.twig', $context );
} else {
  Timber::render( 'single.twig', $context );
}
