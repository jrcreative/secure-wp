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
		if ( $errors->has_errors() ) {
			wp_redirect('/wp-login.php?checkemail=confirm');
			exit();
		}
	}
	public function modify_lostpassword_redirect($errors) {
		return '/wp-login.php?checkemail=confirm';
	}
	
	public function modify_login_messages($messages) {
		global $wp;
		$curr_page = add_query_arg( $wp->query_vars );
		if ($curr_page == '/wp-login.php?checkemail=confirm') {
			$messages = "If your account was found, check your inbox for a password reset link";
		}
		
		return $messages;
	}

	// Remove WordPress version number from RSS feed
	public function remove_version_from_rss() {
		return '';
	}
	
	private function time_to_go($timestamp)
	{
	
		// converting the mysql timestamp to php time
		$periods = array(
			"second",
			"minute",
			"hour",
			"day",
			"week",
			"month",
			"year"
		);
		$lengths = array(
			"60",
			"60",
			"24",
			"7",
			"4.35",
			"12"
		);
		$current_timestamp = time();
		$difference = abs($current_timestamp - $timestamp);
		for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {
			$difference /= $lengths[$i];
		}
		$difference = round($difference);
		if (isset($difference)) {
			if ($difference != 1)
				$periods[$i] .= "s";
				$output = "$difference $periods[$i]";
				return $output;
		}
	}

	public function check_attempted_login( $user, $username, $password ) {
		$limit_attempts = 3;

		if ( get_transient( 'attempted_login' ) ) {
			$wp_errors = new WP_Error();

			$data = get_transient( 'attempted_login' );

			if ( $data['tried'] >= $limit_attempts ) {
				$until = get_option( '_transient_timeout_' . 'attempted_login' );
				$time = $this->time_to_go( $until );
	
				$wp_errors->add( 'too_many_tried',  sprintf( __( '<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in %1$s.' ) , $time ) );
			} else {
				$wp_errors->add( 'times_tried',  sprintf( __( 'This is attempt %1$s of %2$s' ) , $data['tried'], $limit_attempts) );
			}
			return $wp_errors;
		}
	
		return $user;
	}

	function login_failed( $username ) {
		$limit_attempts = 20;
		$time_to_retry = 300;

		if ( get_transient( 'attempted_login' ) ) {
			$data = get_transient( 'attempted_login' );
			$data['tried']++;
	
			if ( $data['tried'] <= $limit_attempts )
				set_transient( 'attempted_login', $data , $time_to_retry );
		} else {
			$data = array(
				'tried'     => 1
			);
			set_transient( 'attempted_login', $data , $time_to_retry );
		}
	}
}
