<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


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

$uploadDir = 'uploads/'; 


if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    
    $originalFileName = $_FILES['image']['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('img_', true) . '.' . $fileExtension;
    $uploadPath = $uploadDir . $uniqueFileName;
    $coddPath = "https://codd.cs.gsu.edu/~zbronola1/SoftwareEngineering/shart/uploads/" . $uniqueFileName;
 
    $fileType = mime_content_type($_FILES['image']['tmp_name']);
    if (strpos($fileType, 'image') === false) {
        echo json_encode(['error' => 'The file is not a valid image.']);
        exit;
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
        $postName = $_POST['postName'] ?? '';
        $postDesc = $_POST['postDescription'] ?? '';
        $userID = $_POST['userID'] ?? '';
        $timestamp = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO artGallery (artImgLink, artName,  authorID, postedAt, artDesc) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $coddPath, $postName, $userID, $timestamp, $postDesc);
        if (!$stmt->execute()) {
            echo json_encode(['error' => 'Failed to insert data into the database.']);
            exit;
        }
        $stmt->close();
        $conn->close();
        echo json_encode(['message' => 'Image uploaded successfully', 'filePath' => $uploadPath]);
    } else {
        echo json_encode(['error' => 'Failed to move uploaded file.']);
    }
} else {
    echo json_encode(['error' => 'No file uploaded or there was an upload error.']);
}
?>
