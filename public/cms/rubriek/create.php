<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Rubriek toevoegen';

// maak rubriek-object
$rubriek = new Rubriek($pdo);

// haal eventueel message uit de sessie
$message = $session->getAndDelete('message', 'Voer een nieuwe rubriek in');

// vul de database-velden van het rubriek-object met lege waarden of waarden uit de sessie
$rubriek->make($session->getAndDelete('post', []));

// haal eventueel errors uit de sessie en stop ze in het rubriek-object
$rubriek->setErrors($session->getAndDelete('errors', []));


?>
<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="<?= PATH_TO_ROOT ?>css/cms.css" />
</head>

<body>

<div class="container">

<?php
    require(PATH_TO_ROOT . '../html/cmsmenu.php');
?>

    <h1><?= TITLE ?></h1>
    
    <p class="message"><?= $message ?></p>
    
    <form action="save.php" method="POST">
    
        <label for="naam">
            naam
            <span class="error"><?= $rubriek->getError('naam') ?></span>
        </label>
        <input id="naam" type="text" name="naam" value="<?= $rubriek->getNaam() ?>" />
        
        <input class="button" type="submit" value="bewaar" />
    
    </form> 

</div>

</body>

</html>