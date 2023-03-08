<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jeremyrosscreative.com
 * @since      1.0.0
 *
 * @package    Secure_Wp
 * @subpackage Secure_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Secure_Wp
 * @subpackage Secure_Wp/public
 * @author     Jeremy Ross <jeremy@jeremyrosscreative.com>
 */
class Secure_Wp_Public {

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
		 * defined in Secure_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/secure-wp-public.css', array(), $this->version, 'all' );

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
		 * defined in Secure_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/secure-wp-public.js', array( 'jquery' ), $this->version, false );

	}

	public function modify_login_errors($errors) {
		$error_message = "<strong>Error:</strong> Username or Password Invalid";

		if (isset($errors->errors['invalid_username'])) {
			$errors->errors['invalid_username'][0] = $error_message;
		}

		if (isset($errors->errors['incorrect_password'])) {
			$errors->errors['incorrect_password'][0] = $error_message;
		}

		return $errors;
	}

	public function modify_lostpassword_errors($errors) {
		if (isset($errors->errors['invalidcombo'])) {
			wp_redirect('/wp-login.php?checkemail=confirm');
			exit();
		}
	}
	public function modify_lostpassword_redirect() {
		return '/wp-login.php?checkemail=confirm';
	}
	
	public function modify_login_messages($messages) {
		global $wp;
		$curr_page = add_query_arg( $wp->query_vars );
		if ($curr_page == '/wp-login.php?checkemail=confirm') {
			$messages = "If your information was found in our system, check your inbox for a password reset link";
		}
		
		return $messages;
	}
}
