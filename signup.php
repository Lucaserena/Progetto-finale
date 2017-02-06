<?php
require ("header.php");
if (isset($_SESSION ["username"])){  
	//If you are already logged in you'll be redirected into account_page.php, otherwise you can see the content
    header("Location: /Libreria/account.php");
} 
 if (isset($_REQUEST["username"]) && isset($_REQUEST["name"]) && isset($_REQUEST["surname"]) && isset($_REQUEST["password"]) 
       && isset($_REQUEST["confirm_password"])) {
      $username= $_REQUEST["username"];
      $name= $_REQUEST["name"];
      $surname= $_POST["surname"];
      $new_password= $_POST["password"];
      $confirm= $_POST["confirm_password"];
  
      if ($confirm != $new_password){
           ?> <p class = "problem" > Entered passwords don't match </p> <?php
      }elseif ((strlen($confirm) < 6) && (preg_match ("/</", $new_password)== false)){ //prevent HTML injection
           ?> <p class = "problem" > Enter password with at least 6 characters and without the unallowed symbols</p> <?php
      }else{ 

           $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root" , "");
           $rows = $db -> query ("SELECT * FROM account WHERE username = '$username'")->fetchAll();
           $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           if ((count ($rows)==0) && (preg_match("/^[a-zA-Z-]+$/", $name) != 0) && (preg_match("/^[a-zA-Z-]+$/", $surname) != 0) && (preg_match ("/^[a-zA-Z0-9-_]+$/", $username))){ 
               $insert =$db->prepare ("INSERT INTO account (username, first_name, last_name, password,mail,punti) VALUES (:user, :name, :username, :pass, 'NULL', '10')");
               $insert->bindParam(':user', $username);
               $insert->bindParam(':name', $name);
               $insert->bindParam(':username', $surname);
               $insert->bindParam(':pass', $new_password);
               $insert->execute();          
               $db = null;
               ?> <p class = "avviso" > Thank you for the registration! You received 10 complimentary points</p> <?php
           }else {
              ?> <p class = "problem" > Username not available </p> <?php
           } 
      }
 }

?>      
              <input type="button" class = "button" onclick="location.href='index.php';" value="Come back to the main page" style= "margin-top:150pt"/>
    </body>
</html>