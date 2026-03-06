<?php
/**
 * Plugin Name:       Ivory Search Shortcode
 * Description:       Creates a [ivory_search_form] shortcode that renders an Ivory Search form with radio button selection.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            topher1kenobe
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ivory-search-shortcode
 */

// Prevent direct access to this file outside of WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Renders an Ivory Search form with optional radio button engine selection.
 *
 * Accepts shortcode attributes to control which search engines (by post ID)
 * are displayed as radio buttons beneath the search input, and optionally
 * filters results to a specific post type via a hidden field.
 *
 * Usage:
 *   [ivory_search_form]
 *   [ivory_search_form id="12,34,56"]
 *   [ivory_search_form id="12,34" post_type="product"]
 *
 * @param array $input {
 *     Shortcode attributes parsed by WordPress.
 *
 *     @type string $id        Optional. Comma-separated list of Ivory Search
 *                             form post IDs to display as radio buttons.
 *     @type string $post_type Optional. Post type slug to restrict search
 *                             results (rendered as a hidden form field).
 * }
 * @return string The complete HTML output of the search form.
 */
function ivory_advanced_form( $input ) {
	// Begin output buffering so we can return the form HTML as a string.
	ob_start();

	// Check to see if we have a search variable
	if ( ! empty( $_GET['s'] ) ) {
		$s = $_GET['s'];
		} else {
		$s = '';
	}

	?>
<form class="is-search-form is-form-style is-form-style-3" action="/" method="get" role="search">
	<label for="is-search-input-1839">
		<span class="is-screen-reader-text">Search for:</span>
			<input type="search" id="is-search-input-1839" name="s" value="<?php echo esc_attr( $s ); ?>" class="is-search-input" placeholder="Search here..." autocomplete="off">
	</label><button type="submit" class="is-search-submit">
	<span class="is-screen-reader-text">Search Button</span>
	<span class="is-search-icon">
		<!-- Magnifying glass SVG icon for the submit button -->
		<svg focusable="false" aria-label="Search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px">
			<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
			</path>
		</svg>
	</span>
	</button>
	<?php
	// If one or more search engine IDs were provided, render them as radio buttons.
	if ( ! empty( $input['id'] ) ) {
		// Split the comma-separated ID string into an array.
		$ids = explode( ',', $input['id'] );

		// Inline styles to reset default list formatting on the engine list.
		echo '<style type="text/css">' . "\n";
		echo '.ivory_engines { list-style-type: none; padding: 0; margin: 10px 0 0 0; }' . "\n";
		echo '</style>' . "\n";

		echo '<ul class="ivory_engines">';
		foreach ( $ids as $id ) {
			// Cast to integer and skip any value that resolves to zero (invalid ID).
			$id = intval( $id );
			if ( 0 !== $id ) {
				// Pre-select the radio button if this engine's ID matches the current query string.
				if ( ! empty( $_GET['id'] ) && intval( $_GET['id'] ) === $id ) {
					$checked = ' checked = "checked"';
				} else {
					$checked = '';
				}

				// Render the radio button with the post title as its visible label.
				echo '<li><label><input type="radio" name="id" value="' . intval( $id ) . '"' . esc_html( $checked ) . '> ' . esc_html( get_the_title( $id ) ) . "</label></li>\n";
			}
		}
		echo '</ul>';
	}
	?>
	<?php
	// If a post_type attribute was supplied, add a hidden field to scope search results.
	if ( ! empty( $input['post_type'] ) ) {
		?>
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $input['post_type'] ); ?>">
		<?php
	}
	?>
</form>
	<?php
	// Capture the buffered HTML, clean the buffer, and return the form markup.
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

// Register the shortcode so [ivory_search_form] invokes ivory_advanced_form().
add_shortcode( 'ivory_search_form', 'ivory_advanced_form' );
