<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

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
 //   $rubrieken = $product->getRubrieken();

    // vul rubriek-object met waarden uit POST
    $product->make($_POST);
    var_dump($product);
//    $productrubriek = $product->getRubriek();
//    var_dump($productrubriek);
//    foreach ($rubrieken as $idrubriek => $rubriek )

    // als rubriek-object niet valide is:
    if (!$product->isValid())
    {
        
        // stop message, errors en post in de sessie
        $session->save('message', 'Formulier ongeldig!');
        $session->save('errors', $product->getErrors());
        $session->save('post', $_POST);
        
        // redirect naar create
        header('location:create.php');
    }
    // als rubriek-object wel valide is:
    else
    {
        // bewaar rubriek-object in de database
        $product->save();
        
        // stop message in de sessie
        $session->save('message', 'Product '.$product->getNaam().' toegevoegd!');
        
        // redirect naar index
        header('location:index.php');
    }

}

