<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Refresh;
use App\Core\AlgorithmePaques;
use App\Models\FormationModel;
use App\Models\FormateurModel;
use DateTime;

class AdminController extends Controller
{
    public function index(): void
    {

        $this->render('/main/index');
    }

    public function formationsHome(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

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
            ]
        );

        if (isset($_POST['search_d']) && !empty($_POST['search_d'])) {
            $infosFormation = $formation->search(
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
                $_POST['search_d'],
                [
                    'nom_formation',
                    'nom_formateur',
                    'prenom_formateur',
                    'Formation.numero_grn',
                    'nom_ville',
                    'designation_type_formation'
                ],
                [
                    'Formateur',
                    'Ville',
                    'Type_Formation'
                ],
                [
                    'id_formateur',
                    'id_ville',
                    'id_type_formation'
                ]
            );
            $search = $_POST['search_d'];
            $this->render('admin/formationsHome', compact('infosFormation', 'search'), 'formations');
        } else {


            $this->render('admin/formationsHome', compact('infosFormation',), 'formations');
        }
    }

    public function modifierFormation(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

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
            $database = new FormationModel;

            $currentId = str_replace("/planning/public/admin/modifierFormation?id=", "", $_SERVER['REQUEST_URI']);

            //Récupèration du nom de la ville pour composer l'id de la formation
            $villeNom = $database->getOne("nom_ville", "Ville", "id_ville", $_POST['ville']);

            //Si un formateur référent a été assigné, attribuer sa valeur. Sinon, donner l'id 1 (correspondant à non attribué).
            $referent = isset($_POST['referent-formateur']) ? $_POST['referent-formateur'] : 1;

            //Création de l'id de la formation
            $nomFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $_POST["date-debut-formation"] . " - " . $_POST["date-fin-formation"] . " " . $villeNom['nom_ville'];

            $database->update(
                'Formation',
                [
                    'nom_formation',
                    'acronyme_formation',
                    'description_formation',
                    'date_debut_formation',
                    'date_fin_formation',
                    'id_type_formation',
                    'numero_grn',
                    'id_formateur',
                    'id_ville'
                ],
                [
                    $nomFormation,
                    $_POST['acronyme'],
                    $_POST['description'],
                    $_POST['date-debut-formation'],
                    $_POST['date-fin-formation'],
                    $_POST['type'],
                    $_POST['grn'],
                    $referent,
                    $_POST['ville']
                ],
                'id_formation',
                $currentId
            );

            $deleteRan = $database->delete('Date_ran', 'id_formation', $currentId);
            $deletePae = $database->delete('Date_pae', 'id_formation', $currentId);
            $deleteCentre = $database->delete('Date_centre', 'id_formation', $currentId);
            $deleteCertif = $database->delete('Date_certif', 'id_formation', $currentId);
            $deleteInterruptions = $database->delete('Interruption', 'id_formation', $currentId);

            if (isset($_POST['date-debut-entreprise'])) {
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $currentId);
                }
            }
            if (isset($_POST['date-debut-centre'])) {
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $currentId);
                }
            }
            if (isset($_POST['date-debut-ran'])) {
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $currentId);
                }
            }
            if (isset($_POST['date-debut-certification'])) {
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $currentId);
                }
            }
            if (isset($_POST['date-debut-interruption'])) {
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $currentId);
                }
            }
            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i], $currentId);
                }
            }
            Refresh::refresh('formationsHome');
        }

        $formation = new FormationModel;

        $currentId = str_replace("/planning/public/admin/modifierFormation?id=", "", $_SERVER['REQUEST_URI']);

        $infosCurrent = $formation->getOne('*', 'Formation', 'id_formation', $currentId);
        $infosFormation = $formation->getInformations();
        $infosRan = $formation->getBy(['date_debut_ran', 'date_fin_ran'], 'Date_ran', ['id_formation'], [$currentId]);
        $infosPae = $formation->getBy(['date_debut_pae', 'date_fin_pae'], 'Date_pae', ['id_formation'], [$currentId]);
        $infosCertif = $formation->getBy(['date_debut_certif', 'date_fin_certif'], 'Date_certif', ['id_formation'], [$currentId]);
        $infosCentre = $formation->getBy(['date_debut_centre', 'date_fin_centre'], 'Date_centre', ['id_formation'], [$currentId]);
        $infosInterruption = $formation->getBy(['date_debut_interruption', 'date_fin_interruption'], 'Interruption ', ['id_formation'], [$currentId]);

        $this->render('admin/modifierFormation', compact('infosCurrent', 'infosFormation', 'infosRan', 'infosRan', 'infosPae', 'infosCertif', 'infosCentre',  'infosInterruption'), 'formations');
    }

    public function ajouterFormation(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

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

            if (isset($_POST['date-debut-entreprise'])) {
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if (isset($_POST['date-debut-centre'])) {
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if (isset($_POST['date-debut-ran'])) {
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if (isset($_POST['date-debut-certification'])) {
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if (isset($_POST['date-debut-interruption'])) {
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $idFormation['MAX(id_formation)']);
                }
            }
            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i], $idFormation);
                }
            }
            Refresh::refresh('/planning/public/admin/ajouterFormation');
        }

        $infos = new FormationModel;

        $infosFormation = $infos->getInformations();

        // Check if the request is an AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation['Formateurs']);
            exit;
        } else {
            $this->render('admin/ajouterFormation', compact('infosFormation'), 'formations');
        };
    }

    public function formateursHome(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        $formateur = new FormateurModel;

        $infosFormateur = $formateur->joinInformations(
            [
                'id_formateur',
                'nom_formateur',
                'prenom_formateur',
                'mail_formateur',
                'type_contrat_formateur',
                'date_debut_contrat',
                'date_fin_contrat',
                'numero_grn',
                'nom_ville'
            ],
            "Formateur",
            ['Ville'],
            ['id_ville']
        );

        if (isset($_POST['search_d']) && !empty($_POST['search_d'])) {
            $infosFormateur = $formateur->search(
                [
                    'id_formateur',
                    'nom_formateur',
                    'prenom_formateur',
                    'mail_formateur',
                    'type_contrat_formateur',
                    'date_debut_contrat',
                    'date_fin_contrat',
                    'numero_grn',
                    'nom_ville'
                ],
                "Formateur",
                $_POST['search_d'],
                [
                    'nom_formateur',
                    'prenom_formateur',
                    'nom_ville',
                    'type_contrat_formateur',
                    'numero_grn'
                ],
                [

                    'Ville'
                ],
                [

                    'id_ville'
                ]
            );
            $search = $_POST['search_d'];
            $this->render('admin/formateursHome', compact('infosFormateur', 'search'), 'formateurs');
        }
        $this->render('admin/formateursHome', compact('infosFormateur'), 'formateurs');
    }

    public function inscriptionFormateur()
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate($_POST, ['inscription'],)) {
            if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['type_contrat']) && !empty($_POST['grn']) && !empty($_POST['ville'])) {

                // verifier le mail
                $mail = $_POST['mail'];
                // if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

                $formateur = new FormateurModel;

                //Création de le mot de pass de la formation
                $mdp_formateur = $_POST["nom"] .  $_POST["prenom"];
                $mdp = sha1($mdp_formateur);

                //un formateur n'est pas admin
                $permissions_utilisateur = 0;

                if ($_POST['type_contrat'] === 'CDI') {
                    $date_fin_contrat = '0001-01-01';
                } else {
                    $date_fin_contrat =  $_POST['date_fin_contrat'];
                }

                $type_contrat = strtoupper($_POST["type_contrat"]);
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


                $_SESSION['success'] = "Formateur ajouté avec succès";
                Refresh::refresh('/planning/public/admin/inscriptionFormateur');
                exit;
                // } else {
                //     $_SESSION['error'] = "email pas bon";
                // }

            } else {
                $_SESSION['error'] = "Formulaire incomplet";
                Refresh::refresh('/planning/public/admin/inscriptionFormateur');
                exit;
            }
        }

        $infos = new FormateurModel;

        $infosFormateur = $infos->getInformations();
        $this->render('/admin/inscriptionFormateur', compact('infosFormateur'), 'formateurs');
    }

    public function modifierFormateur(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate($_POST, ['inscription'])) {

            $database = new FormateurModel;
            $permissions_utilisateur = 0;

            if ($_POST['type_contrat'] === 'CDI') {
                $date_fin_contrat = '0001-01-01';
            } else {
                $date_fin_contrat =  $_POST['date_fin_contrat'];
            }

            $currentId = str_replace("/planning/public/admin/modifierFormateur?id=", "", $_SERVER['REQUEST_URI']);

            $database->update(
                'Formateur',
                [
                    'nom_formateur',
                    'prenom_formateur',
                    'mail_formateur',
                    'type_contrat_formateur',
                    'date_debut_contrat',
                    'date_fin_contrat',
                    'numero_grn',
                    'id_ville'
                ],
                [
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['mail'],
                    $_POST['type_contrat'],
                    $_POST['date_debut_contrat'],
                    $date_fin_contrat,
                    $_POST['grn'],
                    $_POST['ville']
                ],
                'id_formateur',
                $currentId
            );

            Refresh::refresh('/planning/public/admin/formateursHome');
            exit;
        }

        if (Form::validate($_POST, ['date-debut-intervention', 'date-fin-intervention'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/admin/modifierFormateur?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $currentId, $_POST['intervention'][$i]);
                }
            }

            Refresh::refresh('/planning/public/admin/modifierFormateur?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['intervention'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/admin/modifierFormateur?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("Date_intervention", "id_intervention", $_POST['intervention']);

            Refresh::refresh('/planning/public/admin/modifierFormateur?id=' . $currentId);
            exit;
        }

        $formateur = new FormateurModel;

        $currentId = str_replace("/planning/public/admin/modifierFormateur?id=", "", $_SERVER['REQUEST_URI']);

        $infosCurrent = $formateur->joinInformations(
            [
                'id_formateur',
                'nom_formateur',
                'prenom_formateur',
                'mail_formateur',
                'type_contrat_formateur',
                'date_debut_contrat',
                'date_fin_contrat',
                'numero_grn',
                'nom_ville'
            ],
            "Formateur",
            ['Ville'],
            ['id_ville'],
            ['id_formateur'],
            [$currentId]
        );
        $infosInterventions = $formateur->getBy(['id_intervention', 'date_debut_intervention', 'date_fin_intervention'], 'Date_intervention', ['id_formateur'], [$currentId]);

        $infosFormateur = $formateur->getInformations();
        $infosFormation = $formateur->getAll('formation');

        // Check if the request is an AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation);
            exit;
        } else {
            $this->render('admin/modifierFormateur', compact('infosCurrent', 'infosFormateur', 'infosInterventions'), 'formateurs');
        };
    }

    public function activiteFormateurs()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        $html = "<div style='display:flex;justify-content:center;'> <h1 style='width:60%;text-align:center;'>Veuillez séléctionner une période de dates ainsi que des formateurs afin de consulter leur période d'activités.</h1> </div>";
        $FormateurModel = new FormateurModel;

        if (Form::validate($_POST, ['valider'])) {
            // Récupérer les dates saisies par l'utilisateur
            $date_debut_calendrier = $_POST['date_debut'];
            $date_fin_calendrier = $_POST['date_fin'];
            $id_formateur = $_POST['formateur'];
            // Construire une chaîne de caractères contenant les ID sous forme de liste

            //recupere les date de vacances pour chaque formateur
            $formateurs = $FormateurModel->getVacancesById($id_formateur);
            foreach ($formateurs as $formateur) {
                $date_debut_vacences = $formateur['date_debut_vacences'];
                $date_debut_vacences_array = explode(",", $date_debut_vacences);

                $date_fin_vacences = $formateur['date_fin_vacences'];
                $date_fin_vacences_array = explode(",", $date_fin_vacences);

                $validation = $formateur['validation'];
                $validation_array = explode(",", $validation);

                $dates_vacences_formateurs = array();
                $nbVacs = count($date_debut_vacences_array);
                for ($i = 0; $i < $nbVacs; $i++) {
                    $dates_vacences_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut_vacences" => $date_debut_vacences_array[$i],
                        "fin_vacences" => $date_fin_vacences_array[$i],
                        "validation_vacences" => $validation_array[$i]
                    ];
                }

                $dates_vacences_formateurs[] = $dates_vacences_formateur;
            }

            // Récupérer les formateurs qui sont occupés pendant cette période
            $formateurs = $FormateurModel->getInterventionById($id_formateur);
            foreach ($formateurs as $formateur) {
                $date_debut_activite = $formateur['date_debut'];
                $date_debut_array = explode(",", $date_debut_activite);
                // var_dump($date_debut_array);
                $date_fin_activite = $formateur['date_fin'];
                $date_fin_array = explode(",", $date_fin_activite);

                $dates_interventions_formateurs = array();

                $nbInter = count($date_debut_array);
                for ($i = 0; $i < $nbInter; $i++) {
                    $dates_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut" => $date_debut_array[$i],
                        "fin" => $date_fin_array[$i]
                    ];
                }

                $dates_interventions_formateurs[] = $dates_formateur;
            }


            $date_debut_tableau = new DateTime($_POST['date_debut'], new \DateTimeZone('Europe/Paris'));
            // $formattedDebut = date('Y-m-d', $date_debut_tableau);

            $date_fin_tableau = new DateTime(($_POST['date_fin']));
            // $formattedFin = $date_fin_tableau->format("Y-m-d");

            $nbJours = $date_fin_tableau->diff($date_debut_tableau)->days + 1;


            $mois31 = array('1', '3', '5', '7', '8', '10', '12');
            $mois30 = array('4', '6', '9', '11');

            $current_date_year = clone $date_debut_tableau;
            $last_date_year = clone $date_fin_tableau;
            $yearDebut = $current_date_year->format('L');
            $yearFin = $last_date_year->format('L');

            $current_date_year = clone $date_debut_tableau;
            $current_date_month = clone $date_debut_tableau;
            $current_date_dayName = clone $date_debut_tableau;
            $current_date_day = clone $date_debut_tableau;
            $current_date_dayForYears = clone $date_debut_tableau;
            $current_date_dayForMonths = clone $date_debut_tableau;

            $joursFeries = array('01-01', '05-01', '05-08', '07-14', '08-15', '11-01', '11-11', '12-25');

            $count = 0;
            $countFormateurs = count($formateurs);
            $countDates = count($dates_interventions_formateurs[0]);
            $countDatesVacences = count($dates_vacences_formateurs[0]);


            $html = "<div class='main-container'> <div class='tableau-container'> <table> <thead> <tr> <th rowspan = 4>Afpa</th>";
            for ($i = 0; $i < $nbJours; $i++) {
                $annee = $current_date_year->format('Y');
                $dernierJour = $current_date_dayForYears->format('m-d');

                if ($yearDebut || $yearFin) {
                    $count++;
                    if ($count == 366 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                        $html .= "<th colspan='$count'>" . $annee . "</th> ";

                        $count = 0;
                    }
                } else {
                    $count++;
                    if ($count == 365 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                        $html .= "<th colspan='$count'>" . $annee . "</th> ";

                        $count = 0;
                    }
                }

                $current_date_year->modify("+1 day");
                $current_date_dayForYears->modify("+1 day");
            }

            $html .= "</tr> <tr>";
            for ($i = 0; $i < $nbJours; $i++) {
                $mois = $current_date_month->format('n');
                $numeroJour = $current_date_dayForMonths->format('j');

                if (in_array($mois, $mois31)) {
                    $count++;
                    if ($numeroJour === "31" || ($i + 1) == $nbJours) {
                        switch ($mois) {
                            case 1: {
                                    $mois = "Janvier";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 3: {
                                    $mois = "Mars";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 5: {
                                    $mois = "Mai";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 7: {
                                    $mois = "Juillet";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 8: {
                                    $mois = "Août";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 10: {
                                    $mois = "Octobre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 12: {
                                    $mois = "Décembre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                        }
                        $numeroJour = $current_date_dayForMonths->format('j');
                        $count = 0;
                    }
                }

                if (in_array($mois, $mois30)) {
                    $count++;
                    if ($numeroJour === "30" || ($i + 1) == $nbJours) {
                        switch ($mois) {
                            case 4: {
                                    $mois = "Avril";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 6: {
                                    $mois = "Juin";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 9: {
                                    $mois = "Septembre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 11: {
                                    $mois = "Novembre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                        }
                        $numeroJour = $current_date_dayForMonths->format('j');
                        $count = 0;
                    }
                }

                if ($mois === "2") {
                    $count++;
                    if ($yearDebut || $yearFin) {
                        if ($numeroJour == 29 || ($i + 1) == $nbJours) {
                            $mois = "Février";
                            $html .= "<th colspan='$count'>" . $mois . "</th> ";

                            $numeroJour = $current_date_dayForMonths->format('j');
                            $count = 0;
                        }
                    } else {
                        if ($numeroJour == 28 || ($i + 1) == $nbJours) {
                            $mois = "Février";
                            $html .= "<th colspan='$count'>" . $mois . "</th> ";

                            $numeroJour = $current_date_dayForMonths->format('j');
                            $count = 0;
                        }
                    }
                }
                $current_date_month->modify("+1 day");
                $current_date_dayForMonths->modify("+1 day");
            }

            $html .= "</tr> <tr> ";
            for ($i = 0; $i < $nbJours; $i++) {
                $jourNom = $current_date_dayName->format('N');
                switch ($jourNom) {
                    case 1: {
                            $jourNom = "Lun";
                            break;
                        }
                    case 2: {
                            $jourNom = "Mar";
                            break;
                        }
                    case 3: {
                            $jourNom = "Mer";
                            break;
                        }
                    case 4: {
                            $jourNom = "Jeu";
                            break;
                        }
                    case 5: {
                            $jourNom = "Ven";
                            break;
                        }
                    case 6: {
                            $jourNom = "Sam";
                            break;
                        }
                    case 7: {
                            $jourNom = "Dim";
                            break;
                        }
                }
                $current_date_dayName->modify("+1 day");
                $html .= "<th>" . $jourNom . "</th> ";
            }

            $html .= '</tr> <tr> ';
            for ($i = 0; $i < $nbJours; $i++) {
                $jour = $current_date_day->format('j');
                $current_date_day->modify("+1 day");
                $html .= "<th>" . $jour . "</th> ";
            }
            $html .= "</tr> <tbody> <tr>";

            // Création d'un tableau vide pour stocker les périodes de chaque formateur
            $formateur_periodes = array();
            $formateur_vacance = array();

            // Boucle pour parcourir tous les formateurs
            for ($z = 0; $z < $countFormateurs; $z++) {

                // Clonage de la date de début du tableau pour éviter de modifier l'objet original
                $current_date_dayForFormateurs = clone $date_debut_tableau;

                // Ajout du nom et prénom du formateur dans la première colonne du tableau
                $html .= "<th>" . $formateurs[$z]['nom_formateur'] . ' ' . $formateurs[$z]['prenom_formateur'] . "</th> ";

                // Création d'un tableau vide pour stocker les périodes du formateur en cours
                $formateur_periodes[$formateurs[$z]['id_formateur']] = array();
                $formateur_vacance[$formateurs[$z]['id_formateur']] = array();

                // Boucle pour parcourir tous les jours du tableau
                for ($i = 0; $i < $nbJours; $i++) {

                    // Boucle pour parcourir toutes les dates d'intervention pour trouver les périodes du formateur en cours
                    for ($j = 0; $j < $countDates; $j++) {

                        // Stockage de la période dans le tableau des périodes du formateur en cours
                        if ($dates_interventions_formateurs[0][$j]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                            $formateur_periodes[$formateurs[$z]['id_formateur']][] = array(
                                'debut' => $dates_interventions_formateurs[0][$j]['debut'],
                                'fin' => $dates_interventions_formateurs[0][$j]['fin']
                            );
                        }
                    }

                    for ($v = 0; $v < $countDatesVacences; $v++) {

                        // Stockage de la période dans le tableau des périodes du formateur en cours
                        if ($dates_vacences_formateurs[0][$v]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                            $formateur_vacance[$formateurs[$z]['id_formateur']][] = array(
                                'debut_vacences' => $dates_vacences_formateurs[0][$v]['debut_vacences'],
                                'fin_vacences' => $dates_vacences_formateurs[0][$v]['fin_vacences'],
                                'validation' => $dates_vacences_formateurs[0][$v]['validation_vacences']
                            );
                        }
                    }

                    // Récupération de la période courante
                    $periodeJourFeries = $current_date_dayForFormateurs->format('m-d');
                    $weekend = $current_date_dayForFormateurs->format('N');
                    $periode = $current_date_dayForFormateurs->format('Y-m-d');

                    // Vérification si le formateur a une période pour le jour en cours
                    $trainer_has_period = false;
                    foreach ($formateur_periodes[$formateurs[$z]['id_formateur']] as $period) {
                        if ($periode >= $period['debut'] && $periode <= $period['fin']) {
                            $trainer_has_period = true;
                            break;
                        }
                    }

                    $trainer_has_vacences = 0;
                    foreach ($formateur_vacance[$formateurs[$z]['id_formateur']] as $period_vacences) {
                        if ($periode >= $period_vacences['debut_vacences'] && $periode <= $period_vacences['fin_vacences']) {
                            $trainer_has_vacences = 1;
                            if ($period_vacences['validation'] === "1") {
                                $trainer_has_vacences = 2;
                            }
                            break;
                        }
                    }
                    // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période pour le formateur
                    if ($trainer_has_vacences !== 0) {
                        if ($trainer_has_vacences == 2) {
                            $html .= "<th style='background-color: var(--vacancesCell);'></th>";
                        } else if ($trainer_has_vacences == 1) {
                            $html .= "<th style='background-color: goldenrod;'></th> ";
                        }
                    } else {
                        if ($trainer_has_period) {
                            if (
                                in_array($periodeJourFeries, $joursFeries)
                                || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                            ) {
                                $html .= "<th style='background-color: #050F29;'></th> ";
                            } else {
                                if ($weekend === "6" || $weekend === "7") {
                                    $html .= "<th style='background-color: var(--weekendCell);'></th> ";
                                } else {
                                    $html .= "<th style='background-color: var(--greenCell);'></th> ";
                                }
                            }
                        } else {
                            if (
                                in_array($periodeJourFeries, $joursFeries)
                                || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                            ) {
                                $html .= "<th style='background-color: #050F29;'></th> ";
                            } else {
                                if ($weekend === "6" || $weekend === "7") {
                                    $html .= "<th style='background-color: var(--weekendCell);'></th> ";
                                } else {
                                    $html .= "<th style='background-color: var(--emptyCell);'></th> ";
                                }
                            }
                        }
                    }
                    // Incrémentation de la date pour passer au jour suivant
                    $current_date_dayForFormateurs->modify("+1 day");
                }
                // Fermeture de la ligne correspondant au formateur en cours
                $html .= "</tr>";
            }
            $html .= "</tbody> </table> </div> </div>";
        }
        $infosFormateur = $FormateurModel->getFormateur();
        $this->render('/admin/activiteFormateur', compact('infosFormateur', 'html'), 'activite');
    }
}
