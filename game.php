<?php
session_start();
if (!isset($_SESSION["username"])){
	header("Location: /Libreria/index.php");
} 
require ("header.php");
?>
<script src="http://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>

<script src ="game.js"></script>

<div id = "game" type="text/javascript">
<p id="score"> start to play! </p>    
<table>      
<?php                                   //creating a table. The id of the cells is "frame" + number of row + number of the column
   for ($i=0; $i < 10; $i++){
        ?> <tr>
         <?php
          for ($j=0; $j < 10; $j++){
              $ident = "frame".$i.$j;
              ?> <td class="cell" id= "<?=$ident?>">   </td> <?php
          }
           ?> </tr> <?php
   }
?>
</table>
<p id="controls">
<button onclick="Shuffle()" id="shufflebutton">Start</button>
<p id= "timer">  </p>
</div>
</body>
</html>


