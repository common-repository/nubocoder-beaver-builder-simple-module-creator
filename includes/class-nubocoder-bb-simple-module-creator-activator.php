<?php

/**
 * Fired during plugin activation
 *
 * @link       https://nubocoder.com
 * @since      1.0.0
 *
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Nubocoder_Bb_Simple_Module_Creator
 * @subpackage Nubocoder_Bb_Simple_Module_Creator/includes
 * @author     César Siancas <zed.1985@gmail.com>
 */
class Nubocoder_Bb_Simple_Module_Creator_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    
    $example_module_class_name = 'NC_BB_SM_Example_Module';
    
    $args = array(
                 'post_type'  => 'nc-bb-sm',
             'meta_query' => array(
                     array(
                             'key' => '_nc_bb_sm_class_name',
                             'value' => $example_module_class_name,
                             'compare' => '='
                     )
             )
     );
     
     $posts = get_posts( $args );
     
     if( isset($posts[0])){
        return;
     }
    
    $module_definition = file_get_contents( plugin_dir_path( dirname( __FILE__ ) ) . '/includes/example-definition.js');
    $module_front = file_get_contents( plugin_dir_path( dirname( __FILE__ ) ). '/includes/example-front.html');
    
    $post_arr = array(
      'post_title'   => 'NuboCoder BB Example Module',
      'post_type'     => 'nc-bb-sm',
      'post_status'  => 'publish',
      'post_author'  => get_current_user_id(),
      'meta_input'   => array(
        '_nc_bb_sm_class_name' => 'NC_BB_SM_Example_Module',
        '_nc_bb_sm_definition' => $module_definition,
        '_nc_bb_sm_front' => $module_front,
      ),
    );
    
    $post_id = wp_insert_post( $post_arr );  
    
    if( $post_id ){
        
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        global $wp_filesystem;
        WP_Filesystem(); 
        
        $folder = NUBOCODER_BB_SIMPLE_MODULE_CREATOR_MODULES_FOLDER;
        $file_name = $folder . '/NC_BB_SM_Example_Module.php';    
        
        if (!is_dir($folder)) {
            wp_mkdir_p( $folder );
        }else{
            error_log(print_r($folder, true));	
        }
        
        $class_code = "
            <?php class NC_BB_SM_Example_Module extends FLBuilderModule {
            public function __construct() {
            parent::__construct(array(
            'name'=>'NuboCoder BB Example Module',
            'description'=>'BB Custom Module',
            'category'=>'NuboCoder Simple Module Creator',
            ));
            \$this->slug='NC_BB_SM_Example_Module';
            }
            }
        ";
        
        $wp_filesystem->put_contents($file_name, $class_code);
    }
    
	}

}
