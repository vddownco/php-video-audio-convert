<?php
// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    
    // Basic validation
    if (empty($name) || empty($email)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $success = "Thank you, " . $name . "! Your information has been received.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Processing Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success {
            color: #28a745;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007cba;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #007cba;
            border-radius: 4px;
        }
        .back-link:hover {
            background-color: #007cba;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Processing Result</h1>
        
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
            <p>Name: <?php echo $name; ?></p>
            <p>Email: <?php echo $email; ?></p>
        <?php elseif (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="error">No form data received.</div>
        <?php endif; ?>
        
        <a href="index.php" class="back-link">← Back to Form</a>
    </div>
</body>
</html>