<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);

?>
<div>
    <strong>Are you a robot ? </strong>
    <form action="?" method="POST" >
        <div class="g-recaptcha" data-sitekey="6Ld57MMUAAAAAGe87D3ZQhr10-ITDSJ0CTKxTNE2"></div>
        <br/>
    </form>

    <form action="" method="post" onsubmit="checkCaptcha(event)">
        <strong>Enter an url:</strong> <input type="text" name="url" value="<?php echo $url; ?>">
        <input type="submit" value="Submit" name="meta_tag_analyzer">
        <?php  echo $urlError; ?>
    </form>

</div>

  <script type="text/javascript">

    function checkCaptcha(event){
      if(document.querySelector("#g-recaptcha-response").value ===''){
        event.preventDefault();
        alert("Please check the recaptcha");
      }
    }
</script>
