<?php
// データベース接続情報
$servername = ".db.sakura.ne.jp";
$username_db = "gs1";  // ユーザー名
$password_db = "--";  // パスワード
$dbname = "gs1_pj1";


// データベース接続
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POSTリクエスト処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 一括削除
    if (isset($_POST['delete_selected'])) {
        if (!empty($_POST['delete_ids'])) {
            $delete_ids = implode(',', array_map('intval', $_POST['delete_ids']));
            $sql_delete = "DELETE FROM users WHERE id IN ($delete_ids)";
            $conn->query($sql_delete);
        }
    }
    // 個別削除
    if (isset($_POST['delete'])) {
        $id_to_delete = intval($_POST['delete']);
        $sql_delete = "DELETE FROM users WHERE id = $id_to_delete";
        $conn->query($sql_delete);
    }
    // 編集
    if (isset($_POST['edit'])) {
        $id_to_edit = intval($_POST['id']);
        $username = $_POST['username'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $timestamp = $_POST['timestamp'];
        $sql_update = "UPDATE users SET username = '$username', email = '$email', message = '$message', timestamp = '$timestamp' WHERE id = $id_to_edit";
        $conn->query($sql_update);
    }
}

// 検索条件の設定
$search_hashed_id = "";
if (isset($_POST['search_hashed_id'])) {
    $search_hashed_id = $_POST['search_hashed_id'];
}

// user_dataテーブルのデータを取得
$sql = "SELECT id, username, hashed_id, email, message, timestamp FROM users";
if (!empty($search_hashed_id)) {
    $sql .= " WHERE hashed_id LIKE '%" . $conn->real_escape_string($search_hashed_id) . "%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Data List</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles2.css">
</head>
<body>
<header>
    <div class="container">
        <h1>Data List</h1>
        <div class="subtitle">
            <a href="index.php" class="admin-link">user画面に戻る</a>
        </div>
        <div class="link-container">
            <a href="admin_logout.php" class="logout-button">Log Out</a>
        </div>
    </div>
</header>
<div class="container">
    <div class="search-container">
        <form method="post" action="" class="search-form">
            <input type="text" name="search_hashed_id" class="search-input" placeholder="Search by Hashed ID" value="<?php echo htmlspecialchars($search_hashed_id); ?>">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <div class="data-container">
        <form method="post" action="">
            <div class="button-container">
                <button type="submit" name="delete_selected" class="delete-selected-button" onclick="return confirm('Are you sure you want to delete selected entries?')">一括削除</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="username-column">Username</th>
                        <th class="hashed-id-column">Hashed ID</th>
                        <th class="email-column">Email</th>
                        <th class="message-column">Message</th>
                        <th class="timestamp-column">Timestamp</th>
                        <th class="action-column">Actions</th>
                        <th class="select-column">Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='username-column'>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td class='hashed-id-column'>" . htmlspecialchars($row['hashed_id']) . "</td>";
                            echo "<td class='email-column'>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td class='message-column'>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td class='timestamp-column'>" . htmlspecialchars($row['timestamp']) . "</td>";
                            echo "<td class='button-group'>
                                    <button type='button' class='edit-button' data-id='" . $row['id'] . "' data-username='" . htmlspecialchars($row['username']) . "' data-hashed_id='" . htmlspecialchars($row['hashed_id']) . "' data-request_type='" . htmlspecialchars($row['request_type']) . "' data-request_content='" . htmlspecialchars($row['request_content']) . "' data-timestamp='" . htmlspecialchars($row['timestamp']) . "'>編集</button>
                                    <button type='submit' name='delete' value='" . $row['id'] . "' class='delete-button' onclick='return confirm(\"Are you sure?\")'>削除</button>
                                  </td>";
                            echo "<td class='select-column'><input type='checkbox' name='delete_ids[]' value='" . $row['id'] . "'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<!-- 編集モーダル -->
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="post" action="">
            <input type="hidden" name="id" id="edit-id">
            <label for="edit-username">Username:</label>
            <input type="text" name="username" id="edit-username" required>
            <label for="edit-hashed_id">Hashed ID:</label>
            <input type="text" name="hashed_id" id="edit-hashed_id" readonly>
            <label for="edit-email">Request Type:</label>
            <input type="text" name="email" id="edit-email" required>
            <label for="edit-message">Request Content:</label>
            <input type="text" name="message" id="edit-message" required>
            <label for="edit-timestamp">Timestamp:</label>
            <input type="text" name="timestamp" id="edit-timestamp" required>
            <button type="submit" name="edit">更新</button>
        </form>
    </div>
</div>

<script>
    // モーダル表示用のスクリプト
    var modal = document.getElementById('edit-modal');
    var span = document.getElementsByClassName('close')[0];

    document.querySelectorAll('.edit-button').forEach(button => {
        button.onclick = function() {
            modal.style.display = 'block';
            document.getElementById('edit-id').value = this.getAttribute('data-id');
            document.getElementById('edit-username').value = this.getAttribute('data-username');
            document.getElementById('edit-hashed_id').value = this.getAttribute('data-hashed_id');
            document.getElementById('edit-email').value = this.getAttribute('data-email');
            document.getElementById('edit-message').value = this.getAttribute('data-message');
            document.getElementById('edit-timestamp').value = this.getAttribute('data-timestamp');
        };
    });

    span.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
</script>
</body>
</html>