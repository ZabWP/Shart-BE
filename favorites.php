<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// DB connection
$servername = "127.0.0.1";  
$username = "zbronola1";         
$password = "zbronola1";        
$database = "zbronola1";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

// Get the values
$username = $data['username'] ?? '';
$artID = intval($data['artID'] ?? 0);

// if (!$username || !$artID) {
//     http_response_code(400);
//     echo json_encode(["status" => "error", "message" => "Missing username or postID"]);
//     exit();
// }

// Get userID from username
// $userQuery = $conn->prepare("SELECT userID FROM users WHERE username = ?");
// $userQuery->bind_param("s", $username);
// $userQuery->execute();
// $userQuery->bind_result($userID);
// $userFound = $userQuery->fetch();
// $userQuery->close();

// if (!$userFound) {
//     http_response_code(404);
//     echo json_encode(["status" => "error", "message" => "User not found"]);
//     exit();
// }

if ($method === 'POST') {
    // Insert like
    // $stmt = $conn->prepare("INSERT INTO artPostLikes (userID, postID) VALUES (?, ?)");
    // $stmt->bind_param("ii", $userID, $artID);

    // if ($stmt->execute()) {
    //     echo json_encode(["status" => "success", "action" => "liked"]);
    // } else {
    //     if ($conn->errno == 1062) {
    //         echo json_encode(["status" => "already_liked"]);
    //     } else {
    //         echo json_encode(["status" => "error", "message" => $conn->error]);
    //     }
    // }

    $userID= 110;


    $stmt = $conn->prepare("INSERT INTO artPostLikes (userID, postID) VALUES (?, ?)");
    $stmt->bind_param("ii", $userID, $artID);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "action" => "liked"]);
    } else {
        if ($conn->errno == 1062) {
            echo json_encode(["status" => "already_liked"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    }

    $stmt->close();
    $conn->close();
    exit();
}
 
?>
