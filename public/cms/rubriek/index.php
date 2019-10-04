<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Rubrieken';

// haal de rubriekobjecten op
$rubrieken = Rubriek::index($pdo);

// haal eventueel message uit de sessie
$message = $session->getAndDelete('message');

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?></title>
    <link rel="stylesheet" type="text/css" href="<?= PATH_TO_ROOT ?>css/cms.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
</head>

<body>

<?php
    require(PATH_TO_ROOT . '../html/cmsmenu.php');
?>

    <h1><?= TITLE ?></h1>

<?php
    if (isset($message))
    {
?>
    <p class="message"><?= $message ?></p>
<?php
    }
?>
    
<?php
    if (empty($rubrieken))
    {
?>
    <p>Nog geen rubrieken aanwezig...</p>
<?php
    }
    else
    {
?>
    <table class="index">
        <thead>
            <tr>
                <td>naam</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
<?php
        foreach($rubrieken as $rubriek)
        {
?>
            <tr>
                <td>
                    <?= $rubriek->getNaam() ?>
                </td>
                <td class="icon">
                    <a title="bewerken" href="edit.php?id=<?= $rubriek->getId() ?>">
                        <span class="far fa-edit"></span>
                    </a>
                </td>
                <td class="icon">
<?php       
            if ($rubriek->getAantalProducten() != 0)
            {
?>
                    <span class="far fa-trash-alt"></span>
<?php
            }
            else
            {
?>
                    <a title="verwijderen" href="delete.php?id=<?= $rubriek->getId() ?>">
                        <span class="far fa-trash-alt"></span>
                    </a>
<?php
            }
?>
                </td>
            </tr>
<?php
        }
?>
        </tbody>
    </table>
<?php
    }
?>

</body>

</html>