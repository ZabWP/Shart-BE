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

    $userID = $_GET['userID'] ?? '';
    
    $query = "  SELECT a.artID, a.artImgLink
                FROM artGallery a
                JOIN artPostLikes l ON a.artID = l.postID
                WHERE l.userID = $userID
                ORDER BY l.likedAt DESC;
             ";

    $result = $conn->query($query);
    $likes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $likes[] = [
                "artID" => $row['artID'],
                "artImgLink" => $row['artImgLink']
            ];
        }
    }
    $conn->close();
    echo json_encode($likes);
    exit();
?>