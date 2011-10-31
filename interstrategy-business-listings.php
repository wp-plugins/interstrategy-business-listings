<?php
/*
Plugin Name: Interstrategy Business Listings
Plugin URI: http://www.interstrategy.net
Description: Allows you to manage your business listings
Version: 1.1
Author: Interstrategy Inc.
Author URI: http://www.interstrategy.net
License: GPLv2
*/


class BE_Business_Listings {
	var $instance;

	public function __construct() {
		$this->instance =& $this;
		add_action( 'plugins_loaded', array( $this, 'init' ) );	
	}

	public function init() {
		add_action( 'init', array( $this, 'post_type' ) );
		add_action( 'init', array( $this, 'taxonomies' ) );
		add_filter( 'cmb_meta_boxes', array( $this, 'metaboxes' ) );
		add_action( 'init', array( $this, 'initialize_meta_boxes' ), 9999 );
	}
	
	/** 
	 * Register Post Type
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 */

	public function post_type() {
		$defaults = $this->listing_defaults();
		if( apply_filters( 'interstrategy_business_listings_post_type', true ) )
			register_post_type( $defaults['post_type']['slug'], $defaults['post_type']['args'] );	
	}

	/**
	 * Create Taxonomies
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 *
	 */
	
	function taxonomies() {
		$defaults = $this->listing_defaults();
		if( apply_filters( 'interstrategy_business_listings_taxonomy', true ) )
			register_taxonomy( $defaults['taxonomy']['slug'], $defaults['post_type']['slug'],  $defaults['taxonomy']['args'] );
	}
	
	/**
	 * Create Metaboxes
	 * @link http://www.billerickson.net/wordpress-metaboxes/
	 *
	 */
	
	function metaboxes( $meta_boxes ) {
		$defaults = $this->listing_defaults();
		if( apply_filters( 'interstrategy_business_listings_metabox', true ) )
			$meta_boxes[] = $defaults['meta_box'];
		return $meta_boxes;
	}

	function initialize_meta_boxes() {
	    if (!class_exists('cmb_Meta_Box')) {
	        require_once( 'lib/metabox/init.php' );
	    }
	}
	
	public function listing_defaults() {
		$defaults = array(
			'post_type' => array(
				'slug' => 'businesses',
				'args' => array(
					'labels' => array(
						'name' => 'Businesses',
						'singular_name' => 'Business',
						'add_new' => 'Add New',
						'add_new_item' => 'Add New Business',
						'edit_item' => 'Edit Business',
						'new_item' => 'New Business',
						'view_item' => 'View Business',
						'search_items' => 'Search Businesses',
						'not_found' =>  'No Businesses found',
						'not_found_in_trash' => 'No Businesses found in trash',
						'parent_item_colon' => '',
						'menu_name' => 'Businesses'					
					),
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true, 
					'show_in_menu' => true, 
					'query_var' => true,
					'rewrite' => true,
					'capability_type' => 'post',
					'has_archive' => true, 
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title','editor', 'excerpt')
				),
			),
			'taxonomy' => array(
				'slug' => 'business-category',
				'args' => array(
					'hierarchical' => true,
					'labels' => array(
						'name' => 'Categories',
						'singular_name' => 'Category',
						'search_items' =>  'Search Categories',
						'all_items' => 'All Categories',
						'parent_item' => 'Parent Category',
						'parent_item_colon' => 'Parent Category:',
						'edit_item' => 'Edit Category',
						'update_item' => 'Update Category',
						'add_new_item' => 'Add New Category',
						'new_item_name' => 'New Category Name',
						'menu_name' => 'Category'					
					),
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => 'business-category' ),				
				)
			),
			'meta_box' => array(
			    'id' => 'business-details',
			    'title' => 'Business Details',
			    'pages' => array('businesses'), 
				'context' => 'normal',
				'priority' => 'high',
				'show_names' => true, 
			    'fields' => array(
			    	array(
			    		'name' => 'Address Line 1',
			    		'id' => 'be_business_listings_address_1',
			    		'desc' => '',
			    		'type' => 'text',
			    	),
			    	array(
			    		'name' => 'Address Line 2',
			    		'id' => 'be_business_listings_address_2',
			    		'desc' => '',
			    		'type' => 'text',
			    	),
			    	array(
			    		'name' => 'Telephone',
			    		'id' => 'be_business_listings_telephone',
			    		'desc' => '',
			    		'type' => 'text_medium'
			    	),
			    	array(
			    		'name' => 'Website',
			    		'id' => 'be_business_listings_website',
			    		'desc' => '',
			    		'type' => 'text',
			    	),
			    	array(
			    		'name' => 'Email',
			    		'id' => 'be_business_listings_email',
			    		'desc' => '',
			    		'type' => 'text'
			    	)
			    )			
			)
		);
		
		return apply_filters( 'interstrategy_business_listings_defaults', $defaults );
		
	}
	
}

new BE_Business_Listings;