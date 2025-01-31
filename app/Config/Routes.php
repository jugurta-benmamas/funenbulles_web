<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//accueil
$routes->get('/', 'c_Home::index');
$routes->get('/about', 'c_Home::about');

//exposition
$routes->get('/expositions', 'c_expositions::index');

//ludique
$routes->get('/espace_ludique', 'c_ludique::index');
$routes->match(['get', 'post'], '/validerRep', 'c_ludique::valider');
$routes->match(['get', 'post'], '/validerThemeQuestion','c_ludique::validerThemeQuestion');

//auteur
$routes->get('/auteurs', 'c_auteurs::index');

//infos pratique
$routes->get('/pratique', 'c_pratique::index');

//contact
$routes->get('/contact', 'c_contact::index');
$routes->match(['get', 'post'], '/contactValider', 'c_contact::valider');

//admin
$routes->get('/admin','c_admin::index');
$routes->get('/ajouter','c_admin::ajoutPage');
$routes->get('/supprimer','c_admin::suppPage');
$routes->get('/modifier/(:num)','c_admin::modifPage/$1');
$routes->get('/deconnexion','c_admin::deconnexion');
$routes->match(['get', 'post'], '/ajouterQuestion', 'c_admin::ajouterQuestion');
$routes->match(['get', 'post'], '/modifierQuestion/(:num)', 'c_admin::modifierQuestion/$1');
$routes->get('/supprimerQuestion/(:num)', 'c_admin::supprimerQuestion/$1');
$routes->post('/supprimerQuestion/(:num)', 'c_admin::supprimerQuestion/$1');
$routes->match(['get','post'],'/adminPage','c_admin::pageAdmin');
$routes->match(['get','post'],'/connexion','c_admin::connexion');
$routes->match(['get', 'post'], '/validerRepAdmin', 'c_admin::valider');
$routes->match(['get', 'post'], '/validerThemeQuestionAdmin','c_admin::validerThemeQuestionAdmin');
$routes->match(['get', 'post'], '/rechercherQuestions','c_admin::rechercherQuestions');


//mention legales
$routes->get('/mentionsLegales', 'c_mentionsLegales::index');



