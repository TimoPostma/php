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
    $rubriek = new Rubriek($pdo);
    
    // vul rubriek-object met waarden uit POST
    $rubriek->make($_POST);

    // als rubriek-object niet valide is:
    if (!$rubriek->isValid())
    {
        
        // stop message, errors en post in de sessie
        $session->save('message', 'Formulier ongeldig!');
        $session->save('errors', $rubriek->getErrors());
        $session->save('post', $_POST);
        
        // redirect naar create
        header('location:create.php');
    }
    // als rubriek-object wel valide is:
    else
    {
        // bewaar rubriek-object in de database
        $rubriek->save();
        
        // stop message in de sessie
        $session->save('message', 'Rubriek '.$rubriek->getNaam().' toegevoegd!');
        
        // redirect naar index
        header('location:index.php');
    }

}

