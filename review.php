 <?php
session_start();
require ("header.php");
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} 
	

if (isset($_POST["txtcomment"])&& isset($_POST["idbook"])) {
    $account = $_SESSION["username"];
    $text = $_POST["txtcomment"];
    $user = $_SESSION["username"];
    $libro = $_POST["idbook"];
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $db->exec("UPDATE loans SET review = '$text' WHERE username = '$user' AND idBook = '$libro' AND returned = '1'");
    $db->exec("UPDATE account SET punti = punti + 1 WHERE username = '$account'");
    $db->exec("UPDATE books SET borrowed = '0' WHERE Id = '$libro'");
    ?>   <h1 class="reviewmsg"> Thanks for your opinion! </h1>   <?php
}
if (isset($_SESSION["username"]) && isset($_POST["returnedBook"])) {
    $user = $_SESSION["username"];
    $book = $_POST["returnedBook"];
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $db->exec("UPDATE books SET borrowed = '0' WHERE Id = '$book'");
    $db-> exec("UPDATE loans SET returned = '1' WHERE username = '$user' AND idBook = '$book' ");
    ?> 
    <h3> Review one book you read from us </h3>

    <form method="POST" action="review.php">
        <textarea id="txtcomment" name="txtcomment" rows= "5" cols= "40"></textarea><br />
        <input type ="hidden" name="idbook" value="<?= $book ?>" />
        <input type = "submit" class = "button" value= "Comment" style= "width:130pt;">
    </form> 
    <?php
}
?>        
</body>
</html>


