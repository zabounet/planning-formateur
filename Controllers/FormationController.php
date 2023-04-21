<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormationModel;

class FormationController extends Controller
{
    public function index(){
        $infos = new FormationModel;

        $infosFormation = $infos->getInformations();

        $this->render('/formation/ajout-formation', compact('infosFormation'), 'formation');
    }
}