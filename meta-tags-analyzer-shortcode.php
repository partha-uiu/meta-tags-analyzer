<?php 
global $urlError;
$url = isset($_POST['url']) ? $_POST['url']  : (isset($url) ? $url : NULL);
if(isset($urlError)){
    $urlError = $urlError;
} else{
    $urlError = NULL;
}
$recaptchaKey = get_option( 'recaptcha_key' );
?>
    
<div>
    <br/>
    <form class="mb-mt-10 mt-url-from form-url-pl-6" action="" method="post">
        <div class="form-group">
            <div class="form-group mta-form-content-div">
                <label for="basic-url" class="mt-pl-150">Enter an url</label>
                <div class="mta-input-group">
                    <div class="mta-input-group-icon mta-input-icon-backgorund"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-link-45deg" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.715 6.542L3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.001 1.001 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 0 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 0 0-4.243-4.243L6.586 4.672z"/>
                                </svg></div>
                    <div class="mta-input-group-area"><input type="url" name="url" class="form-control" id="url" aria-describedby="url" placeholder="Enter url..."></div>
                   

                </div>
                <?php echo $urlError;?><br/>
                <div class="g-recaptcha rc-div" data-sitekey="<?php echo $recaptchaKey;?>" data-callback="enableSubmitBtn"></div>

            </div>    
        </div>

        <input type="submit" class="mt-btn mt-disable-btn" id="submitUrl" value="Analyze Meta Tags" name="meta_tag_analyzer"  disabled="disabled">
    </form >

<?php 
    if(isset($_POST['url'])){
        $url = $_POST['url'];
        if(empty($url) ||  isset($urlError)){
            return;
        }
        $tags = get_meta_tags($url);
        preg_match("/<title>(.+)<\/title>/siU", file_get_contents($url), $matches);
        $title = $matches[1];
        echo "<table class=\"table table-striped meta-table\">";
        echo "<tr class=\"th-color-meta\" >";
        echo "<th  class=\"text-center\" colspan=\"2\">Meta tag analysis for <span> $url</span> </th>";
        echo "</tr>";
        echo "<tr class=\"mt-text-center\">";
        echo "<th>Meta Name</th>";
        echo "<th>Meta Value</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"f-w-bold\">Title</td>";
        echo "<td>".$title."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=\"f-w-bold\">Description</td>";
        echo "<td>".$tags["description"]."</td>";
        echo "</tr>";
        foreach($tags as $key => $value) {
            
                echo "<tr>";
                echo "<td class=\"f-w-bold\">".$key."</td>";
                echo "<td>".$value."</td>";
                echo "</tr>";
            
        }    
    echo "</table>";
    }?>
</div>

