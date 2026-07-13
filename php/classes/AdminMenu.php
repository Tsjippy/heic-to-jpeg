<?php

namespace TSJIPPY\HEICTOJPEG;

use TSJIPPY;
use TSJIPPY\ADMIN;

use function TSJIPPY\addElement;
use function TSJIPPY\addRawHtml;

if (! defined('ABSPATH')) {
    exit;
}

class AdminMenu extends ADMIN\SubAdminMenu
{

    /**
     * AdminMenu constructor.
     *
     * @param array $settings The settings for the plugin
     * @param string $name The name of the plugin
     */
    public function __construct($settings, $name)
    {
        parent::__construct($settings, $name);
    }

    /**
     * Add the settings page to the admin menu
     *
     * @param \DOMElement $parent The parent menu slug
     * 
     * @return bool True if the settings page was added, false otherwise
     */
    public function settings($parent)
    {

        $label      = addElement('label', $parent, [], 'Convert .heic files attached to an e-mail to jpeg');

        $attributes = ['type' => 'checkbox', 'name' => 'convert-heic', 'value' => 1];

        if (isset($this->settings['convert-heic'])) {
            $attributes['checked'] = 'checked';
        }

        addElement('input', $label, $attributes, '', 'afterBegin');

        return true;
    }

    /**
     * Render the emails settings page for the plugin.
     *
     * @param string $parent The parent element to which the email settings will be added.
     *
     * @return bool Returns false as this plugin does not have email settings.
     */
    public function emails($parent)
    {

        return false;
    }

    /**
     * Render the data settings page for the plugin.
     *
     * @param string $parent The parent element to which the data settings will be added.
     *
     * @return bool Returns false as this plugin does not have data settings.
     */
    public function data($parent = '')
    {

        return false;
    }

    /**
     * Render the functions settings page for the plugin.
     *
     * @param string $parent The parent element to which the functions settings will be added.
     *
     * @return bool Returns false as this plugin does not have functions settings.
     */
    public function functions($parent)
    {

        return false;
    }
}
