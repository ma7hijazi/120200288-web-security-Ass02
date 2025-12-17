<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Hashing Application</title>
</head>
<body>
    <h1>Password Hashing Application</h1>
    
    <form method="post">
        <div>
            <label for="password">Enter Password:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <div>
            <input type="submit" name="hash" value="Hash Password">
            <input type="submit" name="verify" value="Verify Password">
        </div>
    </form>
    
    <?php
    // Start session to store hashed password
    session_start();
    
    // When Hash button is clicked
    if (isset($_POST['hash']) && isset($_POST['password'])) {
        $plaintext_password = $_POST['password'];
        
        // Hash the password
        $hashed_password = password_hash($plaintext_password, PASSWORD_DEFAULT);
        
        // Store in session
        $_SESSION['stored_hash'] = $hashed_password;
        $_SESSION['plain_password'] = $plaintext_password;
        
        echo "<h3>Hashing Result:</h3>";
        echo "<p><strong>Entered Password:</strong> " . htmlspecialchars($plaintext_password) . "</p>";
        echo "<p><strong>Hashed Password:</strong> " . $hashed_password . "</p>";
        echo "<hr>";
    }
    
    // When Verify button is clicked
    if (isset($_POST['verify']) && isset($_POST['password'])) {
        $input_password = $_POST['password'];
        
        echo "<h3>Verification Result:</h3>";
        
        // Check if there is stored hash
        if (isset($_SESSION['stored_hash']) && !empty($_SESSION['stored_hash'])) {
            $stored_hash = $_SESSION['stored_hash'];
            
            // Verify the password
            if (password_verify($input_password, $stored_hash)) {
                echo "<p style='color: green;'> MATCH - Password is correct!</p>";
            } else {
                echo "<p style='color: red;'> NO MATCH - Password is incorrect!</p>";
            }
            
            echo "<p><strong>Password to verify:</strong> " . htmlspecialchars($input_password) . "</p>";
            echo "<p><strong>Stored Hash:</strong> " . $stored_hash . "</p>";
            
            // Show original password for comparison
            if (isset($_SESSION['plain_password'])) {
                echo "<p><strong>Original Password (stored):</strong> " . htmlspecialchars($_SESSION['plain_password']) . "</p>";
            }
        } else {
            echo "<p style='color: orange;'> No password has been hashed yet. Please hash a password first.</p>";
        }
        
        echo "<hr>";
    }
    ?>
</body>
</html>