<?php
/* FilmDB (based on php4flicks) */

// fetchimggd.php - gets image from file or url and temporarily stores it as session data!
// convert image to JPEG with quality of 75% to reduce the blob size
// session must have been initialized

require_once('config/config.php');

	function fetchimg($movieid, $url='', $upload_files=''){
	
		if($url=='' || $url=='http://'){
			//no url specified, so image is supposed to have been uploaded as file. check img data:
			if(@is_readable($upload_files)){
				// no error, so store file
				unset($_SESSION['image']);
				$data = @file_get_contents($upload_files);
				$_SESSION['image'][$movieid] = $data;
				$max_width = 95; $max_height = 140;
				$img = imagecreatefromstring($data);
				$width = imagesx($img); $height = imagesy($img);
				if (($width > $max_width) || ($height > $max_height)) {
					if ($max_width && ($width < $height)) {
						$max_width = ($max_height / $height) * $width;
					} else {
						$max_height = ($max_width / $width) * $height;
					}
				} else {
					$max_width = $width; $max_height = $height;
				}
				$img_new = imagecreatetruecolor($max_width, $max_height);
				imagecopyresampled($img_new, $img, 0, 0, 0, 0, $max_width, $max_height, $width, $height);
				imagedestroy($img); $data = '';
				ob_start(); 
				imagejpeg($img_new, null, 75);
				$data = ob_get_contents();
				ob_end_clean();
				$_SESSION['image'][$movieid] = $data;
				return '';
			} else {
				return 'no file was uploaded...';
			}
		}else {
			//url present, so fetch image from url!
			//special case: imdb url, since imdb does not allow linking to its pages. we've got to send out faked headers...
			if($url == 'http://i.imdb.com/Heads/npa.gif')
				return '';	// the 'NO PIC AVAILABLE' pic, DON'T store it!
			
			if(substr($url,0,19)=='http://ia.imdb.com/'){
			//currently not in use
			//if(substr($url,0,25)=='http://ia.media-imdb.com/'){
				// it's an imdb-url
				$data = "GET ".$url." HTTP/1.0\r\n";
				$data .= "User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)\r\n";
				$data .= "Accept: text/html, image/png, image/x-xbitmap, image/gif, image/jpeg, */*\r\n";
				$data .= "Accept-Language: en, de\r\n";
				$data .= "Accept-Encoding: gzip, deflate, x-gzip, identity, *;q=0\r\n";
				$data .= "Referer: media-imdb.com\r\n";
				$data .= "Host: ia.media-imdb.com\r\n";
				$data .= "Connection: close\r\n";
				$data .= "Cache-Control: no-cache\r\n";
				$data .= "\r\n";
				
				// open connection to imdb server
				//$fp = @fsockopen('ia.media-imdb.com', 80);
				$fp = @fsockopen('ia.media-imdb.com', 80);
				if (!$fp) 
					return 'could not open url...';
					
				// put request header
				fputs ($fp, $data);
				
				// get only image, not header
				$line='';
				while(!feof($fp)&&$line!="\r\n") {
					$line = fgets($fp,256);
				}
				// fetch img
				unset($_SESSION['image']);
				$_SESSION['image'][$movieid] = '';
				$data = '';
				while (!feof($fp)) {
  					$data .= fread($fp, 8192);
				}
				$max_width = 95; $max_height = 140;
				$img = imagecreatefromstring($data);
				$width = imagesx($img); $height = imagesy($img);
				if (($width > $max_width) || ($height > $max_height)) {
					if ($max_width && ($width < $height)) {
						$max_width = ($max_height / $height) * $width;
					} else {
						$max_height = ($max_width / $width) * $height;
					}
				} else {
					$max_width = $width; $max_height = $height;
				}
				$img_new = imagecreatetruecolor($max_width, $max_height);
				imagecopyresampled($img_new, $img, 0, 0, 0, 0, $max_width, $max_height, $width, $height);
				imagedestroy($img); $data = '';
				ob_start(); 
				imagejpeg($img_new, null, 75);
				$data = ob_get_contents();
				ob_end_clean();
				$_SESSION['image'][$movieid] = $data;
				return '';
			}else {
				//'normal' url
				if(!preg_match("/(\.jpg|\.jpeg|\.gif)$/i",$url))
					return 'select .gif or .jpg files only...';
				   				
				$handle = @fopen($url, 'r');
				if (!$handle) 
					return 'could not open url...';
				
				unset($_SESSION['image']);
				$_SESSION['image'][$movieid] = '';
				$data = '';
				while (!feof($handle)) {
  					$data .= fread($handle, 8192);
				}
				fclose($handle);
				$max_width = 95; $max_height = 140;
				$img = imagecreatefromstring($data);
				$width = imagesx($img); $height = imagesy($img);
				if (($width > $max_width) || ($height > $max_height)) {
					if ($max_width && ($width < $height)) {
						$max_width = ($max_height / $height) * $width;
					} else {
						$max_height = ($max_width / $width) * $height;
					}
				} else {
					$max_width = $width; $max_height = $height;
				}
				$img_new = imagecreatetruecolor($max_width, $max_height);
				imagecopyresampled($img_new, $img, 0, 0, 0, 0, $max_width, $max_height, $width, $height);
				imagedestroy($img); $data = '';
				ob_start(); 
				imagejpeg($img_new, null, 75);
				$data = ob_get_contents();
				ob_end_clean();
				$_SESSION['image'][$movieid] = $data;
				return '';
			}
		}
	}
?>
