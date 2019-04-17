<?php
############## API Vesrion 1
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

// Register global Functions
require '../src/global/index.php';

// Home
$app->get('/', function (Request $request, Response $response) {
    echo '<h1>InnoHub Rest API.</h1>';
});

// Authentication Module
$app->group('/api/v1/auth', function () use ($app) {
    require 'modules/authentication/index.php';
});

// Jobs Module
$app->group('/api/v1/jobs', function () use ($app) {
    require 'modules/jobs/index.php';
});

// File PreProcessor
$app->group('/api/v1/preprocessor', function () use ($app) {
    require 'modules/files/index.php';
});

// File Converters
$app->group('/api/v1/converters', function () use ($app) {
    require 'modules/uploads/base64.php';
});

// Uploads
$app->post('/api/v1/uploads', function ($request, $response) {
    require 'modules/uploads/index.php';
});

// Integrations
$app->group('/api/v1/integrations', function () use ($app) {
    require 'modules/integrations/index.php';
});

// Shares
$app->group('/api/v1/shares', function () use ($app) {
    require 'modules/shares/index.php';
});