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
    $newImagePath = 'newImgs/';
    $imagePath = 'imgs/';
    $thumbPath = 'thumbs/';
    $uName = 'webCMS';
    $pword = 'shoopadoop';
    $thumbHeight = 250;



    
    $db = connectToDB($server, $uName, $pword);

    if (checkForNewImages($newImageDir))
    {
        handleNewImages($newImageDir, $imageDir, $thumbDir, $thumbHeight, $db);
    }
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    echo getPathsFromDB($db)[0];
  //  makeLinks($db);
	?> 

</body>
</html>