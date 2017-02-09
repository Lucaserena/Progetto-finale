
<head>
    <title>Sign</title>
    <meta charset="utf-8" />
	<meta name="keywords" content="Online, Bookstore, Online Bookstore">
	 <meta name="author" content="Luca Serena">
    <link type="text/css" href="style.css" rel="stylesheet" />
    <link rel="icon" href="image/favicon.ico" />
    <script src ="menu.js"> </script>
</head>

<body> 
    <?php 
	if (isset($_SESSION["username"])) { ?>
        <div id = "header"> 
            <h2>ONLINE BOOKSTORE</h2>
            <div class="menu"> 
                <button onclick="myFunction()" class="dropbtn">Dropdown</button>
                <div id="myDropdown" class="dropdown-content">
                      <a href="game.php">Minesweeper</a>
                      <a href="edit.php">Change profile</a>
                      <a href="loans.php">Borrow a book</a>
                      <a href="account.php"><img src="image/home.png" height="30px" width="30px"></a>
                      <a>   <form action= "index.php" method= "post">
                                <input type= "submit" value ="log-out">
                                <input type = "hidden" name = "logout" value = "true">
                            </form>
                      </a>
                </div>
            </div>  
        </div>
<?php   }  ?>