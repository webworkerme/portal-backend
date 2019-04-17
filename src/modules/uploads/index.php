<?php
$input = $request->getParsedBody();
$target_dir = '../protected/uploads/' . $input['url'];
mkdir($target_dir, 0777, true);
    $file = $_FILES['file']['name'];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $fn = $input['name'] . '.' . $imageFileType;
    $target_file = $target_dir . $fn;
    
    if ($_FILES["file"]["size"] > 2000000) {
        $uploadOk = 0;
        return $this->response->withJson(array("status" => "error", "message" => "Sorry, your file is too large", "code" => "401"));
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $uploadOk = 0;
        return $this->response->withJson(array("status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "code" => "401"));
    }
    if ($uploadOk == 0) {
        return $this->response->withJson(array("status" => "error", "message" => "Sorry, your file was not uploaded", "code" => "401"));
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            return $this->response->withJson(array("status" => "success", "message" => "File Uploaded", "file" => $fn, "code" => "200"));
        } else {
            return $this->response->withJson(array("status" => "error", "message" => "Sorry, there was an error uploading your file.", "code" => $target_dir));
        }
    }
