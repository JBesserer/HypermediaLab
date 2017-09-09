<?php
session_start();
error_reporting(0);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <?php
        include ('../PageInject/EnteteClient.php');
        ?>
        
        <p> <?php echo "Bonjour M." . $_SESSION["typeUtilisateur"] ?></p>
    </body>
</html>

