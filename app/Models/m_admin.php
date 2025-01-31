<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class m_admin extends Model
{
    public function connexion($login)
    {
        // Connexion à la base de données
        $db = db_connect();

        // Requête
        $query = $db->table('users')
            ->select('login, nom, prenom, motPasse, role')
            ->where('login', $login)
            ->get();

        // Vérification du résultat
        if ($query->getNumRows() > 0) {
            return $query->getResult();
        }

        return false;
    }


    public function ajoutCompte($login, $nom, $prenom, $motPasse, $email, $role)
    {
        // Connexion à la base de données
        $db = db_connect();
        $motPasseHache = password_hash($motPasse, PASSWORD_DEFAULT); // Hachage du mot de passe

        // Insertion des informations dans la base de données
        $informations = [
            'id' => null,
            'login' => $login,
            'nom' => $nom,
            'prenom' => $prenom,
            'motPasse' => $motPasseHache,
            'email' => $email,
            'role' => $role
        ];

        // Exécution de l'insertion
        $db->table('users')->insert($informations);
    }

    function getQuestions()
    {
        $result = false;
        // Connexion à la base de données
        $db = db_connect();
        // Préparation de l'appel à la procédure
        $appel = "CALL liste_questions()";
        // Appel de la procédure stockée
        $query = $db->query($appel);
        // Vérification du résultat
        if ($query->getNumRows() > 0) {
            $result = $query->getResult();
        }
        return $result;
    }

    public function ajoutQuestion($libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4, $correct1, $correct2, $correct3, $correct4)
    {
        // Connexion à la base de données
        $db = db_connect();

        // Préparation de l'appel à la procédure stockée
        $appel = "CALL ajouter_question(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Exécution de la requête avec les paramètres
        $query = $db->query($appel, [$libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4, $correct1, $correct2, $correct3, $correct4
        ]);


        // Vérifie si la requête a retourné des résultats
        if ($query) {
            // Récupère la première ligne de la réponse
            $result = $query->getRow();

            // Si le message de succès ou d'erreur est défini
            if (isset($result->success_message)) {
                return $result->success_message;
            } elseif (isset($result->error_message)) {
                return $result->error_message;
            }
        }
            return 'Erreur lors de l\'exécution de la requête SQL.';

    }




    public function supprimerQuestion($question_id)
    {
        // Connexion à la base de données
        $db = db_connect();

        // Préparation de l'appel à la procédure
        $appel = "CALL supprimer_question(?)";

        // Exécution de la requête avec l'ID de la question
        $query = $db->query($appel, [$question_id]);

        // Vérifie si la requête a retourné des résultats
        if ($query) {
            // Récupère la première ligne de la réponse
            $result = $query->getRow();

            // Si le message de succès ou d'erreur est défini
            if (isset($result->success_message)) {
                return $result->success_message;
            } elseif (isset($result->error_message)) {
                return $result->error_message;
            }
        } else {
            return 'Erreur lors de l\'exécution de la requête SQL.';
        }
    }



    public function modifQuestion($question_id, $libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4, $correct1, $correct2, $correct3, $correct4)
    {
        // Connexion à la base de données
        $db = db_connect();

        // Préparation de l'appel à la procédure stockée
        $appel = "CALL modifier_question(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Exécution de la requête avec les paramètres
        $query = $db->query($appel, [
            $question_id, $libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4,
            $correct1, $correct2, $correct3, $correct4
        ]);

        // Récupère tous les résultats
        $result = $query->getResult();

        // Retourne le message de succès si présent
        if (!empty($result)) {
            return $result[0]->success_message ?? 'Erreur inconnue lors de la modification';
        }

        return 'Erreur inconnue lors de la modification';
    }


    public function modif_Page($question_id)
    {
        $db = db_connect();
        // Préparation de l'appel à la procédure
        $appel = "CALL liste_proposition(?)";

        // Exécution de la requête avec l'ID de la question
        $query = $db->query($appel, [$question_id]);

        if ($query->getNumRows() > 0) {
            return $query->getRow();

        } else {
            return null;
        }
    }


    public function rechercheQuestion($motCle)
    {
        $result = false;
        // Connexion à la base de données
        $db = db_connect();
        // Préparation de l'appel à la procédure
        $appel = "CALL liste_questions_recherche(?)";
        // Appel de la procédure stockée
        $query = $db->query($appel, [$motCle]);
        // Vérification du résultat
        if ($query->getNumRows() > 0) {
            $result = $query->getResult();
        }
        return $result;
    }

    function getThemes()
    {
        $result = false;
        // Connexion à la base de données
        $db = db_connect();
        // Préparation de l'appel à la procédure stockée
        $appel = "CALL recup_theme()";
        // Appel de la procédure stockée
        $query = $db->query($appel);

        // Vérification du résultat
        if ($query->getNumRows() > 0) {
            // Récupérer le résultat sous forme d'un tableau
            $themes = $query->getResult();
            // Extraire uniquement les noms des thèmes en un tableau simple
            $themeList = array_column($themes, 'theme');
            // Retourner le tableau des thèmes
            $result = $themeList;
        }

        return $result;
    }



}
