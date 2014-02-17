<?php
   function connectToDB($dbServer, $userName, $password){
        $db = new mysqli($dbServer, $userName, $password, 'images'); 
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
    	while (false !== ($fname = readdir( $newImageDir ))) {
            if($fname !== "." && $fname !== ".."){
        		$fullFname = $imagePath . $fname;
        		rename($newImagePath . $fname, $fullFname);
                $thumbPath = createThumb($fullFname, $thumbPath, $thumbHeight, $db);
                //insert thumb path into database
                $query = "INSERT INTO thumbdata (filePath) VALUE ('$thumbPath');";
                if (!($db->query($query))){
                    echo "<br> DB error at line ", __LINE__, ":", $db->error, "<br>";
                }
                $query = "SELECT LAST_INSERT_ID()";
                if (!($result = $db->query($query))){
                    echo "<br> DB error at line ", __LINE__, ":", $db->error, "<br>";
                }
                $row = $result->fetch_row();
                $thumbPriKey = $row[0];
                //insert full image path into database
                $query = "INSERT INTO imagedata (fname, thumb) VALUE ('$fullFname', '$thumbPriKey');";
                if (!($db->query($query))){
                    echo "<br> DB error at line ", __LINE__, ":", $db->error, "<br>";
                }
            }
    	}
        closedir($imageDir);
        closedir($newImageDir);
    }
    function createThumb( $fullFname, $pathToThumbs, $thumbHeight, $db) {
        $fname = basename($fullFname);
        $pathToImages = dirname($fullFname);
        //parse path for the extension
	     $info = pathinfo($pathToImages . $fname);
        //continue only if this is a JPEG
		if (strtolower($info['extension']) == 'jpg') {
			// load image and get size
			$img = imagecreatefromjpeg("$fullFname");
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
        }
        return $thumbFullFname;
    }
    function getThumbnailName($imgName)
    {
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        $extPos = strpos($imgName, $ext);
        $fileNameWithoutExt = substr($imgName, 0, ($extPos - 1) );
        echo "Filename is: ", $fileNameWithoutExt, " ";
        $thumbFilename = $fileNameWithoutExt . '-thumb.' . $ext;
        return $thumbFilename;
    }
    function printLinks($db){
        $query = "SELECT imagedata.fname, thumbdata.filePath 
         FROM imagedata 
         INNER JOIN thumbdata 
         ON imagedata.thumb=thumbdata.id;";
        $i=0;
        do{
            if (!($result = $db->query($query))){
            echo "<br> DB error at line ", __LINE__, ":", $db->error, "<br>";
            }
            $row = $result->fetch_row();
            makeLinks($row);
            $i++;
        } while ($i < $db->affected_rows);
        $row = $result->fetch_row();
        return $row;
    }
	function makeLinks($row){
        $imagePath = $row[0];
        $thumbPath = $row[1];
        echo "<img src=\"$thumbPath\" onclick=\"TINY.box.show({image:'$imagePath', animate:true, boxid:'frameless'})\" alt=$imagePath-thumbnail/>";
   } 
?>