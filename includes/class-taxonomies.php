<?php
    namespace Shw\Videos;
    class Taxonomies extends Videos {
        /*
            Sets up the Video Type Taxonomy
                Video Category

            The class Metabox handles Custom Metabox functions.
            This class is native wordpress to add a custom taxonomy to a post.
        */
        public function __construct() {
            add_action( 'init', array($this, 'custom_taxonomy_flush_rewrite'));
            add_action( 'init', array($this, 'video_taxonomy_category'), 0);
        }
        public function custom_taxonomy_flush_rewrite() {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
        public function video_taxonomy_category() {
            $video_category = array (
                'hierarchical'      => true,
                'labels'            => array (
                    'name'              => _x( 'Video Category', 'Video Category', 'video_category' ),
                    'singular_name'     => _x( 'Video Category', 'Video Category', 'video_category' ),
                    'search_items'      => __( 'Search Video Types', 'video_category' ),
                    'all_items'         => __( 'All Video Categories', 'video_category' ),
                    'parent_item'       => __( 'Parent Video Category', 'video_category' ),
                    'parent_item_colon' => __( 'Parent Video Category:', 'video_category' ),
                    'edit_item'         => __( 'Edit Video Category', 'video_category' ),
                    'update_item'       => __( 'Update Video Category', 'video_category' ),
                    'add_new_item'      => __( 'Add New Video Category', 'video_category' ),
                    'new_item_name'     => __( 'New Video Category Name', 'video_category' ),
                    'menu_name'         => __( 'Video Categories', 'video_category' ),
                ),
                'meta_box_cb' => array($this, 'select_video_category'),
                'show_ui'           => true,
                'public'            => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'type', 'with_front' => false ),
                'show_in_rest'      => true
            );
            register_taxonomy( 'video_category', array('video'), $video_category);
        }
        public function select_video_category($post) {
            /*
                Callback for the Video Type category box on the "Add Video" page.
            */
            $types = get_terms(
                'video_category',
                array(
                    'hide_empty' => false,
                    'parent' => 0
                )
            );
            $post = get_post();
            $current_type = wp_get_object_terms(
                $post->ID, 'video_category',
                array( 'orderby' => 'term_id',
                      'order' => 'ASC'
                )
            );
            $name  = '';
            if ( ! is_wp_error( $current_type ) ) {
                if ( isset( $current_type[0] ) && isset( $current_type[0]->name ) ) {
                    $name = $current_type[0]->name;
                }
            }
            require_once(PLUGIN_ROOT.'includes/tpl/video-types.tpl.php');
        }
    }
?>
