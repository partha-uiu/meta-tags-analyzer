<?php
/**
* Plugin Name: Meta Tags Analyzer
* Plugin URI:
* Description: This is a plugin for capture the meta tags of a website
* Version: 1.0
* Author: Partha
* Author URI: 
**/



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
    }
    $url = $_POST['url'];
    $tags = get_meta_tags($url);
    
    echo "<table>";
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