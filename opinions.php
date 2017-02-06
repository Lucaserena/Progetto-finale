<?php
session_start();
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} 	
require ("header.php");
if (isset($_SESSION["username"])) {
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $id = $_GET["id"];
    $rows = $db->query ("SELECT username, review FROM loans WHERE idBook='$id'");
    $number=0;
    ?> <div class= "revBox"> <?php
    foreach ($rows as $row){       
		if (isset($row["review"])){      //not showing where there's not a review
			$number++;
            ?> <div class="rev"> Review  <?= $number ?> <br/>
            from: <?= $row["username"]?> <br/>
            <?= $row["review"]?> </div> <?php
		}
    }
    ?> <div> <?php
    if ($number==0){
        ?> <h3 class="reviewmsg"> No reviews for this book </h3> <?php
    }
}
?> 
</body>
</html>
