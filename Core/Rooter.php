<?php
namespace App\Core;

use App\Controllers\FormateurController;
use App\Controllers\RooterController;

//Rooter principal
class Rooter{

    public function start(){

        // On démarre la session
        session_start();
        // On retire le "trailing slash" éventuel de l'URL
        // On récupère l'URL


        // On gère les paramètres d'URL
        // p=controller/method/parameters
        // On sépare les paramètres dans un tableau
        $params = explode('/', $_GET['p']);

        if($params[0] != ""){
            // On a au moins 1 paramètre
            // On récupère le nom du controller à instancier
            // On met une majuscule en 1ère lettre, on ajoute le namepace complet avant et on ajouter "Controller" après
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // On instancie le controller s'il existe
            if(class_exists($controller)){
                $controller = new $controller();

                // On récupère le 2eme paramètre d'URL
                $action = (isset($params[0])) ? array_shift($params) : 'index';
            } else{
                http_response_code(404);
                echo "La page recherchée n'existe pas";
                exit;
            }

            if(method_exists($controller, $action)){
                // Si il reste des paramètres on les passe à la méthode
                // call_user_func_array envoie a une fonction un tableau de paramètres
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action(); 
            }else{
                http_response_code(404);
                echo "La page recherchée n'existe pas";
                exit;
            }
            
        }else{
            // On a pas de paramètres donc on instancie le controller par défaut
            if(isset($_SESSION['formateur']) || isset($_SESSION['admin'])){
                $controller = new RooterController;
                $controller->index();
            }
            else{
                $formateur = new FormateurController;
                $formateur->login();
            }
        }
    }
}