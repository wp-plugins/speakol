<select id="lang" name="" <?php echo $disabled; ?>>
    <option value="">- Select -</option>
    <option value="en"<?php echo selected($lang, "en", false); ?>>English</option>
    <option value="ar"<?php echo selected($lang, "ar", false); ?>>العربية</option>
</select>
<input type="hidden" name="speakol_lang" value="<?php echo $lang ?>">
