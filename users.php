<?php
// Step 1: Establish a connection to the local MySQL database
$servername = "localhost";  // Local server
$username = "u5f4spq8tat7cr";         // Default username for XAMPP or MAMP
$password = "password";             // Default password is empty
$database = "Shart"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
?>
