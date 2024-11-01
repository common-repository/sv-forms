=== SV Forms ===
Contributors: matthias-reuter, matthiasbathke, dennisheiden
Donate link: https://straightvisions.com
Tags: form-block, form-builder, contact-form
Requires PHP: 8.0
Requires at least: 6.0
Tested up to: 6.5.5
Stable tag: 2.0.05
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0-standalone.html

SV Forms is a block that allows you to create forms in the WordPress Gutenberg Block-Editor, with ease.

== Description ==

Do you want to create quick and easy forms in the WordPress Gutenberg Block-Editor?

Then our new Gutenberg-Block SV Forms is just right for you!

Our SV Forms Block for the WordPress Gutenberg Block-Editor offers you full control and creative freedom in the creation of custom forms.

✔ A form block that wraps everything together and lets you put in whatever you want.
✔ 6 Input-Blocks for different kinds of data (more to come!).
✔ E-Mail notfications when a user submitted your form.
✔ Confirmation E-Mails for users who submitted your form.
✔ "Thank You Message"-Block that let's you create a "Thank You"-Message that will be shown, when a user submitted your form.
✔ Bunch of settings and customization.

<a href="https://straightvisions.com/en/projects/sv-forms/">More information and preview</a>

= Plugin Description =

SV Forms is a block that allows you to create forms in Gutenberg, with ease.

= Team =

* Developed and maintenanced by <a href="https://straightvisions.com">straightvisions GmbH</a>

== Installation ==

This plugin is build to work out-of-the-box. Installation is quite simple.

1. Upload plugin-directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You are using a caching plugin? Don't forget to flush caches now.

== Changelog ==

= 2.0.05=
* Core Update

= 2.0.04=
* Core Update

= 2.0.02 =
* Core Update
* Change Submission Meta Data from single field JSON to multi fields raw
* Frontend JS converted to vanilla JS to avoid jQuery dependency

= 2.0.01 =
* Hotfix

= 2.0.00 =
* Core Update

= 1.9.00 =
* Core Update

= 1.8.11 =
### Various

* Core Update

= 1.8.10 =
### Security Fix

* Third Party Vendor Library

### Various

* Core Update

= 1.8.00 =
### Various

* Core Update

= 1.7.00 =

### Various

* SV Core improvements

= 1.6.00 =

### Various

* SV Core improvements

= 1.5.14 =

### Various

* SV Core improvements

= 1.5.13 =

### Various

* SV Core improvements

= 1.5.12 =

### Various

* Deactivated nonce check, due to problem with caching

= 1.5.11 =

### Various

* SV Core improvements

= 1.5.10 =

### Improvements

* Added min-height and padding to mail- and userselect

### Various

* Update Core
* Updated rest api method to retrieve users

= 1.5.00 =

### Various

* SV Core improvements

= 1.4.19 =

### Features

* Added "Border Style" to inspector panel "Border "Settings"
* Added translation for "German"

### Improvements

* Added default values for various blocks, to ensure a clean design out of the box

### Bug Fixes

* Fixed a bug where the "Submit"-Block have full width without the alignfull class
* Fixed a style bug in the "Select"-Block
* Fixed a style bug in the "Range"-Block

= 1.4.18 =

### Various

* SV Core improvements

= 1.4.17 =

### Bug Fixes

* Fixed a bug where new Form Blocks wouldn't save

= 1.4.16 =

### New Blocks

* Files Block - Allows you to upload files in your forms

### Features

* Added new border settings to the form blocks (except checkbox, radio, range and hidden)

### Enhancements

* Reorganized the block settings of the form blocks (except checkbox, radio, range and hidden)

= 1.4.15 =

### Features

* Added new Hidden Block, to implement hidden input fields in your form
* Added a "Clear SV Forms Meta Field" button to the wrapper Block

### Enhancements

* Added default label to the User Mail Block
* The copy to clippboard buttons will show a notice, when the content is copied to the clippboard

### Bug Fixes

* Fixed that the Form ID in the Forms Block wouldn't update
* Fixed that the get_admin_mails & get_user_mails function can return NULL
* Fixed that the copy to clippboard feature will break the block
* Fixed missing label on radio buttons


= 1.4.14 =

### Various

* SV Core improvements

= 1.4.13 =

### Features

* Form Labels
    * Give your form a label to filter and group your submissions by it.
* Input name check
    * When working on your form, you will get a notice when two of your inputs use the same input name.
* Border Radius Settings
    * Input Block now have a border radius setting.

### New Blocks

* Form Block
    * This block will contain the blocks for the form and is a child of the SV Forms block.

### Enhancements

* The following blocks are now collapsible, for better content overview.
    * Wrapper Block
    * Form Block
    * Thank You Message Block
    * User Mail Block
    * Admin Mail Block
* Input Blocks will notify the user, if an input name already exists inside the current form.
* You can now click on the available input values to copy them in your clippboard.

### Various

* Deactivated the feature that input names will be automatically generated, when the input label is updated, due to possible workflow problems.
* The SV Forms block will no longer directly contain the blocks for the form, but the blocks for all form features.
    * SV Forms will now act as a wrapper for the following blocks:
        * Form (Will now directly contain the blocks for the form)
        * Thank You Message
        * User Mail
        * Admin Mail
* The "Admin Mail" settings was moved to the Admin Mail Block.
* The "Send Confirmation Mail" setting was moved to the User Mail Block and the function was changed.
    * You can choose in a select field, the E-Mail Block to recieve the user mail.

### Bug Fixes

* Prevents form id override when using a form as reuseable block.
* Checkboxes without value will no longer throw PHP notices.
* Spam Guard will no longer throw an error, when not set.
* Fixed a bug where block content of the Admin Mail and User Mail Block will disappear.
* The available input values inside the Thank You Message block will now update live.

= 1.4.13 =

### Various

* FIX Margin
* Update Core

= 1.4.12 =

### Features

* Add action hook on form submit.

### New Blocks

* Spam Guard Block
    * Adds antispam features, to prevent your forms from spam.

### Various

* Updated default form template
    * Added Spam Guard Block

= 1.4.11 =

### Features

* Add WordPress Personal Data Exporter Support
* Add WordPress Personal Data Eraser Support

= 1.4.10 =
### Features

* Adding an archive for form submissions, with the form data inside.
* Automatically add Admin Mail Block when Admin Mail is selected in the

### New Blocks

* Number Block:
    * A input field for numbers.
* Date Block:
    * A input field for dates.
* Range Block:
    * A input field for ranges.
* Phone:
    * A input field for phone numbers.
* Password Block:
    * A input field for passwords and secrects.
* User Mail Block:
    * A wrapper block that contains the e-mail content for the user.
    * Add support for output of input values.
* Admin Mail Block:
    * A wrapper block that contains the e-mail content for the admin.
    * Add support for output of input values.

### Enhancements

* SV Forms Block
    * Add header to wrapper with block name, description and the form id.
    * Add border and styling to wrapper, to better identify the block.
    * Add setting to save form submits.
    * Automatically add Admin Mail Block when Admin Mail is selected.
    * Updated default form template, when adding a new form.
* Thank You Message Block:
    * Add support for output of input values.
* E-Mail Block:
    * Renamed "Is recipient?" to "Send Confirmation Mail" for better understanding.
    * Automatically add User Mail Block when Send Confirmation Mail is selected.
* Post Meta:
    * Updated the data structure and management of the form data inside the post meta.
* Cleaned code for better readability and performance.

### Bug Fixes

* Fix error when Thank You Message block is missing.
* Fix duplicate form ids when duplicating an existing form.
* Fix Validation Settings open on default.

= 1.4.00 =
### Various

* Initial release

== Upgrade Notice ==
Core Update

== Missing a feature? ==

Please use the plugin support forum here on WordPress.org. We will add your wish - if achievable - on our todo list. Please note that we can not give any time estimate for that list or any feature request.

= Paid Services =
Nevertheless, feel free to contact our [WordPress Agency](https://straightvisions.com) if you have any of the following needs:

* get a customization
* get a feature rapidly / on time
* get a custom WordPress plugin or theme developed to exactly fit your needs.