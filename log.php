<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nev = $_POST["nev"] ?? "";
    $jelszo = $_POST["jelszo"] ?? "";

    if ($nev === "" || $jelszo === "") {
        $error = "Ne hagyj üres mezőt!";
    } else {
        $sql = "SELECT * FROM users WHERE username='$nev'";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {

            $error = "helytelen email cím";
        } else {  
            $user = $result->fetch_assoc();
            if ($user["jelszo"] === $jelszo) {
                $success = "Sikeres belépés!";
                 $sql = "INSERT INTO users (last_log) VALUES (CURRDATE() ) WHERE username='$nev'";
                    $conn->query($sql);
            }
             else {
                $error = "Hibás jelszó!";
            }
        }
    }
}  
?>
<!DOCTYPE html>
<html lang="hu">
<body>
<h2>Belépés</h2>
<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>
<form method="post">
    <label>E-mail:</label><br>
    <input type="text" name="nev"><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="jelszo"><br><br>

    <button type="submit">Belépés</button>
</form>
<p><a href="reg.php">Regisztráció</a></p>

</body>
</html>

<?php
$conn->close();
?>
