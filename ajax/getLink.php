<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require_once "libraries/simple_html_dom.php";

$data = json_decode(file_get_contents("php://input"));


if (isset($data->link)) {
    $dom = file_get_html($data->link, false);

    if (!empty($dom)) {

        http_response_code(200);

        echo json_encode(["htmlString" => $dom->outertext]);
    } else {

        http_response_code(404);

        echo json_encode(array("message" => "website doesn't exist"));
    }
} else {
    http_response_code(500);

    echo json_encode(array("message" => "no link given"));
}

exit();
