{extends file="base.tpl"}
{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/candidature.css">
<link rel="stylesheet" href="{$BASE_PATH}/include/css/sinscrire.css">
{/block}
{block name="title"}Inscription 1/3{/block}
{block name="body"}
<section class="formulaire">
    <form method="post" action="{$BASE_PATH}/candidature/2">
        <fieldset>
            <!--INFO GROUPE-->
            <legend> Candidat - A propos du Groupe : </legend>
                <label for="groupe">Nom du groupe :</label>
                <input type="text" name="group[name]" id="groupe" value="{$form.group.name|escape|default:""}"/>
                {if (isset($error.group.name))}<div class="error">{$error.group.name}</div>{/if}
                <br>
                <label for="dept">Département d'origine :</label>
                <select name="group[dept]" id="dept">
                    {foreach from=$depts item=departement}
                        <option value={$departement.ID} {if ({$form.group.dept|default:0} == $departement.ID)}selected{/if}>{$departement.nom} ({$departement.ID})</option>
                    {/foreach}
                </select>
                <br>
                <label for="scene">Type de scène : </label>
                <select name="group[scene]" id="scene">
                    {foreach from=$scenes item=scene}
                        <option value={$scene.ID} {if ({$form.group.scene|default:0} == $scene.ID)}selected{/if}>{$scene.nom}</option>
                    {/foreach}
                </select>
                <br>
                <label for="style_music">Style musical : </label>
                <input type="text" name="group[style_music]" id="style_music" value="{$form.group.style_music|escape|default:""}"/>
                {if (isset($error.group.style_music))}<div class="error">{$error.group.style_music}</div>{/if}
                <br>
                <label for="year_create">Année de création :</label>
                <input type="number" name="group[year_create]" id="year_create" value="{$form.group.year_create|escape|default:""}" min="1900" max="2021" />
                {if (isset($error.group.year_create))}<div class="error">{$error.group.year_create}</div>{/if}
            </div>
            
            <!--INFO LEADER GROUPE-->
            <!--
            <div class="part2">
                <div class="title">Représentant du groupe</div>
                <label for="nom_chefGroup">Nom :</label>
                <input type="text" name="group[chef][nom]" id="nom_chefGroup" value="{$form.group.chef.nom|escape|default:""}"/>
                <br>
                <label for="prenom_chefGroup">Prénom :</label>
                <input type="text" name="group[chef][prenom]" id="prenom_chefGroup" value="{$form.group.chef.prenom|escape|default:""}">
                <br>
                <label for="ad_chefGroup">Adresse :</label>
                <input type="text" name="group[chef][adresse]" id="ad_chefGroup" value="{$form.group.chef.adresse|escape|default:""}"/>
                <br>
                <label for="postal_chefGroup">Code postal :</label>
                <input type="number" name="group[chef][code_postal]" id="postal_chefGroup" value="{$form.group.chef.code_postal|escape|default:""}"/>
                <br>
                <label for="email_chefGroup">Email :</label>
                <input type="text" name="group[chef][email]" id="email_chefGroup" value="{$form.group.chef.email|escape|default:""}"/>
                <br>
                <label for="tel_chefGroup">Téléphone :</label>
                <input type="tel" name="group[chef][tel]" id="tel_chefGroup" value="{$form.group.chef.tel|escape|default:""}"/>
                <br>
            </div>-->
            
            <!--PRESENTATION GROUPE-->
            <div class="part3">
                <label for="presentation">Présentation du groupe :</label>
                <textarea name="group[presentation]" id="presentation">{$form.group.presentation|escape|default:""}</textarea>
                {if (isset($error.group.presentation))}<div class="error">{$error.group.presentation}</div>{/if}
                <br>
                <label for="expe">Expérience scénique :</label>
                <textarea name="group[expe]" id="expe">{$form.group.expe|escape|default:""}</textarea>
                {if (isset($error.group.expe))}<div class="error">{$error.group.expe}</div>{/if}
            </div>
            <!--Enregistrement info et page suivante-->
            <button class="button2" id="next">-> Membres</button>
        </fieldset>
    </form>
</section>
{/block}