<?php
/**
 * Social Share Module
 *
 * @copyright  Innohub Construction Rest API
 * @version    Release: @1.0
 * @since      Available since Release 1.0
 *
 * @return     User Info
 */

## update shares
$app->put('/update/facebook', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, facebook FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['facebook'] + $int;

        $facebook = "UPDATE shares SET facebook = :facebook WHERE jobid = :jobid";
        $sth = $db->prepare($facebook);
        $sth->bindParam("facebook", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("facebookCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->put('/update/twitter', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, twitter FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['twitter'] + $int;

        $twitter = "UPDATE shares SET twitter = :twitter WHERE jobid = :jobid";
        $sth = $db->prepare($twitter);
        $sth->bindParam("twitter", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("twitterCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->put('/update/linkedin', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, linkedin FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['linkedin'] + $int;

        $linkedin = "UPDATE shares SET linkedin = :linkedin WHERE jobid = :jobid";
        $sth = $db->prepare($linkedin);
        $sth->bindParam("linkedin", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("linkedinCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->put('/update/tumblr', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, tumblr FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['tumblr'] + $int;

        $tumblr = "UPDATE shares SET tumblr = :tumblr WHERE jobid = :jobid";
        $sth = $db->prepare($tumblr);
        $sth->bindParam("tumblr", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("tumblrCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->put('/update/pinterest', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, pinterest FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['pinterest'] + $int;

        $pinterest = "UPDATE shares SET pinterest = :pinterest WHERE jobid = :jobid";
        $sth = $db->prepare($pinterest);
        $sth->bindParam("pinterest", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("pinterestCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->put('/update/mail', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT id, jobid, mail FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $input['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);
        $count = $data['mail'] + $int;

        $mail = "UPDATE shares SET mail = :mail WHERE jobid = :jobid";
        $sth = $db->prepare($mail);
        $sth->bindParam("mail", $count);
        $sth->bindParam("jobid", $input['jobid']);
        $sth->execute();
        $res = array("mailCount" => $count);

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

        
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

$app->get('/count/[{jobid}]', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $int = 1;
        $check = "SELECT * FROM shares WHERE jobid = :jobid";
        $sthe = $db->prepare($check);
        $sthe->bindParam("jobid", $args['jobid']);
        $sthe->execute();
        $data = $sthe->fetch(PDO::FETCH_ASSOC);

        return $this->response->withJson(array("status" => "success", "response" => $data, "code" => "200"));
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});