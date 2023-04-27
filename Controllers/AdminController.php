<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Refresh;
use App\Models\FormationModel;

class AdminController extends Controller
{
    public function index(): void{

        $this->render('/main/index');
    }

    public function formationsHome(): void{
        
        $formation = new FormationModel;

        $infosFormation = $formation->joinInformations(
            [
                'id_formation',
                'nom_formation',
                'description_formation',
                'date_debut_formation',
                'date_fin_formation',
                'Formation.numero_grn',
                'nom_formateur',
                'prenom_formateur',
                'designation_type_formation',
                'nom_ville'
            ],
            "Formation",
            [
                'Formateur', 
                'Ville', 
                'Type_Formation'
            ], 
            [
                'id_formateur',
                'id_ville',
                'id_type_formation'
            ]);

        $this->render('admin/formationsHome', compact('infosFormation'), 'formations');
    }

    public function modifierFormation(): void{
        
        $formation = new FormationModel;

        $currentId = str_replace("/planning/public/admin/modifierFormation?id=", "", $_SERVER['REQUEST_URI']);

        $infosCurrent = $formation->getOne('*','Formation','id_formation',$currentId);
        $infosFormation = $formation->getInformations();
        $infosRan = $formation->getBy(['date_debut_ran', 'date_fin_ran'],'Date_ran',['id_formation'],[$currentId]);
        $infosPae = $formation->getBy(['date_debut_pae', 'date_fin_pae'],'Date_pae',['id_formation'],[$currentId]);
        $infosCertif = $formation->getBy(['date_debut_certif', 'date_fin_certif'],'Date_certif',['id_formation'],[$currentId]);
        $infosCentre = $formation->getBy(['date_debut_centre', 'date_fin_centre'],'Date_centre',['id_formation'],[$currentId]);
        $infosInterruption = $formation->getBy(['date_debut_ran', 'date_fin_ran'],'Date_ran',['id_formation'],[$currentId]);


        $this->render('admin/modifierFormation', compact( 'infosCurrent', 'infosFormation', 'infosDates'), 'formations');
    }

    public function ajouterFormation(): void{
        if (Form::validate(
            $_POST,
            [
                'type',
                'grn',
                'acronyme',
                'description',
                'offre',
                'date-debut-formation',
                'date-fin-formation',
                'ville'
            ],
            [
                'date-debut-ran',
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
                'formateur',
                'date-debut-intervention',
                'date-fin-intervention'
            ]
        )) {

            //Déclaration des objets model
            $database = new FormationModel;

            //Récupèration du nom de la ville pour composer l'id de la formation
            $villeNom = $database->getOne("nom_ville", "Ville", "id_ville", $_POST['ville']);

            //Si un formateur référent a été assigné, attribuer sa valeur. Sinon, donner l'id 1 (correspondant à non attribué).
            $referent = isset($_POST['referent-formateur']) ? $_POST['referent-formateur'] : 1;

            //Création de l'id de la formation
            $nomFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . " " . $villeNom['nom_ville'];

            //Insertion des données dans la table formation
            $database->insertFormation(
                $nomFormation,
                $_POST['acronyme'],
                $_POST['description'],
                $_POST['date-debut-formation'],
                $_POST['date-fin-formation'],
                $_POST['type'],
                $_POST['grn'],
                $referent,
                $_POST['ville']
            );

            $idFormation = $database->getLastId('id_formation');

            if(isset($_POST['date-debut-entreprise'])){ 
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $idFormation['MAX(id_formation)']);
                }
            } 
            if(isset($_POST['date-debut-centre'])){
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if(isset($_POST['date-debut-ran'])){
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if(isset($_POST['date-debut-certification'])){
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if(isset($_POST['date-debut-interruption'])){
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if(isset($_POST['date-debut-intervention'])){
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriode("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i]);
                }
            }
            Refresh::refresh('/planning/public/admin/ajouterFormation');
        }

        $infos = new FormationModel;

        $infosFormation = $infos->getInformations();
        unset($infosFormation['Formations']);

        // Check if the request is an AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation["Formateurs"]);
            exit;
        } else {
            $this->render('admin/ajouterFormation', compact('infosFormation'));
        };
    }

    public function formateursHome(): void{
        
        $formateur = new FormationModel;

        $infosFormateur = $formateur->joinInformations(
            [
                'id_formateur',
                'nom_formateur',
                'prenom_formateur',
                'mail_formateur',
                'type_contrat_formateur',
                'date_debut_contrat',
                'date_fin_contrat',
                'numero_grn'
            ],
            "Formateur", 
            ['Ville'], 
            ['id_ville']);

        $this->render('admin/formateursHome', compact('infosFormateur'), 'formateurs');
    }
}
