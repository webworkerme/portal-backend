<?php
function deleteAllFiles($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            deleteAllFiles($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}
function base64ToImage($base64_string, $output_file) {
    $file = fopen($output_file, "wb");

    $data = explode(',', $base64_string);

    fwrite($file, base64_decode($data[1]));
    fclose($file);

    return $output_file;
}
function sendConfirmEmail($e, $n, $c, $t)
{
   /* ob_start();
    include "../src/notifications/emails/confirm/index.php";
    $message = ob_get_clean();

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("support@innohub.com", "Innohub Support");
    $email->setSubject("Welcome to Innohub! Confirm Your Email");
    $email->addTo($e, $n);
    $email->addContent(
        "text/html", $message
    );
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
    } */
}
function generate_string($strength) 
{
    $input = '123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}