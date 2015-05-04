<?php ob_start() ?>
<?php if($settings['app_id']) {  ?>
    <div class="speakol-arguments-box" data-app="<?php echo $settings['app_id']; ?>" data-width="<?php echo $width; ?>" data-lang="<?php echo $lang;  ?>" 
    <?php if($notitle === "true") { ?>
        data-no-title="true"></div>
    <?php } else { ?>
        data-title="<?php echo $title; ?>"></div>
    <?php } ?>
    <script>
    (function(doc, sc, id) {   
       var js, sjs = document.getElementsByTagName(sc)[0];
       if(doc.getElementById(id)) return;
       js = document.createElement(sc);
       js.src = 'http://plugins.speakol.com/js/sdk.js'; js.id=id;
       sjs.parentNode.insertBefore(js, sjs);
    })(document, 'script', 'speakol-sdk');
    </script>
<?php }  ?>
<?php $shortcode = ob_get_clean(); ?>
