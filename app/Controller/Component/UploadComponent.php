<?php
App::uses('Component', 'Controller');

class UploadComponent extends Component {
    var $contentType = array('image/jpg','image/bmp','image/jpeg','image/gif','image/png','image/pjpg','image/pbmp','image/pjpeg','image/ppng','image/pgif');

    function delete_image($filename) {
        unlink($filename);
    }

    function uploadImage($folder, $file, $thumb_size='', $itemId = null, $image_name = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $result = array();

        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }
        // if itemId is set create an item folder
        if($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT.$folder.'/'.$itemId;
            // set new relative folder
            $rel_url = $folder.'/'.$itemId;
            // create directory
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');
        // print_r($file);
        // replace spaces with underscores
        if(!empty($file['name'])) {
			/*@rename image : name image same as image_name, delete here if other project*/  
			if($image_name) {
				$image_name = str_replace(' ', '_', $image_name);
				$filename = $image_name.strrchr($file['name'], '.'); 
			}else{
				$filename = str_replace(' ', '_', $file['name']);
			}
			/*@rename image*/			
            
            // assume filetype is false
            $typeOK = true;
            // check filetype is ok
            foreach($permitted as $type) {
                if($type == $file['type']) {
                    $typeOK = true;
                    break;
                }
            }
            // if file type ok upload the file
            if($typeOK) {
                // switch based on error code
                switch($file['error']) {
                    case 0:
                    // check filename already exists
                        $now = '';
						if(!empty($image_name)){
							$url = $rel_url.'/'.$filename;
							// upload the file
							$success = move_uploaded_file($file['tmp_name'], $url);
						}else{
							if(!file_exists($folder_url.'/'.$filename)) {
								// create full filename
								$full_url = $folder_url.'/'.$filename;
								$url = $rel_url.'/'.$filename;
								// upload the file
								$success = move_uploaded_file($file['tmp_name'], $url);
							} else {
								// create unique filename and upload file
								ini_set('date.timezone', 'Europe/London');
								$now = time();
								$full_url = $folder_url.'/'.$now.$filename;

								$url = $rel_url.'/'.$now.$filename;
								$success = move_uploaded_file($file['tmp_name'], $url);
							}
						}
                        
             
                        // if upload was successful
                        if($success) {
                            // save the url of the file
                            $result['urls'] = $url;
                            $result['filename'] = $now.$filename;
                            $result['type'] = $file['type'];
                            $result['size'] = $file['size'];
                            $result['name'] = $now.$filename;


                            if($thumb_size) {
                                $thumbFolder = $folder_url.'/thumb';
                                $this->resize_img($folder_url.'/'.$result['filename'], $thumb_size, $thumbFolder.'/'.$result['filename']);
                                chmod($folder_url.'/'.$result['filename'], 0777);
                                chmod($thumbFolder.'/'.$result['filename'],0777);
                            }

                        } else {
                            $result['errors'] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                    // an error occured
                        $result['errors'] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                    // an error occured
                        $result['errors'] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }

        }
        return $result;
    }

    function uploadFiles($folder, $formdata,$thumb='', $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $result = array();

        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT.$folder.'/'.$itemId;
            // set new relative folder
            $rel_url = $folder.'/'.$itemId;
            // create directory
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }


        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');

        // loop through and deal with the files
        foreach($formdata as $file) {
            // print_r($file);
            // replace spaces with underscores
            if(!empty($file['name'])) {
                $filename = str_replace(' ', '_', $file['name']);
                // assume filetype is false
                $typeOK = false;
                // check filetype is ok
                foreach($permitted as $type) {
                    if($type == $file['type']) {
                        $typeOK = true;
                        break;
                    }
                }
                // if file type ok upload the file
                if($typeOK) {
                    // switch based on error code
                    switch($file['error']) {
                        case 0:
                        // check filename already exists
                            $now = '';
                            if(!file_exists($folder_url.'/'.$filename)) {
                                // create full filename
                                $full_url = $folder_url.'/'.$filename;
                                $url = $rel_url.'/'.$filename;
                                // upload the file
                                $success = move_uploaded_file($file['tmp_name'], $url);
                            } else {
                                // create unique filename and upload file
                                ini_set('date.timezone', 'Europe/London');
                                $now = date('Y-m-d-His');
                                $full_url = $folder_url.'/'.$now.$filename;

                                $url = $rel_url.'/'.$now.$filename;
                                $success = move_uploaded_file($file['tmp_name'], $url);
                            }
                            // if upload was successful
                            if($success) {
                                // save the url of the file
                                $result['urls'][] = $url;
                                $result['filename'] = $now.$filename;
                                $result['mfile'][] = $now.$filename;

                                if($thumb) {
                                    $thumbFolder = $folder_url.'/thumb';
                                    $this->resize_img($folder_url.'/'.$result['filename'], $thumb, $thumbFolder.'/'.$result['filename']);
                                    chmod($folder_url.'/'.$result['filename'], 777);
                                    chmod($thumbFolder.'/'.$result['filename'],777);
                                }

                            } else {
                                $result['errors'][] = "Error uploaded $filename. Please try again.";
                            }
                            break;
                        case 3:
                        // an error occured
                            $result['errors'][] = "Error uploading $filename. Please try again.";
                            break;
                        default:
                        // an error occured
                            $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                            break;
                    }
                } elseif($file['error'] == 4) {
                    // no file was selected for upload
                    $result['nofiles'][] = "No file Selected";
                } else {
                    // unacceptable file type
                    $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
                }

            }
        }
        return $result;
    }

    function uploadFile($folder, $file, $itemId = null) {

        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $result = array();

        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT.$folder.'/'.$itemId;
            // set new relative folder
            $rel_url = $folder.'/'.$itemId;
            // create directory
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        // $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');

        // loop through and deal with the files


        // replace spaces with underscores
        if(!empty($file['name'])) {
            $filename = str_replace(' ', '_', $file['name']);
            // assume filetype is false
            $typeOK = true;
            // if file type ok upload the file
            if($typeOK) {
                // switch based on error code
                switch($file['error']) {
                    case 0:
                    // check filename already exists
                        $now = '';
                        if(!file_exists($folder_url.'/'.$filename)) {
                            // create full filename
                            $full_url = $folder_url.'/'.$filename;
                            $url = $rel_url.'/'.$filename;
                            // upload the file
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        } else {
                            // create unique filename and upload file
                     
                            $now = time();
                            $full_url = $folder_url.'/'.$now.$filename;

                            $url = $rel_url.'/'.$now.$filename;
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        }
                        // if upload was successful
                        if($success) {
                            // save the url of the file
                            $result['urls'] = $url;
                            $result['filename'] = $now.$filename;
                            $result['name'] = $now.$filename;
                            $result['type'] = $file['type'];
                            $result['size'] = $file['size'];
                            chmod($full_url, 0777);



                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                    // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                    // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }

        }

        return $result;
    }
    function deleteFile($folder, $filename) {
        if(is_array($filename)){
            foreach($filename as $file){
                @unlink(WWW_ROOT . $folder . DS . $file);
            }
        }else{
            @unlink(WWW_ROOT . $folder . DS . $filename);
        }
        
    }
     function resize_img($tempFile, $size, $newFile) {
        $filetype = $this->getFileExtension($tempFile);
        $info = getimagesize($tempFile);
        $image_type = $info['mime'];
        $info = explode('/', $image_type);
        $filetype = $info[1];
        $filetype = strtolower($filetype);

        switch ($filetype) {
            case "jpeg":
            case "jpg":
                $img_src = imagecreatefromjpeg($tempFile);
                break;
            case "gif":
                $img_src = imagecreatefromgif($tempFile);
                break;
            case "png":
                $img_src = imagecreatefrompng($tempFile);
				break;
            case "bmp":
                $img_src = imagecreatefromwbmp($tempFile);
                break;
        }

        $true_width = imagesx($img_src);
        $true_height = imagesy($img_src);

        $size = explode('x', strtolower($size));
         
        if ($true_width > $true_height) {
            $width = $size[0];
            $height = ($width / $true_width) * $true_height;
        } else {
            //anh bang nhau
            if ($true_width == $true_height){

                  $width = $size[0];
                  $height =$size[1];
            }else {
                 $height = $size[1];
                //$width = ($height / $true_height) * $true_width;
                 $width = $size[0];
                 $true_height = ($true_width * $size[1])/$size[0];
            }
        }
        $img_des = imagecreatetruecolor($width, $height);
        imagecopyresampled($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        // Save the resized image
        switch ($filetype) {
           case "jpeg":
            case "jpg":
                imagejpeg($img_des, $newFile, 100);
                break;
            case "gif":
                imagegif($img_des, $newFile, 100);
                break;
            case "png":
                imagepng($img_des, $newFile, 9, null);
				break;
            case "bmp":
                imagewbmp($img_des, $newFile, 100);
                break;
        }
    }

    function resize_imgbk($tempFile, $size, $newFile) {
        $filetype = $this->getFileExtension($tempFile);
        $filetype = strtolower($filetype);
        switch($filetype) {
            case "jpeg":
            case "jpg":
                $img_src = imagecreatefromjpeg($tempFile);
                break;
            case "gif":
                $img_src = imagecreatefromgif ($tempFile);
                break;
            case "png":
                $img_src = imagecreatefrompng ($tempFile);
            case "bmp":
                $img_src = imagecreatefromwbmp ($tempFile);
                break;
        }
        $true_width = imagesx($img_src);
        $true_height = imagesy($img_src);

        $size = explode('x',strtolower($size));
        if ($true_width>=$true_height) {
            $width=$size[0];
            $height = ($width/$true_width)*$true_height;
        }
        else {
            $height=$size[1];
            $width = ($height/$true_height)*$true_width;
        }
        $img_des = imagecreatetruecolor($width,$height);
        imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);
        // Save the resized image
        switch($filetype) {
            case "jpeg":
            case "jpg":
                imagejpeg($img_des,$newFile,80);
                break;
            case "gif":
                imagegif($img_des,$newFile,80);
                break;
            case "png":
                imagepng($img_des,$newFile,80);
            case "bmp":
                imagewbmp($img_des,$newFile,80);
                break;
        }
    }
    function getFileExtension($str) {
        $i = strrpos($str,".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }


    function uploadImageFull($folder, $file, $thumb_size='', $itemId = null){       
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;
        $result = array();

        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }
        // if itemId is set create an item folder
        if($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT.$folder.'/'.$itemId;
            // set new relative folder
            $rel_url = $folder.'/'.$itemId;
            // create directory
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');
        // print_r($file);
        // replace spaces with underscores
        if(!empty($file['name'])) {
            $filename = str_replace(' ', '_', $file['name']);
            // assume filetype is false
            $typeOK = false;
            // check filetype is ok
            foreach($permitted as $type) {
                if($type == $file['type']) {
                    $typeOK = true;
                    break;
                }
            }
            // if file type ok upload the file
            if($typeOK) {
                // switch based on error code
                switch($file['error']) {
                    case 0:
                    // check filename already exists
                        $now = '';
                        if(!file_exists($folder_url.'/'.$filename)) {
                            // create full filename
                            $full_url = $folder_url.'/'.$filename;
                            $url = $rel_url.'/'.$filename;
                            // upload the file
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        } else {
                            // create unique filename and upload file
                            ini_set('date.timezone', 'Europe/London');
                            $now = date('YmdHis');
                            $full_url = $folder_url.'/'.$now.$filename;

                            $url = $rel_url.'/'.$now.$filename;
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        }
                        // if upload was successful
                        if($success) {
                            // save the url of the file
                            $result['urls'] = $url;
                            $result['filename'] = $now.$filename;
                            $result['type'] = $file['type'];
                            $result['size'] = $file['size'];
                            $result['name'] = $now.$filename;


                            if($thumb_size) {

                                $thumbFolder = $folder_url.'/thumb';
                                 if(!is_dir($thumbFolder)) {
                                                mkdir($thumbFolder);
                                            }
                                $this->resize_img($folder_url.'/'.$result['filename'], $thumb_size, $thumbFolder.'/'.$result['filename']);
                                chmod($folder_url.'/'.$result['filename'], 0777);
                                chmod($thumbFolder.'/'.$result['filename'],0777);
                            }

                        } else {
                            $result['errors'] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                    // an error occured
                        $result['errors'] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                    // an error occured
                        $result['errors'] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }

        }
        return $result;
    }
}
?>