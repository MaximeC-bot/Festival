<?php

$list_users = function() {
    $data = array();
    $db = Flight::get('db');
    $req = $db->query("SELECT `username`, `mail` FROM `prj_utilisateurs`");
    if ($req->rowCount() > 0) {
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $index => $user) {
            $data['liste'][$index] = $user;
        }
    } else {
        $data["liste"] = null;
    }
    Flight::render("templates/listeUsers.tpl", $data);
};

$list_candidature = function() {
    $data = array();
    $tab_user = array();
    $db = Flight::get('db');
    if(isset($_POST['supprimer'])) {
        $id = $_POST['supprimer'];
        $db = Flight::get('db');
        
        $req = $db->prepare("DELETE FROM `prj_membres` WHERE `ID_group`=?");
        $req->execute(array($id));
        $req = $db->prepare("SELECT user.username 
                            FROM prj_utilisateurs as user, prj_candidatures as cdts 
                            WHERE cdts.ID = ? and cdts.ID_user=user.ID");
        $req->execute(array($id));
        
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $user) {
            $tab_user = $user;
        }
        $rep=opendir("content/".$tab_user[0]);
         while($file = readdir($rep)){
           if(!is_dir($file)){
                unlink('content/'.$tab_user[0].'/'.$file);
            }
        }
        rmdir('content/'.$tab_user[0]);

        $req = $db->prepare("DELETE FROM `prj_candidatures` WHERE `ID`=?");
        $req->execute(array($id));

    }
    $req = $db->query("SELECT cdts.ID, cdts.nom, dep.nom, pscene.nom, cdts.style, cdts.annee_crea, cdts.presentation, cdts.experience,cdts.ID_user
                     FROM prj_candidatures as cdts, prj_departements as dep, prj_scenes as pscene
                     WHERE dep.ID = cdts.dept and pscene.ID = cdts.scene");
    if ($req->rowCount() > 0) {
        foreach ($req->fetchAll(PDO::FETCH_NUM) as $index => $candidature) {
            $data['liste'][$index] = $candidature;
        }
    } else {
        $data["liste"] = null;
    }
    Flight::render("templates/listeGroupes.tpl", $data);
};