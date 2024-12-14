<?php  
// Tetapan sambungan pangkalan data 
$servername = "localhost"; 
$username = "root"; 
$password = "";   
$dbname = "lab_5b"; 

// Cipta sambungan 
$conn = new mysqli($servername, $username, $password, $dbname);  

// Semak sambungan 
if ($conn->connect_error) {     
    die("Sambungan gagal: " . $conn->connect_error); 
} 

// Inisialisasi pembolehubah 
$error = "";  

// Pemprosesan borang selepas dihantar 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $matric = $_POST['matric']; 
    $password = $_POST['password']; 

    // Pertanyaan untuk mendapatkan pengguna berdasarkan nombor matrik 
    $sql = "SELECT * FROM users WHERE matric = ?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $matric); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) { 
        $user = $result->fetch_assoc(); 

        // Semak kata laluan
        if ($user['password'] === $password) { // Perbandingan langsung tanpa hashing
            // Pengesahan berjaya, pergi ke display.php 
            session_start(); // Mulakan sesi
            $_SESSION['loggedin'] = true; // Tandakan pengguna sebagai log masuk
            $_SESSION['matric'] = $matric; // Simpan maklumat matric dalam sesi
            header("Location: display.php"); 
            exit(); 
        } else { 
            $error = "Invalid username or password"; // Mesej ralat yang betul
        }
    } else { 
        $error = "Invalid username or password, try login again"; // Mesej ralat yang betul
    }
} 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login</title> 
</head> 
<body>

    <h1>Login</h1> 

    <form method="post" action="">
        <?php 
        // Papar ralat jika ada 
        if (!empty($error)) { 
            echo "<p style='color: red;'>$error</p>"; 
        } 
        ?>  

        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" required><br>  

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button> 
        <p>
            <a href="users.php">Register </a>here if you have not.
        </p> 
    </form> 

</body> 
</html>
