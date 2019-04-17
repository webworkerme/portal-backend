<?php
/**
 * Authentication Module
 *
 * @copyright  Innohub Construction Rest API
 * @version    Release: @1.0
 * @since      Available since Release 1.0
 *
 * @return     User Info
 */

use \Firebase\JWT\JWT;

## Create new user
$app->post('/create', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    $key = getenv('SECRET_KEY');
    
    $payload = array(
        "iss" => "https://portal.innotechconstruction.com",
        "iat" => time(),
        "exp" => time() + (3600 * 24 * 15),
        "context" => [
            "user" => [
                "user_login" => $input['password'],
                "user_id" => $input['name'],
            ],
        ],
    );
    try {
        $jwt = JWT::encode($payload, $key, "HS256");

        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {

        // Check if user exists
        $check = "SELECT email FROM users WHERE email = :email";
        $sthe = $db->prepare($check);
        $sthe->bindParam("email", $input['email']);
        $sthe->execute();
        if ($sthe->rowCount() === 1) {
            return $this->response->withJson(array("status" => "error", "message" => "email exist", "code" => "401"));
        } else {
            // Create new user
            // $code = generate_string(8);
            $input['image'] === '' || !$input['image'] ? $image = 'default' : $image = $input['image'];
            $sql = "INSERT INTO users (name, email, token, expiration, password, image, updated, created) VALUES (:name, :email, :token, :expiration, :password, :image, now(), now())";
            $sth = $db->prepare($sql);
            $sth->bindParam("name", $input['name']);
            $sth->bindParam("email", $input['email']);
            $sth->bindParam("token", $jwt);
            $sth->bindParam("expiration", $payload['exp']);
            $sth->bindParam("image", $image);
            $sth->bindParam("password", password_hash($input['password'], PASSWORD_DEFAULT));
            $sth->execute();

            $input['id'] = $db->lastInsertId();
            $input['image'] = $image;
            $input['token'] = $jwt;
            $input['expiration'] = $payload['exp'];
            $input['updated'] = date("Y-m-d H:i:s");
            $input['created'] = date("Y-m-d H:i:s");
            unset($input['password']);
            
            $sqld = "INSERT INTO integrations (user, updated) VALUES (:user, now())";
            $sthd = $db->prepare($sqld);
            $sthd->bindParam("user", $input['id']);
            $sthd->execute();
            return $this->response->withJson(array("status" => "success", "response" => $input, "code" => "200"));
        }
        } else {
            return $this->response->withJson(array("status" => "error", "message" => "incorrect email format", "code" => "401"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Sign in existing user
$app->put('/signin', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    $key = getenv('SECRET_KEY');
    $payload = array(
        "iss" => "https://portal.innotechconstruction.com",
        "iat" => time(),
        "exp" => time() + (3600 * 24 * 15),
        "context" => [
            "user" => [
                "user_login" => $input['password'],
                "user_id" => $input['email'],
            ],
        ],
    );
    try {
        $jwt = JWT::encode($payload, $key, "HS256");

            $check = "SELECT * FROM users WHERE email = :email";
            $sthe = $db->prepare($check);
            $sthe->bindParam("email", $input['email']);
            $sthe->execute();
            $user = $sthe->fetch(PDO::FETCH_ASSOC);

        if (password_verify($input['password'], $user['password'])) {
            $t = "UPDATE users SET token = :token WHERE id = :id";
            $sth = $db->prepare($t);
            $sth->bindParam("token", $jwt);
            $sth->bindParam("id", $user['id']);
            $sth->execute();
            $user['token'] = $jwt;
            // Unset password
            unset($user['password']);
            return $this->response->withJson(array("status" => "success", "response" => $user, "code" => "200"));
        } else {
            // User Credentials Invalid
            return $this->response->withJson(array("status" => "error", "message" => "Sign in error, Invalid credentials", "code" => "401"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Recover Account
$app->put('/recovery', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
            $check = "SELECT * FROM users WHERE email = :email";
            $sthe = $db->prepare($check);
            $sthe->bindParam("email", $input['email']);
            $sthe->execute();
            $user = $sthe->fetch(PDO::FETCH_ASSOC);

        if ($sthe->rowCount() === 1) {
            ## Recover email
            $code = generate_string(8);
            $recover = "UPDATE users SET password = :password WHERE token = :token AND id = :id";
            $sth = $db->prepare($recover);
            $sth->bindParam("token", $user['token']);
            $sth->bindParam("id", $user['id']);
            $sth->bindParam("password", $code);
            $sth->execute();

            if ($sth->rowCount() > 0) {
                if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
                    ### Send Recovery Mail
                    // sendRecoveryEmail($user['email'], $user['firstname'] . ' ' . $user['lastname'], $code);
                }

                return $this->response->withJson(array("status" => "success", "message" => "Password Updated", "code" => "200"));
            } else {
                return $this->response->withJson(array("status" => "error", "message" => "Recovery error, Invalid credentials", "code" => "401"));
            }
        } else {
            // User Credentials Invalid
            return $this->response->withJson(array("status" => "error", "message" => "Recovery error, Invalid credentials", "code" => "401"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});

## Update Reset Password
$app->put('/recovery/update', function ($request, $response) {
    $db = $this->db;
    $input = $request->getParsedBody();
    try {
        $recover = "UPDATE users SET password = :newpass WHERE password = :password AND email = :email";
        $sth = $db->prepare($recover);
        $sth->bindParam("newpass", password_hash($input['password'], PASSWORD_DEFAULT));
        $sth->bindParam("password", $input['code']);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $this->response->withJson(array("status" => "success", "message" => "Password Updated", "code" => "200"));
        } else {
            return $this->response->withJson(array("status" => "error", "message" => "Invalid Reset Code", "code" => "401"));
        }
    } catch (PDOException $e) {
        die($this->response->withJson(array("status" => "error", "message" => "Bad Request", "code" => "401")));
    } finally {
        $db = null;
    }
});