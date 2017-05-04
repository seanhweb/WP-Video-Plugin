<?php
    namespace Shw\Videos;
    class Videos {
        public function __construct() {
            add_action('init', array($this, 'create_video'));
            add_action( 'post_updated', array($this, 'save_video'));
        }
        public function create_video() {
            /*
                Defines the "Video" Content Type in wordpress.
            */
            $args = array (
               'labels' => array(
                    'name' => __( 'Videos' ),
                    'singular_name' => __( 'Videos' ),
                    'add_new' => __( 'Add Video' ),
                    'add_new_item' => __( 'Add New Video' ),
                    'edit_item' => __( 'Edit Video' ),
                    'new_item' => __( 'Add New Video' ),
                    'view_item' => __( 'View Video' ),
                    'search_items' => __( 'Search Videos' ),
                    'not_found' => __( 'No Videos Found' ),
                    'not_found_in_trash' => __( 'No Videos found in trash. ' )
	           ),
                'has_archive' => true,
                'menu_icon' => 'dashicons-format-video',
                'public' => true,
                'show_ui' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'rewrite' => true,
                'menu_position' => 20,
                'supports' => array('title', 'thumbnail', 'editor'),
            );
            register_post_type('video', $args);
        }
        public function save_video( $post_id ) {
            /*
                Runs on action_save: Saves the video in the wordpress database
                Should nonce the following fields:
                    video ID
            */
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                /*
                    If autosaving, do nothing
                */
                return;
            }
            if( !isset( $_POST['videoid'] ) || !isset ( $_POST['provider']) || !wp_verify_nonce( $_REQUEST['video_meta_box'], 'video_meta_save' ) ) {
                /*
                    If the video ID and provider isn't selected, or the wp_kses is faked, get out
                */
                return;
            }
            if( !current_user_can( 'edit_post' ) ) {
                /*
                    If you can't edit a post, get the hell out
                */
                return;
            }

            /*
                Update video ID
            */
            $videoid = wp_kses( $_POST['videoid'], '');
            update_post_meta( $post_id, 'videoid', $videoid, '' );

            /*
                Update video provider
            */
            $provider = wp_kses ($_POST['provider'], '');
            update_post_meta( $post_id, 'provider', $provider, '');

            /*
                Season and Episode database insertion
            */
            $season = wp_kses($_POST['season'], '');
            update_post_meta($post_id, 'season', $season, '');

            $episode = wp_kses($_POST['episode'], '');
            update_post_meta($post_id, 'episode', $episode, '');
            /*
                Define Video type name to be inserted into database
            */
            $video_category = wp_kses($_POST['video_category'], '');
            $term = get_term_by('name', $video_category, 'video_category');

            if( !empty($term) && !is_wp_error( $term ) ) {
                wp_set_object_terms( $post_id, $term->term_id, 'video_category', false);
            }

            /*
                If there is no Featured Image, grab it from youtube
            */
            if( !has_post_thumbnail($post_id)) {
                if($provider == 'youtube') {
                    $this->Generate_Featured_Image( $this->fetch_youtube_thumbnail($videoid), $post_id );
                }
                if($provider == 'vimeo') {
                    $this->Generate_Featured_Image( $this->fetch_vimeo_thumbnail($videoid), $post_id );
                }
            }
        }
        public function fetch_vimeo_thumbnail($vimeoid) {
            /*
                Used to get the thumbnail URL from a vimeo ID.
            */
            $jsonurl = 'https://vimeo.com/api/oembed.json?url=http://vimeo.com/'.$vimeoid;
            $jsondownload = file_get_contents($jsonurl);
            $jsondecoded = json_decode($jsondownload, true);
            $thumbnailurl = $jsondecoded['thumbnail_url'];
            return $thumbnailurl;
        }
        public function fetch_youtube_thumbnail($youtubeid) {
            /*
                Used to get the thumbnail URL from a youtube ID.
            */
            $key = get_option('youtube_api_key');

            $jsonurl = 'https://www.googleapis.com/youtube/v3/videos?part=id,snippet&id='.$youtubeid.'&key='.$key;
            $jsondownload = file_get_contents($jsonurl);
            $jsondecoded = json_decode($jsondownload);
            $thumbnailurl =  $jsondecoded->items[0]->snippet->thumbnails->high->url;
            return $thumbnailurl;
        }
        private function Generate_Featured_Image( $image_url, $post_id  ){
            /*
                Given an Image URL, downloads the image to the WP media gallery
                And sets it to the featured image.
            */
            $upload_dir = wp_upload_dir();
            $image_data = file_get_contents($image_url);
            $filename = date('mdyHisu').basename($image_url);
            if(wp_mkdir_p($upload_dir['path']))
                $file = $upload_dir['path'] . '/' . $filename;
            else
                $file = $upload_dir['basedir'] . '/' . $filename;
            file_put_contents($file, $image_data);
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
            $res2 = set_post_thumbnail( $post_id, $attach_id );
        }
    }
?>
