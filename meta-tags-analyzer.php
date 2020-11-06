<?php
/**
* Plugin Name: Meta Tags Analyzer
* Plugin URI:
* Description: This is a plugin for capture the meta tags of a website
* Version: 1.0
* Author: Partha
* Author URI: 
**/
define( 'WP_DEBUG', true );

if ( ! defined( 'WPINC' ) ) {
	die;
}


//add options page
// Add user input page for name and value

add_action('admin_menu', 'meta_tag_analyzer_options_page');


function meta_tag_analyzer_options_page() {

   $add_key_option_page = add_options_page('Add key', 'Key settings', 'manage_options', 'key-settings', 'key_input_page');
   add_action( 'load-' . $add_key_option_page, 'load_admin_style' );
}

function load_admin_style() {
    wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'css/styles.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
  }

function key_input_page(){
    global $recaptchaKeyError;
    $getKey = get_option( 'recaptcha_key' );
    $recaptchaKey = $getKey ? $getKey:NULL;

    echo <<<HTML
    <h3>Please enter the Data Key for recaptcha</h3>

    <div class="container">
        <form action="" method="post">
            <label for="data-key">Data Key</label>
            <input type="text" id="data-key" name="key" value='{$recaptchaKey}' placeholder="Data Key . . .">
            {$recaptchaKeyError}
            <input type="submit" value="Save">
           
        </form>
    </div>
HTML;
}


add_action('admin_init', 'captcha_key_validation');

//End user input page
function captcha_key_validation(){
    global $recaptchaKeyError;
   
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
    add_option( 'recaptcha_key', $recaptchaKey, '', 'yes' ); 
   }
}



function meta_tags_analyzer_enqueue_scripts(){

    wp_register_script ( 'recaptcha-js', 'https://www.google.com/recaptcha/api.js');

}

function meta_tags_analyzer() {

    include dirname( __FILE__ ) . '/meta-tags-analyzer-shortcode.php';
    wp_enqueue_script('recaptcha-js');

} 

add_shortcode( 'meta_tags_analyzer', 'meta_tags_analyzer');


function url_validation(){

    global  $urlError;

    if(!isset($_POST['meta_tag_analyzer'])){
        return;
    }

    if (isset($_POST['url'])) {
        if (empty($_POST['url'])) {
            $urlError = 'Please enter your url';
        } 
        else {
            $url = $_POST['url'];
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $urlError = 'Invalid URL';
            
            }    
        }
    }

    if(isset($urlError)){
        $urlError = "<span class=\"text-danger\">$urlError</span>";
        return;
    } else{
        $urlError ='';
    }

    $url = $_POST['url'];
    $tags = get_meta_tags($url);
    
    echo "<table>";
    echo "<tr >";
    echo "<th  style=\"text-align: center;\"  colspan=\"2\">Meta tags of:  <span class=\"text-muted\"> $url</span> </th>";
    echo "</tr>";
    echo "<tr>";
    echo "<th>Meta</th>";
    echo "<th>Description</th>";
    echo "</tr>";

    foreach($tags as $key => $value) {
        echo "<tr>";
        echo "<td>".$key."</td>";
        echo "<td>".$value."</td>";
        echo "</tr>";
      }

    echo "</table>";

}

add_action('template_redirect', 'url_validation');