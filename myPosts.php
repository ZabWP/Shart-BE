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

    if (empty($userID)) {
        $username = $_GET['username'] ?? '';
    
        if (empty($username)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing username or userID"]);
            exit();
        }
        $stmt = $conn->prepare("SELECT userID FROM users WHERE username = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Failed to prepare statement"]);
            exit();
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userID);
        if (!$stmt->fetch()) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User not found"]);
            exit();
        }
        $stmt->close();
    }
    
    
    $query = " SELECT * FROM artGallery WHERE authorID = $userID;";

    $result = $conn->query($query);
    $posts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = [
                "artID" => $row['artID'],
                "artImgLink" => $row['artImgLink'],
            ];
        }
    }
    $conn->close();
    echo json_encode($posts);
    exit();
?>