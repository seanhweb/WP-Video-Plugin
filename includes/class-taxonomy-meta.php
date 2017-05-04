<?php
    namespace Shw\Videos;
    class TaxonomyMeta extends Taxonomies {
        public function __construct() {
            /*
                Adds HTML form for the category image editing / adding
            */
            add_action( 'video_category_add_form_fields', array($this, 'add_category_images'),10,2 );
            add_action( 'video_category_edit_form_fields', array ( $this, 'update_category_images' ), 10, 2 );

            /*
                Adds the enctype tag for the HTML form.
            */
            add_action( 'video_category_term_edit_form_tag', array($this, 'update_edit_form'));

            /*
                Wordpress Callback to save edited and created categories.
            */
            add_action( 'created_video_category', array ( $this, 'save_category_image'), 10,2);
            add_action( 'edited_video_category', array ( $this, 'updated_category_image' ), 10, 2 );

            /*
                Adds javascript for the wordpress media gallery.
            */
            add_action( 'admin_enqueue_scripts', array($this, 'load_wp_media_files') );
            add_action( 'admin_footer', array ( $this, 'add_script' ) );
        }
        public function update_edit_form() {
            echo ' enctype="multipart/form-data"';
        }
        public function updated_category_image ( $term_id, $tt_id ) {
            if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
                $image = $_POST['category-image-id'];
                update_term_meta ( $term_id, 'category-image-id', $image );
            } else {
                update_term_meta ( $term_id, 'category-image-id', '' );
            }
        }
        public function update_category_images ( $term, $taxonomy ) {
            require_once(PLUGIN_ROOT.'includes/tpl/video-category-images-update.tpl.php');
        }
        public function load_wp_media_files() {
            wp_enqueue_media();
        }
        public function add_category_images($taxonomy) {
            require_once(PLUGIN_ROOT.'includes/tpl/video-category-image-new.tpl.php');
        }
        public function save_category_image ( $term_id, $tt_id ) {
            if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
                $image = $_POST['category-image-id'];
                add_term_meta( $term_id, 'category-image-id', $image, true );
            }
         }
        public function add_script() { ?>
            <script>
                jQuery(document).ready( function($) {
                    function ct_media_upload_category(button_class) {
                        var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                        $('body').on('click', button_class, function(e) {
                            var button_id = '#'+$(this).attr('id');
                            var send_attachment_bkp = wp.media.editor.send.attachment;
                            var button = $(button_id);
                            _custom_media = true;
                            wp.media.editor.send.attachment = function(props, attachment)   {
                                if ( _custom_media ) {
                                    $('#category-image-id').val(attachment.id);
                                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                    $('#category-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
                                }
                                else {
                                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                                }
                            }
                            wp.media.editor.open(button);
                            return false;
                        });
                    }
                    ct_media_upload_category('.ct_tax_media_button_category.button');
                    $('body').on('click','.ct_tax_media_remove_category',function(){
                        $('#category-image-id').val('');
                        $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    });
                    $(document).ajaxComplete(function(event, xhr, settings) {
                        var queryStringArr = settings.data.split('&');
                        if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                            var xml = xhr.responseXML;
                            $response = $(xml).find('term_id').text();
                            if($response!=""){
                                //Clear the thumb image
                                $('#category-image-wrapper').html('');
                            }
                        }
                    });
                });
            </script>
         <?php }
    }

?>
