<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Rubriek bewerken';

$message = $session->getAndDelete('message', 'Bewerk de rubriek');

// maak een object
$rubriek = new Rubriek($pdo);

// stel de id in (uit de querystring)
$rubriek->setId($_GET['id'] ?? 0);

// stel de errors in (uit de sessie)
$rubriek->setErrors($session->getAndDelete('errors'));

if ($rubriek->hasNoErrors())

{
    // haal de gegevens uit de database
    $rubriek->load();
    var_dump($rubriek);
    if (!$rubriek->getLoaded())
    {
        $session->save('message', 'Rubriek met id ' . $rubriek->getId() . ' bestaat niet (meer) ...');
        header('location:index.php');
        exit();
    }
}
else
{
    // haal de gegevens uit de oude post

    $rubriek->make($session->getAndDelete('post'));

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
    
    <form action="update.php?id=<?= $rubriek->getId() ?>" method="POST">
    
        <label for="naam">
            naam
            <span class="error"><?= $rubriek->getError('naam') ?></span>
        </label>
        <input type="text" name="naam" value="<?= $rubriek->getNaam() ?>"/>
        
        <input class="button" type="submit" value="update" />
    
    </form> 

</body>

</html>