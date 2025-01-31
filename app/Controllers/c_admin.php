<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_admin;
use App\Models\m_ludique;
use Config\Services;

class c_admin extends BaseController
{
    public function index()
    {
        $data['validation'] = Services::validation();
        $data['titre'] = "Connexion Admin";
        $data['title'] = "Connexion Admin";

        // Vérifier si un message flash existe
        $session = Services::session();
        if ($session->getFlashdata('infoConnexion')) {
            $data['infoConnexion'] = $session->getFlashdata('infoConnexion');
        } else {
            $data['infoConnexion'] = null; // Pas de message par défaut
        }

        return view('connexionAdmin_view', $data);
    }


    public function connexion()
    {
//        $model = new m_admin();
//        $model->ajoutCompte('Hatan.C', 'Hatan','Charles','Hatan.Charles37', 'charles.hatan@gmail.com', 'admin');
        // Mise en place du service
        $validation = service('validation');

        // Règles de validation des données
        $validation->setRules([
            'login' => 'required|min_length[3]|max_length[20]',
            'motPasse' => 'required|min_length[12]',
        ],
            [
                'login' => ['required' => 'Votre login est obligatoire',
                    'min_length' => '3 caractères minimum'
                ],
                'motPasse' => [
                    'required' => 'Votre mot de passe est obligatoire',
                    'min_length' => '12 caractères minimum'
                ]
            ]);


        // Récupération des données du formulaire
        $data = [
            'login' => $this->request->getPost('login'),
            'motPasse' => $this->request->getPost('motPasse'),
            'title'=> "Connexion Admin",
            "titre" => "Connexion Admin",
        ];

        // Contrôle de validation des règles sur les données
        if ($validation->run($data)) {
            // Mise en place de la gestion des sessions
            $session = Services::session();

            // Contrôle du login dans la table user
            $loginUser = $this->request->getPost('login');
            $model = new m_admin();
            $user = $model->connexion($loginUser);

            // Le login n'est pas trouvé
            if ($user === false) {
                $session->setFlashdata('infoConnexion', 'Utilisateur non trouvé');
                $data['validation'] = $validation;
                return view('connexionAdmin_view',$data);
            } else {
                // Vérification si l'utilisateur est un administrateur
                if ($user[0]->role !== 'admin') {
                    $session->setFlashdata('infoConnexion', 'Accès réservé aux administrateurs');
                    $data['validation'] = $validation;
                    return view('connexionAdmin_view',$data);
                }

                // Le login est trouvé, comparaison des mots de passe
                $pwd = $user[0]->motPasse;
                $verifPwd = password_verify($this->request->getPost('motPasse'), $pwd);

                // Mots de passe identiques
                if ($verifPwd) {
                    // Mise en place des sessions
                    $session->set('login', $user[0]->login); // Enregistrement du login
                    $session->set('nom', $user[0]->nom); // Enregistrement du nom
                    $session->set('prenom', $user[0]->prenom); // Enregistrement du prénom
                    $dataok["titre"]="Connexion Admin";
                    $dataok["title"]="Connexion Admin";
                    return view('connexionOk_view',$dataok);
                } else {
                    $session->setFlashdata('infoConnexion', 'Mot de passe incorrect');
                    $data['validation'] = $validation;
                    return view('connexionAdmin_view',$data);
                }
            }
        } else {
            // Affichage des erreurs de validation
            $data['validation'] = $validation;
            $data["titre"]="Connexion Admin";
            $data["title"]="Connexion Admin";
            return view('connexionAdmin_view', $data);
        }
    }


    public function deconnexion()
    {
        $session = Services::session();
        $session->remove('login');
        $session->destroy();
        $data = [
            'titre' => "Deconnexion Admin",
            'title' => "Deconnexion Admin",
        ];
        return view('connexionOk_view',$data);
    }

    public function pageAdmin()
    {
        $session = Services::session();

        // Vérifier si l'utilisateur est connecté
        if (!$session->has('login')) {
            // Rediriger vers la page de connexion avec un message d'erreur
            $session->setFlashdata('infoConnexion', 'Vous devez être connecté pour accéder à cette page.');
            $data = [
                'titre' => "Connexion Admin",
                'title' => "Connexion Admin",
                'validation' => Services::validation()];
            return view('connexionAdmin_view', $data);

        }
        // Créer une instance du modèle
        $model = new m_admin();

        // Récupérer le mot-clé de la recherche, s'il y en a un
        $motCle = $this->request->getPost('motCle');

        // Si un mot-clé est fourni, rechercher les questions
        if (!empty($motCle)) {
            $lesQuestions = $model->rechercheQuestion($motCle);
        } else {
            // Sinon, récupérer toutes les questions
            $lesQuestions = $model->getQuestions();
        }

        // Préparer les données pour la vue
        $data = [
            'titre' => "Espace Ludique Admin",
            'title' => "Espace Ludique Admin",
            'lesQuestions' => $lesQuestions
        ];

        // Charger la vue avec les données
        return view('adminPage_view', $data);
    }




    public function ajoutPage()
    {
        $session = Services::session();
        $data['validation'] = \CodeIgniter\Config\Services::validation();

        // Vérifier si l'utilisateur est connecté
        if (!$session->has('login')) {
            // Rediriger vers la page de connexion avec un message d'erreur
            $session->setFlashdata('infoConnexion', 'Vous devez être connecté pour accéder à cette page.');
            $data = [
                'titre' => "Connexion Admin",
                'title' => "Connexion Admin",
                'validation' => Services::validation()];
            return view('connexionAdmin_view', $data);

        }
        $model = new m_admin();
        $themes = $model->getThemes();
        $data = [
            'titre' => "Ajouter Une Question",
            'title' => "Ajouter",
            'themes' => $themes
        ];
        return view('ajouter_view',$data);
    }

    public function ajouterQuestion()
    {
        $model = new m_admin();
        // Récupère les données du formulaire
        $libelle = $this->request->getPost('libelle');
        $theme = $this->request->getPost('theme');
        $image = $this->request->getPost('image');
        $prop1 = $this->request->getPost('prop1');
        $prop2 = $this->request->getPost('prop2');
        $prop3 = $this->request->getPost('prop3');
        $prop4 = $this->request->getPost('prop4');

        // Récupère les valeurs correctes pour chaque proposition
        $correct1 = $this->request->getPost('prop1_correct');
        $correct2 = $this->request->getPost('prop2_correct');
        $correct3 = $this->request->getPost('prop3_correct');
        $correct4 = $this->request->getPost('prop4_correct');

        $validation = service('validation');
        // Mise en place du service

        // Règles de validation des données
        $validation->setRules([
            'libelle' => 'required|min_length[3]|max_length[250]',
            'theme' => 'required',
            'prop1' => 'required|min_length[1]|max_length[250]',
            'prop1_correct' => 'required',
            'prop2' => 'required|min_length[1]|max_length[250]',
            'prop2_correct' => 'required',
        ],
            [
                'libelle' => ['required' => 'Un libelle pour la question est obligatoire',
                    'min_length' => '3 caractères minimum',
                    'max_lengh' => '250 caractères maximum',
                ],
                'theme' => ['required' => 'Un choix de thème est obligatoire'
                ],
                'prop1' => ['required' => 'Une proposition de réponse est obligatoire',
                    'min_length' => '1 caractères minimum',
                    'max_lengh' => '250 caractères maximum',
                ],
                'prop1_correct' =>['required'=> 'Reponse correcte ou incorrect ?',],
                'prop2' => ['required' => 'Une 2e proposition est obligatoire',
                    'min_length' => '1 caractères minimum',
                    'max_lengh' => '250 caractères maximum',
                ],'prop2_correct' =>['required'=> 'Reponse correcte ou incorrect ?',],
            ]);
        $themes = $model->getThemes();


        // Envoie les données à la vue success_view
        $data = [
            'title' => "Ajouter",
            'titre'=>"Ajouter Une Question",
            'libelle' => $libelle,
            'theme' => $theme,
            'prop1' => $prop1,
            'prop2' => $prop2,
            'prop1_correct' => $correct1,
            'prop2_correct' => $correct2,
            'validation'=>$validation,
            'themes' => $themes,

        ];
        if($validation->run($data)){
            //Sauvegarder dans la base de donnée
            $model = new m_admin();
            $message = $model->ajoutQuestion($libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4, $correct1, $correct2, $correct3, $correct4);
            $data['message'] = $message;
            //Message de succès
            return view('succes_view', $data);
        }else{
            $data['validation'] = Services::validation();
            return view('ajouter_view', $data);
        }

    }





    public function supprimerQuestion($question_id = null)
    {
        // Utilise le modèle pour supprimer la question
        $model = new m_admin();

        // Appelle la méthode pour supprimer la question
        $message = $model->supprimerQuestion($question_id);  // Appelle la méthode dans le modèle

        // Envoie les données à la vue success_view
        $data = [
            'title' => "Message",
            'question_id' => $question_id,
            'message' => $message  // Affiche le message retourné
        ];

        return view('succes_view', $data);
    }




    public function modifPage($question_id)
    {
        $session = Services::session();

        // Vérifier si l'utilisateur est connecté
        if (!$session->has('login')) {
            // Rediriger vers la page de connexion avec un message d'erreur
            $session->setFlashdata('infoConnexion', 'Vous devez être connecté pour accéder à cette page.');
            $data = [
                'titre' => "Connexion Admin",
                'title' => "Connexion Admin",
                'validation' => Services::validation()
            ];
            return view('connexionAdmin_view', $data);
        }

        // Récupérer les informations de la question avec l'ID
        $model = new m_admin();
        $question = $model->modif_Page($question_id); // Récupère la question selon l'ID

        $themes = $model->getThemes();

        // Préparer les données pour la vue
        $data = [
            'titre' => "Modifier Une Question",
            'title' => "Modifier",
            'libelle' => $question->libelle,
            'theme' => $question->theme,
            'image' => $question->image,
            'prop1' => $question->prop1,
            'prop2' => $question->prop2,
            'prop3' => $question->prop3,
            'prop4' => $question->prop4,
            'est_correct_1' => $question->est_correct_1,
            'est_correct_2' => $question->est_correct_2,
            'est_correct_3' => $question->est_correct_3,
            'est_correct_4' => $question->est_correct_4,
            'themes' => $themes,
            'question_id' => $question_id,
            'question' => $question,
        ];


        return view('modifier_supprimer_view', $data); // Afficher la vue de modification avec la question
    }


    public function modifierQuestion($question_id = null)
    {
        $model = new m_admin();

        // Récupère les données du formulaire
        $libelle = $this->request->getPost('libelle');
        $theme = $this->request->getPost('theme');
        $image = $this->request->getPost('image');
        $prop1 = $this->request->getPost('prop1');
        $prop2 = $this->request->getPost('prop2');
        $prop3 = $this->request->getPost('prop3');
        $prop4 = $this->request->getPost('prop4');
        $correct1 = $this->request->getPost('correct1');
        $correct2 = $this->request->getPost('correct2');
        $correct3 = $this->request->getPost('correct3');
        $correct4 = $this->request->getPost('correct4');

        // Appelle la méthode pour modifier la question
        $message = $model->modifQuestion($question_id, $libelle, $theme, $image, $prop1, $prop2, $prop3, $prop4, $correct1, $correct2, $correct3, $correct4);
        $themes = $model->getThemes();
        // Envoie les données à la vue success_view
        $data = [
            'title' => "Message",
            'question_id' => $question_id,
            'message' => $message,  // Affiche le message retourné
            'libelle' => $libelle,
            'theme' => $theme,
            'image' => $image,
            'prop1' => $prop1,
            'prop2' => $prop2,
            'prop3' => $prop3,
            'prop4' => $prop4,
            'est_correct_1' => $correct1,
            'est_correct_2' => $correct2,
            'est_correct_3' => $correct3,
            'est_correct_4' => $correct4,
            'themes' => $themes,
        ];

        return view('succes_view', $data);
    }





}
