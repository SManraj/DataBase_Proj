<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "library"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM Employee WHERE Email = '$user' AND PhoneNum = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        echo json_encode([
            'status' => 'success',
            'userID' => $row['EmpID'],
            'email' => $row['Email'],
            'phone' => $row['PhoneNum'],
            'fullName' => $row['FName'] . " " . $row['MiddleI'] . " " . $row['LName'],
            'section' => $row['SectionNum']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid login credentials.']);
    }
    
    $conn->close();
}
?>
