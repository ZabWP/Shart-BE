<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

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

// --- INPUT ---
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$artID = $_GET['id'];

// // --- VALIDATE ---
// if (empty($username) || $artID === 0) {
//     http_response_code(400);
//     echo json_encode(["status" => "error", "message" => "Missing username or artID"]);
//     exit();
// }

// // --- GET userID from username ---
// $stmt = $conn->prepare("SELECT userID FROM users WHERE username = ?");
// $stmt->bind_param("s", $username);
// $stmt->execute();
// $stmt->bind_result($userID);
// $stmt->fetch();
// $stmt->close();

// --- CHECK if like exists ---
$liked = false;

//delete later!!!
$userID = 110;

if ($userID) {
   
    $check = $conn->prepare("SELECT 1 FROM artPostLikes WHERE userID = ? AND postID = ?");
    $check->bind_param("ii", $userID, $artID);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $liked = true;
    }

    $check->close();
}

$conn->close();

// --- RETURN result ---
echo json_encode(["liked" => $liked]);
exit();
