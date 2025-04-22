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


if (empty($_SERVER['QUERY_STRING'])) {
    $sql = "
    SELECT 
        artGallery.*, 
        users.username, 
        users.name, 
        users.profilePic, 
        COUNT(artPostLikes.likeID) AS likeCount
    FROM artGallery 
    INNER JOIN users ON artGallery.authorID = users.userID
    LEFT JOIN artPostLikes ON artGallery.artID = artPostLikes.postID
    GROUP BY artGallery.artID, users.username, users.name, users.profilePic
    ORDER BY likeCount DESC
    LIMIT 10
    ";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);

    $conn->close();
    exit();
} 



else {
    $id = $_GET['id'];
    $sql = 
    "SELECT artGallery.*, users.username, users.name , users.profilePic 
    FROM artGallery INNER JOIN users ON artGallery.authorID = users.userID 
    WHERE artID = $id";
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $conn->close();
    echo json_encode($data);
    exit();  
}

?>


