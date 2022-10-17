<?php

/**
 * Plugin Name:       Custom Plugin
 * Plugin URI:        https://localhost/wordpress/new.com/
 * * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tahsin Tasnia
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) { //constant variable, security check
    die;
}

//function hello_world_function( $atts = [], $content = null) {
// do something to $content
// always return
//return $content;
//  return "<h1>Hello Samadhan solutions</h1>";

//}
/**
 * /**
 * The [wporg] shortcode.
 *
 * Accepts a title and will display a box.
 *
 * @param array $atts Shortcode attributes. Default empty.
 * @param string $content Shortcode content. Default null.
 * @param string $tag Shortcode tag (name). Default empty.
 * @return string Shortcode output.
 */

define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define("PLUGIN_URL",plugins_url());


add_action('admin_menu','add_custom_menu');
function add_custom_menu(){
add_menu_page( 'CustomPlugin',
    'Custom Plugin Menu',
    'manage_options',
    'custom_plugin',
    'custom_plugin_function',
    'dashicons-share-alt',
    9
);
    add_submenu_page( 'custom_plugin',
    'Add New',
    'Add New',
    'manage_options',
    'submenu',
     'submenu_function',
     );
}
function custom_plugin_function(){
    include_once PLUGIN_DIR_PATH.'/views/add-new.php';
}
function submenu_function(){
    include_once PLUGIN_DIR_PATH.'/views/all-page.php';
}

function custom_plugin_assets() {
    wp_enqueue_style( 'style', PLUGIN_URL."/plugin1/assets/css/style.css", '','1.0' );
}

add_action( 'admin_enqueue_scripts', 'custom_plugin_assets' );

class NewPlugin{
    function __construct(){


    }
    protected function custom_post(){
        add_action('init',array($this,'custom_post_type')  );
    }

    function register(){
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
    }
    function activate(){
        flush_rewrite_rules();

    }
    function deactivate(){

    }
    function uninstall(){

    }
    function custom_post_type(){
        register_post_type('book',['public'=>true,'label'=>'Books']);
    }


    function enqueue(){
        wp_enqueue_style('mypluginstyle',plugins_url('/assets/css/style.css',__FILE__));
        wp_enqueue_script('mypluginscript',plugins_url('/assets/js/myscript.js',__FILE__));
    }
}
class Secondclass extends NewPlugin{
    function register_post(){
        $this->custom_post();
    }

}
$newplugin= new NewPlugin();
$newplugin->register();
$secondclass=new Secondclass();
$secondclass->register_post();
register_activation_hook(__FILE__,array($newplugin,'activate'));