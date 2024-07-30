<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    // データベースに接続
    $servername = ".db.sakura.ne.jp";
    $username_db = "gs1";  // ユーザー名
    $password_db = "--";  // パスワード
    $dbname = "gs1_pj1";
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ユーザー情報をデータベースから取得
    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username_db_result, $password_db_hashed);
        $stmt->fetch();
        if (password_verify($password_input, $password_db_hashed)) {
            // ユーザーが認証された場合
            header('Location: admin.php');
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

                
                
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles3.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Login</h1>
        </div>
    </header>
    <div class="container">
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
            <input type="submit" value="Log in">
        </form>
        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>
        <div class="signin-link">
            <a href="admin_signup.php">初めての方はこちら</a>
        </div>
    </div>
</body>
</html>
                