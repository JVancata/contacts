<?php
if (empty($seo)) {
    $seo = new SEO();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seo->title; ?></title>
    <link rel="icon" type="image/png" href="<?php echo $seo->favicon; ?>">
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <link rel="stylesheet" href="/resources/css/font_awesome_all.min.css">
</head>

<body class="pb-5">
    <?php
    require 'header.php';
    ?>