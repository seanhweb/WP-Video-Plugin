<?php
    /*
        Plugin Name: Seanhweb Video Plugin
        Description: Allows a user to enter videos into their wordpress site from Vimeo and Youtube.
        Version: 1.0
        Author: Sean Houlihan
        Author URI: https://seanhweb.com
        License: GPL2
    */
    define('PLUGIN_ROOT', plugin_dir_path( __FILE__ ));

    require_once(PLUGIN_ROOT.'includes/class-admin.php');

    require_once(PLUGIN_ROOT.'includes/class-video.php');
    require_once(PLUGIN_ROOT.'includes/class-metaboxes.php');
    require_once(PLUGIN_ROOT.'includes/class-taxonomies.php');
    require_once(PLUGIN_ROOT.'includes/class-taxonomy-meta.php');

    new Shw\Videos\Admin;

    new Shw\Videos\Videos;
    new Shw\Videos\Metaboxes;
    new Shw\Videos\Taxonomies;
    new Shw\Videos\TaxonomyMeta;
?>
