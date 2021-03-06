<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://jasonyingling.me
 * @since      1.0.0
 *
 * @package    Easy_Pull_Quotes
 * @subpackage Easy_Pull_Quotes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Pull_Quotes
 * @subpackage Easy_Pull_Quotes/public
 * @author     Jason Yingling <yingling017@gmail.com>
 */
class Easy_Pull_Quotes_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Pull_Quotes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Pull_Quotes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-pull-quotes-public.css', array( 'dashicons' ), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Pull_Quotes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Pull_Quotes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name.'-twitter-widget', '//platform.twitter.com/widgets.js', array(), $this->version, false );

	}

	public function epq_quote_shortcode($atts, $content = null) {
		wp_enqueue_script( $this->plugin_name.'-twitter-widget' );
		$epq = shortcode_atts( array(
			'align' => 'right-align',
		), $atts );

		$shortened_content = $this->truncate($content);
		$sanitized_text = wp_strip_all_tags($shortened_content);
		$sanitized_url = rawurlencode(wp_get_shortlink());

		return '<span class="epq-pull-quote epq-pull-quote-default epq-' . esc_attr($epq['align']) . '">' . do_shortcode($content) . '<a href="https://twitter.com/intent/tweet?text='.$sanitized_text.'&url='.$sanitized_url.'" class="epq-twitter"><span class="dashicons dashicons-twitter"></span></a></span>';
	}

	public function truncate($string,$length=240,$append="&hellip;") {
		$string = trim($string);

		if(strlen($string) > $length) {
			$string = wordwrap($string, $length);
			$string = explode("\n", $string, 2);
			$string = $string[0] . $append;
		}

		return $string;
	}

}
