<?php



class SpeakolSettings
{
    
    private $menu;
    public static $displaysIn = array(
        'posts' => 1,
        'pages' => 2,
        'both' => 3,
        'none' => 4, 
    );
    static function getInstance()
    {
        static $instance = null;
        if(null === $instance) {
            $instance =  new static();
        }

        return $instance;
    }

    protected function __construct()
    {
        $this->registerSettings();
        $this->registerMenu();
    }

    public function registerMenu() {
        add_action('admin_menu', array($this, 'createMenu'));
        add_action('admin_enqueue_scripts', array($this, 'addAssets'));
        add_action('admin_notices', array($this, 'showErrors'));
    }


    public function renderMenuPage() { 
        require_once(__DIR__ . '/../views/settings.php');
    }

    public function showErrors() {
        settings_errors('speakol');
    }


    public function registerSettings() {
        add_action('admin_init', array($this, 'addSettings'));
    }

    public function addAssets() {
        wp_enqueue_style('speakol-style', plugins_url('../css/grid.css', __FILE__));
        wp_enqueue_script('speakol-script', plugins_url('../js/main.js', __FILE__), array('jquery'));
    }

    public function createMenu() {
        $this->menu = add_menu_page('Speakol', 'Speakol', 'manage_options', 'speakol' , array($this, 'renderMenuPage'), plugins_url('../img/logo.png', __FILE__));
    }

    public function addSettings() {
        register_setting('speakol', 'speakol_argbox_status');
        register_setting('speakol', 'speakol_app_id', array($this, 'appIdValidation'));
        register_setting('speakol', 'speakol_box_width', array($this, 'boxWidthValidation'));
        register_setting('speakol', 'speakol_displays_in', array($this, 'displaysInValidation'));
        register_setting('speakol', 'speakol_lang', array($this, 'langValidation'));
        register_setting('speakol', 'speakol_title');
        register_setting('speakol', 'speakol_no_title', array($this, 'noTitleValidation'));
        add_settings_section('speakol_settings_section', '', '', 'speakol');
        add_settings_field('speakol_argbox_status', 'Argument Box Status' , array($this, 'addArgBoxStatus'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_app_id', 'Publisher ID', array($this, 'addAppId'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_box_width', 'Box Width(Optional)' , array($this, 'addBoxWidth'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_displays_in', 'Displays In' , array($this, 'addDisplaysIn'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_title', 'Title' , array($this, 'addTitle'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_no_title', 'No Title' , array($this, 'addNoTitle'), 'speakol', 'speakol_settings_section');
        add_settings_field('speakol_lang', 'Language' , array($this, 'addLang'), 'speakol', 'speakol_settings_section');
    }

    public function addArgBoxStatus() {
        $argbox_status = get_option('speakol_argbox_status', 0);
        require_once(__DIR__ . '/../views/argboxstatus.php');
    }


    public function addBoxWidth() {
        $box_width = get_option('speakol_box_width' ,'');
        $readonly = (!$this->isArgBoxStatusEnabled()) ? 'readonly' : '';
        echo '<input id="box_width" type="text" name="speakol_box_width" value="'. $box_width . '"' . $readonly . ' >';
    }


    public function addAppId() {
        $app_id = get_option('speakol_app_id', '');
        $readonly = (!$this->isArgBoxStatusEnabled()) ? 'readonly' : '';
        echo '<input id="app_id" type="text" name="speakol_app_id" value="'. $app_id . '"' . $readonly . ' >';
        echo '<p class="description"> You\'ll find your Publisher ID in the Settings page in your dashboard</p>';
    }

    public function addDisplaysIn() {
        $displays_in = get_option('speakol_displays_in', '');
        $disabled = (!$this->isArgBoxStatusEnabled()) ? 'disabled' : '';
        require_once(__DIR__ . '/../views/displaysin.php');
    }


    public function addLang() {
        $lang = get_option('speakol_lang', 'en');
        $disabled = (!$this->isArgBoxStatusEnabled()) ? 'disabled' : '';
        require_once(__DIR__ . '/../views/lang.php');
    }

    public function addTitle() {
        $title = get_option('speakol_title', 'What do you Think?');
        $readonly = (!$this->isArgBoxStatusEnabled()) ? 'readonly' : '';
        echo '<input id="title" type="text" name="speakol_title" value="'. $title . '"' . $readonly . ' >';
    }

    public function addNoTitle() {
        $notitle = get_option('speakol_no_title', false);
        $checked = (checked("on", $notitle, false)) ? 'checked="checked"' : '';
        $disabled = (!$this->isArgBoxStatusEnabled()) ? 'disabled' : '';
        echo  '<input type="checkbox" id="no_title" name="speakol_no_title"' . $disabled  . $checked  .'/>';
    }

    public function noTitleValidation($input) {
        $notitle = get_option('speakol_no_title', false);
        if(!$this->isArgBoxStatusEnabled()) {
            return $notitle;
        }

        $notitle = $input; 

        return $notitle;
    }

    public function getSettings() {
        return array(
            'lang' => get_option('speakol_lang', 'en'),
            'title' => get_option('speakol_title', 'What do you think?'),
            'argbox_status' => get_option('speakol_argbox_status', 0),
            'displays_in' => get_option('speakol_displays_in', ''),
            'box_width' => get_option('speakol_box_width', '600'),
            'app_id' => get_option('speakol_app_id', ''),
            'no_title' => get_option('speakol_no_title', false),
        );
    }


    public function boxWidthValidation($input) {
        $box_width = get_option('speakol_box_width', '600');
        if(isset($input) && is_numeric($input)) {
            $box_width = $input;
        }

        return $box_width;
    }

    public function appIdValidation($input) {
        $app_id = get_option('speakol_app_id', '');
        if(!$this->isArgBoxStatusEnabled()) {
            return $app_id;
        }

        if(isset($input) && is_numeric($input)) {
            $app_id = $input;
        } else {
            add_settings_error('speakol', '', 'App ID is invalid', 'error');
        }
        return $app_id;
    }

    public function displaysInValidation($input) {
        $displays_in = get_option('speakol_displays_in', '');
        if(!$this->isArgBoxStatusEnabled()) {
            return $displays_in;
        }

        if(isset($input) && in_array($input , array_values(self::$displaysIn))) {
            $displays_in = $input;
        } else {
            add_settings_error('speakol', '', 'Displays In is invalid', 'error');
        }

        return $displays_in;

    }


    public function langValidation($input) {
        $lang = get_option('speakol_lang', 'en');
        if(!$this->isArgBoxStatusEnabled()) {
            return $lang;
        } 

        if(isset($input) && in_array($input, array('ar', 'en'))) {
            $lang = $input;
        } else {
            add_settings_error('speakol', '','Language is invalid', 'error');
        }

        return $lang;
    }

    public function titleValidation($input) {
        $title = get_option('speakol_title','What do you Think?');
        if(isset($input)) {
            $title = $input;
        } else {
            add_settings_error('speakol', '', 'Title is invalid', 'error');
        }
        return $title;
    }


    public function isArgBoxStatusEnabled() {
        $argbox_status = get_option('speakol_argbox_status', 0);
        return checked(1, $argbox_status, false);
    }


    private function __clone()
    {
        
    }


    private function __wakeup() {
        
    }


}
