<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Winlorant Tracker</title>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
</head>

<body>
    <div class="form-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username-tag">Username & Tag</label>
                <div class="tag-container">
                    <input type="text" class="username " id="username" name="username" placeholder="Username" maxlength="16" required>
                    <input type="text" class="tag" id="tag" name="tag" placeholder="Tag" maxlength="5" required>
                </div>
            </div>
            <button type="submit" class="btn-submit">Register</button>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['username']) && isset($_POST['tag'])) {
                    include_once 'get_user_region.php';
                    $database_config = include_once '../../src/config/database.php';

                    $host = $database_config['host'];
                    $dbname = $database_config['dbname'];
                    $user = $database_config['user'];
                    $password = $database_config['password'];

                    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                    $username = $_POST['username'];
                    $tag = $_POST['tag'];
                    $region = get_user_region($username, $tag);

                    if (!$region) {
                        echo "<p class='error'>Invalid username or tag</p>";
                        return;
                    }

                    $query = "SELECT * FROM users WHERE username = :username AND tag = :tag";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
                    $stmt->execute();
                    $user = $stmt->fetch();

                    if (!$user) {
                        $query = "INSERT INTO users (username, tag, region) VALUES (:username, :tag, :region)";
                        $stmt = $db->prepare($query);
                        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                        $stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
                        $stmt->bindValue(':region', $region, PDO::PARAM_STR);
                        $stmt->execute();
                    }

                    setcookie('username', $username, [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                    ]);
                    setcookie('tag', $tag, [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                    ]);
                    setcookie('region', $region, [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                    ]);

                    header('Location: ../index.php');
                }
            }
            ?>
        </form>
    </div>
</body>

</html>