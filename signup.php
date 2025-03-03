<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $displayname = trim($_POST["displayname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $file = "accounts.txt";

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("<script>alert('Passwords do not match!'); window.history.back();</script>");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Read existing accounts
    $accounts = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    
    // Check for duplicate username or email
    foreach ($accounts as $account) {
        list($existing_username, $existing_email, $existing_hash) = explode(",", $account);
        if ($username === $existing_username || $email === $existing_email) {
            die("<script>alert('Account already exists!'); window.history.back();</script>");
        }
    }

    // Save new account
    $new_account = "$username,$email,$hashed_password" . PHP_EOL;
    file_put_contents($file, $new_account, FILE_APPEND);
    
    // Success message and redirect
    echo "<script>alert('Account created successfully! Redirecting...');
          setTimeout(function() { window.location.href = 'account.html'; }, 2000);
          </script>";
    exit();
}
?>
