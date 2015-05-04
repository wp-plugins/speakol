<div class="wrap">
    <h2>Speakol: General Settings</h2>
    <form method="post"  action="options.php">
        <?php settings_fields('speakol') ?>
        <?php do_settings_sections('speakol')?>
        <?php submit_button();  ?>
    </form>
<div class="block-group speakol-info <?php echo (!$this->isArgBoxStatusEnabled()) ? 'hidden' : ''; ?>">
    <div class="block one text-center">
        <i class="dashicons dashicons-info dashicons-lg"></i>
    </div>
    <div class="block seven eleven-md eleven-sm">
        <p class="no-margin margin-bottom info-text">
        The default argument box title will appear as "What do you think?". This is used to spark a
        quick and simple debate regarding your anicle title and content. Readers will vote up or down
        and add their opinions.
        </p>
        <p class="no-margin margin-bottom info-text">
            The frame pixel width determines how wide the Argument box will be. Your Digital Manager
            can help you determine this, but please email ask@speakol.com ¡f you have any questions or
            queries
        </p>
    </div>
</div>
</div>
