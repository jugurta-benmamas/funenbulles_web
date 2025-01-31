<?php

namespace App\Models;

use CodeIgniter\Model;

class m_ludique extends Model
{
    function genereAlea($themes,$nbQuestions) {
        $db = db_connect();

        // Sélectionner des questions avec un ou plusieurs thèmes
        $numQuestionsAleatoires = $db->table('questions')
            ->select("questions.id")
            ->whereIn('questions.theme', $themes)
            ->orderBy("RAND()")
            ->limit($nbQuestions)
            ->get()
            ->getResultArray();

        // Récup des IDs des questions
        $listeNumero = array_column($numQuestionsAleatoires, 'id');

        // Stocker les IDs dans la session
        session()->set('listeNumero', $listeNumero);

        return $listeNumero;
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



    function recupQuestionsReponses($themes,$nbQuestions) {
        $result = false;
        $db = db_connect();

        // Récupérer les IDs des questions
        $listeNumero = $this->genereAlea($themes,$nbQuestions);

        // Ensuite, récupérer les réponses correspondantes aux questions sélectionnées
        $query = $db->table('questions')
            ->select("questions.id as id, questions.libelle as question, questions.image as image, questions.theme as theme, propositions.libelle as reponse, est_correcte")
            ->join('associer', 'associer.question_id = questions.id')
            ->join('propositions', 'propositions.numero = associer.proposition_id')
            ->whereIn('questions.id', $listeNumero)
            ->whereIn('questions.theme', $themes)
            ->orderBy("questions.libelle")
            ->get();

        // Vérification résultat
        if ($query->getNumRows() > 0) {
            $result = $query->getResult();
        }
        return $result;
    }

    function recupQuestionsBonneReponse() {
        $result = false;
        $db = db_connect();

        // Récupérer la liste des questions depuis la session
        $listeNumero = session()->get('listeNumero');

        $query = $db->table('questions')
            ->select("questions.id as id, questions.libelle as question, propositions.libelle as reponse, est_correcte")
            ->join('associer', 'associer.question_id = questions.id')
            ->join('propositions', 'propositions.numero = associer.proposition_id')
            ->where('associer.est_correcte = true')
            ->whereIn('questions.id', $listeNumero)
            ->orderBy("questions.libelle")
            ->get();

        // Vérification résultat
        if ($query->getNumRows() > 0) {
            $result = $query->getResult();
        }
        return $result;
    }
}
