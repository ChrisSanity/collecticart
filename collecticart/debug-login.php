<?php
// debug-login.php - DELETE THIS FILE AFTER DEBUGGING!
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "collecticart");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Admin Accounts Debug</h2>";

// Get all admin accounts
$result = $conn->query("SELECT id, username, password, role FROM users WHERE role = 'admin'");

if ($result && $result->num_rows > 0) {
    echo "<h3>Found " . $result->num_rows . " admin account(s):</h3>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
        echo "<strong>ID:</strong> " . $row['id'] . "<br>";
        echo "<strong>Username:</strong> " . $row['username'] . "<br>";
        echo "<strong>Password Hash:</strong> " . substr($row['password'], 0, 20) . "...<br>";
        echo "<strong>Hash Length:</strong> " . strlen($row['password']) . " characters<br>";
        echo "<strong>Role:</strong> " . $row['role'] . "<br>";
        
        // Test password verification
        echo "<br><strong>Password Tests:</strong><br>";
        
        $test_passwords = ['admin', 'admin123', 'password', 'Admin123', '123456'];
        
        foreach ($test_passwords as $test_pass) {
            $verify = password_verify($test_pass, $row['password']);
            $status = $verify ? "✅ MATCH" : "❌ NO MATCH";
            echo "Testing '$test_pass': $status<br>";
        }
        
        echo "</div>";
    }
} else {
    echo "<p>No admin accounts found!</p>";
}

echo "<hr>";
echo "<h3>Manual Password Reset</h3>";
echo "<p>Use this form to reset an admin password:</p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $username = $_POST['reset_username'];
    $new_password = $_POST['new_password'];
    
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashed, $username);
    
    if ($stmt->execute()) {
        echo "<div style='background: #d4edda; padding: 15px; margin: 10px 0; border: 1px solid #c3e6cb;'>";
        echo "✅ Password updated successfully for '$username'<br>";
        echo "New password: '$new_password'<br>";
        echo "Hash: " . $hashed;
        echo "</div>";
        
        // Verify it works
        $check = $conn->query("SELECT password FROM users WHERE username = '$username'");
        if ($check && $row = $check->fetch_assoc()) {
            $verify = password_verify($new_password, $row['password']);
            echo "<p>Verification test: " . ($verify ? "✅ SUCCESS" : "❌ FAILED") . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Error updating password: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

?>

<form method="POST" style="border: 1px solid #ccc; padding: 20px; max-width: 400px;">
    <div style="margin-bottom: 15px;">
        <label>Username:</label><br>
        <input type="text" name="reset_username" required style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>New Password:</label><br>
        <input type="text" name="new_password" required style="width: 100%; padding: 8px;">
    </div>
    <button type="submit" name="reset" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
        Reset Password
    </button>
</form>

<hr>

<h3>Test Login Function</h3>
<form method="POST" style="border: 1px solid #ccc; padding: 20px; max-width: 400px;">
    <div style="margin-bottom: 15px;">
        <label>Username:</label><br>
        <input type="text" name="test_username" required style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label>Password:</label><br>
        <input type="text" name="test_password" required style="width: 100%; padding: 8px;">
    </div>
    <button type="submit" name="test_login" style="background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer;">
        Test Login
    </button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_login'])) {
    $test_user = $_POST['test_username'];
    $test_pass = $_POST['test_password'];
    
    echo "<div style='background: #f8f9fa; padding: 15px; margin: 10px 0; border: 1px solid #dee2e6;'>";
    echo "<h4>Login Test Results:</h4>";
    
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $test_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo "❌ User '$test_user' not found in database<br>";
    } else {
        $user = $result->fetch_assoc();
        echo "✅ User found: ID=" . $user['id'] . ", Role=" . $user['role'] . "<br>";
        echo "Password you entered: '$test_pass'<br>";
        echo "Password hash in DB: " . substr($user['password'], 0, 30) . "...<br>";
        
        $verify = password_verify($test_pass, $user['password']);
        
        if ($verify) {
            echo "<strong style='color: green;'>✅ PASSWORD MATCHES! Login should work.</strong><br>";
        } else {
            echo "<strong style='color: red;'>❌ PASSWORD DOES NOT MATCH!</strong><br>";
            echo "<p>Possible issues:</p>";
            echo "<ul>";
            echo "<li>Wrong password</li>";
            echo "<li>Extra spaces in password</li>";
            echo "<li>Password hash corrupted in database</li>";
            echo "</ul>";
        }
    }
    echo "</div>";
    
    $stmt->close();
}

$conn->close();
?>

<p style="color: red; font-weight: bold; margin-top: 30px;">
    ⚠️ DELETE THIS FILE (debug-login.php) AFTER YOU'RE DONE DEBUGGING!
</p>