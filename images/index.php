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
    ini_set('display_errors',1); 
    error_reporting(E_ALL);

        function makeFolderLinks(){

        }
        function getThumbnailName($image)
        {
            $fnamearray = explode('.', $image);
            $fnamearray[0] = $fnamearray[0].'-thumb.';
            $thumbName = implode($fnamearray);
            return $thumbName;
        }
    	function createThumbs( $pathToImages, $pathToThumbs, $thumbHeight) {
    		//open the dir
    		$dir = opendir( $pathToImages);
    		//loop through directory looking for JPGs
    		while (false !== ($fname = readdir( $dir ))) {
    			
                if(!is_dir($pathToImages.$fname))
                {
                    //parse path for the extension
    			     $info = pathinfo($pathToImages . $fname);
               
                    //continue only if this is a JPEG
        			if (strtolower($info['extension']) == 'jpg') {
        				// load image and get size
        				$img = imagecreatefromjpeg("{$pathToImages}{$fname}");
        				$width = imagesx( $img );
        				$height = imagesy( $img );


        				//calculate thumbnail size

        				$new_height= $thumbHeight;
        				$new_width = floor($width * ($thumbHeight / $height) );
        				$tmp_img = imagecreatetruecolor($new_width, $new_height );


        				//copy and resized old image into new image
        				imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                        $thumbName = getThumbnailName($fname);
         				imagejpeg( $tmp_img, "{$pathToThumbs}{$thumbName}" );
                    }
                }
    		}
    		//close directory
    		closedir( $dir );
    	}
        

    	function makeLinks($pathToImages){


			if($handle = opendir($pathToImages)) {
		    	$i = 0;
	    		while (false !== ($entry = readdir($handle))) {
    	    		if ($entry !== "." && $entry !== ".."){
                        if(is_dir($pathToImages.$entry))
                        {
                            echo "<a href=imgs\\$entry>$entry<img src=\"..\\yellow-manila-folder.png\" alt=\"Folder\"></a>";
                            $i++;
                        }
    	    		}
	            }
            }
            closedir($handle);
            if($handle = opendir($pathToImages)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry !== "." && $entry !== ".."){
                        if(!is_dir($pathToImages.$entry)){
                            $i++;   
                            $thumbName = getThumbnailName($entry);
                            echo "<img src=\"thumbs/$thumbName\" onclick=\"TINY.box.show({image:'imgs/$entry', animate:true, boxid:'frameless'})\" alt=$entry-thumbnail/>";
                        }
                    }
                }
		   
			}
            closedir($handle);
    	}
    	$imgDir = '/var/www/html/images/imgs/';
    	$thumbDir = '/var/www/html/images/thumbs/';
    	createThumbs($imgDir, $thumbDir, 250);
    	makeLinks($imgDir);
	?>
</body>
</html>