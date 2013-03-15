<?php
/**
 * Plugin Name: Footer Text
 * Plugin URI: http://bungeshea.com/plugins/footer-text/
 * Description: Allow changing of the footer text easily from the dashboard
 * Author: Shea Bunge
 * Author URI: http://bungeshea.com
 * License: MIT
 * License URI: http://opensource.org/licenses/mit-license.php
 * Version: 1.0
 */

/** Dashboard Administration Menu ********************************************/

/**
 * Add the footer text options page to
 * the 'Appearance' dashboard menu
 *
 * @uses add_theme_page() To register the new submenu
 *
 * @since 1.0
 */
function add_footer_text_options_page() {
	$theme_page = add_theme_page(
		__( 'Footer Text', 'footer-text' ),	// Name of page
		__( 'Footer Text', 'footer-text' ),	// Label in menu
		'edit_theme_options',          		// Capability required
		'footer-text', 	               		// Menu slug, used to uniquely identify the page
		'render_footer_text_options_page'	// Function that renders the options page
	);
}
add_action( 'admin_menu', 'add_footer_text_options_page' );

/**
 * Display the footer text options page
 * and save posted text to the database
 *
 * @uses update_option() To save the text to the database
 * @uses screen_icon() To display the dashboard menu icon
 * @uses wp_editor() For a visual editor
 * @uses get_option() To retrieve the current text from the database
 * @uses submit_button() To generate a form submit button
 *
 * @since 1.0
 */
function render_footer_text_options_page() {

	if ( isset( $_POST['footer_text'] ) )
		update_option( 'theme_footer_text', stripslashes( $_POST['footer_text'] ) );

	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'Footer Text', 'footer-text' ); ?></h2>


		<form method="post" action="" style="margin: 20px 0;">
			<?php
				wp_editor( get_option( 'theme_footer_text', '' ), 'footer_text' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/** Template Tags ******************************************************/

/**
 * Fetches the footer text from the database
 * with formatting functions applied
 *
 * @return string The formatted footer text
 *
 * @since 1.0
 */
function get_footer_text() {
	return apply_filters( 'the_content', get_option( 'theme_footer_text', '' ) );
}

/**
 * Retrieves the footer text and displays it if it is set
 * Nothing is displayed if the footer text is not set
 *
 * @uses get_footer_text() To retrieve the footer text
 *
 * @param string $before The text to display before the footer text
 * @param string $after The text to display after the footer text
 * @param bool $display Output or return the resulting text?
 * @return null|string The footer text if $output is true
 *
 * @since 1.0
 */
function footer_text( $before = '', $after = '', $display = true ) {

    $footer_text = get_footer_text();
    $output = ( empty( $footer_text ) ? '' : $before . $footer_text . $after );

    if ( $display )
	    echo $output;
    else
        return $output;

}