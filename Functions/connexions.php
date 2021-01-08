<?php

$get_login = function(){
    Flight::render("templates/login_regis.tpl");
};

$register = function (){
    global $DB_PREFIX;
    $error = false;
    if (empty($_POST['pseudo'])) $error["pseudo"] = "Merci de remplir ce champs"; // On vérifie si le champs username est rempli
    if (empty($_POST['mail'])) $error["mail"] = "Merci de remplir ce champs"; // On vérifie si le champs email est rempli
    if (empty($_POST['pass'])) $error["pass"] = "Merci de remplir ce champs"; // On vérifie si le champs mdp est rempli
    if (empty($_POST['verifpass'])) $error["verifpass"] = "Merci de remplir ce champs"; // On vérifie si le champs mdp est rempli
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) && !$error) $error['mail'] = "Merci d écrire une adresse email valide"; // on vérifie la validité de l'adresse email s'il n'y a pas déjà d'erreur
    
    if (!$error) { // S'il n'y a pas d'erreur on continue les vérifications
        $db = Flight::get("db");
        $req = $db->prepare("SELECT `username` FROM `${DB_PREFIX}utilisateurs` WHERE `username` = ? "); // On vérifie si le nom d'utilisateur existe déjà pour éviter qu'il soit réutiliser et éviter une erreur sql
        $req->execute(array($_POST['pseudo']));
        if ($req->fetch()) $error["pseudo"] = "Le nom d'utilisateur est déjà pris"; // Si on a un résultat on renvoie une erreur
        else {
            $req = $db->prepare("SELECT `mail` FROM `${DB_PREFIX}utilisateurs` WHERE `mail` = ?"); // Sinon on vérifie l'adresse email de la même façon
            $req->execute(array($_POST['mail']));
            if ($req->fetch()) $error["mail"] = "L\\'adresse email est déjà utilisée";
            else {
                if ($_POST['pass'] === $_POST['verifpass']){
                    $req = $db->prepare("INSERT INTO `${DB_PREFIX}utilisateurs`(`username`, `mail`, `password`) VALUES (?, ?, ?);"); // Si il n'y a toujours pas eu d'erreur on enregistre l'utilisateur dans la bdd
                    $req->execute(array($_POST['pseudo'], $_POST['mail'], password_hash($_POST['pass'], PASSWORD_DEFAULT))); // Bien sur on oublie pas de hasher le mdp
                    $_SESSION['logged'] = true; // On défini l'utilisateur comme connecté
                    $_SESSION['username'] = $_POST['pseudo'];
                    $_SESSION['admin'] = false;
                }else{
                    $error["verifpass"] = "Mot de passe incorrect";
                }               
            }
        }
    }
    if ($error) { // S'il y a eu une erreur précédement on réaffiche le formulaire avec les champs préremplis (sauf le mdp) et on affiche les erreurs
        Flight::render("templates/login_regis.tpl", array("post" => $_POST, "error" => $error, "action" => "register"));
    } else { // Sinon on redirige vers la page de success d'inscription
        Flight::redirect("/profil");
    }
};

$login = function(){
    global $DB_PREFIX;
    $error = false;
    if (empty($_POST['pseudo'])) $error["pseudo"] = "Merci de remplir ce champs"; // On vérifie que les champs soient remplis
    if (empty($_POST['pass'])) $error["pass"] = "Merci de remplir ce champs";
    if (!$error) { // S'il sont remplis on continue
        $db = Flight::get("db");
        $req = $db->prepare("SELECT * FROM `${DB_PREFIX}utilisateurs` WHERE (`mail`= ?) OR (`username`= ?)");
        $req->execute(array($_POST['pseudo'], $_POST['pseudo'])); // On récupère les infos de l'utilisateur avec cette email
        if ($data = $req->fetch()) { // S'il existe on vérifie le mdp
            if (password_verify($_POST['pass'], $data['password'])) { // Si le mdp est bon on connecte l'utilisateur
                $_SESSION['logged'] = true;
                $_SESSION['username'] = $data['username'];
                $_SESSION['admin'] = ($data['admin'] >= 1);
            } else $error['error'] = "Adresse Email ou mot de passe invalide."; // Sinon erreur générique pour éviter les failles de sécurité
        }
        else $error['error'] = "Adresse email ou mot de passe invalide."; // Sinon erreur générique pour éviter les failles de sécurité
    }
    if ($error) { // S'il y a eu une erreur alors on réaffiche le formulaire avec l'adresse email pré-remplie et les erreurs affichés
        Flight::render("templates/login_regis.tpl", array("post" => $_POST, "error" => $error, "action" => "login"));
    } else { // Sinon on renvoie l'utilisateur sur l'accueil
        Flight::redirect("/");
    }
};

$logout = function () {
    $_SESSION = array();
    session_destroy();
    session_start();
    Flight::redirect("/");
};
