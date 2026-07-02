<?php

namespace TSJIPPY\HEICTOJPEG;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

// convert heic attachments to jpg
add_filter('wp_mail', __NAMESPACE__ . '\wpMail', 10, 1);
/**
 * Convert .heic attachments in emails to .jpg format.
 *
 * @param array $args The arguments for the wp_mail function, including attachments.
 *
 * @return array The modified arguments with .heic attachments converted to .jpg.
 */
function wpMail($args)
{
    if(is_array($args['attachments'])){
        foreach ($args['attachments'] as &$attach) {
            $ext        = pathinfo($attach, PATHINFO_EXTENSION);

            if ($ext == 'heic') {
                global $heicConverter;

                // only instantiate this class once to speed up
                if (!isset($heicConverter)) {
                    $heicConverter = new HeicConverter();
                }

                $dest   = str_replace($ext, 'jpg', $attach);

                // Convert the heic image
                if ($heicConverter->convert($attach, $dest)) {
                    $attach = $dest;
                }
            }
        }
    }

    return $args;
}

// remove picture again
add_action('wp_mail_succeeded', __NAMESPACE__ . '\removeJpg');

add_action('wp_mail_failed', __NAMESPACE__ . '\removeJpg');

/**
 * Remove .jpg attachments that were created from .heic files after the email is sent.
 *
 * @param array $mailData The data of the sent email, including attachments.
 *
 * @return void
 */
function removeJpg($mailData)
{
    if (is_array($mailData) && !empty($mailData['attachments'])) {
        // loop over all the attachments
        foreach ($mailData['attachments'] as $attachment) {
            $ext        = pathinfo($attachment, PATHINFO_EXTENSION);
            if ($ext == 'jpg') {
                $heicPath   = str_replace($ext, 'heic', $attachment);

                // a heic path of this image exists
                if (file_exists($heicPath)) {
                    // remove the jpg file
                    wp_delete_file($attachment);
                }
            }
        }
    }
}
