<?php

$profil = function($username = null) {
    global $DB_PREFIX;
    $error = false;
    $user = get_user_by_username($username ? $username : $_SESSION['username'], Flight::get('db'));
    if ($user)
        Flight::render("templates/profil.tpl", array("admin" => $user['admin'], "user" => $user));
    else
        Flight::redirect("/login", 401);

    /** changer de mdp */
    if (isset($_POST['changeMDP'])) {
        if (empty($_POST['mdpActu'])) $error = "Un ou plusieurs champs manquant"; 
        if (empty($_POST['newMDP'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['confirmNewMDP'])) $error = "Un ou plusieurs champs manquant";

        if (!$error) { // S'il sont remplis on continue
            $db = Flight::get("db");
            $req = $db->prepare("SELECT `password` FROM `${DB_PREFIX}utilisateurs` WHERE (`ID` = ?)");
            $req->execute(array($user['ID']));
            if ($_POST['newMDP'] === $_POST['confirmNewMDP']){
                if ($data = $req->fetch()) {
                    if (password_verify($_POST['mdpActu'], $data['password'])) {
                        $req = $db->prepare("UPDATE `${DB_PREFIX}utilisateurs` SET `password`=? WHERE (`ID` = ?)");
                        $req->execute(array(password_hash($_POST['newMDP'], PASSWORD_DEFAULT),$user['ID']));
                    } else {
                    $error = "Mot de passe incorrect";
                    }
                }
            }else{
                $error = "Verification de votre mot de passe incorrect";
            }  
        }
    }
    if (isset($_POST['change_information'])) {
        if (empty($_POST['newNom'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newPrnom'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newMail'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newAdresse'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newVille'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newCPost'])) $error = "Un ou plusieurs champs manquant";
        if (empty($_POST['newPhone'])) $error = "Un ou plusieurs champs manquant";
        if (!filter_var($_POST['newMail'], FILTER_VALIDATE_EMAIL) && !$error) $error= "Merci d\\'écrire une adresse email valide";

        if (!$error) {
            $db = Flight::get("db");
            $req = $db->prepare("SELECT `mail` FROM `${DB_PREFIX}utilisateurs` WHERE (`mail` = ?) AND (`ID` != ?)"); 
            $req->execute(array($_POST['newMail'],$user['ID']));
            if ($req->fetch()) $error = "L\\'adresse email est déjà utilisée";
            else{
                if(!$error){
                    $req = $db->prepare("UPDATE `${DB_PREFIX}utilisateurs` SET `mail`=?,`nom`=?,
                    `prenom`=?,`rue`=?,`code_postal`=?,`ville`=?,`num_tel`=? WHERE (`ID` = ?)");
                    $req->execute(array($_POST['newMail'],$_POST['newNom'],$_POST['newPrnom'],
                    $_POST["newAdresse"],$_POST['newCPost'],$_POST['newVille'],$_POST['newPhone'],$user['ID']));
                    $req = $db->prepare("SELECT * FROM `${DB_PREFIX}utilisateurs` WHERE (`mail`= ?)");
                    $req->execute(array($_POST['newMail']));
                    if ($data = $req->fetch() ) {
                        $_SESSION['logged'] = true;
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['admin'] = ($data['admin'] >= 1);
                        Flight::redirect("/profil");
                    }
                }
            }
        }
    }
    if ($error)
        echo '<SCRIPT language="Javascript">alert(\''.$error.'\');</SCRIPT>';
};

$goto_profil = function() {
    Flight::redirect("/profil");
};
