<?php
    namespace Shw\Videos;
    class Admin {
        function __construct() {
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }
        function admin_menu() {
            $hook = add_management_page(
                'Video Plugin Options',
                'Video Plugin',
                'manage_options',
                'video-plugin',
                array( $this, 'admin_page' ),
                ''
            );
            add_option('youtube_api_key', true);
        }
        function admin_page() {
            if (!current_user_can('manage_options')) {
                wp_die( __('You do not have sufficient permissions to access this page.') );
            }
            if(isset($_POST['youtube_api_key']) && $_POST['hidden_field'] == 'Y') {
                update_option('youtube_api_key', $_POST['youtube_api_key']);
            }
            $yt_api_key = get_option('youtube_api_key');
            require_once(PLUGIN_ROOT.'includes/tpl/admin-page.tpl.php');
        }
    }
?>
