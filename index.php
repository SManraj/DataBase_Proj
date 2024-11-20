<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Database</title>
    <link rel="stylesheet" href="styles.css">
    <h1>Library Database</h1>
    
    <div class="button-container">
        <a href="employee-login.html" class="button"> <button>Employee Login</button></a>
        <a href="guest-login.html" class="button"> <button>User Login</button></a>
        <a href="index.php" class="button"> <button>Book Catalog</button></a>
    </div>
    
    <!-- Book Catalog -->
    <div class="book_catalog"> 
        <h2>Book Catalog</h2>
        <input type="text" placeholder="Search...">
        <button type="button">Search</button>
        <div class="dropdown">
            <button class="dropdown-button">Search With</button>
            <div class="dropdown-content">
                <a href="#" onclick="setSearchOption('BookID')">BookID</a>
                <a href="#" onclick="setSearchOption('ISBN')">ISBN</a>
                <a href="#" onclick="setSearchOption('Title')">Title</a>
                <a href="#" onclick="setSearchOption('Author')">Author</a>
            </div>
            <span id="selected-option">BookID</span> <!-- Default option -->
        </div>
        
        <!-- Display Login Success Message -->
        <?php if(isset($_SESSION['userID'])): ?>
            <h2>Welcome, <?php echo $_SESSION['fullName']; ?></h2>
            <p>User ID: <?php echo $_SESSION['userID']; ?></p>
            <p>Email: <?php echo $_SESSION['email']; ?></p>
            <p>Phone: <?php echo $_SESSION['phone']; ?></p>
        <?php else: ?>
            <p>You are not logged in.</p>
        <?php endif; ?>
    </div>

    <script>
        function setSearchOption(option) {
            document.getElementById('selected-option').innerText = option;
        }
    </script>
</body>
</html>
