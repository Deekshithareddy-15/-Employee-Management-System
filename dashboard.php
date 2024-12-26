<?php
session_start();

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if (time() - $_SESSION['last_activity'] > $_SESSION['expire_time']) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=Session expired, please log in again.");
    exit();
}

$_SESSION['last_activity'] = time(); 

$employee_name = $_SESSION['name'];
$employee_id = $_SESSION['employee_id'];
$login_success_message = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : null;

unset($_SESSION['login_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }
        .dashboard-container h2 {
            color: #0056b3;
            margin-bottom: 10px;
        }
        .welcome-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }
        .nav-links {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .nav-links a {
            color: #0056b3;
            font-weight: bold;
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 15px;
            background-color: #e7f1ff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .nav-links a:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
        .logout-button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #ff3b3b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #d32f2f;
        }
        .popup-message {
            display: none; 
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Employee Dashboard</h2>
        <p class="welcome-message">Welcome to your dashboard, <?php echo htmlspecialchars($employee_name); ?>!</p>
        
        <div class="nav-links">
            <a href="#">Profile</a>
            <a href="#">Tasks</a>
            <a href="#">Messages</a>
            <a href="#">Settings</a>
        </div>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
    <?php if ($login_success_message): ?>

        <div class="popup-message" id="popupMessage">
            <?php echo htmlspecialchars($login_success_message); ?>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var popup = document.getElementById("popupMessage");
                popup.style.display = "block";
                
                setTimeout(function() {
                    popup.style.display = "none";
                }, 3000);
            });
        </script>
    <?php endif; ?>
</body>
</html>
