<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);
?>
<div>
    <form action="?" method="POST">
        <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaKey?>"></div>
        <br/>
        <input type="submit" value="Submit">
    </form>

    <form action="" method="post">
    <?php echo (isset($urlError))? $urlError : NULL; ?>
        Enter a url: <input type="text" name="url" value="<?php echo $url; ?>">
        
        <input type="submit" value="Submit" name="meta_tag_analyzer">
        
    </form>

    <h1>Hello</h1>
</div>

