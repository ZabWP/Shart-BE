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
// Step 2: Write the query to select all data from a table
$sql = "SELECT * FROM yourTableName"; // Replace 'yourTableName' with your actual table name

// Step 3: Execute the query
$result = $conn->query($sql);

// Step 4: Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Creator: " . $row["creator"]. "<br>";
    }
} else {
    echo "0 results";
}

// Step 5: Close the connection
$conn->close();
exit();

}
else {
    $id = $_GET['userID']; 
    $query = "
        SELECT users.*, artGallery.* 
        FROM users 
        INNER JOIN artGallery ON users.userID = artGallery.authorID
        WHERE users.userID = $id";

    $result = $conn->query($query);
    $data = []; 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;  // Add each row to the data array
        }
    } else {
        $data = ['error' => 'No data found'];
    }
    $conn->close();
    echo json_encode($data);
    exit();
    
}
?>
