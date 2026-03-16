<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nev = $_POST["nev"] ?? "";
    $jelszo = $_POST["jelszo"] ?? "";

    if ($nev === "" || $jelszo === "") {
        $error = "Minden mező kitöltése kötelező!";
    } else {
        
        $check = $conn->query("SELECT * FROM users WHERE username='$nev'");

        if ($check->num_rows > 0) {
            $error = "Ez a Felhasználó már létezik";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$nev', '$jelszo')";
            if ($conn->query($sql) === TRUE) {
                $success = "Sikeres regisztráció!";
            } else {
                $error = "Hiba történt: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<body>

<h2>Regisztráció</h2>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<form method="post">
    <label>E-mail:</label><br>
    <input type="email" name="email"><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="jelszo"><br><br>

    <button type="submit">Regisztráció</button>
</form>

<p><a href="log.php">Belépés</a></p>

</body>
</html>

<?php
$conn->close();
?>
