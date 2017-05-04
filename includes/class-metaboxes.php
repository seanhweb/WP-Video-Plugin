<?php
    namespace Shw\Videos;
    class MetaBoxes extends Videos {
        public function __construct() {
            add_action( 'add_meta_boxes', array($this, 'video_meta_boxes'));
        }
        public function video_meta_boxes() {
            /*
                Defines three meta boxes for the left side.
                youtube Information
                And a notice about the thumbnail (UI)
            */
            add_meta_box(
                'metainfo',
                'Meta Information',
                array($this, 'video_meta_information'),
                'video',
                'normal',
                'high'
            );
            add_meta_box(
                'featured_image_help',
                'Note',
                array($this, 'video_featured_image_help'),
                'video',
                'side',
                'low'
            );
        }
        public function video_meta_information( $post ) {
            /*
                Call back for the video ID metabox
            */
            wp_nonce_field( 'video_meta_save', 'video_meta_box' );

            $provider = get_post_meta($post->ID, 'provider', true);
            $videoid = get_post_meta($post->ID, 'videoid', true);
            $season = get_post_meta($post->ID, 'season', true);
            $episode = get_post_meta($post->ID, 'episode', true);

            require_once(PLUGIN_ROOT. 'includes/tpl/video-meta.tpl.php');
        }
        public function video_featured_image_help( $post ) {
            /*
                Call back for the featured image metabox
            */
            require_once(PLUGIN_ROOT.'includes/tpl/video-featured-image-help.tpl.php');
        }
    }
?>
