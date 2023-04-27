<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Refresh;
use App\Models\FormationModel;
use App\Models\FormateurModel;

class AdminController extends Controller
{
    public function ajouterFormation(): void
    {
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
            $villeNom = $database->getOne("Ville", "nom_ville", "id_ville", $_POST['ville']);

            //Si un formateur référent a été assigné, attribuer sa valeur. Sinon, donner l'id 1 (correspondant à non attribué).
            $referent = isset($_POST['referent-formateur']) ? $_POST['referent-formateur'] : 1;

            //Création de l'id de la formation
            $idFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . " à " . $villeNom['nom_ville'];

            //Insertion des données dans la table formation
            $database->insertFormation(
                $idFormation,
                $_POST['acronyme'],
                $_POST['description'],
                $_POST['date-debut-formation'],
                $_POST['date-fin-formation'],
                $_POST['type'],
                $_POST['grn'],
                $referent,
                $_POST['ville']
            );

            if(isset($_POST['date-debut-entreprise'])){ 
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $idFormation);
                }
            } 
            if(isset($_POST['date-debut-centre'])){
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $idFormation);
                }
            }
            if(isset($_POST['date-debut-ran'])){
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $idFormation);
                }
            }
            if(isset($_POST['date-debut-certification'])){
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $idFormation);
                }
            }
            if(isset($_POST['date-debut-interruption'])){
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $idFormation);
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

        // Check if the request is an AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation["Formateurs"]);
            exit;
        } else {
            $this->render('/admin/ajouterFormation', compact('infosFormation'));
        };
    }



    public function inscriptionFormateur()
    {
        if (Form::validate($_POST, ['inscription'],)) {
            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['type_contrat']) && !empty($_POST['grn']) && !empty($_POST['ville'])){
                
                // verifier le mail
                $mail = $_POST['mail'];
                // if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                   
                    $formateur = new FormateurModel;
                    
                    //Création de le mot de pass de la formation
                    $mdp_formateur = $_POST["nom"] .  $_POST["prenom"] ;
                    $mdp = sha1($mdp_formateur);
                    
                    //un formateur n'est pas admin
                    $permissions_utilisateur = 0;
                    
                    if(!isset($_POST['date_fin_contrat'])){
                        $date_fin_contrat = '0001-01-01';
                    }
                    else{
                        $date_fin_contrat =  $_POST['date_fin_contrat'] ;
                    }
                
                    $type_contrat = strtoupper($_POST["type_contrat"]) ;
                //Insertion des données dans la table formation
                    $formateur->insertFormateur(
                        $_POST['nom'],
                        $_POST['prenom'],
                        $mail,
                        $mdp,
                        $type_contrat,
                        $_POST['date_debut_contrat'],
                        $date_fin_contrat,
                        $permissions_utilisateur,
                        $_POST['grn'],
                        $_POST['ville']
                    );
                    
                    
                    $_SESSION['success'] = "cest fait";
                    Refresh::refresh('/planning/public/admin/inscriptionFormateur');
                    exit;
                // } else {
                //     $_SESSION['error'] = "email pas bon";
                // }

            } else {
                $_SESSION['error'] = "cest pas complet";
                Refresh::refresh('/planning/public/admin/inscriptionFormateur');
                exit;
            }
        } 




        $infos = new FormateurModel;

        $infosFormateur = $infos->getInformations();
        $this->render('/admin/inscriptionFormateur', compact('infosFormateur'));
    }
}
