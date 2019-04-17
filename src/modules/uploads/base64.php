<?php
$app->post('/base64', function ($request, $response) {
    try{
    $db = $this->db;
    $input = $request->getParsedBody();
    $filePath = '../protected/uploads/' . $input['url'];
        // deleteAllFiles($filePath);
        base64ToImage($input['base64'], $filePath.$input['name']);
        $image = 'profile';
        $updateimage = "UPDATE users SET image = :image WHERE id = :id";
        $sth = $db->prepare($updateimage);
        $sth->bindParam("image", $image);
        $sth->bindParam("id", $input['id']);
        $sth->execute();
        return $this->response->withJson(array("status" => "success", "response" => $input['url'].$input['name'], "code" => "200"));
    } catch (PDOException $e){
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    }
})
?>