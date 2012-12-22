=== Gravatar Shortcode ===
Contributors: beaulebens
Tags: shortcode, gravatar, avatar
Requires at least: 2.5
Tested up to: 3.4
Stable tag: trunk
Donate link: http://dentedreality.com.au

Allows you to use a shortcode in your Posts and Pages to embed a Gravatar quickly and easily just using an email address.

== Description ==
Allows you to use a shortcode in your Posts and Pages to embed a Gravatar quickly and easily just using an email address.

== Installation ==
1. Unzip and upload `/wp-gravatar-shortcode/` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use the [gravatar] shortcode in a Post or Page

== Options ==
In addition to email="", you can also include the following attributes within the shortcode for extra formatting etc:

See http://dentedreality.com.au/projects/wp-plugin-gravatar-shortcode/ for more examples.

* email: the email address to display the Gravatar for
* size: a number (e.g. 60) representing the pixel size of the Gravatar to display (they are square)
* rating: a letter restricting the maxiumum rating of Gravatar to display (g, pg, r, x)
* default: the default image to use if there isn’t one associated with this email address (otherwise it will use the Gravatar.com default)
* alt: the “alt” attribute to apply to the img tag produced
* title: title attribute for the img tag
* align: align attribute for the img, should be left, right, absmiddle, baseline etc
* style: custom style attribute (e.g. ‘margin: 5px; border: solid 1px #000;’)
* class: add a class to the img tag
* id: add an id to the img tag for specific styling/DOM manipulation.
* border: adjust the border attribute for the img

== Changelog ==
1.2
* Escape attributes, props batmoo

1.1
* Actually make use of the "default" option, props Jonathan C
* Change default size to 80, to match Gravatar's internal default

1.0
* Initial Release