<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */
 
// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

const TITLE = 'product verwijderen';

// maak een object
$product = new Product($pdo);

// stel de id in (uit de querystring)
$product->setId($_GET['id'] ?? 0);

// haal de rubriek met de gegeven id uit de database
$product->load();
if (!$product->getLoaded())
{
    $session->save('message', 'Rubriek met id <strong>' . $product->getId() . '</strong> bestaat niet (meer) ...');
    header('location:index.php');
    exit();
}
else
{
    if (!$product->deletable())
    {
        $session->save('message', 'Rubriek <strong>' . $product->getNaam() . '</strong> is in gebruik en mag daarom niet verwijderd worden ...');
        header('location:index.php');
        exit();
    }
    else
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $product->delete($ok);
            $session->save('message', 'Rubriek <strong>' . $product->getNaam() . '</strong> is ' . ($ok ? '' : 'NIET') . ' verwijderd');
            header('location:index.php');
            exit();
        }        
    }
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
    
    <p>Weet je zeker dat je de rubriek <strong><?= $product->getNaam() ?></strong> wil verwijderen?</p>
        
    <form action="delete.php?id=<?= $product->getId() ?>" method="POST">
            
        <input class="button" type="submit" value="ja, verwijder" />
    
    </form>

</body>

</html>