<?php
    $menu = [
        'Rubrieken'         => 'rubriek/index.php',
        'Rubriek toevoegen' => 'rubriek/create.php',
        'producten'         => 'product/index.php',
        'product toevoegen' => 'product/create.php',
        'bestellingen'         => 'bestelling/index.php',
        'bestelling toevoegen' => 'bestelling/create.php',
        'tafels'         => 'tafel/index.php',
        'tafel toevoegen' => 'tafel/create.php'
    ];
    
    $listitems = [];
    foreach ($menu as $tekst => $href)
    {
        $class = $tekst == TITLE ? 'active' : 'passive';
        $listitems[] = '<li class="' . $class . '"><a href="' . PATH_TO_ROOT . 'cms/' . $href . '">' . $tekst . '</a></li>' . PHP_EOL;
    }
?>
<nav>

    <ul>
        <?= join('<li>|</li>', $listitems) ?>
    </ul>

</nav>


