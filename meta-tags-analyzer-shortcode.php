<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);
$recaptchaKey = get_option( 'recaptcha_key' );
?>
    
<div>
    <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaKey;?>" data-callback="enableSubmitBtn"></div>
    <br/>
    <form class="mb-mt-10 mt-url-from" action="" method="post">
        <span class="f-b "> Enter an url: </span>
        <input class="mt-text" type="text" name="url">
        <br />
        <?php echo (isset($urlError) &&  isset($_POST['url']))? $urlError : NULL; ?> <br/>
        <input type="submit" class="mt-btn mt-disable-btn" id="submitUrl" value="Submit" name="meta_tag_analyzer"  disabled="disabled">
    </form >

    <?Php 
     if(isset($_POST['meta_tag_analyzer'])){

        global  $urlError;
    
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
        if(empty($url)){
            return;
        }
        $tags = get_meta_tags($url);
        
        echo "<table class=\"mt-tag-table\">";
        echo "<tr >";
        echo "<th  class=\"text-center\" colspan=\"2\">Meta tags of:  <span class=\"text-muted\" > $url</span> </th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th class=\"mt-w-140\">Meta</th>";
        echo "<th class=\"mt-w-140\">Description</th>";
        echo "</tr>";
    
        foreach($tags as $key => $value) {
            echo "<tr>";
            echo "<td>".$key."</td>";
            echo "<td>".$value."</td>";
            echo "</tr>";
        }
    
        echo "</table>";
     } 
     ?>
</div>

