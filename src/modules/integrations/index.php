<?php
$app->get('/status/[{user}]', function ($request, $response, $args) {
    $db = $this->db;
    try {
        $sql = "SELECT * FROM integrations WHERE user = :user";
        $sth = $db->prepare($sql);
        $sth->bindParam("user", $args['user']);
        $sth->execute();
        $res = $sth->fetchAll();
        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
 });
 ?>