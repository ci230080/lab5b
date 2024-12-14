<?php 
// Memulakan sesi
session_start(); 

// Semak jika pengguna telah log masuk, jika belum, arahkan ke login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Arahkan ke login jika belum log masuk
    exit;
}

// Tetapan sambungan pangkalan data
$servername = "localhost"; 
$username = "root"; 
$password = "";   
$dbname = "lab_5b"; 

// Mewujudkan sambungan
$conn = new mysqli($servername, $username, $password, $dbname);  

// Memeriksa sambungan
if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
} 

// Pertanyaan untuk mendapatkan data daripada jadual users
$sql = "SELECT matric, name, role AS accessLevel FROM users"; 
$result = $conn->query($sql); 
?> 

<!DOCTYPE html> 
<html lang="en"> 

<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>User List</title> 
</head> 

<body> 
    <center><h1>Users List</h1></center>
    
    <table border="1" width="60%" align="center" cellpadding="12" cellspacing="0"> 
        <thead> 
            <tr> 
                <th>Matric</th> 
                <th>Name</th> 
                <th>Role</th> 
                <th>Update</th> 
                <th>Delete</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php 
            // Semak jika terdapat data untuk dipaparkan
            if ($result->num_rows > 0) { 
                // Mengambil setiap baris daripada set keputusan
                while ($row = $result->fetch_assoc()) { 
                    echo "<tr> 
                        <td>" . htmlspecialchars($row["matric"]) . "</td> 
                        <td>" . htmlspecialchars($row["name"]) . "</td> 
                        <td>" . htmlspecialchars($row["accessLevel"]) . "</td> 
                        <td><a href='update_form.php?matric=" . urlencode($row["matric"]) . "'>Update</a></td> 
                        <td><a href='delete_form.php?matric=" . urlencode($row["matric"]) . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a></td> 
                    </tr>";
                } 
            } else { 
                // Paparkan mesej jika tiada data dijumpai
                echo "<tr><td colspan='5'>No users found</td></tr>"; 
            } 
            ?> 
        </tbody> 
    </table>

    <footer style="text-align:center; margin-top:20px;">
        <a href="display.php">Back to Home</a>
        <!-- Pautan log keluar -->
    <div style="text-align: center; margin-top: 50px;">
        <a href="logout.php">Logout</a>
    </div>
    </footer>
</body> 

</html>
