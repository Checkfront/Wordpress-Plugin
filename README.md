![Checkfront](https://media.checkfront.com/images/brand/Checkfront-Logo-Tag-60.png)
Checkfront Wordpress Booking Plugin
==========================

The [Checkfront Wordpress Booking Plugin](http://www.checkfront.com/wordpress/) seamlessly 

integrates Checkfront into your Wordpress powered Website.  This combines the robust publishing capabilities
of Wordpress with the power of Checkfront.

This plugin is for Wordpress 1.6 or greater (tested to 2.5).  

Except as otherwise noted, the Checkfront PHP Wordpress Plugin is licensed under the Apache Licence, Version 2.0
(http://www.apache.org/licenses/LICENSE-2.0.html)

Usage
-----

Once installed and configured, you can render a booking window anywhere in your site by creating a new article, and 
supplying the checkfront shortcode: {checkfront}. 

== Example ==


```html
<h2>Booking Online!</h2>

{checkfront}
```

You can further customize how the booking portal renders by supplying options to the short code.

```html

<!-- Auto select a category -->
{checkfront category_id=1}

<!-- Filter a category-->
{checkfront category_id=1 options=filter}

<!-- Display the tabbed interface in a compact layout-->
{checkfront options=tabs,compact}

<!-- Use a custom background and font-->
{checkfront style=background-color: #000;color:#fff;font-family:Tahoma; width:800}
```
For a full list of of available options please the setup guide: [Online Bookings with Wordpress and Checkfront](http://www.checkfront.com/joomla/);

