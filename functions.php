<?php
require_once 'vendor/autoload.php';

function scanDirectory($target) : array
{
    $htmlFiles = [];
    foreach (array_merge(glob($target . '/*', GLOB_ONLYDIR), glob($target . '/*.html')) as $item) {
        if (is_dir($item))
        {
            $htmlFiles = array_merge($htmlFiles, scanDirectory($item));
        }
        else
        {
            $htmlFiles[] = $item;
        }
    }

    return $htmlFiles;
}

function custom_copy($src, $dst)
{

    $dir = opendir($src);
    @mkdir($dst);

    while( $file = readdir($dir) ) {

        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) )
            {
                custom_copy($src . '/' . $file, $dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }

    closedir($dir);
}