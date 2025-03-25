<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
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

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$bio = $data["bio"];
$email = $data["email"];
$name = $data["name"];
$picture = $data["picture"];
$currentDate = date("Y-m-d H:i:s");

$sql = $conn->prepare("INSERT INTO users (username, name, email, bio, profilePic, createdAt) VALUES (?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssssss", $username, $name,$email, $bio, $picture, $currentDate);

if ($sql->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    echo json_encode(["error" => "Error inserting data: " . $sql->error]);
}


$conn->close();
?>