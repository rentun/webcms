<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gallariez</title>
    <link rel="stylesheet" type="text/css" href="tinybox.css" />

    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="/tinybox.js"></script>
</head>
<body>

<?php
    echo $_SERVER['SERVER_SOFTWARE'];
    include '../lib/util.php';
    $server = 'localhost';

    $uName = 'webCMS';
    $pword = 'shoopadoop';
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    $imgDir = 'images/imgs/';
    $thumbDir = 'images/thumbs/';
    $db = connectToDB($server, $uName, $pword);
    createThumbs($imgDir, $thumbDir, 250, $db);
    makeLinks($imgDir);
	?> 

</body>
</html>