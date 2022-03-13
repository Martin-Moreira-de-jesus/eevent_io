<?php

session_start();

const DONOR = 'donor';
const ADMIN = 'admin';
const JURY = 'jury';
const ORGANIZER = 'organizer';
const _PUBLIC = 'public';

require_once('../Utils/AutoLoader.php');

try {
    $url = '';
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
        if ($url[strlen($url) - 1] === '/') {
            $url = substr($url, 0, -1);
            header('Location: /' . $url);
            exit();
        }
        $url = explode('/', $url);
        if ($url[array_key_last($url)] === '') {
            unset($url[array_key_last($url)]);
        }
    }
    if (isset($_GET['controller'], $_GET['action'])) {
        $controllerName = $_GET["controller"] . 'Controller';
        $actionName = $_GET["action"];

        $_GET = array();
        $controller = new $controllerName();
        $controller->$actionName();
    } elseif ($url === '') {
        $controller = new PublicController();
        $controller->readIdeas();
    } elseif (str_contains($url[0], 'idee') && isset($url[1]) && is_numeric($url[1]) && !isset($url[2])) {
        $controller = new  PublicController();
        $controller->readIdea($url[1]);
    } elseif ($url[0] === 'admin') {
        $controller = new AdminController();
        if (!isset($url[1])) {
            $controller->readIndex();
        } elseif ($url[1] === 'campagnes') {
            if (!isset($url[2])) {
                $controller->readCampaigns();
            } elseif (is_numeric($url[2])) {
                if (!isset($url[3])) {
                    $controller->readIdeas($url[2]);
                } else if ($url[3] === 'modifier' && !isset($url[4])) {
                    $controller->readModifyCampaign($url[2]);
                } else {
                    $controller = new ErrorController();
                    $controller->error404('/');
                }
            } elseif ($url[2] === 'creer' && !isset($url[3])) {
                $controller->readCreateCampaign();
            } else {
                $controller = new ErrorController();
                $controller->error404('/');
            }
        } elseif ($url[1] === 'idee' && isset($url[2]) && is_numeric($url[2])) {
            if (!isset($url[3])) {
                $controller->readIdea($url[2]);
            } else {
                $controller = new ErrorController();
                $controller->error404('/');
            }
        } elseif ($url[1] === 'utilisateurs' && !isset($url[2])) {
            $controller->readUsers();
        } else {
            $controller = new ErrorController();
            $controller->error404('/');
        }
    } else if ($url[0] === 'login' && !isset($url[1])) {
        $controller = new UserController();
        $controller->Index();
    } else if ($url[0] === 'organisateur') {
        $controller = new OrganizerController();
        if (!isset($url[1])) {
            $controller->read();
        } else if ($url[1] === 'creer' && !isset($url[2])) {
            $controller->readCreate();
        } else if ($url[1] === 'modifier' && isset($url[2]) && is_numeric($url[2]) && !isset($url[3])) {
            $controller->readEdit($url[2]);
        } else {
            $controller = new ErrorController();
            $controller->error404('/');
        }
    } else if ($url[0] === 'jury') {
        $controller = new JuryController();
        if (!isset($url[1])) {
            $controller->read();
        }else if ($url[1] === 'idee' && isset($url[2]) && is_numeric($url[2]) && !isset($url[3])){
            $controller->readOne($url[2]);
        }
        else {
            $controller = new ErrorController();
            $controller->error404('/');
        }
    } else if ($url[0] === 'enregistrement' && !isset($url[1])) {
        $controller = new UserController();
        $controller->registration();
    } else if ($url[0] === 'changemdp' && !isset($url[1])) {
        $controller = new UserController();
        $controller->PasswordChange();
    } else if ($url[0] === 'recuperation' && !isset($url[1])) {
        $controller = new UserController();
        $controller->PasswordForgotten();
    } else {
        $controller = new ErrorController();
        $controller->error404('/');
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}