<?php
namespace Gutenbox;

/**
 * Blocks
 */
class Blocks {

    function __construct() {
    	add_action( 'enqueue_block_assets', array( $this, 'frontend_assets' ) );
    	add_filter( 'block_categories', array( $this, 'register_block_category' ), 10, 2 );
    	add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );
    }

    /**
	 * Register Gutenberg block category
	 *
	 * @param array  $categories Block categories.
	 * @param object $post Post object.
	 *
	 * @since 0.1.0
	 */
	function register_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'gutenbox',
					'title' => __( 'Gutenbox', 'gutenbox' ),
				),
			)
		);
	}

    /**
     * Enqueue Gutenberg block assets for both frontend + backend.
     *
     * @uses {wp-editor} for WP editor styles.
     * @since 0.1.0
     */
    function frontend_assets() { // phpcs:ignore
    	// Styles.
    	wp_enqueue_style(
    		'gutenbox-style-css', // Handle.
    		plugins_url( 'dist/blocks.style.build.css', GUTENBOX_ROOT_FILE ), // Block style CSS.
    		array( 'wp-editor' ), // Dependency to include the CSS after it.
    		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
    	);
    }

    /**
     * Enqueue Gutenberg block assets for backend editor.
     *
     * @uses {wp-blocks} for block type registration & related functions.
     * @uses {wp-element} for WP Element abstraction — structure of blocks.
     * @uses {wp-i18n} to internationalize the block's text.
     * @uses {wp-editor} for WP editor styles.
     *
     * @since 0.1.0
     */
    function editor_assets() { // phpcs:ignore
    	// Scripts.
    	wp_enqueue_script(
    		'gutenbox-block-js', // Handle.
    		plugins_url( '/dist/blocks.build.js', GUTENBOX_ROOT_FILE ), // Block.build.js: We register the block here. Built with Webpack.
    		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
    		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: File modification time.
    		true // Enqueue the script in the footer.
    	);

    	// Styles.
    	wp_enqueue_style(
    		'gutenbox-block-editor-css', // Handle.
    		plugins_url( 'dist/blocks.editor.build.css', GUTENBOX_ROOT_FILE ), // Block editor CSS.
    		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
    		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
    	);
    }
}
