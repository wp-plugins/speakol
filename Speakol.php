<?php

/**
* Plugin Name: Speakol
* Plugin URI: 
* Description: Speakol helps you build your own community and drive up engagement around your content.
* Author: infraLayer
* Author URI: http://www.infralayer.com/
* Version: 1.4 
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(__DIR__ . '/classes/SpeakolSettings.php');


class Speakol
{
    private $settings;
    static function getInstance()
    {
        static $instance = null;
        if(null === $instance) {
            $instance =  new static();
        }

        return $instance;
    }


    public function init() {
        $this->settings = SpeakolSettings::getInstance();
        add_action('init', array($this, 'registerShortcode'));
        add_filter('the_content', array($this, 'addSpeakol'));
    }


    public function registerShortcode() {
        add_shortcode('speakol-argbox', array($this, 'shortcodeFunction'));
    }

    public function shortcodeFunction($attrs) {
        $settings = $this->settings->getSettings();
        extract(shortcode_atts(array(
            'lang' => $settings['lang'],
            'width' => $settings['box_width'],
            'title' => $settings['title'],
            'notitle' => ( $settings['no_title'] === 'on' ) ? 'true' : 'false',
        ), $attrs));

        $shortcode = "";
        require_once(__DIR__ . '/views/argumentsbox.php');
        return $shortcode;
    }


    public function addSpeakol($content) {
        $settings = $this->settings->getSettings();
        $displaysIn = SpeakolSettings::$displaysIn;
        $pageCondiditon = selected($displaysIn['pages'], $settings['displays_in'], false ) && is_page();
        $postCondiditon = selected($displaysIn['posts'], $settings['displays_in'], false) && is_single();
        $bothCondiditon = selected($displaysIn['both'], $settings['displays_in'], false) && (is_single() || is_page());
        if ($settings['app_id'] && (checked(1, $settings['argbox_status'], false)) && ($pageCondiditon || $postCondiditon || $bothCondiditon)) {
            $shortcode = do_shortcode('[speakol-argbox]');
            $content  = $content . $shortcode;       
        }
        return $content;
    }

    protected function __construct()
    {
        
    }


    private function __clone()
    {
        
    }


    private function __wakeup() {
        
    }
}

$speakol = Speakol::getInstance();

$speakol->init();

