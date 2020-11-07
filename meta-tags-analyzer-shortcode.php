<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);
$recaptchaKey = get_option( 'recaptcha_key' );
?>
    
<div>
    <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaKey;?>" data-callback="enableSubmitBtn"></div>
    <br/>
    <form action="" method="post">
        <span class="f-b "> Enter an url: </span><input type="text" name="url" value="<?php echo $url; ?>">
        <br />
        <?php echo (isset($urlError) &&  isset($_POST['url']))? $urlError : NULL; ?> <br/>
        <input type="submit" class="btn disable-btn" id="submitUrl" value="Submit" name="meta_tag_analyzer"  disabled="disabled">
    </form>

    <h1>Hello</h1>
</div>

