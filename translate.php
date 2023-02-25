<?php
require_once 'functions.php';
$source = $argv[1] ?? die('Error: Please Enter Source Directory');
$sourceLang = $argv[2] ?? die('Error: Please Enter Source Language');
$target = $argv[3] ?? die('Error: Please Enter Target Directory');
$targetLang = $argv[3] ?? die('Error: Please Enter Target Language');

custom_copy($source, $target);
$htmlFiles = scanDirectory($target);

foreach ($htmlFiles as $file)
{
    echo $file . 'is translated';
    $html = file_get_contents($file);

    $contents =  mb_str_split($html, 99999);
    $translates = [];

    $translate = new Google\Cloud\Translate\V2\TranslateClient([
        'key' => 'AIzaSyDeQwsUhVyL8n484MVY0ioaHAOwigppVB0',
    ]);

    foreach ($contents as $content)
    {
        $result = $translate->translate($content, [
            'format' => 'html',
            'source' => $sourceLang,
            'target' => $targetLang,
        ]);

        $translates[] = $result['text'];
    }


    $newHtml = str_replace($html, $result['text'], $html);

    file_put_contents($file, implode('', $translates));
}

echo 'All files translated total :' . count($htmlFiles);