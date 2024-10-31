<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://nubocoder.com
 * @since      1.0.0
 *
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/admin
 * @author     César Siancas <zed.1985@gmail.com>
 */
class Nubocoder_Bb_Simple_Module_Creator_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name.'-ace', plugin_dir_url( __FILE__ ) . 'js/ace.js', array( ), '1.4.12', true );
		wp_enqueue_script( $this->plugin_name.'-beautify', plugin_dir_url( __FILE__ ) . 'js/beautify.js', array( $this->plugin_name.'-ace' ), '1.15.1', true );
		wp_enqueue_script( $this->plugin_name.'-html-beautify', plugin_dir_url( __FILE__ ) . 'js/html-beautify.js', array( $this->plugin_name.'-beautify' ), '1.15.1', true );
		wp_enqueue_script( $this->plugin_name.'-main', plugin_dir_url( __FILE__ ) . 'js/main.js', array( $this->plugin_name.'-ace', $this->plugin_name.'-beautify', $this->plugin_name.'-html-beautify' ), $this->version, true );

	}
	
	/**
	 * Creates the custom post type 'nc-bb-sm' that defines the modules.
	 *
	 * @since    1.0.0
	 */
	public function create_cpt() {
		
		$labels = array(
			'name'                  => _x( 'Modules', 'Post type general name', 'nubocoder-beaver-builder-simple-module-creator' ),
			'singular_name'         => _x( 'Module', 'Post type singular name', 'nubocoder-beaver-builder-simple-module-creator' ),
			'menu_name'             => _x( 'NuboCoder BB Simple Modules', 'Admin Menu text', 'nubocoder-beaver-builder-simple-module-creator' ),
			'name_admin_bar'        => _x( 'Module', 'Add New on Toolbar', 'nubocoder-beaver-builder-simple-module-creator' ),
			'add_new'               => __( 'Add New', 'nubocoder-beaver-builder-simple-module-creator' ),
			'add_new_item'          => __( 'Add New Module', 'nubocoder-beaver-builder-simple-module-creator' ),
			'new_item'              => __( 'New Module', 'nubocoder-beaver-builder-simple-module-creator' ),
			'edit_item'             => __( 'Edit Module', 'nubocoder-beaver-builder-simple-module-creator' ),
			'view_item'             => __( 'View Module', 'nubocoder-beaver-builder-simple-module-creator' ),
			'all_items'             => __( 'All Modules', 'nubocoder-beaver-builder-simple-module-creator' ),
			'search_items'          => __( 'Search Modules', 'nubocoder-beaver-builder-simple-module-creator' ),
			'parent_item_colon'     => __( 'Parent Modules:', 'nubocoder-beaver-builder-simple-module-creator' ),
			'not_found'             => __( 'No modules found.', 'nubocoder-beaver-builder-simple-module-creator' ),
			'not_found_in_trash'    => __( 'No modules found in Trash.', 'nubocoder-beaver-builder-simple-module-creator' ),
		);
		
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'nc-bb-sm' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
		);
		
		register_post_type( 'nc-bb-sm', $args );
		
	}
	
	/**
	 * Creates the required custom fields for the Module definition.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes(){
		
		add_meta_box(
				'nc_bb_sm_class_name',
				__( 'Class Name (BB Module Identifier)', 'nubocoder-beaver-builder-simple-module-creator' ),
				array( $this, 'nc_bb_sm_class_name_callback' ),
				'nc-bb-sm',
				'normal',
				'high'
		);
		
		add_meta_box(
				'nc_bb_sm_definition',
				__( 'Definition (Array)', 'nubocoder-beaver-builder-simple-module-creator' ),
				array( $this, 'nc_bb_sm_definition_callback' ),
				'nc-bb-sm',
				'normal',
				'high'
		);
		
		add_meta_box(
				'nc_bb_sm_front',
				__( 'Front (HTML)', 'nubocoder-beaver-builder-simple-module-creator' ),
				array( $this, 'nc_bb_sm_front_callback' ),
				'nc-bb-sm',
				'normal',
				'high'
		);
		
	}
	
	/**
	 * Creates the custom field 'nc_bb_sm_class_name'.
	 *
	 * @since    1.0.0
	 * @param      object    $post    Current post (module).
	 */
	function nc_bb_sm_class_name_callback($post) {
			wp_nonce_field('nc_bb_sm_save_postdata', 'nc_bb_sm_nonce');
			$module_class_name = get_post_meta($post->ID, '_nc_bb_sm_class_name', true);
			?>
			<input style="width: 100%;" disabled="1" type="text" id="_nc_bb_sm_class_name_field" name="nc_bb_sm_class_name" value="<?php echo esc_attr($module_class_name); ?>">
			<?php
	}
	
	/**
	 * Creates the custom field 'nc_bb_sm_definition'.
	 *
	 * @since    1.0.0
	 * @param      object    $post    Current post (module).
	 */
	function nc_bb_sm_definition_callback($post) {
			
			$array_value = get_post_meta($post->ID, '_nc_bb_sm_definition', true);
			?>
			<div>
					<div id="nc_bb_sm_definition_editor" style="height: 300px; width: 100%;"><?php echo esc_textarea($array_value); ?></div>
					<input type="hidden" id="nc_bb_sm_definition_field" name="nc_bb_sm_definition" value="<?php echo esc_attr($array_value); ?>">
			</div>
			<?php
	}
	
	/**
	 * Creates the custom field 'nc_bb_sm_front'.
	 *
	 * @since    1.0.0
	 * @param      object    $post    Current post (module).
	 */
	function nc_bb_sm_front_callback($post) {
		
		$html_data = get_post_meta($post->ID, '_nc_bb_sm_front', true);
		
		// Cleans the format
		$escaped_html_data = htmlspecialchars($html_data, ENT_QUOTES, 'UTF-8');
		
		?>
		<div>
				<div id="nc_bb_sm_front_editor" style="height: 300px; width: 100%;"></div>
				<input type="hidden" id="nc_bb_sm_front_field" name="nc_bb_sm_front" value="<?php echo esc_attr($escaped_html_data); ?>">
		</div>
		<?php
	}
	
	/**
	 * Stores the custom fields for the module and creates the class file.
	 *
	 * @since    1.0.0
	 * @param      int    $post_id    Current post (module).
	 */
	function save_postdata($post_id) {
		
		if (!isset($_POST['nc_bb_sm_nonce']) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nc_bb_sm_nonce'] ) ), 'nc_bb_sm_save_postdata')) {
				return;
		}
		
		if (!current_user_can('edit_post', $post_id)) {
				return;
		}
		
		$error_messages = [];
		
		// Validates and saves nc_bb_sm_definition
		if (isset($_POST['nc_bb_sm_definition'])) {
			$json_data = trim(stripslashes( sanitize_text_field( $_POST['nc_bb_sm_definition'] ) ) );
			
			// Deletes invisible characters
			$json_data = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $json_data);
			
			// Removes jump lines or any white space
			$json_data = preg_replace('/\s+/', ' ', $json_data);
			
			// Decodes JSON to check validity 
			$array_data = json_decode($json_data, true);
			if ($array_data === null && json_last_error() !== JSON_ERROR_NONE) {
					$error_messages[] = __( 'Error: Definition must be a valid JSON array.', 'nubocoder-beaver-builder-simple-module-creator' );
			} else {
					update_post_meta($post_id, '_nc_bb_sm_definition', $json_data);
			}
		}
		
		// Validates and stores nc_bb_sm_front
		if (isset($_POST['nc_bb_sm_front'])) {
			$html_data = wp_kses_post( $_POST['nc_bb_sm_front'] );
			$html_data = trim(stripslashes($html_data));
			
			// Validates HTML again
			if ($html_data != strip_tags($html_data, '<p><a><div><span><b><i><ul><ol><li><h1><h2><h3><h4><h5><h6>')) {
					$error_messages[] = __( 'Error: Front must be valid HTML.', 'nubocoder-beaver-builder-simple-module-creator' );
			} else {
					update_post_meta($post_id, '_nc_bb_sm_front', wp_kses_post($html_data));
			}
		}
		
		// Creates the unique Identifier that will be also the ClassName
		if ( isset($_POST['nc_bb_sm_front']) && isset($_POST['nc_bb_sm_definition']) ) {
			
			$module_class_name = get_post_meta( $post_id , '_nc_bb_sm_class_name', true);
			
			if( !$module_class_name ){
				
				$module_class_name = ucwords( str_replace( '-', ' ', sanitize_title( $_POST['post_title'] ) ) );
				$module_class_name = 'NC_BB_SM_'.  str_replace( ' ', '_', $module_class_name );
				update_post_meta($post_id, '_nc_bb_sm_class_name', $module_class_name );	
			}
			
			
			// Generates the class file
			$module_attributes = array(
				 'name'          => sanitize_text_field( $_POST['post_title'] ),
				 'description'   => __('BB Custom Module', 'nubocoder-beaver-builder-simple-module-creator'),
				 'category'		=> __('NuboCoder Simple Module Creator', 'nubocoder-beaver-builder-simple-module-creator'),
			);
			
			$this->generate_class_file($module_class_name, $module_attributes);	
			
		}
		
		if (!empty($error_messages)) {
				set_transient('nc_bb_sm_error', implode('<br>', $error_messages), 10);
		}
	}
	
	/**
	 * Deletes the class file when the post (module) is deleted.
	 *
	 * @since    1.0.0
	 * @param      int    $post_id    Post (module) being deleted.
	 */
	function before_delete_post($post_id) {
			
			$post_type = get_post_type($post_id);
	
			if ($post_type === 'nc-bb-sm') {
				
				$module_class_name = get_post_meta( $post_id , '_nc_bb_sm_class_name', true);
				
				if( !$module_class_name ){
					return;
				}
				
				$folder = NUBOCODER_BB_SIMPLE_MODULE_CREATOR_MODULES_FOLDER;
				$file_name = $folder . '/' . $module_class_name . '.php';
				
				if (file_exists($file_name)) {	
					wp_delete_file($file_name);
				}
				
			}
	}
	
	/**
	 * Displays errors in the backend
	 *
	 * @since    1.0.0
	 */
	function admin_notices() {
		if ($error_message = get_transient('nc_bb_sm_error')) {
				echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $error_message ) . '</p></div>';
				delete_transient('nc_bb_sm_error');
		}
	}
	
	/**
	 * Loads all the active custom modules
	 *
	 * @since    1.0.0
	 */
	public function load_custom_modules(){
		
		// Check if Beaver Builder is installed
		if ( ! class_exists( 'FLBuilder' ) ) {
			 return;	
		}
		 
		// Get modules from database
		$args = array(
				'post_type'              => array('nc-bb-sm'), 
				'post_status'            => array('publish'),
				'posts_per_page'         => '-1'
		);

		$modules_list = get_posts( $args );

		foreach ( $modules_list as $module ) {
			
			$module_class_name = get_post_meta( $module->ID , '_nc_bb_sm_class_name', true);	
			
			if ( !class_exists( $module_class_name )) {
				
				// Includes all the custom modules files
				if( $this->load_class_from_file( $module_class_name ) ){
					
					// Register the module with BB and includes assigns the required fields
					$module_fields = get_post_meta( $module->ID , '_nc_bb_sm_definition', true);	
					$this->load_module_fields( $module_class_name, $module_fields );
					
					// Add the filter that will render the module
					$module_template = get_post_meta( $module->ID , '_nc_bb_sm_front', true);	
					$this->front_end_filter( $module_class_name, $module_template );
						
				}
				
			}

		}

	}
	
	/**
	 * Loads the created file containing the Module's Class definition
	 *
	 * @since    1.0.0
	 * @param      string    $class_name    Required custom module
	 */ 
	function load_class_from_file( $class_name ) {
			
			$folder = NUBOCODER_BB_SIMPLE_MODULE_CREATOR_MODULES_FOLDER;
			$file_name = $folder . '/' . $class_name . '.php';
	
			// If the file exists
			if (file_exists($file_name)) {
					// We include it, this way Beaver Builder can includes it
					include_once $file_name;
					
					if (class_exists($class_name)) {
							return true;
					} else {
							return false;
					}
			} else {
					return false;
			}
	}
	
	/**
	 * Generates a file containing the new module Class definition.
	 *
	 * @since    1.0.0
	 * @param      string    $class_name    New module class name
	 * @param      array    $class_attributes    New module attributes
	 */
	function generate_class_file($class_name, $class_attributes) {
		
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			global $wp_filesystem;
			WP_Filesystem(); 
		
			$folder = NUBOCODER_BB_SIMPLE_MODULE_CREATOR_MODULES_FOLDER;
	
			if (!is_dir($folder)) {
					wp_mkdir_p( $folder );
			}
	
			$file_name = $folder . '/' . $class_name . '.php';
	
			// Builds the class content
			 $class_code = "<?php class ".$class_name." extends FLBuilderModule {\n";
			 $class_code 		.= "public function __construct() {\n";
			 $class_code			.= "parent::__construct(array(\n";
			 
			 foreach( $class_attributes as $name=>$value ){
				 $class_code				.= "'".$name."'=>'".$value."',\n";
			 }
			 
			 $class_code			.= "));\n";
			 $class_code			.= "\$this->slug='".$class_name."';\n";
			 $class_code 		.= "}\n";
			 $class_code .= "}\n";
	
			// Creates or updates the content
			$wp_filesystem->put_contents($file_name, $class_code);
	
			return true;
	}
	
	/**
	 * Makes Beaver Builder to load the new module and defines its fields
	 *
	 * @since    1.0.0
	 * @param      string    $module_class_name    New module class name
	 * @param      array    $module_fields    New module fields array
	 */
	function load_module_fields( $module_class_name, $module_fields ) {
		 
		 FLBuilder::register_module( $module_class_name , json_decode( $module_fields, true ));
		
	}
	
	/**
	 * Creates the filter that will handle the frontend part of the new module.
	 *
	 * @since    1.0.0
	 * @param      string    $module_class_name    New module class name
	 */
	function front_end_filter( $module_class_name ){
		 
		add_filter( 'fl_builder_module_frontend_custom_'.$module_class_name, function( $settings, $module ) { 
			 
			 // check the transients 
			 $cached_front_definition = get_transient( '_nc_bb_sm_front-' . $module->slug );
			 
			 // Someone might be updating the Module definition, so we keep the cache updated
			 if( is_user_logged_in() || $cached_front_definition === false ){
					$args = array(
								 'post_type'  => 'nc-bb-sm',
							 'meta_query' => array(
									 array(
											 'key' => '_nc_bb_sm_class_name',
											 'value' => $module->slug,
											 'compare' => '='
									 )
							 )
					 );
					 
					 $posts = get_posts( $args );
					 
					 if( !isset($posts[0])){
						 // translators: %s: Custom Module's Name
							return sprintf( esc_html__( 'The module %s could not be found.', 'nubocoder-beaver-builder-simple-module-creator' ), $module_class_name );
					 }else{
							 $post_id = $posts[0]->ID;
					 }
					 
					 // Gets the modules front end definition
					 $module_template = get_post_meta( $post_id , '_nc_bb_sm_front', true);	
					 
					 set_transient( '_nc_bb_sm_front-' . $module->slug, $module_template, 12 * HOUR_IN_SECONDS );
			 }
			 else{
				 $module_template = $cached_front_definition;
			 }
			 
			 if( !$module_template ){
				 // translators: %s: Custom Module's Name
				 return sprintf( esc_html__( 'The module %s doesnt have a valid Template.', 'nubocoder-beaver-builder-simple-module-creator' ), $module_class_name );
			 }
			 
			 
			 // Detects all the content inside '{}' that later will be replaced with the fields values
			 $module_template = urldecode($module_template);
			 $pattern = "/\{([^}]*)\}/";
			 $matches = array();
			 
			 preg_match_all($pattern, $module_template, $matches);
			 
			 foreach( $matches[0] as $index=>$value ){
				 
				 if( isset( $settings[ $matches[1][$index] ] ) ){
					 $module_template = str_replace( $value, $settings[ $matches[1][$index] ], $module_template );
				 }
				 
			 }
			 
			 return $module_template;
		 
		}, 10, 2);
		 
	}

}
