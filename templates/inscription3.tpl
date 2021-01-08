{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/candidature.css">
<link rel="stylesheet" href="{$BASE_PATH}/include/css/sinscrire3.css">
{/block}
{block name="title"}Inscription 3/3{/block}
{block name="body"}
<section class="formulaire">
    <form enctype="multipart/form-data" method="post" action="traitement.php">
        <fieldset>
            <!--INFO PARTICIPATION-->
                <legend>Informations :</legend>
                <label for="stat">Statut associatif :</label>
                <input type="radio" name="info[stat]" {if (isset($form.info.stat) && $form.info.stat=="true")}checked{/if} value="true" /> Oui / Non
                <input type="radio" name="info[stat]" {if ((isset($form.info.stat) && $form.info.stat=="false") || !isset($form.info.stat))}checked{/if} value="false" />
                {if (isset($error.info.stat))}<div class="error">{$error.info.stat}</div>{/if}
                <br>
                <label for="stat">Inscrit à la SACEM :</label>
                <input type="radio" name="info[sacem]" {if (isset($form.info.sacem) && $form.info.sacem=="true")}checked{/if} value="true" /> Oui / Non
                <input type="radio" name="info[sacem]" {if ((isset($form.info.sacem) && $form.info.sacem=="false") || !isset($form.info.sacem))}checked{/if} value="false" />
                {if (isset($error.info.sacem))}<div class="error">{$error.info.sacem}</div>{/if}
                <br>
                <label for="stat">Producteur :</label>
                <input type="radio" name="info[prod]" {if (isset($form.info.prod) && $form.info.prod=="true")}checked{/if} value="true" /> Oui / Non
                <input type="radio" name="info[prod]" {if ((isset($form.info.prod) && $form.info.prod=="false") || !isset($form.info.prod))}checked{/if} value="false" />
                {if (isset($error.info.prod))}<div class="error">{$error.info.prod}</div>{/if}
                <br>

                <!--EXTRAIT MUSICAUX-->
                <label for="mp3">Extrait MP3 :</label><br>
                {for $i=1 to 3}
                <input class="fich" type="file" accept="audio/MP3" name="file_mp3_{$i}"><br>
                {if (isset($error.file.mp3.$i))}<div class="error">{$error.file.mp3.$i}</div>{/if}
                {/for}
                <label for="image">Images du groupe (au format PNG ou JPG) :</label><br>
                {for $i=1 to 2}
                <input class="fich" type="file" accept="image/png,image/jpeg" name="file_img_{$i}"><br>
                {if (isset($error.file.img.$i))}<div class="error">{$error.file.img.$i}</div>{/if}
                {/for}
                <span>Les images doivent faire au minimum 300 DPI</span>
                <label for="image">Fiche technique du groupe (pdf) :</label><br>
                <input class="fich" type="file" accept="application/pdf" name="file_pdf_tech"><br>
                {if (isset($error.file.pdf.tech))}<div class="error">{$error.file.pdf.tech}</div>{/if}
                <label for="image">Fiche SACEM ou descriptif du groupe (pdf) :</label><br>
                <input class="fich" type="file" accept="application/pdf" name="file_pdf_sacem"><br>
                {if (isset($error.file.pdf.sacem))}<div class="error">{$error.file.pdf.sacem}</div>{/if}
                <!--Enregistrement info et page suivante OU page précédente-->
                <div class="button_contener">
                <button type="submit" class="button" id="back" formaction="{$BASE_PATH}/candidature/2"><- Membres</button>
                <button class="button2" type="submit" id="next" formaction="{$BASE_PATH}/candidature">-> Fin</button>
                </div>
        </fieldset>
    </form>
</section>
{/block}