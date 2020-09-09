=== HookyWoo WooCommerce Hooks Customizer ===
Contributors: jrobie23
Tags: Hooks, WooCommerce, Woo, Woo Commerce, Actions, Filters
License: GNU GENERAL PUBLIC LICENSE
License URI: http://fsf.org/
Requires at least: 3.7.1
Tested up to: 5.2.2
Stable tag: 1.5.1
Requires PHP: 5.3

A WYSIWYG solution for adding content to the majority of all WooCommerce Action Hooks.
 
== Description ==

HookyWoo is a text editing solution for adding content to the majority of all WooCommerce Action Hooks.

1. Use the image to find the location of the hook in which you would like to enter some text.
2. Enter your text in the text editor section
3. Save your changes.
4. Check your work on the public facing side of the site.

Stylesheet is included for the basic layout of the plugin. 
All hook divs have their own class so you can update the CSS however you need to.

Use your browser's inspector to locate the classes for the specific div in which that hook is contained and add your own styling to the content.
The "after cart" and "before product tabs" divs are both set to clear:all; for basic layout reasons. Those, and all others, can be over ridden in your own theme's stylesheet.

Includes "Shop/Archive" , "Single Product" Hooks.
For PRO Version (includes Checkout and Cart pages), please visit <a href="https://madcowweb.com/hookywoo-product/">Mad Cow Web</a>

<a href="https://madcowweb.com/contact-us/">Contact Us</a>
== Installation ==
 
Activate the plugin through the 'Plugins' menu in WordPress.
Settings page is found under "WooCommerce - HookyWoo Settings".
Add some text to your desired field on the single product page or the shop page and save your changes.

== Frequently Asked Questions ==
 
= What about styled text and images? =
 
You can put any sort of HTML you like in that text area.
For example:

`<p class="my-cool-class">My Awesome Paragraph Styled however I want</p>`
`<img src="/wp-content/uploads/2013/06/cd_3_flat.jpg">`
`<div class="my-cool-div">My Awesome Stuff inside my div</div>`

= Will I lose my changes if I upgrade =
 
No. The data is stored safely in the database. Just remove the Standard Plugin and Upload the Pro version as you would any other plugin.

== Changelog ==
= 1.1.0 =
* Added tabbed function to better separate page sections
* Updated readme file with more instructions
= 1.3.0 =
* Included Cart and Checkout pages
== Upgrade Notice ==
1.3.0
Including cart and checkout pages
= 1.4.5 =
fix php errors for empty indexes on empty fields
= 1.5.1 =
update URLs
