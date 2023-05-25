<?php

if (empty($_GET["action"])) {
    header('Location: /404');
    exit;
}

$sanitizedFileName = str_replace("/", "", $_GET["action"]);
$sanitizedFileName = str_replace("\\", "", $sanitizedFileName);
$sanitizedFileName = str_replace(":", "", $sanitizedFileName);
$sanitizedFileName = str_replace("$", "", $sanitizedFileName);
$sanitizedFileName = str_replace("#", "", $sanitizedFileName);
$sanitizedFileName = str_replace("*", "", $sanitizedFileName);
$sanitizedFileName = str_replace("(", "", $sanitizedFileName);
$sanitizedFileName = str_replace(")", "", $sanitizedFileName);
$sanitizedFileName = str_replace("..", "", $sanitizedFileName);

$sanitizedFileName = trim($sanitizedFileName);

if ($sanitizedFileName == "." || empty($sanitizedFileName) || substr($sanitizedFileName, 0, 1) == ".") {
    header('Location: /404');
    exit;
}

$filename = __DIR__ . '/../../uploads/' . $sanitizedFileName;

if (file_exists($filename)) {
    $fp = fopen($filename, 'rb');

    // send the right headers
    header("Content-Type: " . mime_content_type($filename) . "");
    header("Content-Length: " . filesize($filename));

    fpassthru($fp);
    exit;
}
//
else {
    header('Location: /404');
    exit;
}
