<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);

?>
<div>
    <form action="?" method="POST">
        <div class="g-recaptcha" data-sitekey="6Ld57MMUAAAAAGe87D3ZQhr10-ITDSJ0CTKxTNE2"></div>
        <br/>
        <input type="submit" value="Submit">
    </form>

    <form action="" method="post">
        Enter a url: <input type="text" name="url" value="<?php echo $url; ?>">
        <input type="submit" value="Submit" name="meta_tag_analyzer">
        <?php  echo $urlError; ?>
    </form>

</div>


i