<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->link)) {

    $image = $data->link;
    // Read image path, convert to base64 encoding
    $imageData = base64_encode(file_get_contents($image));

    // Format the image SRC:  data:{mime};base64,{data};
    $src = 'data: ' . getimagesize($image)['mime'] . ';base64,' . $imageData;


    http_response_code(200);

    echo json_encode(["base64ImgSrc" => $src]);
} else {

    http_response_code(500);

    echo json_encode(array("message" => "no link given"));
}

exit();
