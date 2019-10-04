<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// paginatitel als constante
const TITLE = 'Producten';

// haal de rubriekobjecten op
$bestellingen = Bestelling::index($pdo);

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
if (empty($bestellingen))
{
    ?>
    <p>Nog geen producten aanwezig...</p>
    <?php
}
else
{
    ?>
    <table class="index">
        <thead>
        <tr>
            <td>volgnummer</td>
            <td></td>
            <td></td>
            <td>besteltijd</td>
            <td>tafel</td>
            <td>serveertijd</td>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach($bestellingen as $bestelling)
        {?>
            <tr>
                <td>
                    <?= $bestelling->getVolgnummer() ?>
                </td>
                <td class="icon">
                    <a title="bewerken" href="edit.php?id=<?= $bestelling->getId() ?>">
                        <span class="far fa-edit"></span>
                    </a>
                </td>
                <td class="icon">
                    <?php
                    if ($bestelling->getServeertijd() > 0)
                    {
                        ?>
                        <span class="far fa-trash-alt"></span>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a title="verwijderen" href="delete.php?id=<?= $bestelling->getId() ?>">
                            <span class="far fa-trash-alt"></span>
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?= $bestelling->getBesteltijd() ?>
                </td>
                <td>
                    <?= $bestelling->getIdTafel() ?>
                </td>

                <td>
                    <?= $bestelling->getServeertijd() ?>
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