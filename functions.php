<?php
/**
 * Dermatex Hair theme bootstrap.
 *
 * @package dermatex
 */

defined( 'ABSPATH' ) || exit;

define( 'DERMATEX_VERSION', wp_get_theme()->get( 'Version' ) ?: '0' );
define( 'DERMATEX_DIR', get_template_directory() );
define( 'DERMATEX_URI', get_template_directory_uri() );

/**
 * Theme supports.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'style.css', 'assets/css/editor.css' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_image_size( 'dx-card', 800, 600, true ); // 4:3 editorial crop.
	add_image_size( 'dx-hero', 1440, 900, true );
} );

/**
 * Preload the two fonts used above the fold.
 */
add_action( 'wp_head', function () {
	$fonts = array(
		'dm-serif-display-latin-400-normal.woff2',
		'manrope-latin-400-normal.woff2',
	);
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( DERMATEX_URI . '/assets/fonts/' . $font )
		);
	}
}, 1 );

/**
 * Front-end assets. Slider and compare scripts load only where their block is present.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'dermatex', get_stylesheet_uri(), array(), DERMATEX_VERSION );

	wp_enqueue_script(
		'dermatex-site',
		DERMATEX_URI . '/assets/js/site.js',
		array(),
		DERMATEX_VERSION,
		array( 'strategy' => 'defer', 'in_footer' => true )
	);
} );

/**
 * Block styles (button variations are defined in theme.json).
 */
add_action( 'init', function () {
	register_block_style( 'core/button', array( 'name' => 'secondary', 'label' => __( 'Secondary', 'dermatex' ) ) );
	register_block_style( 'core/button', array( 'name' => 'gold', 'label' => __( 'Gold', 'dermatex' ) ) );

	// Full-width band backgrounds: select a Group, then Styles > Band.
	$bands = array(
		'band-canvas' => __( 'Band: Canvas', 'dermatex' ),
		'band-white'  => __( 'Band: White', 'dermatex' ),
		'band-soft'   => __( 'Band: Soft cream', 'dermatex' ),
		'band-navy'   => __( 'Band: Navy', 'dermatex' ),
		'band-gold'   => __( 'Band: Gold', 'dermatex' ),
	);
	foreach ( $bands as $name => $label ) {
		register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
	}
} );

/**
 * Pattern categories.
 */
add_action( 'init', function () {
	register_block_pattern_category( 'dermatex', array( 'label' => __( 'Dermatex', 'dermatex' ) ) );
	register_block_pattern_category( 'dermatex-home', array( 'label' => __( 'Dermatex Homepage', 'dermatex' ) ) );
	register_block_pattern_category( 'dermatex-pages', array( 'label' => __( 'Dermatex Subpages', 'dermatex' ) ) );
	register_block_pattern_category( 'dermatex-sections', array( 'label' => __( 'Dermatex Sections', 'dermatex' ) ) );
} );

/**
 * Custom blocks: any directory in /blocks with a block.json is registered.
 */
add_action( 'init', function () {
	foreach ( glob( DERMATEX_DIR . '/blocks/*/block.json' ) ?: array() as $block_json ) {
		register_block_type( dirname( $block_json ) );
	}
} );

/**
 * Estimated reading time (used by the article template).
 */
function dermatex_reading_time( $post_id = null ) {
	$content = get_post_field( 'post_content', $post_id ?: get_the_ID() );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $words / 220 ) );
}

add_shortcode( 'dx_reading_time', function () {
	/* translators: %d: minutes */
	return esc_html( sprintf( _n( '%d min read', '%d min read', dermatex_reading_time(), 'dermatex' ), dermatex_reading_time() ) );
} );

/**
 * Replace the [dx_reading_time] token while the block renders, so it uses the
 * post of the current query-loop iteration (shortcodes run after the loop ends).
 */
add_filter( 'render_block_core/paragraph', function ( $content, $block ) {
	if ( false === strpos( $content, '[dx_reading_time]' ) ) {
		return $content;
	}
	$post_id = $block['context']['postId'] ?? get_the_ID();
	$mins    = dermatex_reading_time( $post_id );
	/* translators: %d: minutes */
	$label   = sprintf( _n( '%d min read', '%d min read', $mins, 'dermatex' ), $mins );
	return str_replace( '[dx_reading_time]', esc_html( $label ), $content );
}, 10, 2 );

/**
 * "More from the journal" on a single article should not list the article itself.
 */
add_filter( 'query_loop_block_query_vars', function ( $query, $block ) {
	// Query block 13 is "More from the journal" in templates/single.html.
	$query_id = isset( $block->context['queryId'] ) ? (int) $block->context['queryId'] : 0;
	if ( 13 === $query_id && is_singular( 'post' ) ) {
		$query['post__not_in'] = array( get_queried_object_id() );
	}
	return $query;
}, 10, 2 );


/**
 * [dx_breadcrumb] token (subpage hero): Home / parent pages / current page title.
 */
add_filter( 'render_block_core/paragraph', function ( $content ) {
	if ( false === strpos( $content, '[dx_breadcrumb]' ) ) {
		return $content;
	}
	$post_id = get_the_ID();
	$items   = array( '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'dermatex' ) . '</a>' );
	foreach ( array_reverse( get_post_ancestors( $post_id ) ) as $ancestor ) {
		$items[] = '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
	}
	$items[] = '<span aria-current="page">' . esc_html( get_the_title( $post_id ) ) . '</span>';
	return '<nav class="dx-crumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'dermatex' ) . '">' . implode( '<span aria-hidden="true"> / </span>', $items ) . '</nav>';
}, 9 );

/**
 * Pages built from a "Subpage" starter pattern get the matching page template automatically
 * (no double title, full-width bands). A template chosen by hand is never overridden.
 */
function dermatex_assign_subpage_template( $post_id, $post ) {
	if ( ! $post || 'page' !== $post->post_type || wp_is_post_revision( $post_id ) ) {
		return;
	}
	$current = get_post_meta( $post_id, '_wp_page_template', true );
	if ( $current && 'default' !== $current ) {
		return;
	}
	foreach ( array( 'info', 'media', 'service' ) as $kind ) {
		if ( false !== strpos( (string) $post->post_content, 'dx-subpage--' . $kind ) ) {
			update_post_meta( $post_id, '_wp_page_template', 'subpage-' . $kind );
			return;
		}
	}
}
add_action( 'save_post_page', 'dermatex_assign_subpage_template', 20, 2 );
add_action( 'rest_after_insert_page', function ( $post ) {
	dermatex_assign_subpage_template( $post->ID, $post );
} );
