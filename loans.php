<?php
session_start();
require ("header.php");
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} 	
    if (isset($_REQUEST["borrbook"])) {
        $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
        $account = $_SESSION["username"];
        $idbook = $_POST["borrbook"];
        $rows = $db-> query ("SELECT punti FROM account WHERE username = '$account'");
        foreach ($rows as $row){
                  $points = $row ["punti"];
                  if ($points > 3){
                               $db-> exec("UPDATE books SET borrowed= '1' WHERE Id='$idbook'");
                               $db-> exec("INSERT INTO loans VALUES ('$account','$idbook', NULL, 0)");
                               $db-> exec("UPDATE account SET punti = punti - 4 WHERE username = '$account'");
                  } else {   ?>  <h1> No enough points </h1> <?php 
                  }
        }
    }
?>

<div class ="tabellalibri" style = "width:70%;">
       <div class = "tableRow">
          <div class = "little">
                   <h4>Take it</h4>
          </div>

          <div class = "little">
  	     	<h4>Author</h4>
          </div>

          <div class ="big">
  		<h4>Title</h4>
          </div>

          <div class = "veryLittle">
    	        <h4>Year</h4>
          </div>
      </div>

            <?php
            $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
            $rows = $db->query("SELECT * FROM books");
            foreach ($rows as $row) {
                if ($row['borrowed'] == 0) {
                    ?>
                    <div class = "tableRow green">
                          <form action = "loans.php" method="post">
                              <div class = "littleInput" >
                                 <input class= "inputMP" type ="hidden" name="borrbook" value="<?= $row['Id'] ?>" />
                                 <input type="submit" value="Borrow Book" /> 
                              </div>
                           </form>
                        <?php
                } else {
                    ?>
                <div class = "tableRow red">
                      <div class = "littleInput">
                            <input class= "inputMP" type="submit" value="Out of Stock" name="borrowbook" disabled />
                      </div>
                            <?php
                       }
                                   ?>
                      <div class = "littleInput">
        	               <p class = "margin" > <?= $row['author'] ?> </p>
       	              </div> 

                      <div class = "big">
  		                 <p> <?= $row['title'] ?> </p>
       	              </div>

                      <div class = "veryLittle">
  	                  	   <p> <?= $row['year'] ?> </p>
       	              </div> 
                      <div class= "little">
                          <a href="opinions.php?id=<?= $row['Id']?>"> See reviews </a>
                      </div> 
                </div>
                <?php
            }
            ?> 
</div>
</body>
</html>
