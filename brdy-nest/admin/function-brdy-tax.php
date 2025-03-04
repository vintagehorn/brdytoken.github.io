<?php

add_action( 'init', 'create_brdy_tax' );

function create_brdy_tax() {

    /* Create Genre Taxonomy */
    $args = array(
        'label' => __( 'BRDY Category' ),
        'rewrite' => array( 'slug' => 'brdy-category' ),
        'hierarchical' => true,
    );

    register_taxonomy( 'brdy-category', 'brdy', $args );