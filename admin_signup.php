   <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // パスワードのハッシュ化
    
        // タイムスタンプを取得
        $timestamp = date('Y-m-d H:i:s');
    
        // データベースに接続
        $servername = ".db.sakura.ne.jp";
        $username_db = "gs1";  // データベースユーザー名
        $password_db = "--";  // データベースパスワード
        $dbname = "gs1_pj1";
        
        $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // ユーザー情報をデータベースに保存
        $stmt = $conn->prepare("INSERT INTO admin (username, password, timestamp) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        if ($stmt->bind_param("sss", $username, $hashed_password, $timestamp) === false) {
            die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        if ($stmt->execute() === false) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        } else {
            // 新しいユーザーIDを取得
            $user_id = $stmt->insert_id;
            // ハッシュIDを生成
            $hashed_id = hash('sha256', $user_id);
    
            // ハッシュIDをデータベースに保存
            $stmt_update = $conn->prepare("UPDATE admin SET hashed_id = ? WHERE id = ?");
            if ($stmt_update === false) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            if ($stmt_update->bind_param("si", $hashed_id, $user_id) === false) {
                die("Bind param failed: (" . $stmt_update->errno . ") " . $stmt_update->error);
            }
            if ($stmt_update->execute() === false) {
                die("Execute failed: (" . $stmt_update->errno . ") " . $stmt_update->error);
            }
    
            // ユーザー登録が成功した場合、バッファをクリアしてからリダイレクト
            ob_start();
            header("Location: admin_login.php");
            ob_end_flush();
            exit();
        }
    
        $stmt->close();
        $conn->close();
    }
    ?>
    
    
    
    <!DOCTYPE html>
<html>
<head>
    <title>Sign UP</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles3.css">
   
</head>
<body>
    <header>
        <div class="container">
            <h1>Sign Up</h1>
        </div>
    </header>
    <div class="container">
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="sign up">
        </form>
    </div>
</body>
</html>
