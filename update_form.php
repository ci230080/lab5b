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

// Mewujudkan sambungan ke pangkalan data
$conn = new mysqli($servername, $username, $password, $dbname);  

// Memeriksa jika sambungan gagal
if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
} 

// Mengambil data pengguna jika matric diberikan melalui URL
$matric = ""; 
$name = ""; 
$role = ""; 

if (isset($_GET['matric'])) { 
    $matric = $_GET['matric']; 
    $sql = "SELECT * FROM users WHERE matric = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $matric); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) { 
        // Mendapatkan data pengguna jika wujud
        $user = $result->fetch_assoc(); 
        $name = $user['name'];         
        $role = $user['role']; 
    } else { 
        echo "User not found."; 
        exit; 
    } 
} 

// Mengendalikan penghantaran borang
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $matric = $_POST['matric']; 
    $name = $_POST['name'];     
    $role = $_POST['role']; 

    // Pertanyaan untuk mengemas kini data pengguna
    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("sss", $name, $role, $matric); 

    // Memeriksa jika pengemaskinian berjaya
    if ($stmt->execute()) {         
        echo "<p style='color: green;'>User updated successfully!</p>"; 
    } else {         
        echo "<p style='color: red;'>Error updating user: " . $conn->error . "</p>";     
    } 
} 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Update User</title> 
</head> 
<body> 
    <h1>Update User</h1> 
    <form method="post" action=""> 
        <label for="matric">Matric:</label> 
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($matric); ?>" readonly><br><br> 

        <label for="name">Name:</label> 
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br> 

        <label for="role">Role:</label> 
        <select id="role" name="role" required> 
            <option value="lecturer" <?php echo $role == "lecturer" ? "selected" : ""; ?>>Lecturer</option> 
            <option value="student" <?php echo $role == "student" ? "selected" : ""; ?>>Student</option> 
        </select><br><br> 

        <button type="submit">Update</button> 
        <footer> 
            <a href="display.php">Back</a> 
        </footer> 
    </form> 
</body> 
</html>
