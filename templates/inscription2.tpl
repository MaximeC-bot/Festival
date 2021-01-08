{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/candidature.css">
<link rel="stylesheet" href="{$BASE_PATH}/include/css/sinscrire2.css">
<script>function cM(){
    for(var i=1,x=document.getElementById("nbMembre").value;i<=8;i++)document.getElementById("block_membre"+i).style.display=(i>x?"none":"block");}</script>
{/block}
{block name="title"}Inscription 2/3{/block}
{block name="body"}
<section class="formulaire">
    <form enctype="multipart/form-data" method="post">
        <fieldset>
            <!--INFO MEMBRE-->
                <legend> Candidat - A propos des Membres : </legend>
                <label class="nbMb" for="nbMembre">Nombre de Membres (entre 1 et 8) : </label>
                <input class="nbMb2" type="number" min=1 max=8 value={$form.nbMembres|default:1} onchange="cM()" id="nbMembre" name="nbMembres"/>
                {if (isset($error.nbMembres))}<div class="error">{$error.nbMembres}</div>{/if}
                <br>
                {for $i=1 to 8}
                <span id="block_membre{$i}" {if ($i > {$form.nbMembres|default:1})}style="display:none"{/if}>
                    <label class="membre" for="membre{$i}_nom">Membre {$i} :</label>
                    <input class="membre" type="text" name="membres[{$i}][nom]" id="membre{$i}_nom" placeholder="Nom" value="{$form.membres.$i.nom|escape|default:""}"/>
                    <input class="membre" type="text" name="membres[{$i}][prenom]" id="membre{$i}_prenom" placeholder="Prénom" value="{$form.membres.$i.prenom|escape|default:""}"/>
                    <input class="membre" type="text" name="membres[{$i}][instru]" id="membre{$i}_instru" placeholder="Instrument" value="{$form.membres.$i.instru|escape|default:""}"/>
                    {if (isset($error.membre.$i))}<div class="error">{$error.membre.$i}</div>{/if}
                    <br>
                </span>
                {/for}

                <!--FACULTATIF : RESEAUX SOCIAUX-->
                <div class="title">LIENS DIVERS :</div>
                {if (isset($error.media.website))}<div class="error">{$error.media.website}</div>{/if}
                <label for="siteWeb">Site Web : </label>
                <input type="text" name="media[website]" id="siteWeb" value="{$form.media.website|escape|default:""}"/>
                <br>
                <label for="fb">Page Facebook : </label>
                <input type="text" name="media[fb]" id="fb" value="{$form.media.fb|escape|default:""}"/>
                <br>
                <label for="tw">Twitter : </label>
                <input type="text" name="media[tw]" id="tw" value="{$form.media.tw|escape|default:""}"/>
                <br>
                <label for="soundCloud">Sound Cloud(facultatif) : </label>
                <input type="text" name="media[soundcloud]" id="soundCloud" value="{$form.media.soundCloud|escape|default:""}"/>
                <br>
                <label for="yt">Youtube(facultatif) : </label>
                <input type="text" name="media[yt]" id="yt" value="{$form.media.yt|escape|default:""}"/>
            <div class="press">
                <label for="presse">Dossier de presse (facultatif) :</label>
                <input type="file" accept="application/pdf" class="press2" name="media_presse" id="presse">{$form.media.presse|escape|default:""}</textarea>
                {if (isset($error.media.presse))}<div class="error">{$error.media.presse}</div>{/if}
            </div>
            <!--Enregistrement info et page suivante OU page précédente-->
            <div class="button_contener">
                <button type="submit" class="button" id="back" formaction="{$BASE_PATH}/candidature/1"><- Groupe</button>
                <button class="button2" type="submit" id="next" formaction="{$BASE_PATH}/candidature/3">-> Informations</button>
            </div>
        </fieldset>
    </form>
</section>
{/block}