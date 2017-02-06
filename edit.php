 <?php
session_start();
require ("header.php");
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} else { ?>
	
    <form method= "post" action = "edit.php"">
           <fieldset style="margin:auto">
               <p> Insert the actual password to act some changes </p>
               <label for="name">Name</label> 
               <input id="name" type="text" name="name" placeholder="Name" value="" data-validate="required"/> <br/>
               <label for="name">Surname</label>
               <input id="surname" type="text" name="surname" placeholder="Surname" value="" data-validate="required"/> <br/>
               <label for="new_password">New password</label>
               <input id="new_password" type="password" name="new_password" maxlength="15"placeholder="New password" value="" autocomplete="off"
                      data-type="password-input" data-validate="required" /> <br/>
               <label for="repeat_new_password">Repeat new password</label>
               <input id="repeat_new_password" type="password" name="repeat_new_password" maxlength="15"placeholder="Confirm new password" value=""
                      data-type="password-input" data-validate="required" /> <br/>
               <label for="old_password">Password</label>
               <input id="old_password" type="password" name="old_password" maxlength="15"placeholder="Insert actual password for each edit" value="" autocomplete="off"
                      data-type="password-input" data-validate="required"/> <br/>
               <div class ="sign_in_button"> <input type = "submit" value= "Submit"> </div>
           </fieldset> 

   </form>
    <?php
    if (isset($_POST["old_password"])){
          $username = $_SESSION["username"];
          $db = new PDO("mysql:dbname=databaselibreria; host=localhost", "root", "");
          $rows = $db->query("SELECT * FROM account WHERE username = '$username'");           
          $password = $_POST["old_password"]; 
          $success = array();  //array of fields successfully edited
          $fail = array();   //array of fields not successfully edited
          foreach ($rows as $row){
                  if (strcmp($row["password"], $password)== 0){         //to act any change you must enter your own password
                         /* ?> <p> Successful edit </p>  <?php */
                          if (isset($_POST["name"]) && ($_POST["name"]!= "")){
                                 $name = $_POST["name"];
                                  if (preg_match("/^[a-zA-Z- ]+$/", $name) != 0){      //Your name must only include letters, dashes, or spaces.
                                       $insert = $db -> prepare ("UPDATE account SET first_name = :n WHERE username= '$username'"); 
                                       $insert-> bindParam (':n', $name);   //prevent SQL injection with parameters
                                       $insert-> execute(); 
                                       if (sizeof($success)!=0)
                                            $success[]= ", ";               //display list of edited fields divided by ","
                                       $success[] = "name";  
                                  }else{
                                        if (sizeof($fail)!=0)
                                              $fail[]= ", ";
                                        $fail[] = "name"; }                      
                          }            
                          if (isset($_POST["surname"]) && ($_POST["surname"]!= "")){
                                 $surname = $_POST["surname"];
                                  if (preg_match("/^[a-zA-Z- ]+$/", $name) != 0){ 
                                       $insert = $db->prepare("UPDATE account SET last_name = :sn WHERE username= '$username'");
                                       $insert-> bindParam (':sn', $surname);  //prevent SQL injection with parameters
                                       $insert-> execute();
                                       if (sizeof($success)!=0)
                                            $success[]= ", ";
                                       $success[] = "surname";  
                                 }else{
                                       if (sizeof($fail)!=0)
                                             $fail[]= ", ";
                                       $fail[] = "surname"; }  
                          }   

                          if (isset($_POST["new_password"]) && (preg_match ("/ /", $_POST["new_password"])== false) && (preg_match ("/</", $_POST["new_password"])== false) && isset($_POST["repeat_new_password"])){
                                 $newPass = $_POST ["new_password"];
                                 $confirm = $_POST ["repeat_new_password"];
                                 $insert = "UPDATE account SET password = '$newPass' WHERE username= '$username'";
                                 if ((strcmp($newPass, $confirm) == 0) && (strlen($newPass)>5) ){
                                     $db->exec($insert); 
                                     if (sizeof($success)!=0)
                                          $success[]= ", ";
                                     $success[] = "password";  
                                 }else{
                                      if (sizeof($fail)!=0)
                                            $fail[]= ", ";
                                      $fail[] = "password"; 
                                 } 
                          }       
                  } else { ?> <p class= "problem"> Entered password not valid </p>  <?php }
          }
               if (sizeof($success)>0){ ?> <h1> <?php
                   foreach ($success as $s)
                           echo $s;
                   ?> successfully edited </h1> <?php
               }
               if (sizeof($fail)>0){ ?> <p class="problem"> <?php
                   foreach ($fail as $f)
                           echo $f;
                   ?> unsuccessfully edited </p> <?php
               }
    }
}
?>
</body>
</html>
