<?php
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== "yes") {
  header("location: index.php");
  echo ("du er ikke admin");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bot system Linje-5</title>
  <?php
    include "css.php";
    ?>
  <link rel="icon" type="image/x-icon" href="assets/jpg/linje5.jpg">
</head>

<body>

  <ul class="topnav">
          <li><a href="index.php"><img src="assets/svg/house-03-svgrepo-com.svg" class="menyicon" height="40px" width="auto"></a>
                              </li>
          <li><a href="leggtil.php"><img src="assets/svg/file-add-svgrepo-com.svg" class="menyicon" height="40px"
          width="auto"></a></li>
          <li><a href="profil.php"><img src="assets/svg/user-01-svgrepo-com.svg" class="menyicon" height="40px"
                    width="auto"></a></li> 
          <li><a href="FAQ.php"><img src="assets\svg\circle-help-svgrepo-com.svg" class="menyicon" height="40px"
                    width="auto"></a></li>
          <li><a href='admin.php'><img src='assets/svg/file-edit-svgrepo-com.svg' class='menyiconAktiv' height='40px' width='auto'></a></li>

  </ul>
  
<div class="velkommen">
  <h1 >Velkommen administrator
    <?php echo ($_SESSION["navn"]); ?>!
  </h1>
</div>
  <div class="updatebuttons">
    <button onclick="opptnavn()" class="betalebtn">Oppdater navn</button>
    <button onclick="oppttotal()" class="betalebtn">Oppdater total</button>
    <button onclick="opptubetalt()" class="betalebtn">Oppdater ubetalt</button>
  </div>

  <table id="score">
    <tr>
      <th class="TABLE">Navn</th>
      <th class="TABLE">Total</th>
      <th class="TABLE">Total ubetalt</th>
      <th class="TABLE">Oppdatere tabel</td>
    </tr>
    <!--Her henter man ut alle brukere fra databasen og vier dem fremm på amdin siden
    med knapper forå endre data i databasen -->
    <?php
  
    $sql = "SELECT navn, total, ubetalt FROM login ORDER BY CONVERT(total,INTEGER) DESC";

   
    $result = $link->query($sql);

    
    if ($result->num_rows > 0) {
    
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='TABEL'>" . $row["navn"] . "</td>";
        echo "<td class='TABEL'>" . $row["total"] . "</td>";
        echo "<td class='TABEL'>" . $row["ubetalt"] . "</td>";
        echo "<td class='TABEL'><form method='post' action='update.php' class='updateform'>
                <input type='hidden' name='submit' value='submit'>        
                <input type='hidden' name='id' value='" . $row["navn"] . "'>
                <input type='number' name='ubetalt' placeholder='" . $row["ubetalt"] . "'>
                <input type='submit' name='submit' value='Oppdater' id='sumbit' class='oppdaterbtn'>
                </form>
                <form method='post' action='update.php' class='updateform2'>
                <input type='hidden' name='submit2' value='submit2'>
                <input type='hidden' name='id2' value='" . $row["navn"] . "'>
                <input type='number' name='total' placeholder='" . $row["total"] . "'>
                <input type='submit' name='submit2' value='Oppdater' id='' class='oppdaterbtn'>
                </form>
                <form method='post' action='update.php' class='updateform3'>
                <input type='hidden' name='submit3' value='submit3'>
                <input type='hidden' name='id3' value='" . $row["navn"] . "'>
                <input type='text' name='navn' placeholder='" . $row["navn"] . "'>
                <input type='image' src='assets/svg/check-svgrepo-com.svg'  alt='Submit' name='submit3' value='Oppdater' id='' class='oppdaterbtn'style='width: auto; height: 20px;'/>
                </form></td>";
        echo "</tr>";
      
      }
    }
    ?>
    <tr>
      <th>Total</th>
      <?php
      $count = "SELECT SUM(total) FROM login";
      $result = $link->query($count);
    
      while ($row = mysqli_fetch_array($result)) {
        echo "<td>" . $row['SUM(total)'] . "</td>";
      }
      ?>
    </tr>
  </table>

  <script>

    function opptnavn() {
      document.querySelectorAll(".updateform").forEach(a => a.style.display = "none");
      document.querySelectorAll(".updateform3").forEach(a => a.style.display = "block");
      document.querySelectorAll(".updateform2").forEach(a => a.style.display = "none");
    }

    function oppttotal() {
      document.querySelectorAll(".updateform").forEach(a => a.style.display = "none");
      document.querySelectorAll(".updateform2").forEach(a => a.style.display = "block");
      document.querySelectorAll(".updateform3").forEach(a => a.style.display = "none");
    }
    function opptubetalt() {
      document.querySelectorAll(".updateform").forEach(a => a.style.display = "block");
      document.querySelectorAll(".updateform2").forEach(a => a.style.display = "none");
      document.querySelectorAll(".updateform3").forEach(a => a.style.display = "none");
    }

  </script>
</body>

</html>