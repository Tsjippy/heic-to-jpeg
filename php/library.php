<?php

namespace TSJIPPY\HEICTOJPEG;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

add_filter('tsjippy-library-accepted-files', __NAMESPACE__ . '\addAcceptedFiles');
/**
 * Add support for .heic and .heif files in the media library.
 *
 * @param string $files The original accepted file types.
 *
 * @return string The modified accepted file types including .heic and .heif.
 */
function addAcceptedFiles($files)
{
    return $files . ', image/heic, image/heif';
}
