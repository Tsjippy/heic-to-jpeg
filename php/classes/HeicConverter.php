<?php

namespace TSJIPPY\HEICTOJPEG;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

class HeicConverter
{
    public function __construct()
    {
        $path   = PLUGINPATH  . 'lib/vendor/maestroerror/php-heic-to-jpg/bin/heicToJpg';
        if (!is_executable($path)) {
            chmod($path, 0555);
        }
    }

    /**
     * Converts heic images to jpg. Stores the jpg to a file for future use as the conversion is quite slow
     *
     * @param   string  $path       The path or url to the file
     * @param   string  $dest       The path to the destination file. If left empty it will echo the image to the screen
     *
     * @return  boolean|string      Whether the conversion was succesfull or if destination is empty the image blob(url)
     */
    public function convert($path, $dest = '')
    {
        $path   = TSJIPPY\urlToPath($path);

        if (!is_file($path) || !\Maestroerror\HeicToJpg::isHeic($path)) {
            return false;
        }

        // We should print it to the screen
        if (empty($dest)) {
            $ext        = pathinfo($path, PATHINFO_EXTENSION);
            $checkPath  = str_replace(" .$ext", ' .jpeg', $path);

            if (file_exists($checkPath)) {
                // Get existing file data
                $jpg = file_get_contents($checkPath);
            } else {
                try {
                    // convert to jpeg
                    $jpg    = \Maestroerror\HeicToJpg::convert($path)->get();
                } catch (\Exception $e) {
                    TSJIPPY\printArray($e->getMessage());
                    return False;
                }

                $size   = getimagesizefromstring($jpg);

                // reduce size, as we do not need super big images
                if ($size[0] > 1024 || $size[1] > 1024) {
                    //store the jpeg so that we dont have to reduce again next time
                    $img        = imagecreatefromstring($jpg);
                    $imgResized = imagescale($img, 1024);

                    // Store the file
                    imagejpeg($imgResized, $checkPath);

                    $jpg = file_get_contents($checkPath);
                } else {
                    // store as file
                    $img = imagecreatefromstring($jpg);
                    imagejpeg($img, $checkPath);
                }
            }

            $base64 = base64_encode($jpg);

            return "data:image/jpeg;base64, $base64";
        } else {
            if (file_exists($dest)) {
                return True;
            }

            try {
                return \Maestroerror\HeicToJpg::convert($path)->saveAs($dest);
            } catch (\Exception $e) {
                TSJIPPY\printArray($e->getMessage());
                return False;
            }
        }
    }
}
