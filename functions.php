<?php

/**
 * tdk_setup function.
 * 
 * @access public
 * @return void
 */
function tdk_setup() {
	load_theme_textdomain( 'tdk', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;
	register_nav_menus(
		array( 'main-menu' => __( 'Main Menu', 'tdk' ) )
	);
}
add_action( 'after_setup_theme', 'tdk_setup' );



/**
 * tdk_load_scripts function.
 * 
 * @access public
 * @return void
 */
function tdk_load_scripts() {
	wp_enqueue_script( 'degnerate-scripts',  get_template_directory_uri() . '/js/script.min.js?ver' . time(), array('jquery'));
	// Add Google Fonts
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Playfair+Display+SC|Pontano+Sans|Crimson+Text|Vollkorn', false);
	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
}
add_action( 'wp_enqueue_scripts', 'tdk_load_scripts' );



/**
 * tdk_enqueue_comment_reply_script function.
 * 
 * @access public
 * @return void
 */
function tdk_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'comment_form_before', 'tdk_enqueue_comment_reply_script' );


/**
 * tdk_title function.
 * 
 * @access public
 * @param mixed $title
 * @return void
 */
function tdk_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}
add_filter( 'the_title', 'tdk_title' );


/**
 * tdk_filter_wp_title function.
 * 
 * @access public
 * @param mixed $title
 * @return void
 */
function tdk_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_filter( 'wp_title', 'tdk_filter_wp_title' );


/**
 * tdk_widgets_init function.
 * 
 * @access public
 * @return void
 */
function tdk_widgets_init() {
	register_sidebar( array (
			'name' => __( 'Sidebar Widget Area', 'tdk' ),
			'id' => 'primary-widget-area',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => "</li>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'tdk_widgets_init' );


/**
 * tdk_custom_pings function.
 * 
 * @access public
 * @param mixed $comment
 * @return void
 */
function tdk_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}

/**
 * tdk_comments_number function.
 * 
 * @access public
 * @param mixed $count
 * @return void
 */
function tdk_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
add_filter( 'get_comments_number', 'tdk_comments_number' );

/**
 * tdk_search_form function.
 * 
 * @access public
 * @param mixed $form
 * @return void
 */
function tdk_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
	<label style="display: none;" class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
	<input type="text" placeholder="Search" value="' . get_search_query() . '" name="s" id="s" />
	<i class="fa fa-search"></i>
	<input type="submit" id="searchsubmit" value="'. esc_attr__( 'Go!' ) .'" />
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'tdk_search_form' );

/**
 * wpb_move_comment_field_to_bottom function.
 * 
 * @access public
 * @param mixed $fields
 * @return void
 */
function tdk_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'tdk_move_comment_field_to_bottom' );


 
/**
 * Validation function for contact form.
 */
function tdk_custom_validation_filter( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
	
	// Phone input field is hidden and should be empty. If it got filled in, we are dealing with a spammer. Die!
    if ( 'your-phone' == $tag->name ) {        
        $your_phone = $_POST['your-phone'];
        
        if (!empty($your_phone)) {
	        $result->invalidate($tag, "Hello, spammer");        
	    } 
    }
 
    return $result;
}

add_filter( 'wpcf7_validate_email*', 'tdk_custom_validation_filter', 20, 2 );

/**
 * Recipe custom post type.
 */
function tdk_recipe_post_type() {

	$labels = array(
		'name'                  => _x( 'Recipes', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Recipes', 'text_domain' ),
		'name_admin_bar'        => __( 'Recipe', 'text_domain' ),
		'archives'              => __( 'Recipe Archives', 'text_domain' ),
		'attributes'            => __( 'Recipe Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Recipes', 'text_domain' ),
		'add_new_item'          => __( 'Add New Recipe', 'text_domain' ),
		'add_new'               => __( 'Add New Recipe', 'text_domain' ),
		'new_item'              => __( 'New Recipe', 'text_domain' ),
		'edit_item'             => __( 'Edit Recipe', 'text_domain' ),
		'update_item'           => __( 'Update Recipe', 'text_domain' ),
		'view_item'             => __( 'View Recipe', 'text_domain' ),
		'view_items'            => __( 'View Recipes', 'text_domain' ),
		'search_items'          => __( 'Search Recipe', 'text_domain' ),
		'not_found'             => __( 'Recipe not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Recipe not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Recipe', 'text_domain' ),
		'description'           => __( 'Recipe', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'recipe', $args );

}
add_action( 'init', 'tdk_recipe_post_type', 0 );
