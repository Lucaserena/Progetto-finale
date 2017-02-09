<?php
session_start();
require ("header.php");
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} 
	
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $account = $_SESSION["username"];
    $rows= $db->query("SELECT first_name, last_name from account WHERE username= '$account'");
    foreach ($rows as $row){
    ?>
           <p id= "welcome"> Welcome <?= $row["first_name"] ?> <?=$row["last_name"]?> </p>
           <?php
    }


if (isset($_REQUEST["points"]) && isset ($_REQUEST["creditcard"]) && preg_match ("/^[0-9]+$/",$_REQUEST["creditcard"] )) {
    $points = $_POST["points"];
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $account = $_SESSION["username"];
    $db->exec("UPDATE account SET punti=punti+$points WHERE username = '$account'");
}
?>
<form method= "post" action = "account.php" style = "float : left;">
    <fieldset>
        <legend>Credit Point</legend>
        <h3>Your Points are:</h3> 
        <?php
        $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
        $account = $_SESSION["username"];
        $rows = $db->query("SELECT punti FROM account WHERE username = '$account'")->fetchAll();
        if (count($rows) == 1) {
            foreach ($rows as $row) {
                ?>
                <h3>   <?= $row["punti"] ?></h3>
                <?php
            }
        } else {
            ?>  <p class= "problem"> Account not found </p>  <?php
        }
        ?>
        <br/>
        <h3>Buy some Points!</h3>
        <br/>
        <select name="points">
            <option value="10">10$ = 10 points</option>
            <option value="25">20$ = 25 points</option>
            <option value="70">50$ = 70 points</option>
            <option value="160">100$ = 160 points</option>
        </select>
        <br/>
        <input id="creditcard" type="text" name="creditcard" placeholder="Credit Card" required/> <br/><pre></pre>
        <input type = "submit" value= "Buy some points!">
    </fieldset>
</form>
<?php
$bb = $db->query("SELECT * FROM loans WHERE username='$account' AND returned = '0' ")->fetchAll();
if (count($bb)>0){ ?>
    <div class ="tabellalibri" style = "height: 246pt; margin : auto;">         <!-- divs as table  -->
        <div class = "tableRow">
              <div class = "big">
  	            <h4>Borrowed book</h4>
  	          </div>

  	          <div class ="little" style = "margin-left: 20pt;">
  	            <h4>Author</h4>
              </div>

  	          <div class = "little" style = "margin-left: 20pt;">
      	            <h4>Give back</h4>
     	      </div>
        </div>
        <?php
        $query = $db->query("SELECT * FROM loans l LEFT JOIN books b ON l.idBook = b.Id WHERE l.username='$account' AND returned = '0' ");
        foreach ($query as $row2) {
            ?>       			     			
            <div class = "tableRow">
                      <div class = "big">
  		                <p> <?= $row2['title'] ?> </p>
           	          </div>
 
                      <div class = "littleInput">
  	    	              <p class= "margin"> <?= $row2['author'] ?> </p>
       	              </div>

                      <div class = "littleInput">
                            <form action = "review.php" method="post">
                                  <input type = "hidden" name="returnedBook" value = "<?php echo $row2['idBook'] ?>" >
                                  <p> <input type="submit" value="Return Book" style=" margin : 0;"> </p>
                            </form>
  	                  </div> 
            </div>  <?php
        } ?> 
    </div>    <?php
} ?> 
</body>
</html>
