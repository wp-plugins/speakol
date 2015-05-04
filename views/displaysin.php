<select id="displays_in" name="" <?php echo $disabled; ?>>
    <option value="">- Select -</option>
    <option value="1"<?php echo selected($displays_in, 1, false); ?>>in all posts</option>
    <option value="2"<?php echo selected($displays_in, 2, false); ?>>in all pages</option>
    <option value="3"<?php echo selected($displays_in, 3, false); ?>>in all pages and posts</option>
    <option value="4"<?php echo selected($displays_in, 4, false); ?>>none</option>
</select>
<input type="hidden" name="speakol_displays_in" value="<?php echo $displays_in ?>">
<p class="description speakol-info <?php echo (!$this->isArgBoxStatusEnabled()) ? 'hidden' : ''?>">
    if you want to manually insert the argument box, please use this short code.
</p>
<br>
<input id="speakol_shortcode" type="text" name="" value="[speakol-argbox]" <?php echo (!$this->isArgBoxStatusEnabled()) ? 'class="hidden"' : ''; ?>>
