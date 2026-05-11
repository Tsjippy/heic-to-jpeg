<?php
namespace TSJIPPY\HEICTOJPEG;
use TSJIPPY;
use TSJIPPY\ADMIN;

use function TSJIPPY\addElement;
use function TSJIPPY\addRawHtml;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdminMenu extends ADMIN\SubAdminMenu{

    /**
     * AdminMenu constructor.
     * 
     * @param array $settings The settings for the plugin
     * @param string $name The name of the plugin
     */
    public function __construct($settings, $name){
        parent::__construct($settings, $name);
    }

    public function settings($parent){

        $label      = addElement('label', $parent, [], 'Convert .heic files attached to an e-mail to jpeg');
        
        $attributes = ['type' => 'checkbox', 'name' => 'convert-heic', 'value' => 1];

        if(isset($this->settings['convert-heic'])){
            $attributes['checked'] = 'checked';
        }

        addElement('input', $label, $attributes, '', 'afterBegin');

        return true;
    }

    public function emails($parent){

        return false;
    }

    public function data($parent=''){
    
        return false;
    }

    public function functions($parent){

        return false;
    }

}