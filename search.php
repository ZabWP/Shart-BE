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
    die("Connection failed: " . $conn->connect_error);
} 


$search = isset($_GET['query']) ? '%' . $_GET['query'] . '%' : '';


$response = [
    "art" => [],
    "users" => []
];


    // Search in artGallery table
    $stmt = $conn->prepare("SELECT artID, artName, artImgLink FROM artGallery WHERE artName LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $response["art"] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Search in users table
    $stmt = $conn->prepare("SELECT userID, username, profilePic FROM users WHERE username LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $response["users"] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();



$conn->close();
echo json_encode($response);
?>

