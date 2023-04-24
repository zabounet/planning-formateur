<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormationModel;

class FormationController extends Controller
{
    
    public function ajouterFormation(): void{
        $infos = new FormationModel;

        $infosFormation = $infos->getInformations();

        // Check if the request is an AJAX request
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation["Formateurs"]);
            exit;
        }
        else{
            $this->render('/formation/ajout-formation', compact('infosFormation'), 'formation');
        };
    }
}