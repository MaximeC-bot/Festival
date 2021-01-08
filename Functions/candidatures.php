<?php
$candidature = array();
if (!isset($_SESSION['form'])) $_SESSION['form'] = array();

/** GET */

$candidature['home']['get'] = function() {
    global $show_candidature, $DB_PREFIX;
    $req = Flight::get('db')->prepare("SELECT ID from ${DB_PREFIX}candidatures WHERE ID_user = (SELECT ID FROM ${DB_PREFIX}utilisateurs WHERE username = ? LIMIT 0,1)");
    $req->execute(array($_SESSION['username']));
    if ($req->fetch()) {
        $show_candidature(get_userID_by_username($_SESSION['username'], Flight::get('db')));
    } else {
        if (empty($_SESSION['form'])) {
            Flight::redirect("/candidature/1");
        } elseif (verify_form($_SESSION['form'], 1)) {
            Flight::redirect("/candidature/1");
        } elseif (verify_form($_SESSION['form'], 2)) {
            Flight::redirect("/candidature/2");    
        } elseif (verify_form($_SESSION['form'], 3)) {
            Flight::redirect("/candidature/3");
        } else {
            Flight::redirect("/candidature/1");
        }
    }
};

$candidature['group']['get'] = function($error = null) {
    global $DB_PREFIX;
    $db = Flight::get("db");
    $dept_req = $db->query("SELECT * FROM ${DB_PREFIX}departements ORDER BY ID ASC");
    $scene_req = $db->query("SELECT * FROM ${DB_PREFIX}scenes ORDER BY ID ASC");
    Flight::render("inscription1.tpl", array("form" => $_SESSION['form'], "depts" => $dept_req, "scenes" => $scene_req, 'error' => $error));
};

$candidature['membres']['get'] = function($error = null) {
    Flight::render("inscription2.tpl", array("form" => $_SESSION['form'], 'error' => $error));
};

$candidature['infos']['get'] = function($error = null) {
    Flight::render("inscription3.tpl", array("form" => $_SESSION['form'], 'error' => $error));
};

/** POST */

$candidature['home']['post'] = function() {
    global $candidature;
    $_SESSION['form'] = array_merge($_SESSION['form'], $_POST);
    gestion_form($_SESSION['form'], $_FILES);
};

$candidature['group']['post'] = function() {
    global $candidature;
    $_SESSION['form'] = array_merge($_SESSION['form'], $_POST);
    $error = save_files($_FILES);
    if (empty($error))
        $candidature['group']['get']();
    else
        $candidature['membres']['get']($error);
};

$candidature['membres']['post'] = function() {
    global $candidature;
    $_SESSION['form'] = array_merge($_SESSION['form'], $_POST);
    $error = save_files($_FILES);
    if (empty($error))
        $candidature['membres']['get']();
    else
        $candidature['infos']['get']($error);
};

$candidature['infos']['post'] = function() {
    global $candidature;
    $_SESSION['form'] = array_merge($_SESSION['form'], $_POST);
    $error = save_files($_FILES);
    if (empty($error))
        $candidature['infos']['get']();
    else
        $candidature['membres']['get']($error);
};

/** Utils */

function gestion_form($form, $files) {
    global $candidature;
    $error = save_files($files);
    $errors = verify_form($form);
    if (is_array($errors)) {
        $error = array_merge($errors, $error);
        if (isset($error['group'])) {
            $candidature['group']['get']($error);
        } elseif (isset($error['membres']) || isset($error['media'])) {
            $candidature['membres']['get']($error);
        } elseif (isset($error['file'])) {
            $candidature['infos']['get']($error);
        } else {
            $candidature['group']['get']($error);
        }
    } else {
        $db = Flight::get('db');
        $sql = "INSERT INTO `prj_candidatures`(`ID_user`, `nom`, `dept`, `scene`, `style`, `annee_crea`, `presentation`, `experience`, `url_web`, `fb`, `twitter`, `soundcloud`, `youtube`, `asso`, `sacem`, `producteur`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $user = get_user_by_username($_SESSION['username'], $db);
        if (!$user) Flight::redirect("/login");
        $req = $db->prepare($sql);
        $req->execute(array(
            $user['ID'],
            $form['group']['name'],
            $form['group']['dept'],
            $form['group']['scene'],
            $form['group']['style_music'],
            $form['group']['year_create'],
            $form['group']['presentation'],
            $form['group']['expe'],
            $form['media']['website'],
            $form['media']['fb'],
            $form['media']['tw'],
            $form['media']['soundcloud'],
            $form['media']['yt'],
            ($form['info']['stat'] == "true" ? true : false),
            ($form['info']['sacem'] == "true" ? true : false),
            ($form['info']['prod'] == "true" ? true : false)
        ));
        $candidature_id = $db->lastInsertId();
        $req = $db->prepare("INSERT INTO `prj_membres`(`ID_group`, `nom`, `prenom`, `instrument`) VALUES (?,?,?,?)");
        for ($i=1; $i <= $form['nbMembres']; $i++) {
            $membre = $form['membres'][$i]; 
            $req->execute(array($candidature_id, $membre['nom'], $membre['prenom'], $membre['instru']));
        }
        Flight::redirect("/");
    }
}

function save_file($file, $as) {
    $file_location = "content/" . $_SESSION['username'];
    $extension = substr($file['name'], -4);
    if (substr($extension, 0, 1) == ".") $extension = substr($extension, 1);
    if (substr($as, 0, 4) == "file")
        $nom = substr($as, 9);
    elseif (substr($as, 0, 5) == "media")
        $nom = 'presse';
    return move_uploaded_file($file['tmp_name'], "$file_location/$nom.$extension");
}

function save_files($files) {
    $file_location = "content/" . $_SESSION['username'];
    if (!file_exists($file_location)) mkdir($file_location);
    $error = array();
    if (!empty($files)) {
        foreach ($files as $nom => $file) {
            if ($file['error'] != UPLOAD_ERR_OK && $file['error'] != UPLOAD_ERR_NO_FILE) {
                if (substr($nom, 0, 4) == "file")
                    $error['file'][substr($nom, 5, 3)][substr($nom, 9)] = "Error on file loading";
                elseif (substr($nom, 0, 5) == "media")
                    $error['media']['presse'] = "Error on file loading";
                continue;
            }
            if ($file['error'] == UPLOAD_ERR_OK && !save_file($file, $nom)) {
                if (substr($nom, 0, 4) == "file")
                    $error['file'][substr($nom, 5, 3)][substr($nom, 9)] = "Error on file loading";
                elseif (substr($nom, 0, 5) == "media")
                    $error['media']['presse'] = "Error on file loading";
            }
        }
    }
    return $error;
}

/**
 * verify_form
 * Verifie que le formulaire est correctement rempli
 * 
 * @param  array $form Array contenant les valeurs du formulaire
 * @param  int $part (0|null = all, 1 = group, 2 = membres, 3 = infos)
 * @return bool|array false if form is good, array of errors if form not good
 */
function verify_form($form, $part = null) {
    if (is_numeric($part) && $part > 0) {
        switch ($part) {
            case 1:
                if ($error = verify_group($form)) return false;
                else return $error;
            case 2:
                if ($error = verify_membres($form)) return false;
                else return $error;
            case 3:
                if ($error = verify_infos($form)) return false;
                else return $error;
            default:
                return verify_form($form);
        }
    } else {
        $error = array();
        if (is_array($errors = verify_group($form)))
            $error = array_merge($error, $errors);
        if (is_array($errors = verify_membres($form)))
            $error = array_merge($error, $errors);
        if (is_array($errors = verify_infos($form)))
            $error = array_merge($error, $errors);
        if (empty($error)) return false;
        else return $error;
    }
    return array();
}

function verify_group($form) {
    $error = array();
    $group = $form['group'];
    if (empty($group['name'])) $error['group']['name'] = "Champs requis";
    if (empty($group['style_music'])) $error['group']['style_music'] = "Champs requis";
    if (empty($group['year_create'])) $error['group']['year_create'] = "Champs requis";
    // if (empty($group['chef']['nom'])) $error['group']['chef']['nom'] = "Champs requis";
    // if (empty($group['chef']['prenom'])) $error['group']['chef']['prenom'] = "Champs requis";
    // if (empty($group['chef']['adresse'])) $error['group']['chef']['adresse'] = "Champs requis";
    // if (empty($group['chef']['code_postal'])) $error['group']['chef']['code_postal'] = "Champs requis";
    // if (empty($group['chef']['email'])) $error['group']['chef']['email'] = "Champs requis";
    // if (empty($group['chef']['tel'])) $error['group']['chef']['tel'] = "Champs requis";
    if (empty($group['presentation'])) $error['group']['presentation'] = "Champs requis";
    if (empty($group['expe'])) $error['group']['expe'] = "Champs requis";
    if ($error == array()) {
        return true;
    } else {
        return $error;
    }
}


function verify_membres($form) {
    $error = array();
    $nbMembres = $form['nbMembres'];
    $membres = $form['membres'];
    for ($i=1; $i <= $nbMembres; $i++) { 
        $membre = $membres[$i];
        if (empty($membre['nom'])) $error['membres'][$i] = "Champs requis";
        if (empty($membre['prenom'])) $error['membres'][$i] = "Champs requis";
        if (empty($membre['instru'])) $error['membres'][$i] = "Champs requis";
    }
    $media = $form['media'];
    if (empty($media['website']) && empty($media['fb'])) $error['media']['website'] = "Site ou lien facebook obligatoire";
    if (empty($error)) {
        return true;
    } else {
        return $error;
    }
}


function verify_infos($form) {
    $error = array();
    $infos = $form['info'];
    if (empty($infos['stat'])) $error['info']['stat'] = "Selection requise";
    if (empty($infos['sacem'])) $error['info']['sacem'] = "Selection requise";
    if (empty($infos['prod'])) $error['info']['prod'] = "Selection requise";
    $file_location = "content/" . $_SESSION['username'];
    if (!is_file_path($file_location, "1", array("mp3"))) $error['file']['mp3'][1] = "Fichier requis";
    if (!is_file_path($file_location, "2", array("mp3"))) $error['file']['mp3'][2] = "Fichier requis";
    if (!is_file_path($file_location, "3", array("mp3"))) $error['file']['mp3'][3] = "Fichier requis";
    if (!is_file_path($file_location, "1", array("png","jpg","jpeg"))) $error['file']['img'][1] = "Fichier requis";
    if (!is_file_path($file_location, "2", array("png","jpg","jpeg"))) $error['file']['img'][2] = "Fichier requis";
    if (!is_file_path($file_location, "sacem", array("pdf"))) $error['file']['pdf']['sacem'] = "Fichier requis";
    if (!is_file_path($file_location, "tech", array("pdf"))) $error['file']['pdf']['tech'] = "Fichier requis";
    if (empty($error)) {
        return true;
    } else {
        return $error;
    }
}

/**
 * is_file_path
 *
 * @param  string $path path to the file without final /
 * @param  string $filename filename without extension
 * @param  array $extensions extension without dot
 * @return bool if one file is found with one of the extensions
 */
function is_file_path($path, $filename, $extensions) {
    $res = false;
    foreach ($extensions as $ext) {
        $res |= file_exists("$path/$filename.$ext");
    }
    return $res;
}

function which_file_extension($path, $filename, $extensions) {
    foreach ($extensions as $ext) {
        if (file_exists("$path/$filename.$ext"))
            return $ext;
    }
    return false;
}
