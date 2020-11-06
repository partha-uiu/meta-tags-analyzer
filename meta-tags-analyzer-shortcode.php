<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);
?>
<style>
.f-b {
  font-weight: bold;
}
</style>    
<div>
    <form action="?" method="POST">
        <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaKey?>"></div>
        <br/>
        <input type="submit" value="Submit">
    </form>

    <form action="" method="post">
   
         <span class="f-b "> Enter a url: </span><input type="text" name="url" value="<?php echo $url; ?>">
        <?php echo (isset($urlError))? $urlError : NULL; ?> <br/>
        <input type="submit" value="Submit" name="meta_tag_analyzer">
        
    </form>

    <h1>Hello</h1>
</div>

