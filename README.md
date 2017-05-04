# Seanhweb Video Content Type Plugin

What this plugin does: 

 * Adds in a custom post type "Video" for you to use. 
 * From the video id (Youtube or Vimeo), grabs a thumbnail to set as the wordpress "Featured Image" 

What this plugin *does not* do:

 * Display what you enter on the front end of the site. 
 * Theme anything outside of the admin page. 

### Installation

Download the [latest zip file](https://github.com/seanhweb/WP-Video-Plugin/archive/master.zip) and upload it as a wordpress plugin. 

Plugins -> Add New -> Upload 

Upon activating the plugin, you must get a [youtube API key](https://developers.google.com/youtube/v3/getting-started). You can enter your youtube API key under tools -> Video Plugin. 

### Features

* Sets a "Featured Image" based on the youtube/vimeo ID provided. 
* Set categories of Videos and category images. E.G if you have a series on youtube, you can add a category for that series, with an image of your show. 

### Theme Usage

The fields for the video page are set as the following, from a post.php. 

```
	$provider = get_post_meta($post->ID, 'provider', true);
 	$videoid = get_post_meta($post->ID, 'videoid', true);
    $episode = get_post_meta($post->ID, 'episode', true); 
    $season = get_post_meta($post->ID, 'season', true); 
```

The URLS are set as the following:

* http://yoursite.com/video - All Videos
* http://yoursite.com/video/lets-play All videos in the category with the slug with "lets-play"

#### Example 1. - Video Player with Video ID

```
<?php if($provider == 'youtube'): ?>
	<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php print $videoid; ?>" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe> 
<?php elseif($provider == 'vimeo'): ?>
	<iframe src="https://player.vimeo.com/video/<?php print $videoid; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen id="video-player" class="embed-responsive-item"></iframe>
<?php endif; ?>
```

#### Example 2. - Query Category Information

```
function all_categories() {
    /*
        Returns all categories in the video taxonomy.
    */
    $category = get_terms(
        array (
            'taxonomy' => 'video_category',
            'hide_empty' => true,
        )
    );
    $output = array();
    $x = 0;
    foreach($category as $item) {
        $output[$x]['id'] = $item->term_id;
        $output[$x]['name'] = $item->name;
        $output[$x]['slug'] = $item->slug;
        $output[$x]['count'] = $item->{'count'};
        $x++;
    }
    usort($output, array($this, 'sort_by_count'));
    return $output;
}

$categories = all_categories(); 
foreach($categories as $category) {
	$image_id = get_term_meta( $id, 'category-image-id', true );
  	echo wp_get_attachment_image ( $image_id, 'category-image' );
    echo $category['name']; 
    echo $category['slug']; 
    echo $category['count']; 
}
```
