<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

// in elke request nodig:
const PATH_TO_ROOT = '../../';
require_once(PATH_TO_ROOT.'../include/init.php');

// als de request geen POST is, redirect naar index

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    // stop message in sessie
    $session->save('message', 'Illegale aanroep!');

    // redirect naar index
    header('location:index.php');
}
else
{   
    // maak rubriek-object
    $product = new Product($pdo);
    
    // stel de id in (uit de querystring)
    $product->setId($_GET['id'] ?? 0);
     
    // controleer of de rubriek in de database zit
    $product->load();

    if (!$product->getLoaded())
    {
        $session->save('message', 'Rubriek met id ' . $product->getId() . ' bestaat niet (meer) ...');
        header('location:index.php');
    }
    else
    {
        // haal de waarden voor de attributen uit de POST
        $product->make($_POST);
        
        // valideer
        if (!$product->isValid(true))
        {
            // stop message, errors en post in de sessie
            $session->save('message', 'Formulier ongeldig!');
            $session->save('errors', $product->getErrors());
            $session->save('post', $_POST);
            
            // redirect naar edit
            header('location:edit.php?id='.$product->getId());
        }
        else
        {
            // update de rubriek
            $product->update($ok);
            
            // stop message in de sessie
            $session->save('message', 'Rubriek ' . $product->getNaam() . ($ok ? ' ' : ' NIET ') . 'aangepast!');
            
            // redirect naar index
            header('location:index.php');
        }
    }
}