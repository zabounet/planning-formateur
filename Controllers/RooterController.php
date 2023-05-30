<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormateurModel;
use App\Models\FormationModel;
use DateTime;
use App\Core\AlgorithmePaques;
use App\Models\CouleursModel;

class RooterController extends Controller
{

    public function index()
    {
        $color = new CouleursModel;
        $color->setSessionCoulors();
        if (Form::validate($_POST, ['rechercher'])) {

            $databaseFormation = new FormationModel;
            $databaseFormateur = new FormateurModel;

            // Si la valeur de lieu n'est pas celle de l'option par défaut, alors $centre est égal à sa valeur, sinon il est égal à "aucun"
            $_POST['lieu'] !== "default" ? $centre = $_POST['lieu'] : $centre = "Aucun";

            // Si la valeur de GRN pas vide et n'est pas celle de l'option par défaut, alors $grn est égal à sa valeur, sinon il est égal à "aucun"
            if (empty($_POST['grns'])) {
                $grn = "Aucun";
            } else {
                $_POST['grns'] !== "default" ? $grn = $_POST['grns'] : $grn = "Aucun";
            };

            // Si aucun formateur n'est selectionné, demande à l'utilisateur d'en selectionner au moins 1
            if (is_null($_POST['formateurs'])) {
                echo "Veuillez choisir au moins un formateur";
                exit;
            } else {
                $_POST['formateurs'] === $_POST['nbFormateurs'] ? $formateursSelectionnes = "Aucun" : $formateursSelectionnes = $_POST['formateurs'];
            }

            // Récupère l'ensemble des champs de la table formation où les numero_grn, id_formateur et id_ville sont respectivements égaux à $grn, $_POST['formateurs] et $centre. 
            $formations = $databaseFormation->getByIn(['*'], 'Formation', ['numero_grn', 'id_formateur', 'id_ville'], [$grn, $_POST['formateurs'], $centre]);



            // Création de tableaux vides pour stocker les périodes diferents de chaque formation
            $formation_centres = array();
            $formation_certifs = array();
            $formation_PAEs = array();
            $formation_RANs = array();
            // Initialisation de la variable $html.
            $html = "
                <div class='main-container'> 
                    <div class='tableau-container'> ";


            // Compte le nombre de formations récupérées
            $nbformation = count($formations);
            for ($x = 0; $x < $nbformation; $x++) {

                // Récupère le formateur référent
                $referent = $databaseFormateur->getBy(['nom_formateur', 'prenom_formateur'], 'Formateur', ['id_formateur'], [$formations[$x]->id_formateur]);

                //recupere les date de vacances pour chaque formateur et les place dans un tableau
                $formateurs = $databaseFormateur->getDatesById(
                    ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                    ['date_debut_vacances', 'date_fin_vacances', 'validation'],
                    'Formateur',
                    ['Date_vacance', 'Date_vacance', 'Date_vacance'],
                    ['Date_vacance'],
                    ['Formateur'],
                    ['id_formateur'],
                    'id_formateur',
                    $formateursSelectionnes
                );
                foreach ($formateurs as $formateur) {
                    $date_debut_vacences = $formateur['date_debut_vacances'];
                    $date_debut_vacences_array = explode(",", $date_debut_vacences);

                    $date_fin_vacences = $formateur['date_fin_vacances'];
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

                //recupere les date de MNSP pour chaque formateur et les place dans un tableau
                $formateurs = $databaseFormateur->getDatesById(
                    ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                    ['date_debut_MNSP', 'date_fin_MNSP'],
                    'Formateur',
                    ['Date_MNSP', 'Date_MNSP'],
                    ['Date_MNSP'],
                    ['Formateur'],
                    ['id_formateur'],
                    'id_formateur',
                    $formateursSelectionnes
                );
                foreach ($formateurs as $formateur) {
                    $date_debut_MNSP = $formateur['date_debut_MNSP'];
                    $date_debut_MNSP_array = explode(",", $date_debut_MNSP);

                    $date_fin_MNSP = $formateur['date_fin_MNSP'];
                    $date_fin_MNSP_array = explode(",", $date_fin_MNSP);

                    $dates_MNSP_formateurs = array();
                    $nbMNSP = count($date_debut_MNSP_array);
                    for ($i = 0; $i < $nbMNSP; $i++) {
                        $dates_MNSP_formateur[] = [
                            "id_formateur" => $formateur['id_formateur'],
                            "debut_MNSP" => $date_debut_MNSP_array[$i],
                            "fin_MNSP" => $date_fin_MNSP_array[$i],
                        ];
                    }

                    $dates_MNSP_formateurs[] = $dates_MNSP_formateur;
                }

                //recupere les date de perfectionnement pour chaque formateur et les place dans un tableau
                $formateurs = $databaseFormateur->getDatesById(
                    ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                    ['date_debut_perfectionnement', 'date_fin_perfectionnement'],
                    'Formateur',
                    ['Date_perfectionnement', 'Date_perfectionnement'],
                    ['Date_perfectionnement'],
                    ['Formateur'],
                    ['id_formateur'],
                    'id_formateur',
                    $formateursSelectionnes
                );
                foreach ($formateurs as $formateur) {
                    $date_debut_perfectionnement = $formateur['date_debut_perfectionnement'];
                    $date_debut_perfectionnement_array = explode(",", $date_debut_perfectionnement);

                    $date_fin_perfectionnement = $formateur['date_fin_perfectionnement'];
                    $date_fin_perfectionnement_array = explode(",", $date_fin_perfectionnement);

                    $dates_perfectionnement_formateurs = array();
                    $nbPerfs = count($date_debut_perfectionnement_array);
                    for ($i = 0; $i < $nbPerfs; $i++) {
                        $dates_perfectionnement_formateur[] = [
                            "id_formateur" => $formateur['id_formateur'],
                            "debut_perfectionnement" => $date_debut_perfectionnement_array[$i],
                            "fin_perfectionnement" => $date_fin_perfectionnement_array[$i]
                        ];
                    }

                    $dates_perfectionnement_formateurs[] = $dates_perfectionnement_formateur;
                }

                // Récupérer les dates de télétravail pour chaque formateurs et les place dans un tableau
                $formateurs = $databaseFormateur->joinInformations(
                    ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur', 'jour_teletravail', 'date_prise_effet', 'validation'],
                    'Formateur',
                    ['Date_teletravail'],
                    ['id_formateur'],
                    ['Formateur.id_formateur'],
                    $formateursSelectionnes
                );
                foreach ($formateurs as $formateur) {
                    $teletravail_formateurs = [
                        "jours" => $formateur->jour_teletravail,
                        "prise_effet" => $formateur->date_prise_effet,
                        "validation" => $formateur->validation,
                        "id_formateur" => $formateur->id_formateur
                    ];

                    $dates_teletravail_formateurs[] = $teletravail_formateurs;
                }


                // Récupérer les dates d'interventions pour chaque formateurs et les place dans un tableau
                $formateurs = $databaseFormateur->getDatesById(
                    ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur', 'Formation.id_formation'],
                    ['date_debut_intervention', 'date_fin_intervention', 'id_formation'],
                    'Formateur',
                    ['Date_intervention', 'Date_intervention', 'Formation'],
                    ['Date_intervention', 'Formation'],
                    ['Formateur', 'Date_intervention'],
                    ['id_formateur', 'id_formation'],
                    'id_formateur',
                    $formateursSelectionnes
                );
                foreach ($formateurs as $formateur) {
                    $date_debut_activite = $formateur['date_debut_intervention'];
                    $date_debut_array = explode(",", $date_debut_activite);
                    $date_fin_activite = $formateur['date_fin_intervention'];
                    $date_fin_array = explode(",", $date_fin_activite);
                    $formation_intervention = $formateur['id_formation'];
                    $formation_intervention_array = explode(",", $formation_intervention);

                    $dates_interventions_formateurs = array();

                    $nbInter = count($date_debut_array);
                    for ($i = 0; $i < $nbInter; $i++) {
                        $dates_formateur[] = [
                            "debut" => $date_debut_array[$i],
                            "fin" => $date_fin_array[$i],
                            "id_formation" => $formation_intervention_array[$i],
                            "id_formateur" => $formateur['id_formateur']
                        ];
                    }

                    $dates_interventions_formateurs[] = $dates_formateur;
                }

                // création d'un objet DateTime avec la date de début entrée
                $date_debut_tableau = new DateTime($_POST['date_debut']);
                // création d'un objet DateTime avec la date de fin entrée
                $date_fin_tableau = new DateTime($_POST['date_fin']);

                // Calcul du nombre de jours séparant les 2 dates, + 1 pour ajouter le jour actuel à la différence.
                $nbJours = $date_fin_tableau->diff($date_debut_tableau)->days + 1;

                // Tableau contenant les mois de 31 et 30 jours en nombre
                $mois31 = array('1', '3', '5', '7', '8', '10', '12');
                $mois30 = array('4', '6', '9', '11');

                // Clonage des dates de début et fin afin de savoir si l'année est bisextile ou non
                $current_date_year = clone $date_debut_tableau;
                $last_date_year = clone $date_fin_tableau;
                $yearDebut = $current_date_year->format('L');
                $yearFin = $last_date_year->format('L');

                // Clonages des dates de début afin de s'en servir pour l'itération des boucles consitutant les lignes du tableau
                $current_date_month = clone $date_debut_tableau;
                $current_date_dayName = clone $date_debut_tableau;
                $current_date_day = clone $date_debut_tableau;
                $current_date_dayForYears = clone $date_debut_tableau;
                $current_date_dayForMonths = clone $date_debut_tableau;

                // Tableau contenant les jours fériées franças fixes
                $joursFeries = array('01-01', '05-01', '05-08', '07-14', '08-15', '11-01', '11-11', '12-25');

                // Tableau contenant le nom des jours de la semaine et leur numéro
                $joursSemaine = [
                    "lundi" => "1",
                    "mardi" => "2",
                    "mercredi" => "3",
                    "jeudi" => "4",
                    "vendredi" => "5",
                ];

                // Compteur utilisés pour arrêter différentes boucles dans certaines situations
                $count = 0;
                $countFormateurs = count($formateurs);

                // Si aucune date relevées, alors le compteur est à 0
                if (!isset($dates_interventions_formateurs[0])) {
                    $countDates = 0;
                } else {
                    $countDates = count($dates_interventions_formateurs[0]);
                }

                if (!isset($dates_MNSP_formateurs[0])) {
                    $countDatesMNSP = 0;
                } else {
                    $countDatesMNSP = count($dates_MNSP_formateurs[0]);
                }

                if (!isset($dates_perfectionnement_formateurs[0])) {
                    $countDatesPerf = 0;
                } else {
                    $countDatesPerf = count($dates_perfectionnement_formateurs[0]);
                }

                if (!isset($dates_vacences_formateurs[0])) {
                    $countDatesVacences = 0;
                } else {
                    $countDatesVacences = count($dates_vacences_formateurs[0]);
                }

                // Ouverture du tableau
                $html .= " 
                            <table> 
                                <thead> 
                                <tr> 
                                    <th rowspan = 5>Afpa </th>
                                    <th class='sticky-container' colspan = '$nbJours'> <span> " . $formations[$x]->nom_formation . ' - ' . $referent[0]->nom_formateur . ' ' . $referent[0]->prenom_formateur . " </span> </th> 
                                </tr>
                                <tr>";

                for ($i = 0; $i < $nbJours; $i++) {
                    $annee = $current_date_year->format('Y');
                    $dernierJour = $current_date_dayForYears->format('m-d');

                    // Si l'une des 2 années des dates renseignées est bisextile, alors passe dans cette boucle.
                    if ($yearDebut || $yearFin) {
                        $count++;
                        // Le nombre d'itérations est égal à 366 ou le jour actuel de la boucle est le 31 décembre 
                        if ($count == 366 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                            // Créé une ligne de taille équivalente au compteur.
                            $html .= "<th class='sticky-container' colspan='$count'> <span> " . $annee . "</span> </th> ";

                            $count = 0;
                        }
                    } else {
                        $count++;
                        // Le nombre d'itérations est égal à 365 ou le jour actuel de la boucle est le 31 décembre 
                        if ($count == 365 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                            // Créé une ligne de taille équivalente au compteur.
                            $html .= "<th class='sticky-container' colspan='$count'> <span> " . $annee . "</span> </th> ";

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

                    // Si le mois actuel matche avec l'un des mois présent dans le tableau $mois31
                    if (in_array($mois, $mois31)) {
                        // Compteur du nombre d'iterations
                        $count++;
                        // Lorsque $numeroJour atteins 31 ou bien que la prochaine boucle sera la dernière
                        if ($numeroJour === "31" || ($i + 1) == $nbJours) {
                            // Le mois est égal à l'un de ces chiffre, 
                            // sa valeur est changée par le nom du mois correspondant et est inscrite dans le tableau
                            // La largeur de la case dépend du nombre d'itérations
                            switch ($mois) {
                                case 1: {
                                        $mois = "Janvier";
                                        break;
                                    }
                                case 3: {
                                        $mois = "Mars";
                                        break;
                                    }
                                case 5: {
                                        $mois = "Mai";
                                        break;
                                    }
                                case 7: {
                                        $mois = "Juillet";
                                        break;
                                    }
                                case 8: {
                                        $mois = "Août";
                                        break;
                                    }
                                case 10: {
                                        $mois = "Octobre";
                                        break;
                                    }
                                case 12: {
                                        $mois = "Décembre";
                                        break;
                                    }
                            }
                            $html .= "<th class='sticky-container' colspan='$count'> <span> " . $mois . " </span> </th> ";
                            // Le jour est remis au bon format
                            $numeroJour = $current_date_dayForMonths->format('j');
                            // Le compteur est remis à 0
                            $count = 0;
                        }
                    }
                    // Si le mois actuel matche avec l'un des mois présent dans le tableau $mois30
                    if (in_array($mois, $mois30)) {
                        // Compteur du nombre d'iterations
                        $count++;
                        // Lorsque $numeroJour atteins 30 ou bien que la prochaine boucle sera la dernière
                        if ($numeroJour === "30" || ($i + 1) == $nbJours) {
                            // Le mois est égal à l'un de ces chiffre, 
                            // sa valeur est changée par le nom du mois correspondant et est inscrite dans le tableau
                            // La largeur de la case dépend du nombre d'itérations
                            switch ($mois) {
                                case 4: {
                                        $mois = "Avril";
                                        break;
                                    }
                                case 6: {
                                        $mois = "Juin";
                                        break;
                                    }
                                case 9: {
                                        $mois = "Septembre";
                                        break;
                                    }
                                case 11: {
                                        $mois = "Novembre";
                                        break;
                                    }
                            }
                            $html .= "<th class='sticky-container' colspan='$count'> <span> " . $mois . " </span> </th> ";
                            // Le jour est remis au bon format
                            $numeroJour = $current_date_dayForMonths->format('j');
                            // Le compteur est remis à 0
                            $count = 0;
                        }
                    }

                    // Si le mois actuel est égal à 2
                    if ($mois === "2") {
                        // Compteur du nombre d'iterations
                        $count++;
                        // S'il s'agit d'une année bisextile
                        if ($yearDebut || $yearFin) {
                            // Lorsque $numeroJour atteins 29 ou bien que la prochaine boucle sera la dernière
                            if ($numeroJour == 29 || ($i + 1) == $nbJours) {
                                // Le mois est égal à Février
                                // La largeur de la case dépend du nombre d'itérations
                                $mois = "Février";
                                $html .= "<th class='sticky-container' colspan='$count'> <span> " . $mois . " </span> </th> ";

                                $numeroJour = $current_date_dayForMonths->format('j');
                                $count = 0;
                            }
                        } else {
                            // Lorsque $numeroJour atteins 28 ou bien que la prochaine boucle sera la dernière
                            if ($numeroJour == 28 || ($i + 1) == $nbJours) {
                                // Le mois est égal à Février
                                // La largeur de la case dépend du nombre d'itérations
                                $mois = "Février";
                                $html .= "<th class='sticky-container' colspan='$count'> <span> " . $mois . " </span> </th> ";

                                // Le jour est remis au bon format
                                $numeroJour = $current_date_dayForMonths->format('j');
                                // Le compteur est remis à 0
                                $count = 0;
                            }
                        }
                    }
                    $current_date_month->modify("+1 day");
                    $current_date_dayForMonths->modify("+1 day");
                }

                $html .= "</tr> <tr> ";
                for ($i = 0; $i < $nbJours; $i++) {
                    // Pour chaque jour, une case est créée. 
                    $jourNom = $current_date_dayName->format('N');
                    // Le jour est égal à l'un de ces chiffre, 
                    // sa valeur est changée par le nom du jour correspondant et est inscrite dans le tableau
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
                    // Pour chaque jour, une case contenant le nombre du jour dans le mois est créée.
                    $jour = $current_date_day->format('j');
                    $current_date_day->modify("+1 day");
                    $html .= "<th>" . $jour . "</th> ";
                }
                $html .= "</tr> <tbody> <tr> ";


                // Création de tableaux vides pour stocker les périodes de chaque formateur
                $formateur_periodes = array();
                $formateur_vacance = array();
                $formateur_MNSP = array();
                $formateur_perfectionnement = array();

                // Ajout du nom formation dans la première colonne du tableau

                // Boucle pour parcourir tous les formateurs
                for ($z = 0; $z < $countFormateurs; $z++) {

                    // Clonage de la date de début du tableau pour éviter de modifier l'objet original
                    $current_date_dayForFormateurs = clone $date_debut_tableau;

                    // Ajout du nom et prénom du formateur dans la première colonne du tableau
                    $html .= "<th>" . $formateurs[$z]['nom_formateur'] . ' ' . $formateurs[$z]['prenom_formateur'] . "</th> ";

                    // Création d'un tableau vide pour stocker les périodes du formateur en cours
                    $formateur_periodes[$formateurs[$z]['id_formateur']] = array();
                    $formateur_vacance[$formateurs[$z]['id_formateur']] = array();
                    $formateur_MNSP[$formateurs[$z]['id_formateur']] = array();
                    $formateur_perfectionnement[$formateurs[$z]['id_formateur']] = array();


                    // Boucle pour parcourir tous les jours du tableau
                    for ($i = 0; $i < $nbJours; $i++) {

                        // Boucle pour parcourir toutes les dates d'intervention pour trouver les périodes du formateur en cours
                        for ($j = 0; $j < $countDates; $j++) {

                            // Stockage de la période dans le tableau des périodes du formateur en cours
                            if ($dates_interventions_formateurs[0][$j]['id_formateur'] == $formateurs[$z]['id_formateur'] && $dates_interventions_formateurs[0][$j]['id_formation'] == $formations[$x]->id_formation) {
                                $formateur_periodes[$formateurs[$z]['id_formateur']][] = array(
                                    'debut' => $dates_interventions_formateurs[0][$j]['debut'],
                                    'fin' => $dates_interventions_formateurs[0][$j]['fin']
                                );
                            }
                        }

                        // Boucle pour parcourir toutes les dates de vacance pour trouver les vacance du formateur en cours
                        for ($v = 0; $v < $countDatesVacences; $v++) {

                            // Stockage de la période dans le tableau des périodes du formateur en cours
                            if ($dates_vacences_formateurs[0][$v]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_vacance[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_vacances' => $dates_vacences_formateurs[0][$v]['debut_vacences'],
                                    'fin_vacances' => $dates_vacences_formateurs[0][$v]['fin_vacences'],
                                    'validation' => $dates_vacences_formateurs[0][$v]['validation_vacences']
                                );
                            }
                        }

                        for ($w = 0; $w < $countDatesMNSP; $w++) {
                            if ($dates_MNSP_formateurs[0][$w]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_MNSP[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_MNSP' => $dates_MNSP_formateurs[0][$w]['debut_MNSP'],
                                    'fin_MNSP' => $dates_MNSP_formateurs[0][$w]['fin_MNSP'],
                                );
                            }
                        }
                        for ($y = 0; $y < $countDatesPerf; $y++) {
                            if ($dates_perfectionnement_formateurs[0][$y]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_perfectionnement[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_perfectionnement' => $dates_perfectionnement_formateurs[0][$y]['debut_perfectionnement'],
                                    'fin_perfectionnement' => $dates_perfectionnement_formateurs[0][$y]['fin_perfectionnement'],
                                );
                            }
                        }

                        // Récupération de la période courante
                        $periodeJourFeries = $current_date_dayForFormateurs->format('m-d');
                        $periode = $current_date_dayForFormateurs->format('Y-m-d');
                        $jourLettre = $current_date_dayForFormateurs->format('N');

                        // Vérification si le formateur a une période pour le jour en cours
                        $formateurAvoirPeriode = false;
                        foreach ($formateur_periodes[$formateurs[$z]['id_formateur']] as $periodeFormateur) {
                            if ($periode >= $periodeFormateur['debut'] && $periode <= $periodeFormateur['fin']) {
                                $formateurAvoirPeriode = true;
                                break;
                            }
                        }

                        $formateurAvoirTeletravail = 0;
                        foreach ($dates_teletravail_formateurs as $periode_teletravail) {
                            if ($periode_teletravail['validation'] === "1") {
                                $priseEffet = new DateTime($periode_teletravail['prise_effet']);
                                if ($priseEffet >= $date_debut_tableau) {
                                    $jours_array = explode(',', $periode_teletravail['jours']);
                                    for($i = 0; $i <= count($joursSemaine); $i++){
                                        if (in_array($jours_array, array_flip($joursSemaine))) {
                                            $formateurAvoirTeletravail = 1;
                                            break;
                                        }
                                    }
                                }
                                break;
                            }
                        }

                        // Vérification si le formateur a des vacances pour le jour en cours et si elles sont validées ou en attente
                        $formateurAvoirVacances = 0;
                        foreach ($formateur_vacance[$formateurs[$z]['id_formateur']] as $periode_vacances) {
                            if ($periode >= $periode_vacances['debut_vacances'] && $periode <= $periode_vacances['fin_vacances']) {
                                $formateurAvoirVacances = 1;
                                if ($periode_vacances['validation'] === "1") {
                                    $formateurAvoirVacances = 2;
                                }
                                break;
                            }
                        }

                        $formateurAvoirMNSP = false;
                        foreach ($formateur_MNSP[$formateurs[$z]['id_formateur']] as $MNSPFormateur) {
                            if ($periode >= $MNSPFormateur['debut_MNSP'] && $periode <= $MNSPFormateur['fin_MNSP']) {
                                $formateurAvoirMNSP = true;
                                break;
                            }
                        }

                        $formateurAvoirPerfectionnement = false;
                        foreach ($formateur_perfectionnement[$formateurs[$z]['id_formateur']] as $perfectionnementFormateur) {
                            if ($periode >= $perfectionnementFormateur['debut_perfectionnement'] && $periode <= $perfectionnementFormateur['fin_perfectionnement']) {
                                $formateurAvoirPerfectionnement = true;
                                break;
                            }
                        }

                        // Vérification si le jour en cours est compris dans les dates de formation en cours
                        $formation_en_cours = false;
                        if ($periode >= $formations[$x]->date_debut_formation && $periode <= $formations[$x]->date_fin_formation) {
                            $formation_en_cours = true;
                        }

                        // Si la date actuelle n'est pas comprise dans les dates de formations
                        if (!$formation_en_cours) {
                            $html .= "<td style='background-color: black;'></td> ";
                        } else {
                            // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période de vacances pour le formateur
                            if ($formateurAvoirVacances !== 0) {
                                if ($formateurAvoirVacances == 2) {
                                    $html .= "<td style='background-color: " . $_SESSION['color']['couleur_vacance_validee'] . " ;'></td>";
                                } else if ($formateurAvoirVacances == 1) {
                                    $html .= "<td style='background-color: " . $_SESSION['color']['couleur_vacance_demandees'] . ";'></td> ";
                                }
                            } else {
                                // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période d'intervention pour le formateur
                                if ($formateurAvoirPeriode) {
                                    // Si la date actuelle est un jour férié
                                    if (
                                        in_array($periodeJourFeries, $joursFeries)
                                        || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                        || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                                    ) {
                                        $html .= "<td style='background-color: " . $_SESSION['color']['couleur_ferie'] . ";'></td> ";
                                    } else {
                                        // Si le jour de la semaine est égal à 6 ou 7
                                        if ($jourLettre === "6" || $jourLettre === "7") {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_weekend'] . " ;'></td> ";
                                        } else {
                                            if ($formateurAvoirTeletravail) {
                                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_centre'] . " ;'> T </td> ";
                                            }
                                            else{
                                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_centre'] . " ;'></td> ";
                                            }
                                        }
                                    }
                                } else {
                                    if (
                                        // Si la date actuelle est un jour férié
                                        in_array($periodeJourFeries, $joursFeries)
                                        || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                        || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                                    ) {
                                        $html .= "<td style='background-color:" . $_SESSION['color']['couleur_ferie'] . ";'></td> ";
                                    } else {
                                        // Si le jour de la semaine est égal à 6 ou 7
                                        if ($jourLettre === "6" || $jourLettre === "7") {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_weekend'] . " ;'></td> ";
                                        } else {
                                            if ($formateurAvoirMNSP) {
                                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_MNSP'] . " ;'></td> ";
                                            } else if ($formateurAvoirPerfectionnement) {
                                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_perfectionment'] . " ;'></td> ";
                                            } else {
                                                $html .= "<td style='background-color: var(--emptyCell);'></td> ";
                                            }
                                        }
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
                // Fermeture de la table
                $html .= "</tbody> </table>";
            }
            $nbformation == 0 ? $html = "Aucun résultat." : $html .= " </div> </div>";
        } else {
            $html = "<div style='height: 80vh; display:flex; align-items:center; justify-content:center;'> <h1 style='text-align:center'> Veuillez entrer des informations dans les champs de recherche afin de consulter les formations. </h1> </div>";
        }

        $formation = new FormationModel;
        $formateur = new FormateurModel;
        $formateurs = $formateur->getFormateur();
        $GRNs = $formateur->getAll('GRN');
        $villes = $formation->getAll('Ville');
        !isset($html) ? $html = "Aucun résultat." : '';
        isset($_POST['rechercher']) ? $data = $_POST : $data = "";

        $this->render('main/index', compact('GRNs', 'formateurs', 'villes', 'html', 'data'), 'main');
    }
}
