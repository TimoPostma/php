<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Product toevoegen';

// maak rubriek-object
$product = new Product($pdo);
$rubrieken = $product->getRubrieken($pdo);

// haal eventueel message uit de sessie
$message = $session->getAndDelete('message', 'Voer een nieuwe rubriek in');

// vul de database-velden van het rubriek-object met lege waarden of waarden uit de sessie
$product->make($session->getAndDelete('post', []));

// haal eventueel errors uit de sessie en stop ze in het rubriek-object
$product->setErrors($session->getAndDelete('errors', []));


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
            <span class="error"><?= $product->getError('naam') ?></span>
        </label>
        <input id="naam" type="text" name="naam" value="<?= $product->getNaam() ?>" />
        <label for="prijs">
            prijs
            <span class="error"><?= $product->getError('prijs') ?></span>
        </label>
        <input id="prijs" type="text" name="prijs" value="<?=$product->getPrijs()?>">
        <label for="id_rubriek">
            Rubriek
            <span class="error"><?= $product->getError('id_rubriek') ?></span>
        </label>

        <select name="id_rubriek">


            <?php

            foreach ($rubrieken as $rubriek => $item)
            {?>

                <option value="<?=$item['id']?>"><?=$item['naam']?></option>

            <?php
            }
            ?>




        </select>

        
        <input class="button" type="submit" value="bewaar">
    
    </form>

</div>

</body>

</html>