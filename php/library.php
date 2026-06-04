<?php

namespace TSJIPPY\HEICTOJPEG;

use TSJIPPY;

if (! defined('ABSPATH')) {
    exit;
}

add_filter('tsjippy-library-accepted-files', __NAMESPACE__ . '\addAcceptedFiles');
function addAcceptedFiles($files)
{
    return $files . ', image/heic, image/heif';
}
