<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Bestelling toevoegen';

// maak rubriek-object
$bestelling = new Bestelling($pdo);
$tafels = $bestelling->getTafels($pdo);

// haal eventueel message uit de sessie
$message = $session->getAndDelete('message', 'Voer een nieuwe Bestelling in');

// vul de database-velden van het rubriek-object met lege waarden of waarden uit de sessie
$bestelling->make($session->getAndDelete('post', []));

// haal eventueel errors uit de sessie en stop ze in het rubriek-object
$bestelling->setErrors($session->getAndDelete('errors', []));


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
    
        <label for="volgnummer">
            volgnummer
            <span class="error"><?= $bestelling->getError('volgnummer') ?></span>
        </label>
        <input id="volgnummer" type="text" name="volgnummer" value="<?= $bestelling->getVolgnummer() ?>" />
        <label for="besteltijd">
            besteltijd
            <span class="error"><?= $bestelling->getError('besteltijd') ?></span>
        </label>
        <input id="besteltijd" type="text" name="besteltijd" value="<?=date('Y-m-d H:i:s');;?>">


        <label for="volgnummer">
            volgnummer
            <span class="error"><?= $bestelling->getError('serveertijd') ?></span>
        </label>
        <input id="volgnummer" type="text" name="volgnummer" value="<?= $bestelling->getServeertijd() ?>" />




        <label for="id_tafel">
            tafel
            <span class="error"><?= $bestelling->getError('id_tafel') ?></span>
        </label>

        <select name="id_tafel">


            <?php

            foreach ($tafels as $tafel => $item)
            {?>

                <option value="<?=$item['id']?>"><?=$item['nummer']?></option>

            <?php
            }
            ?>




        </select>

        
        <input class="button" type="submit" value="bewaar">
    
    </form>

</div>

</body>

</html>