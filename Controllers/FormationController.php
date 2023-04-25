<?php

namespace App\Controllers;

use App\Core\Form;

use App\Core\Db;
use App\Models\FormationModel;
use App\Models\Date_paeModel;
use App\Models\Date_centreModel;
use App\Models\Date_certifModel;
use App\Models\Date_ranModel;
use App\Models\InterruptionModel;
use App\Models\FormateurModel;
use App\Models\VilleModel;
use App\Models\GRNModel;
use App\Models\Type_FormationModel;
use App\Models\Acronyme_formationModel;

class FormationController extends Controller
{
    
    public function ajouterFormation(): void{
        if(Form::validate($_POST, 
        ['type',
        'grn', 
        'acronyme',
        'description', 
        'offre', 
        'date-debut-formation', 
        'date-fin-formation', 
        'ville'], 
        ['date-debut-ran', 
        'date-fin-ran', 
        'date-debut-entreprise', 
        'date-fin-entreprise', 
        'date-debut-centre', 
        'date-fin-centre', 
        'date-debut-certification', 
        'date-fin-certification', 
        'date-debut-interruption', 
        'date-fin-interruption', 
        'referent-formateur', 
        'date-debut-intervention', 
        'date-fin-intervention'])) {

            //Déclaration des objets model
            $acronyme = new Acronyme_formationModel;
            $ville = new VilleModel;
            $formation = new FormationModel;

            // $acronyme->insertAcronym($_POST['acronyme'], $_POST['grn']);
            $idAcronyme = $acronyme->getLastId("id_acronyme_formation");

            $villeNom = $ville->getOne("nom_ville", "id_ville" ,$_POST['ville']);

            //Création de l'id de la formation
            $idFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . " à " . $villeNom['nom_ville'];
            $formation->insertFormation(
                $idFormation, 
                $_POST['description'], 
                $_POST['date-debut-formation'], 
                $_POST['date-fin-formation'], 
                $_POST['type'], 
                $_POST['grn'], 
                $idAcronyme["MAX(id_acronyme_formation)"], 
                $_POST['referent-formateur'], 
                $_POST['ville']);

            // $db = $formation->lastInsertId();

            // $periodesEntreprise = count($_POST['date-debut-entreprise']);
            // for($i = 0; $i < $periodesEntreprise; $i++){
            //     $pae = new Date_paeModel;
            //     $pae->insertPAE($db, );
            // }
            // $periodesCentre = count($_POST['date-debut-centre']);
            // for($i = 0; $i < $periodesCentre; $i++){
            // }
            // $periodesInterruption = count($_POST['date-debut-interruption']);
            // for($i = 0; $i < $periodesInterruption; $i++){
            // }
            // $periodesFormateurs = count($_POST['date-debut-intervention']);
            // for($i = 0; $i < $periodesFormateurs; $i++){
            // }
        }

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