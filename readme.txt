=== Cynosure ===
Contributors: eatingrules
Tags: leadgen,highlight,spotlight,opt-in,feature,featured,focus
Tested up to: 6.2
Stable tag: trunk
License: GPLv2

Highlight a specific element as the user scrolls through a page. 

== Description ==
**cynosure** (sī′nə-shoo͝r)
_noun: Something that strongly attracts attention; a center of attraction._

Using a CSS selector, Cynosure will apply a full-screen `box-shadow` effect to a target `<div>` as  it reaches the center of the window, drawing attention to specific content you want to feature.

== How to use ==

1. Determine the CSS `.class` or `#id` of the `div` element that you want to highlight. (It will only work on a `div`, not a `span` or `p` or other element.)  Right-click on the content you want to feature, then select "Inspect."  This will show you the code for the content. Look for a `<div>` element that has a unique `class` or `id` name.

2. Go to the Cynosure settings page. Enter the `.class` or `#id`. Be sure to include the . for a class, or # for an id (example:  `.cp-popup-content`).  

3. Optionally, select a custom highlight color and opacity.

4. Save the settings, then try it on the front-end of your site. As the target element scrolls into view, you should see a highlight effect animate in (and then go away as it scrolls past).



== Frequently Asked Questions ==

= Why use this? =

The most common use case is to highlight an opt-in or signup form that is embedded in your post content. As the form scrolls into the middle of the page, the highlight effect will make it the center of attention, helping increase your opt-in rate.

= How can I set a class on my div in the Block Editor? =

In the Block Editor, select the Block - or Group of blocks - that you'd like to highlight. In the sidebar, expand the "Advanced" section. Enter a unique class name in the "Additional CSS Class(es)" field. Do not include the `.` in this field, but do include it in the Cynosure settings.

For example, if you want to target a paragraph block, enter `myimportantblock` in the Additional CSS Classes field. Then, in the Cynosure settings, enter `.myimportantblock`.  Now it should highlight when it scrolls into view.

= Why isn't it working? =

You'll need to determine the CSS `.class` or `#id` of the `div` element that you want to highlight. It will only work on a `div` (not a `span` or `p` or other element).

Be sure to include the `.` (for a class or `#` for an id).

= How can I troubleshoot? =

In the Cynosure settings, enable the "Debug Mode" option and save the settings.  Then, view the post or page that has the `div` you want to highlight.

Open Developer Tools in your browser, and go to the Console Tab.  You should see some messages there from `[Cynosure]`.

Be sure to disable Debug Mode when you're done.


== Screenshots ==

1. The target div element will be highlighted when it scrolls to the middle of the page. 

2. The settings page. Specify a target class or ID of the div you want to highlight. Color and opacity of the shadow is easily changed.

3. Debug mode, showing the target selector and target div contents.

== Changelog ==

1.0 - Initial release