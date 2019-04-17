<?php
$app->get('/file[/{id}/{type}/{data}]', function ($request, $response, $args) {
    try {
        $id = $args['id'];
        $data = $args['data'];
        $image = @file_get_contents('../protected/uploads/' . $args['id'] . '/' . $args['type'] . '/' . $args['data']);
        if ($image === false) {
            $handler = $this->notFoundHandler;
            return $handler($request, $response);
        }
        $response->write($image);
        return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->get('/delete[/{type}/{id}/{data}]', function ($request, $response, $args) {
    try {
        $data = $args['data'];
        unlink('../protected/' . $args['type'] . '/' . $args['id'] . '/' . $args['data']);
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});