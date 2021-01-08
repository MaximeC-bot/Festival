{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/profil.css">
{/block}
{block name="title"}Profil{/block}
{block name="body"}
{include file="menu.tpl" admin=$admin}
<section class="infoUtilisateur">
<img src="{$BASE_PATH}/include/img/profil.png"/>
<div class="info">
    <div class="name">{$user['prenom']} {$user['nom']}</div>
    <div>{$user['username']}</div>
    <br>
    <div>{$user['mail']}</div>
    <div>{$user['num_tel']}</div>
    <br>
    <div>{$user['rue']}, {$user['code_postal']} {$user['ville']}</div>
</div>
</section>
<section class="changeInfo">
   <form method="post" action="{$BASE_PATH}/profil">
           <!--MODIF MOT DE PASSE-->
           <div class="titreChange">Changer de mot de passe:</div>
           <br>
               <label for="mdpActu">Mot de passe actuel:</label>
               <br>
               <input type="password" name="mdpActu" id="mdpActu"/>
               <br>
               <label for="newMDP">Nouveau mot de passe</label>
               <br>
               <input type="password" name="newMDP" id="newMDP"/>
               <br>
               <label for="confirmNewMDP">Confirmation du nouveau mot de passe</label>
               <br>
               <input type="password" name="confirmNewMDP" id="confirmNewMDP"/>
               <br>
               <br>
               <input type="submit" name="changeMDP" />
   </form>
   <form class="form2Orga" method="post" action="{$BASE_PATH}/profil">
           <!--MODIF INFO-->
           <div class="titreChange"> Informations personnelles </div>
           <br>
           <section class="tab">
               <label for="newNom">Nom</label>
               <br>
               <input type="text" name="newNom" id="newNom" value="{$user['nom']}" />
               <br>
               <label for="newPrnom">Prénom</label>
               <br>
               <input type="text" name="newPrnom" id="newPrnom"value="{$user['prenom']}" />
               <br>
               <label for="newMail">Email</label>
               <br>
               <input type="text" name="newMail" id="newMail" value="{$user['mail']}" />
               <br>
           </section>
           <section class="tab2">
               <label for="newAdresse">Adresse</label>
               <br>
               <input type="text" name="newAdresse" id="newAdresse" value="{$user['rue']}" />
               <br>
               <label for="newVille">Ville</label>
               <br>
               <input type="text" name="newVille" id="newVille" value="{$user['ville']}" />
               <br>
               <label for="newCPost">Code postale</label>
               <br>
               <input type="text" name="newCPost" id="newCPost" value="{$user['code_postal']}"  />
               <br>
               <label for="newPhone">Telephone</label>
               <br>
               <input type="text" name="newPhone" id="newPhone" value="{$user['num_tel']}" />
               <br>
               <br>
           </section>
           <input class="butChangeAd" type="submit" name="change_information"/>
   </form>
</section>
</body>
{/block}