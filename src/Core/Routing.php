<?php

/*
    App : dossier src, dossier contenant toutes les classes de notre application, spécifié dans le composer.json
    Core : dossier src/Core
*/

namespace App\Core;

/*
    Le Routage doit récupérer l'URL et trouver le contrôleur et la méthode, reliés à la route (l'URL)
*/

class Routing
{
    /*
        Lister toutes les routes de l'application
            clé : la route
            valeur : array contenant le nom du controleur
    */
    private array $routes = [
        '/' => [
            'controller' => 'Homepage',
            'method' => 'index',
        ],
        '/auth' => [
            'controller' => 'Authentication',
            'method' => 'index',
        ],
        '/admin/games' => [
            'controller' => 'Game',
            'method' => 'showTable',
        ],
        '/admin/game/form' => [
            'controller' => 'Game',
            'method' => 'createEntry',
        ],
        '/admin/game/add' => [
            'controller' => 'Game',
            'method' => 'add',
        ],
        '/admin/game/form/update' => [
            'controller' => 'Game',
            'method' => 'modifEntry',
        ],
        '/admin/game/form/update-fait' => [
            'controller' => 'Game',
            'method' => 'update',
        ],
        '/admin/game/form/delete' => [
            'controller' => 'Game',
            'method' => 'deleteEntry',
        ],
        '/admin/game/form/delete-fait' => [
            'controller' => 'Game',
            'method' => 'delete',
        ],
        '/admin/game/delete/(\d+)' => [
            'controller' => 'Game',
            'method' => 'deleteEntry',
        ],
        '/login' => [
            'controller' => 'Login',
            'method' => 'index',
        ],
        '/logout' => [
            'controller' => 'Logout',
            'method' => 'index',
        ],
        '/register' => [
            'controller' => 'Register',
            'method' => 'index',
        ],
        
        /*
            utilisation d'une expression rationnelle
            () : création d'un groupe
            \d : chiffre
            + : 1 ou plusieurs
            ?<...> : nommer le groupe
        
        
        '/(?<id>\d+)' => [
            'controller' => 'Homepage',
            'method' => 'index',
        ],
        */
        
    ];

    // retourner le contrôleur et la méthode
    public function getRouteInfos():array
    {
        // récupérer la route (URL)
        $uri = $_SERVER['REQUEST_URI'];

        // Valeur par défaut
        $result = [
            'controller' => 'NotFound',
            'method' => 'index',
            'vars' => [],
        ];

        // tester si la route 
        foreach($this->routes as $regexp => $infos)
        {
            /*
                preg_match : tester la concordance avec une expression rationnelle, 3 paramètres
                - expression rationnelle
                - chaîne de caractères à tester
                - récupération des groupes
            */
            if(preg_match("#^^$regexp$#", $uri, $groups))
            {
                $result = $infos;
                $result['vars'] = $groups;
                
                // stopper la boucle
                break;
            }
        }

        // dans les groupes des expressions rationnelles, ne conserver que les clés non numériques
        foreach($result['vars'] as $key => $value)
        {
            // unset : supprimer une entrée dans un array
            if(is_int($key)) 
            {
                unset($result['vars'][$key]);
            }
        }
        
        return $result;        
    }
}