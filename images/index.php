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
    include '../lib/util.php';
    $server = 'localhost';
    $uName = 'webCMS';
    $pword = 'shoopadoop';
    ini_set('display_errors',1); 
    error_reporting(E_ALL);
    $imgDir = '/var/www/html/images/imgs/';
    $thumbDir = '/var/www/html/images/thumbs/';
    createThumbs($imgDir, $thumbDir, 250);
    makeLinks($imgDir);
	?>
</body>
</html>