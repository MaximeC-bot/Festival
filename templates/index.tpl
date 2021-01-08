{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/index.css">
{/block}
{block name="title"}Accueil{/block}
{block name="body"}
<header>
    <div class="title"><img src="{$BASE_PATH}/include/img/xoxo.png"></div>
</header>  
<main>
    <div class="info">
        <div class="info_who">QUI SOMMES NOUS ?</div>
        <div class="description">
            Un festival de musique associatif lance chaque année un appel à candidatures pour permettre à
            des groupes de jouer sur scène au début de l’été, sur une période de trois jours et devant un
            public de plusieurs millers de personnes. L'association s'engage à mettre tout en œuvre pour
            garantir à l'ensemble des groupes des conditions d'accueil technique professionnelles (prestations
            techniques, catering, prise en charge par les équipes de bénévoles). Le festival représente pour
            certains un tremplin vers des scènes d’envergure nationale.
        </div>
    </div>
    <div class="registred">Groupes déjà inscrits</div>
    <div class="affiche">
        <img class="im" src="{$BASE_PATH}/include/img/sexion.png"/>
        <img class="im" src="{$BASE_PATH}/include/img/blackpink.png"/>
        <img class="im" src="{$BASE_PATH}/include/img/indochine.png"/>
        <img class="im" src="{$BASE_PATH}/include/img/eagles.png"/>
    </div>
    <div class="registred">Inscrivez-vous !</div>
    <section class="bottom">
        <section class="zone_inscription">
            <section class="connexion">
                <div class="title_connect">Se connnecter</div>
                <form method="post" action="{$BASE_PATH}/login">
                    <div>
                        <label for="pseudo">Identifiant :</label>
                        <input type="text" name="pseudo" id="pseudo"/>
                        <br />
                        <label for="pass">Mot de passe :</label>
                        <input type="password" name="pass" id="pass" />
                        <br />
                        <input class="button" type="submit" name="connect" id="connect" value="Connexion"/>
                    </div>
                </form>
            </section>
            <section class="inscription">
                <div class="title_connect">S'inscrire</div>
                <form method="post" action="{$BASE_PATH}/register">
                    <div>
                        <label for="pseudo">Identifiant :</label><br>
                        <input type="text" name="pseudo" id="pseudo"/>
                        <br>
                        <label for="mail">Email :</label><br>
                        <input type="text" name="mail" id="mail"/>
                        <br>
                        <label for="pass">Mot de passe :</label><br>
                        <input type="password" name="pass" id="pass" />
                        <br>
                        <label for="verifpass">Confirmer mot de passe :</label><br>
                        <input type="password" name="verifpass" id="verifpass"/>
                        <br>
                        <input class="button" type="submit" name="connect" id="connect" value="Valider"/>
                    </div>
                </form>
            </section>
        </section>
    </section>
</main>
{/block}