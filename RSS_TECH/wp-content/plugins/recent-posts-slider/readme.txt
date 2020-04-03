=== Recent Posts Slider ===
Contributors: nehagoel	
Donate link: http://recent-posts-slider.com/donate/
Tags: posts, recent, recent posts, recent post, scroll, slider, most recent, posts slider, most recent posts
Requires at least: 2.9.1
Tested up to: 4.7.2
Stable tag: 1.1
Recent posts slider displays your blog's recent posts using slider.

== Description ==
**Plugin Demo:** [RPS Lite Demo](http://recent-posts-slider.com)
Recent Posts slider displays your blog's recent posts either with excerpt or thumbnail image of first image of the post using slider.
You can customize the slider in many ways (width, height, post per slide, no of posts to display & more).**Plugin Demo:** [RPS Pro Demo](http://recent-posts-slider.com/rps-pro-version-demo-theme5/)
> **Upgrade to RPS Pro to get the features listed below**>> * Responsive> * More Customization options for pagination position & arrow> * Four different templates to showcase your recent posts with slider> * Easy color pickers to change background & text color> * Multiple slider on a same page of with different theme, width, height, category & posts setting> * Random PostsIt creates the thumbnail of either the first image from the post or of featured image. If you want to create a thumbnail of a specific image add a custom field as rps_custom_thumb and specify image path as value.
If you have a feature that you would like to get added in future versions, feel free to contact me at http://recent-posts-slider.com/contact.If you find it useful please don't forget to rate this plugin.
== Installation ==
= Installation =
1. You can use the built-in installer.
     OR         
     Download the zip file and extract the contents.
     Upload the 'recent-posts-slider' folder to your plugins directory (wp-content/plugins/).
1. Activate the plugin through the 'Plugins' menu in WordPress.
Now go to **Settings** and then **Recent Posts Slider** to configure any options as desired.

= How to use =
In order to display the recent posts slider, you have three options
1. Simply place `<?php if (function_exists('rps_show')) echo rps_show(); ?>` in your theme or use rps_show( $category_ids, $total_posts, $post_include_ids, $post_exclude_ids ) to have different slider on differet pages;
1. Add the shortcode simply '[rps]' or '[rps category_ids="2,3"  total_posts="2" post_include_ids="1" post_exclude_ids="2"]'.
1. Using widget.
Check admin setting details [here](http://recent-posts-slider.com/installation-how-to-use/)

== Frequently Asked Questions ==

= Why only few characters display in post title? =
Yes, it will display only few characters due to some restrictions for flexible width & height of slider. 
To view complete post title move the mouse pointer over it.

= Having problems, questions, bugs & suggestions =
Contact me at http://recent-posts-slider.com/contact

== Screenshots ==

1. Configuration page1. Pro Theme 11. Pro Theme 3

== Changelog === v1.1 =* WP 4.4 compatibility test
= v0.9 =* WP 4.3 compatibility fixes
= v0.7.8 =
* Code improvement
= v0.7.5 =
* Tested for WP 4.1
= v0.7.4 =
* Help added
= v0.7.3 =
* Color Picker added
= v0.7.2 =
* Internationalization + info update
= v0.7.1 =
* Customize the widget slider according to category, post ids & total no. of posts.
= v0.7 =
* Full internationalization is now possible
* Provided an alt tag to the images inside slider
* Fixed the no image issue on subdomains
* You are now allowed to show different slider on different pages based on category, post ids & total no. of posts
* Do check out http://recent-posts-slider.com/2013/01/v0-7-released/
= v0.6.3 =
* Security update removed REQUEST_URI
* Date Internationalization
= v0.6.2 =
* Jquery conflict issue resolved.
* Some new features added.
* Check out the detailed description at http://recent-posts-slider.com.
= v0.6.1 =
* Small image issue is fixed.
= v0.6 =
* Featured image thumbnail support is added.
* IE issue is fixed.
= v0.5 =
* Resolved some issues.
* New feature is added to show both excerpt & post thumb.
* New features are added to set post title color, pagination style, slider speed & excerpt words size.
= v0.4 =
* Fixed the issue related to image thumbnail
= v0.3 =
* Widget support is added.
* Custom field is added to pull post image.
* Jquery updated to latest version.
= v0.2 =
* Added more customization options for specific categories & posts.
= v0.1 =
* Initial release version.