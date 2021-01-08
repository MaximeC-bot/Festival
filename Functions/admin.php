<?php

$admin_index = function() {
    $data = array();
    $db = Flight::get('db');
    $req = $db->query("SELECT `username`, `mail` FROM `prj_utilisateurs` ORDER BY ID DESC LIMIT 10 ");
    if ($req->rowCount() > 0) {
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $index => $user) {
            $data['liste_user'][$index] = $user;
        }
    } else {
        $data["liste_user"] = null;
    }
    $req = $db->query("SELECT cdts.ID, cdts.nom, dep.nom, pscene.nom, cdts.style, cdts.annee_crea, cdts.presentation, cdts.experience,cdts.ID_user
                     FROM prj_candidatures as cdts, prj_departements as dep, prj_scenes as pscene
                     WHERE dep.ID = cdts.dept and pscene.ID = cdts.scene
                     ORDER BY ID DESC LIMIT 10");
    if ($req->rowCount() > 0) {
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $index => $candidature) {
            $data['liste_candidature'][$index] = $candidature;
        }
    } else {
        $data["liste_candidature"] = null;
    }

    Flight::render("templates/indexAdmin.tpl",$data);
};

$show_candidature = function ($id) {
    $data = array();
    $db = Flight::get('db');
    $req = $db->prepare("SELECT cdts.nom, dep.nom, pscene.nom, 
    cdts.style, cdts.annee_crea, cdts.presentation, cdts.experience, cdts.url_web, cdts.youtube, cdts.fb, cdts.twitter, cdts.soundcloud , user.username, cdts.ID
    FROM prj_candidatures as cdts, 
    prj_departements as dep, prj_scenes as pscene, prj_utilisateurs as user WHERE  cdts.ID_user = user.ID 
    and dep.ID = cdts.dept and pscene.ID = cdts.scene and cdts.ID_user = ?");
    $req->execute(array($id));
    if ($req->rowCount() > 0) {
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $candidature) {
            $data = $candidature;
        }
    } else {
        $data = null;
    }
    $req = $db->prepare("SELECT * FROM prj_membres WHERE ID_group = ? ORDER BY ID");
    $req->execute(array($data[13]));
    $membres = $req->fetchAll(PDO::FETCH_ASSOC);
    $img = array();
    $img[1] = which_file_extension("content/" . $data[12], "1", array("png", "jpg", "jpeg"));
    $img[2] = which_file_extension("content/" . $data[12], "2", array("png", "jpg", "jpeg"));
    Flight::render("templates/candidat.tpl", array('information' => $data, "admin" => $_SESSION['admin'], "img" => $img, "membres" => $membres));
};
