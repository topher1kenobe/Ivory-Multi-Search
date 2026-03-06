# Ivory Search Shortcode #
Contributors:      topher1kenobe
Tags:              search, shortcode, ivory search
Requires at least: 5.8
Tested up to:      6.5
Requires PHP:      7.4
Stable tag:        1.0.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Renders an Ivory Search form with radio-button form selection via a simple shortcode.

## Description ##

This plugin adds the `[ivory_search_form]` shortcode which outputs an Ivory Search
compatible search form.  Instead of a single hidden `id` field the shortcode queries
the supplied Ivory Search form IDs, retrieves their titles, and renders them as a
set of radio buttons so the visitor can choose which search scope to use.

**Shortcode attributes**

| Attribute   | Type                    | Default | Description                                          |
|-------------|-------------------------|---------|------------------------------------------------------|
| `post_type` | string                  | `post`  | Value passed as the `post_type` hidden field.        |
| `id`        | comma-separated integers| —       | IDs of Ivory Search forms to present as radio buttons. |

**Example usage**

    [ivory_search_form post_type="product" id="1839,1842,1855"]

## Requirements ##

* The **Ivory Search** plugin must be installed and activated.
* The search form posts must have `publish` status.

## Installation ##

1. Upload the `ivory-search-shortcode` folder to `/wp-content/plugins/`.
2. Activate the plugin through the *Plugins* screen in WordPress.
3. Add the shortcode to any post, page, or widget.

## Changelog ##

= 1.0.0 =
* Initial release.
