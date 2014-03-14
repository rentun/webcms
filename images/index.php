<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Gallariez</title>
    <link rel="stylesheet" type="text/css" href="tinybox.css" />
    <div class="topbar"></div>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="/tinybox.js"></script>
</head>
<body>
    <div id="gallery">
        <?php

            include '../lib/util.php';
            include '../conf/config.php';
            $server = 'localhost';
            $newImagePath = 'newImgs/';
            $imagePath = 'imgs/';
            $thumbPath = 'thumbs/';
            $uName = 'webCMS';
            $pword = 'shoopadoop';
            $thumbHeight = 250;
            if (!($db = connectToDB($config['server'], $config['uName'], $config['pword'] ))){
                echo "Database error at line ", __LINE__;
            }
            if (checkForNewImages($newImagePath))
            {
                handleNewImages($config['newImagePath'], $config['imagePath'], $config['thumbPath'], $config['thumbHeight'], $db);
            }
            ini_set('display_errors',1); 
            error_reporting(E_ALL);
            printLinks($db);
            $db->close();
        ?> 
    </div>
</body>
</html>