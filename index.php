<?php
session_start();

if (isset($_POST ["logout"])) {
    session_destroy();
    session_regenerate_id(TRUE);
    session_start();
}
if (isset($_SESSION ["username"])){               
	//If you are already logged in you'll be redirected into account_page.php, otherwise you can see the content
    header("Location: /Libreria/account.php");
} else {
    
require ("header.php");
?>
<div id="forms">
    <form method= "post" action = "index.php">
        <fieldset>
            <legend> Sign in  </legend>
            <label for="username">Username</label> <input id="signin_username" type="text" name="signin_username" placeholder="Username" value="" data-resin-target='signin_username' required/> <br/>
            <label for="password">Password</label> <input id="signin_password" type="password" maxlength = "15" name="signin_p" placeholder="Password" value="" data-resin-target='signin_password' required/> <br/>
            <div class ="sign_in_button"> <input type = "submit" value= "Submit"> </div>
        </fieldset>
    </form>

    <form method= "post" action = "signup.php">
        <fieldset class = "container">
            <legend> Sign up  </legend>
            <label for="username">Username</label> 
            <input id="username" type="text" name="username" placeholder="Username" value="" required/> <br/>
            <label for="name">Name</label> 
            <input id="name" type="text" name="name" placeholder="Nome" value="" data-resin-target='name' required/> <br/>
            <label for="surname">Surname</label>
            <input id="surname" type="text" name="surname" placeholder="Cognome" value="" data-resin-target='name' required/> <br/>
            <label for="new_password">Password</label>
            <input id="new_password" type="password" name="password" maxlength="15"placeholder="Password" value="" autocomplete="off"
                   data-type="password-input" data-resin-target='newpassword' required/> <br/>
            <label for="confirm_password">Confirm password</label> 
            <input id="confirm_password" type="password" maxlength="15" name="confirm_password"    
                   placeholder="Conferma  password" value="" autocomplete="off" data-resin-target='confirmpassword' required/>  <br/>
            <div class ="sign_in_button"> <input type = "submit" value= "Submit"> </div>
        </fieldset>
    </form>
</div>


<?php
if (isset($_POST["signin_username"]) && isset($_POST["signin_p"]) && (preg_match ("/^[a-zA-Z0-9-_]+$/", $_POST["signin_username"]))) {
    $signin_username = $_POST["signin_username"];
    $pass = $_POST["signin_p"];
    $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
    $rows = $db->query("SELECT password FROM account WHERE username = '$signin_username'")->fetchAll();
    if (count($rows) == 1) {
        foreach ($rows as $row)
            if (strcmp($row["password"], $pass) == 0) {
                $_SESSION["username"] = $signin_username;                  //username will be the session identifier
                header("Location: /Libreria/account.php");
            } else {
                ?>  <p class= "problem"> Password given not valid </p>  <?php
            }
    } else {
        ?>  <p class= "problem"> Account not found </p>  <?php
    }
}
?>
<h1>Online Bookstore</h1>

<div class ="tabellalibri">
        <div class = "tableRow">
         	<div class = "little">
  	        	<h4> Author </h4>
  	        </div>

  	        <div class ="veryBig">
  		        <h4> Title </h4>
  	        </div> 

        	<div class = "veryLittle">
    	        <h4> Year </h4>
  	        </div>
        </div>

        <?php
        $db = new PDO ("mysql:dbname=databaselibreria; host=localhost", "root" , "");
        $rows = $db->query ("SELECT * FROM books");     
        foreach ($rows as $row){
           ?> 			    				
                <div class= "tableRow">
																				
                     <div class = "little">
  		                  <p> <?= $row['author'] ?> </p>
       	             </div>

                     <div class = "veryBig">
  		                   <p> <?= $row['title'] ?> </p>
       	             </div>

                     <div class = "veryLittle">
  	                      <p> <?= $row['year'] ?> </p>
       	             </div> 
                </div> 
        <?php }
}         ?>   
</div>
</body>
</html>
