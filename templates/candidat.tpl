{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/candidat.css">
{/block}
{block name="title"}Candidature n°{$information[13]}{/block}
{block name="body"}
{include file="menu.tpl" admin=$admin}
<section class="detail">
  <div class="info">
    <h1>Nom du Groupe : {$information[0]}</h1>
      <span class="titre">Audio 1 : <span class="donnee"></span><audio controls><source src="{$BASE_PATH}/content/{$information[12]}/1.mp3" type="audio/mpeg"></audio></span><br>
      <span class="titre">Audio 2 : <span class="donnee"></span><audio controls><source src="{$BASE_PATH}/content/{$information[12]}/2.mp3" type="audio/mpeg"></audio></span><br>
      <span class="titre">Audio 3 : <span class="donnee"></span><audio controls><source src="{$BASE_PATH}/content/{$information[12]}/3.mp3" type="audio/mpeg"></audio></span><br>
      <br>
      <span class="titre">Département : <span class="donnee">{$information[1]}</span></span><br>
      <span class="titre">Scène : <span class="donnee">{$information[2]}</span></span><br>
      <span class="titre">Style : <span class="donnee">{$information[3]}</span></span><br>
      <span class="titre">Année de Création : <span class="donnee">{$information[4]}</span></span><br>
      <br>
      <span class="titre">Présentation : <br><br><span class="donnee">{$information[5]}</span></span><br><br>
      <span class="titre">Expérience : <span class="donnee">{$information[6]}</span></span><br>
      <br>
      <span class="titre">Web : <span class="donnee">{$information[7]}</span></span><br>
      <span class="titre">Facebook : <span class="donnee">{$information[9]}</span></span><br>
      <span class="titre">Twitter : <span class="donnee">{$information[10]}</span></span><br>
      <span class="titre">Sndc : <span class="donnee">{$information[11]}</span></span><br>
      <span class="titre">Youtube : <span class="donnee">{$information[8]}</span></span><br>
      <span class="titre">Dossier de Presse : <span class="donnee"><a target="_blank" href="{$BASE_PATH}/content/{$information[12]}/presse.pdf">Ouvrir le Dossier de Presse</a></span></span><br>
      <span class="titre">SACEM/SetList : <span class="donnee"></span><a target="_blank" href="{$BASE_PATH}/content/{$information[12]}/sacem.pdf">Ouvrir le fichier SACEM/SetList</a></span><br>
      <span class="titre">Fiche Technique : <span class="donnee"></span><a target="_blank" href="{$BASE_PATH}/content/{$information[12]}/tech.pdf">Ouvrir la Fiche Technique</a></span><br>
      <br>
      <span class="titre">Membres : </span><br>
      <span class="donnee">{foreach from=$membres item=membre}
        {$membre.nom} {$membre.prenom} : {$membre.instrument}<br>
      {/foreach}</span>
  </div>
  <div class="photo">
  <img class="photoUn" src="{$BASE_PATH}/content/{$information[12]}/1.{$img.1}" alt="Image 1">
  <img class="photoDe" src="{$BASE_PATH}/content/{$information[12]}/2.{$img.2}" alt="Image 2">
  </div>
</section>
{/block}