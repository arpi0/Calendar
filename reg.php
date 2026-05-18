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
    <head> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   </head>
    <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="Main.php">Calendar
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <button class="nav-link active" aria-current="page" onclick="newdate()" href="#">New</button> 
        </li>
        <li class="nav-item">
         <a  class="nav-link active" href="log.php" >Log/Reg</a>
        </li>
  <li class="nav-item">
    <a class="nav-link active"  aria-current="page" href="#" id="demo" 
    <?php $sql="SELECT username FROM users WHERE last_log  LIMIT 1 "; $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
     ?> <h1> <?php  echo "Welcome, " . $row["username"] . "!"; ?></h1> <?php
    } else {
        echo "No user found.";
    }
    ?>
  </a>
  </li>
      </ul>
    </div>
  </div>
</nav>
</header>
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
    <input type="text" name="nev"><br><br>

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
