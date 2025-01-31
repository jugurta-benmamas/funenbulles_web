<?php

namespace App\Controllers;

use App\Models\m_ludique;

class c_ludique extends BaseController
{
    public function index()
    {
        $model = new m_ludique();

        // Récupérer les thèmes depuis la base de données
        $themes = $model->getThemes();

        // Vérifier le nombre de questions sélectionnées
        $nbQuestions = 8;

        // Préparer les données à envoyer à la vue
        $data = [
            'title' => 'Espace Ludique',
            'titre' => 'Connaissez-vous bien les Bandes Dessinées & Manga ? ',
            'themes' => $themes,
            'questions' => $model->recupQuestionsReponses($themes, $nbQuestions)  // Récupérer les questions selon les thèmes
        ];

        return view('ludique_view', $data);
    }





    public function valider()
    {
        $score = 0;
        $model = new m_ludique();
        $questions = $model->recupQuestionsBonneReponse();
        $bonnesReponses = [];
        foreach ($questions as $question) {
            $repQuestion = $this->request->getPost($question->id);
            if ($repQuestion == $question->reponse && $question->est_correcte == 1) {
                $score++;
                $bonnesReponses[] = $question;
            }
        }


        if ($score == 0){
            $message = "Tu n'as aucune bonne reponse";
        }else{
            if ($score >= 1 && $score <= 4){
                $message = "Tu peux mieux faire....";
            }else{
                $message = "Bravo !!!";
            }
        }

        $data = [
            'title' => 'Page du score ',
            'score' => $score,
            'message' => $message,
            'questionsOk' => $bonnesReponses
        ];
        return view('result_ludique_view', $data);
    }

    public function validerThemeQuestion()
    {
        // Récupérer les thèmes choisis par l'utilisateur via POST
        $themes = $this->request->getPost('theme'); // Le thème est un tableau
        $nbQuestions = $this->request->getPost('nb_question');

        // Récupérer les réponses des checkboxes (exemple ici pour une autre question)
        $reponses = $this->request->getPost('question');  // Récupère les valeurs cochées, sous forme de tableau



        if (is_array($reponses)) {
            // Si plusieurs réponses ont été sélectionnées, vous pouvez les parcourir
            foreach ($reponses as $reponse) {
                echo $reponse . "<br>"; // Affiche chaque réponse sélectionnée
            }
        }

        if (!in_array($nbQuestions, ['8', '10', '12', '14', '16'])) {
            $nbQuestions = 8; // Valeur par défaut si rien n'est sélectionné ou si la valeur n'est pas valide
        }

        $model = new m_ludique();

        // Récupérer les questions correspondant aux thèmes sélectionnés
        // Si plusieurs thèmes sont choisis, vous devez adapter le modèle pour accepter un tableau
        $questions = $model->recupQuestionsReponses($themes, $nbQuestions);
        $themes = $model->getThemes();
        // Préparer les données à envoyer à la vue
        $data = [
            'title' => 'Espace Ludique',
            'titre' => 'Connaissez-vous bien les Bandes Dessinées ? ',
            'themes' => $themes,
            'questions' => $questions,
            'reponses' => $reponses, // Ajoutez les réponses dans le tableau de données
            'nb_question' => $nbQuestions
        ];

        // Afficher les questions du thème dans la vue
        return view('ludique_view', $data);
    }








}