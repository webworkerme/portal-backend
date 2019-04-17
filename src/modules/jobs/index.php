<?php
/**
 * company Module
 *
 * @copyright  Innohub Construction Rest API
 * @version    Release: @1.0
 * @since      Available since Release 1.0
 *
 * @return     User Info
 */

## Create new company
$app->post('/create/company', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        // Check if company exists
        $check = "SELECT name, user FROM company WHERE name = :name AND user = :user";
        $sthe = $db->prepare($check);
        $sthe->bindParam("name", $input['name']);
        $sthe->bindParam("user", $input['user']);
        $sthe->execute();
        if ($sthe->rowCount() === 1) {
            return $this->response->withJson(array("status" => "error", "message" => "Company profile exists", "code" => "401"));
        } else {
            // Create new company
            $input['logo'] === '' || !$input['logo'] ? $image = 'default' : $image = $input['logo'];
            $sql = "INSERT INTO company (name, user, location, logo, updated, created) VALUES (:name, :user, :location, :logo, now(), now())";
            $sth = $db->prepare($sql);
            $sth->bindParam("name", $input['name']);
            $sth->bindParam("user", $input['user']);
            $sth->bindParam("location", $input['location']);
            $sth->bindParam("logo", $image);
            $sth->execute();

            $input['id'] = $db->lastInsertId();
            $input['logo'] = $image;
            $input['updated'] = date("Y-m-d H:i:s");
            $input['created'] = date("Y-m-d H:i:s");

            return $this->response->withJson(array("status" => "success", "response" => $input, "code" => "200"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});


## Create new job
$app->post('/create/job', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        // Check if company exists
        $check = "SELECT title, company FROM jobs WHERE title = :title AND company = :company";
        $sthe = $db->prepare($check);
        $sthe->bindParam("title", $input['title']);
        $sthe->bindParam("company", $input['company']);
        $sthe->execute();
        if ($sthe->rowCount() === 1) {
            return $this->response->withJson(array("status" => "error", "message" => "Job posting exists", "code" => "401"));
        } else {
            // Create new posting
            $sql = "INSERT INTO jobs (title, description, company, closeDate, location, updated, created) VALUES (:title, :description, :company, :closeDate, :location, now(), now())";
            $sth = $db->prepare($sql);
            $sth->bindParam("title", $input['title']);
            $sth->bindParam("description", $input['description']);
            // , company, location,
            $sth->bindParam("company", $input['company']);
            $sth->bindParam("closeDate", $input['closeDate']);
            $sth->bindParam("location", $input['location']);
            $sth->execute();

            $input['id'] = $db->lastInsertId();
            $input['updated'] = date("Y-m-d H:i:s");
            $input['created'] = date("Y-m-d H:i:s");

            $sqla = "INSERT INTO shares (jobid, updated, created) VALUES (:jobid, now(), now())";
            $stha = $db->prepare($sqla);
            $stha->bindParam("jobid", $input['id']);
            $stha->execute();

            return $this->response->withJson(array("status" => "success", "response" => $input, "code" => "200"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Get all job postings
$app->get('/query/all', function ($request, $response, $args) {
    $db = $this->db;
    try {
        $sql = "SELECT * FROM jobs RIGHT JOIN company ON jobs.company = company.id";
        $sth = $db->prepare($sql);
        $sth->execute();
        $res = $sth->fetchAll();

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Get postings for individual company
$app->get('/query/company/[{id}]', function ($request, $response, $args) {
    $db = $this->db;
    try {
        $sql = "SELECT * FROM jobs RIGHT JOIN company ON jobs.company = company.id WHERE company.id = :companyId";
        $sth = $db->prepare($sql);
        $sth->bindParam("companyId", $args['id']);
        $sth->execute();
        $res = $sth->fetchAll();

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Open positions
$app->get('/query/positions/[{id}]', function ($request, $response, $args) {
    $db = $this->db;
    try {
        $sql = "SELECT * FROM jobs WHERE company = :companyId";
        $sth = $db->prepare($sql);
        $sth->bindParam("companyId", $args['id']);
        $sth->execute();

        $res = array("positions" => $sth->rowCount());

        return $this->response->withJson(array("status" => "success", "response" => $res, "code" => "200"));

    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});