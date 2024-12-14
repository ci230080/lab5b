<?php 
// Memulakan sesi
session_start(); 

// Semak jika pengguna telah log masuk, jika belum, arahkan ke login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Arahkan ke login jika belum log masuk
    exit;
}

// Database connection settings 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "lab_5b"; 

// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname);  

// Check connection
if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
} 

// Check if 'matric' is provided in the URL 
if (isset($_GET['matric'])) { 
    $matric = $_GET['matric']; 
    $sql = "DELETE FROM users WHERE matric = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $matric); 
    
    if ($stmt->execute()) {         
        echo "<p style='color: green;'>User with Matric $matric deleted successfully!</p>"; 
    } else {         
        echo "<p style='color: red;'>Error deleting user: " . $conn->error . "</p>";     
    } 
} else {
    echo "<p style='color: red;'>Invalid request. Matric is missing.</p>";
}

// Redirect to display.php after operation
header("Location: display.php");
exit;

// Close connection
$conn->close();
?>
