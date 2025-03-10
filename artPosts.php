<?php
// Allow requests from any origin (CORS handling)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (empty($_SERVER['QUERY_STRING'])) {
    $jsonData = file_get_contents("./art.json");

    echo $jsonData;
    exit();
} else {
    $id = $_GET['id'];
    $jsonData = file_get_contents("./art.json");
    $artPosts = json_decode($jsonData, true);
    foreach ($artPosts as $artPost) {
        if ($artPost['id'] == $id) {
            echo json_encode($artPost);
            exit();
        }
    }
    echo json_encode(["error" => "Art post not found"]);
    exit();  
}

?>


