<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Product bewerken';

$message = $session->getAndDelete('message', 'Bewerk het product');

// maak een object
$product = new Product($pdo);
$rubrieken = $product->getRubrieken($pdo);
var_dump($rubrieken[0]['naam']);
// stel de id in (uit de querystring)
$product->setId($_GET['id'] ?? 0);

// stel de errors in (uit de sessie)
$product->setErrors($session->getAndDelete('errors'));

if ($product->hasNoErrors())

{
    // haal de gegevens uit de database
    $product->load();
  //  var_dump($product);
    if (!$product->getLoaded())
    {
        $session->save('message', 'Rubriek met id ' . $product->getId() . ' bestaat niet (meer) ...');
        header('location:index.php');
        exit();
    }
}
else
{
    // haal de gegevens uit de oude post

    $product->make($session->getAndDelete('post'));
//    var_dump($product);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="<?= PATH_TO_ROOT ?>css/cms.css" />
</head>

<body>

<?php
require(PATH_TO_ROOT . '../html/cmsmenu.php');
?>

<h1><?= TITLE ?></h1>

<p class="message"><?= $message ?></p>

<form action="update.php?id=<?= $product->getId() ?>" method="POST">

    <label for="naam">
        naam
        <span class="error"><?= $product->getError('naam') ?></span>
    </label>
    <input type="text" name="naam" value="<?= $product->getNaam() ?>"/>
    <label for="prijs">
        prijs
        <span class="error"><?= $product->getError('naam') ?></span>
    </label>
    <input type="text" name="prijs" value="<?= $product->getPrijs() ?>"/>

    <label for="id_rubriek">
        Rubriek
        <span class="error"><?= $product->getError('naam') ?></span>
    </label>
    <select name="id_rubriek">
        <?php
        foreach ($rubrieken as $rubriek => $item)
        {
            if ($item['id'] == $product->getId_rubriek()) {

                echo '<option value="';
                echo $item['id'];
                echo '" selected>';
                echo $item['naam'];
                echo '</option>';

                }

            else {echo '<option value="';
                  echo $item['id'];
                  echo '">';
                  echo   $item['naam'];
                  echo '</option>';}
        }
        ?>
    </select>
    <input class="button" type="submit" value="update" />

</form>

</body>

</html>