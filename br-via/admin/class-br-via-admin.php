<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       http://example.com
* @since      1.0.0
*
* @package    bR_VIA
* @subpackage bR_VIA/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    bR_VIA
* @subpackage bR_VIA/admin
* @author     Your Name <email@example.com>
*/
class bR_VIA_Admin {

	/**
	* The ID of this plugin.
	*
	* @since    1.0.0
	* @access   private
	* @var      string    $bR_VIA    The ID of this plugin.
	*/
	private $bR_VIA;

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
	* @param      string    $bR_VIA       The name of this plugin.
	* @param      string    $version    The version of this plugin.
	*/
	public function __construct( $bR_VIA, $version ) {

		$this->br_via = $bR_VIA;
		$this->version = $version;
		add_action("save_post", "save_blmetas");
		add_action("save_draft", "save_blmetas");
		//$this->bodyloop_meta_box();
	}

	/**
	* Register the stylesheets for the admin area.
	*
	* @since    1.0.0
	*/
	public function enqueue_styles() {

		/**
		* This function is provided for demonstration purposes only.
		*
		* An instance of this class should be passed to the run() function
		* defined in bR_VIA_Loader as all of the hooks are defined
		* in that particular class.
		*
		* The bR_VIA_Loader will then create the relationship
		* between the defined hooks and the functions defined in this
		* class.
		*/

		//wp_enqueue_style( $this->br_via, plugin_dir_url( __FILE__ ) . 'css/br-via-admin.css', array(), $this->version, 'all' );

	}

	/**
	* Register the JavaScript for the admin area.
	*
	* @since    1.0.0
	*/
	public function enqueue_scripts() {

		/**
		* This function is provided for demonstration purposes only.
		*
		* An instance of this class should be passed to the run() function
		* defined in bR_VIA_Loader as all of the hooks are defined
		* in that particular class.
		*
		* The bR_VIA_Loader will then create the relationship
		* between the defined hooks and the functions defined in this
		* class.
		*/

		//wp_enqueue_script( $this->br_via, plugin_dir_url( __FILE__ ) . 'js/br-via-admin.js', array( 'jquery' ), $this->version, false );

	}

	// BODYLOOP
	// Metabox permettant de créer une loop personnalisée qui sera placée avant, après ou en remplacement de la loop page.

	// Création de la metabox
	public function bodyloop_meta_box() {

	}

	// Affichage de la metabox
	public function bodyloop_meta_options() {
		global $post;
		global $wpdb;

		if (defined('AI1EC_POST_TYPE'))
		wp_nonce_field('ai1ec', AI1EC_POST_TYPE);

		$custom = get_post_custom($post -> ID);
		$post_views_count = isset($custom["post_views_count"][0]) ? $custom["post_views_count"][0] : false;

		echo 'Vous êtes sur un article "' . get_post_format() . '".';
		echo '<h4>Nombre de vues</h4>';
		echo '<input name="post_views_count" class="form-input" value="' . $post_views_count . '" size="16" type="text" />';

		$videoType = 'you';

		$custom = get_post_custom($post -> ID);

		include 'bodyloop_form_page.php';
	}

	// Sauvegarde des données
	public function save_blmetas($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		} else {

			foreach (getDefaultLoop() as $K => $V) {
				if(isset($_POST[$K])) {
					update_post_meta(get_the_ID(), $K, $_POST[$K]);
				}
			}

		}
	}

	public function doFormInput($string, $instance = false, $options = false, $after = false) {// 'Afficher un titre,afficher_titre ?'
		// Création de formulaire en parallèle avec bodyloop.php, le widget
		include 'bodyloop_functions_page.php';
		return $form_item . $after;
	}

	public function getOptions($which) {
		switch($which) {
			default :
			return array();
			break;
			case 'filtres_categories' :
			return get_categories();
			break;
		}
	}

	/* FIN DE LA METABOX */

	/////////////////////////////////////////////////////////////////////////////////////////////////////////




}
