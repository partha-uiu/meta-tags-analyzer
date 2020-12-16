<?php
/**
* Plugin Name: Meta Tags Analyzer
* Plugin URI:
* Description: Display all the meta tags of a website
* Version: 1.0
* Author: Partha
* Author URI: 
**/

if ( ! defined( 'WPINC' ) ) {
	die;
}


//add options page
// Add user input page for recaptcha key

add_action('admin_menu', 'meta_tag_analyzer_options_page');


function meta_tag_analyzer_options_page() {

   $add_key_option_page = add_options_page('Add key', 'Key settings', 'manage_options', 'key-settings', 'key_input_page');
   add_action( 'load-' . $add_key_option_page, 'load_admin_style' );
}

function load_admin_style() {
    wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'css/styles.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}


function meta_tags_analyzer_scripts_and_styles(){

    wp_register_script ( 'recaptcha-btn', plugins_url ('js/recaptcha-btn.js', __FILE__ ),array('jquery'));
    wp_enqueue_script('recaptcha-btn');

    wp_register_style( 'custom-css', plugins_url ( 'css/custom-style.css', __FILE__ ));
    wp_enqueue_style( 'custom-css' );
}

add_action('wp_enqueue_scripts','meta_tags_analyzer_scripts_and_styles');

function key_input_page(){
    global $recaptchaKeyError;
    $getKey = get_option( 'recaptcha_key' );
    $recaptchaKey = $getKey ? $getKey:NULL;

    echo <<<HTML
    <h3>Please enter the Data Key for recaptcha</h3>

    <div class="mt-container">
        <form action="" method="post">
            <label for="data-key">Data Key</label>
            <input class="mt-text" type="text" id="data-key" name="key" value='{$recaptchaKey}' placeholder="Data Key . . .">
            {$recaptchaKeyError}
            <input class="mt-submit" type="submit" value="Save" name="save_settings">
           
        </form>
    </div>
HTML;
}


add_action('admin_init', 'captcha_key_validation');

//End user input page
function captcha_key_validation(){
    global $recaptchaKeyError;
    if(isset($_POST['save_settings'])){

        if (isset($_POST['key'])) {
            if(empty($_POST['key'])) {
                    $recaptchaKeyError = 'Recaptcha Key name must be filled';
            }
        }

        if(isset($recaptchaKeyError)){
            $recaptchaKeyError = "<span class=\"text-danger\">$recaptchaKeyError</span>";
        }

        if(isset($recaptchaKeyError)){
            return;
        }

        $recaptchaKey = $_POST['key'];
        $checkExistingKey = get_option('recaptcha_key');
        

        if($checkExistingKey) {
            update_option( 'recaptcha_key', $recaptchaKey );
        }else {
            add_option( 'recaptcha_key', $recaptchaKey ); 
        }
    } 
}


add_action( 'wp_enqueue_scripts', 'meta_tags_analyzer_enqueue_scripts' );

function meta_tags_analyzer_enqueue_scripts(){

    wp_register_script ( 'recaptcha-js', 'https://www.google.com/recaptcha/api.js');

}

function meta_tags_analyzer() {

    include dirname( __FILE__ ) . '/meta-tags-analyzer-shortcode.php';
    wp_enqueue_script('recaptcha-js');
    wp_enqueue_style( 'custom-css' );
} 

add_shortcode( 'meta_tags_analyzer', 'meta_tags_analyzer');


function url_validation(){

    global  $urlError ;

    if (isset($_POST['url'])) {
        
        if (empty($_POST['url'])) {
            $urlError = 'Please provide an url ! ';
            
        } 
        elseif (filter_var($_POST['url'], FILTER_VALIDATE_URL)===false) {
            $urlError = 'Please provide a valid url !';
            
        }  
    }

    if(isset($urlError)){
        $urlError = "<span  style=\"margin-left: 120px;
        font-weight: 600;\" class=\"mt-text-danger\">$urlError</span>";
        return;
    } 

}



add_action('template_redirect', 'url_validation');
