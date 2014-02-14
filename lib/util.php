<?php

   function connectToDB($dbServer, $userName, $password){
        $db = new mysqli($dbServer, $userName, $password, 'images');
        //catch(exception $e)
        //{
        //    echo 'Database Error: ',  $e->getMessage(), "\n";
        //    return;
        //}
        return $db;
    }
    function checkForNewImages($newImagePath){
        $dir = opendir($newImagePath);
    	if (false == ($fname = readdir( $dir ))){
    		return 0;
    	}
    	else{
    		return 1;
    	}
        closeDir($dir);
    }
    function handleNewImages($newImagePath, $imagePath, $thumbPath, $thumbHeight, $db){

         $imageDir = opendir($imagePath);
         $newImageDir = opendir($newImagePath);
    	while (false !== ($fname = readdir( $unhandledImageDir ))) {
    		$fullFname = $prodImageDir.$fname;
    		rename($unhandledImageDir.$fname, $fullFname);
    		$db->mysqli_query("INSERT INTO imageData SET fname VALUE $fullFname");
            createThumbs($fullFname, $thumbPath, $thumbHeight, $db);
    	}
        closedir($imageDir);
        closedir($newImageDir);
    }
        
    function getPathsFromDB($db){
        $query = "SELECT imageData.fname, thumbData.filePath 
         FROM imageData 
         INNER JOIN thumbData 
         ON imageData.thumb=thumbData.id";
        $result = $db->query($query);
        $row = $result->fetch_array();
        return $row;
    }

    function createThumbs( $fullFname, $pathToThumbs, $thumbHeight, $db) {

        $fname = basename($fullFname);
        $pathToImages = dirname($fullFname);
        $preppedQuery = "SELECT 'id' FROM imageData WHERE 'fname' = $fname";
        if ($queryOutPut = $db->query($preppedQuery)){

        $numrows = $queryOutPut->num_rows;
		//open the dir
		$dir = opendir( $pathToImages);
		//loop through directory looking for JPGs
    }   
    else {echo "database error";}


		while (false !== ($fname = readdir( $dir ))) {
			
        
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
                    $thumbFullFname = $pathToThumbs.$thumbName;
     				imagejpeg( $tmp_img, $thumbFullFname );
                    //Insert thumb path into DB
                    $query = "INSERT INTO thumbData filePath VALUES $thumbFullName";
                    $db->mysqli_query($query);
                    //then get back the primary key for the thumb
                    $query = "SELECT $id FROM thumbData WHERE 'filePath' = $thumbFullName";
                    $result = $db->mysqli_query($query);
                    $thumbRow = $result->fetch_assoc();
                    //finally insert thumb primary key into image foreign key location
                    $query = "INSERT INTO imageData thumb VALUES $thumbRow[1]";
                    $db->mysqli_query($query);

                }
		}
        closedir($dir);
    }
	function makeLinks($db){

        echo "<img src=\"thumbs/$thumbName\" onclick=\"TINY.box.show({image:'imgs/$entry', animate:true, boxid:'frameless'})\" alt=$entry-thumbnail/>";
      
   }
        
?>