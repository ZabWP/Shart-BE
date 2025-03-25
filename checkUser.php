<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
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
$email = $data["email"];
$name = $data["name"];
$picture = $data["picture"];

if (!$email) {
    die(json_encode(["error" => "InvalidEmail"]));
}

$sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["status" => "newUser"]);
} else {
    echo json_encode(["status" => "existingUser"]);
}

$conn->close();
?>