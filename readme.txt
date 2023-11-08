# Checkfront Online Booking System

Contributors: checkfront
Stable tag: 3.7
Tags: Booking, Booking System, Reservation, Reservation System, Online Booking, Booking Engine, Tours, Tour Operator, Booking Plugin, Reservation Plugin, Booking Software, Reservation Payment System, Activity Booking, Rental Booking, Reservation Payments, Tour Booking, Passbook, Availability, Payments, Bookings
Requires at least: 2.0
License: GPLv2 or later
Tested up to: 6.4

The Premier Wordpress Plugin for Easy Online Booking of Tours, Activities, Rentals & Accommodations.

## Description

**Checkfront** is an [Online Booking System](https://www.checkfront.com?cfcp=wp) designed for your tour, activity, rental or accommodation business. Checkfront helps streamline the reservation process and grow your business by allowing you to manage availability and inventory, learn about your customers, automate communications, access valuable insights, and plan your day to day operations. 

**Your guests** can view your availability and book directly from your Wordpress website at whatever time suits them. They can easily submit their details, sign digital waivers and documents, review their booking history, and make an online payment — all from a desktop or mobile device. 
 
This plugin provides a powerful **real-time booking interface** that blends in with your existing Wordpress theme by connecting your Checkfront account to your Wordpress site. 

### Features include

* Display real time availability, [take reservations, bookings and process payments](https://www.checkfront.com?cfcp=wp) online within your website
* Automatically send confirmations, alerts, invoices, and customized follow-up to customers, staff and partners
* [Collect information](https://www.checkfront.com/introducing-guest-form?cfcp=wp) for each participant with Guest Form and plan your day in advance with the Daily Agenda
* Over 50 additional integrations including [MailChimp, Zoho, Google Apps, Xero, and Twilio SMS](https://www.checkfront.com/addons?cfcp=wp)
* Create Customer Accounts for customers to review booking history, store autofill details and (optionally) modify future bookings from a personal login
* Sync your availability with OTAs like Viator, Expedia and TripAdvisor
* Detailed analytics and reporting
* Track third-party referrals and commissions with Partner Accounts
* Responsive, mobile-friendly booking process and back-end
* Support for multiple languages and international currencies
* Multi-gateway payment processing including Stripe, Square, Paypal, Authorize.net, SagePay & dozens more
* SSL support keeps the customer on your website while making payment
* Support for shortcodes, or custom theme pages in Wordpress.
* Tailored onboarding session and a 24/7 support team
* **No commissions!**

Checkfront integrates seamlessly into WordPress and does not force customers off to an external website to process bookings or view availability. Checkfront keeps consumer data secure and separate from WordPress. 

The combined CMS features of WordPress with the power, flexibility and security of the Checkfront back-end make for an industry leading booking management system.

[See Checkfront and Wordpress in action here.](https://vimeo.com/108589695)

### Installation

1. Install the Checkfront Booking plugin in your Wordpress admin by going to *'Plugins / Add New'* and  searching for *'Checkfront'*,  **(or)** If doing a manual install, download the plugin and unzip into your `/wp-content/plugins/` directory 
2. Activate the the plugin through the 'Plugins' menu in WordPress

### Configuration

1. Create your [Checkfront account](https://www.checkfront.com/start/?cfcp=wp "Checkfront Setup")
2. Setup you inventory and configure your account on Checkfront
3. Enable the Checkfront booking search widget in Wordpress
4. Create a Wordpress **Post** and embed the Checkfront booking system by using the shortcode: `[checkfront]` (see the plugin for more options to pass to the shortcode)
5. If you wish to use a theme template instead of a shortcode, see the checkfront-custom-temp late-sample.php provided with the plugin

### Frequently Asked Questions

1. [Checkfront Wordpress FAQ](https://www.checkfront.com/wordpress/#faq) 
2. [General Checkfront FAQ](https://www.checkfront.com/faq?cfcp=wp) 
3. [Additional Support and Documenation](https://www.checkfront.com/support?cfcp=wp)

### Screenshots

1. Checkfront Dashboard
2. Wordpress code generator within Checkfront
3. Booking Interface integrated into Wordpress
4. Booking Interface within Checkfront
5. Checkfront Guest Form

## Upgrade Notice

### Changelog

* *September 19th 2023:*
  * Fixed CSRF vulnerability
* *November 2nd 2022:*
  * Wordpress 6.1 compatibility
  * Removed deprecated sidebar widget
* *February 25th 2021:*
  * Fixed broken image links in plugin setup
* *September 17th 2020:*
  * Added better compatibility with PHP v7.3
* *July 27th 2018:*
  * Added Guest Form information to readme
* *May 15th 2018:*
  * Updates to readme
  * New setup video and improved plugin documentation
* *March 7th 2015:*
  * You can now pass lang_id (language) and partner_id (for upcoming partner accounts) in the Checkfront shortcode.
* *November 19th 2014:*
  * New walk through /setup video.
* *September 10 2014*:
  * Added support for Wordpress 4.0
  * Added lang_id and partner_id to shortcode options.
* *September 30 2013*:
  * Added support for new interface library, updated Widget library and support for end_date shortcode.
* *June 27 2012*:
  * Split out CheckfrontWidget class so it can be used on its own.  Added custom template sample.  Fixed issue with category filter.
* *June 25 2012*:
  * Added support for v2.0 Checkout.  Includes more configuration options.
* *May 11 2010*:
  * Removed "Online Bookings by Checkfront" link
* *Apr 29 2010*:
  * Added the ability to filter booking pages by category or item id.
  * Upgraded to latest API.
* *Mar 21 2010*:
  * Added sidebar widget.
  * Improved calendar navigation.
  * Better theme integration.
* *Feb 28 2010*:
  * Fixed php shortcode issue.
* *Feb 24 2010*:
  * Updated screenshots
  * Removed legacy invoice insert.
* *Feb 18 2010*:
  * Moved to new 0.9 Checkfront API
  * Now supports framed version of booking window should the theme interfere with the plugin
  * Removed search widget: search functionality has been moved to main booking interface  - will reappear in another format.
* *Nov 30 2009*: 
    * Improved compatibility fixes.  
* *Nov 13 2009*: 
    * Made compatible with Wordpress 2.5+.  
    * No longer loads remote javascript site wide, only on an embedded booking page.
    * Improved warning messages and admin settings.
    * Moved admin settings to plugin menu.
* *Nov 6 2009*: Updated readme, small IE fix.
* *Nov 5 2009*: Initial public beta.
