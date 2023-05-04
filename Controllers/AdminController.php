<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Refresh;
use App\Models\FormationModel;
use App\Models\FormateurModel;

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

        $this->render('admin/formationsHome', compact('infosFormation'), 'formations');
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
                    $database->insertPeriode("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i]);
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

        $this->render('admin/formateursHome', compact('infosFormateur'), 'formateurs');
    }

    public function inscriptionFormateur()
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate($_POST, ['inscription'])) {
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
                //Insertion des données dans la table formation
                $formateur->insertFormateur(
                    $_POST['nom'],
                    $_POST['prenom'],
                    $mail,
                    $mdp,
                    $_POST['type_contrat'],
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
                    $database->insertPeriode("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $currentId);
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
        $infosInterventions = $formateur->getBy(['id_intervention','date_debut_intervention', 'date_fin_intervention'],'Date_intervention', ['id_formateur'], [$currentId]);

        $infosFormateur = $formateur->getInformations();
        $this->render('admin/modifierFormateur', compact('infosCurrent', 'infosFormateur', 'infosInterventions'), 'formateurs');
    }

    public function activiteFormateurs()
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        $FormateurModel = new FormateurModel;

        if (Form::validate($_POST, ['valider'])) {
            echo "ee";
            // Récupérer les dates saisies par l'utilisateur
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];
            $id_formateur = $_POST['formateur'];
            // Construire une chaîne de caractères contenant les ID sous forme de liste

            // Récupérer les formateurs qui sont occupés pendant cette période
            $formateurs = $FormateurModel->getInterventionById($id_formateur);
            var_dump($formateurs);


            // Construire le tableau HTML
            $table_html = '<table>';
            $table_html .= '<tr><th></th>'; // Première ligne avec les dates
            $date_courante = strtotime($date_debut);
            while ($date_courante <= strtotime($date_fin)) {
                $table_html .= '<th>' . date('d/m/Y', $date_courante) . '</th>';
                $date_courante = strtotime('+1 day', $date_courante);
            }
            $table_html .= '</tr>';

            foreach ($formateurs as $formateur) {
                $table_html .= '<tr>';
                $table_html .= '<td>' . $formateur['nom'] . ' ' . $formateur['prenom'] . '</td>';

                // Pour chaque jour entre la date de début et la date de fin, vérifier si le formateur est occupé
                $date_courante = strtotime($date_debut);
                while ($date_courante <= strtotime($date_fin)) {
                    $occupe = false;
                    foreach ($formateur['dates_occupees'] as $date_occupee) {
                        if ($date_courante >= strtotime($date_occupee['date_debut']) && $date_courante <= strtotime($date_occupee['date_fin'])) {
                            $occupe = true;
                            break;
                        }
                    }
                    $table_html .= '<td class="' . ($occupe ? 'occupe' : '') . '"></td>';
                    $date_courante = strtotime('+1 day', $date_courante);
                }

                $table_html .= '</tr>';
            }
            $table_html .= '</table>';

            // Afficher le tableau dans la vue
            echo $table_html;


            // // if(Form::validate($_POST,['date_debut','date_fin','formateur'])){
            // $date_debut = $_POST['date_debut'];
            // $date_fin = $_POST['date_fin'];

            //  // $infos = new FormateurModel;



            // $nb_formateur = count($_POST['formateur']);
            // for($i = 0 ; $i < $nb_formateur; $i++){
            //     $test = [
            //         "test" => ""
            //     ];
            //     $infos->joinInformations(['date_debut_intervention','date_fin_intervention','nom_formateur','prenom_formateur'],'Formateur',['Date_intervention'],['id_formateur'],['Formateur.id_formateur'], [$_POST['formateur'][$i]])

            //   // $nomPrenomFormateur = $test[$i][0]->nom_formateur . " " . $test[$i][0]->prenom_formateur;

            //  // echo $nomPrenomFormateur;
            //     var_dump($test);
            // }die;
            // $nbDate = count($test);

            // for($j = 0 ; $j < $nbDate; $j++){
            //     $intervention = strtotime($test[$j]->date_debut_intervention);

            //     var_dump($test[$j]); echo '<br><br>';
            //     echo $intervention . '<br><br>';

            //     if(strtotime($_POST['date_debut'] <= $intervention && strtotime($_POST['date_fin'] >= $intervention))){
            //         echo $intervention;
            //    }
            // }



            // }
        }
        $infosFormateur = $FormateurModel->getFormateur();
        $this->render('/admin/activiteFormateur', compact('infosFormateur',));
    }
}
