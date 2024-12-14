<?php 
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

// Mengendalikan penghantaran borang
$message = ""; // Untuk menyimpan mesej kejayaan atau ralat
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $matric = $_POST['matric']; 
    $name = $_POST['name']; 
    $user_password = $_POST['password']; // Nama pemboleh ubah ditukar untuk elakkan konflik dengan pemboleh ubah 'password' PHP
    $role = $_POST['role']; 

    // Pertanyaan SQL untuk memasukkan data
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$user_password', '$role')";     

    if ($conn->query($sql) === TRUE) { 
        $message = "Registration successful."; 
    } else { 
        $message = "Error: " . $conn->error; 
    } 
} 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Registration Form</title> 
</head> 
<body> 
    <h1>Register Form</h1> 
     
    <?php 
    // Paparkan mesej jika ada
    if (!empty($message)) echo "<p>$message</p>"; 
    ?>      

    <form method="post" action=""> 
        <label for="matric">Matric:</label><br> 
        <input type="text" id="matric" name="matric" required><br><br>  

        <label for="name">Name:</label><br> 
        <input type="text" id="name" name="name" required><br><br>  

        <label for="password">Password:</label><br> 
        <input type="password" id="password" name="password" required><br><br>  

        <label for="role">Role:</label><br> 
        <select id="role" name="role" required> 
            <option value="" disabled selected>Please select</option> 
            <option value="lecturer">Lecturer</option> 
            <option value="student">Student</option> 
        </select><br><br> 

        <button type="submit">Submit</button> 
    </form> 
    <footer> 
        <a href="login.php">Login</a> 
    </footer> 
</body> 
</html>
