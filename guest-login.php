<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");  
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");  
header("Access-Control-Allow-Headers: Content-Type");  

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "library"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = $_POST['username'];
    $pass = $_POST['password'];

    
    $sql = "SELECT * FROM User WHERE Email = '$user' AND PhoneNum = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        
       
        session_start();
        $_SESSION['userID'] = $row['EmpID'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['phone'] = $row['PhoneNum'];
        $_SESSION['fullName'] = $row['FName'] . " " . $row['MiddleI'] . " " . $row['LName'];
        $_SESSION['section'] = $row['SectionNum'];

        
        header('Location: index.html');
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid login credentials.']);
    }

    $conn->close();
}
?>
