<?php
/**
 * Created by PhpStorm.
 * User: manni
 * Date: 17.03.14
 * Time: 10:25
 */
add_action('init', 'cptui_register_my_cpt_production');
function cptui_register_my_cpt_production() {
    register_post_type('production', array(
      'label' => 'Productions',
      'description' => '',
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'capability_type' => 'post',
      'map_meta_cap' => true,
      'hierarchical' => false,
      'rewrite' => array('slug' => 'production', 'with_front' => true),

      'query_var' => true,
      'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
      'taxonomies' => array('category'),
      'labels' => array (
        'name' => 'Productions',
        'singular_name' => 'Production',
        'menu_name' => 'Productions',
        'add_new' => 'Add Production',
        'add_new_item' => 'Add New Production',
        'edit' => 'Edit',
        'edit_item' => 'Edit Production',
        'new_item' => 'New Production',
        'view' => 'View Production',
        'view_item' => 'View Production',
        'search_items' => 'Search Productions',
        'not_found' => 'No Productions Found',
        'not_found_in_trash' => 'No Productions Found in Trash',
        'parent' => 'Parent Production',
      )
    ) ); }
