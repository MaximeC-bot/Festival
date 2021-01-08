{block name="title"}Inscription/Connexion{/block}
{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/index.css">
{/block}
{block name="body"}
<main>
    <section class="zone_inscription">
        <section class="connexion">
            <div class="title_connect">Connexion</div>
            <form method="post" action="login">
                <div>
                    <label for="pseudo">Identifiant :</label>
                    <input type="text" name="pseudo" id="pseudo" {if (isset($post['pseudo']) && $action != "register")}value="{$post['pseudo']}" {/if}/>
                    {if (isset($error['pseudo']) && $action != "register")}<span class="pure-form-message">{$error['pseudo']}</span>{/if}
                    <br />
                    <label for="pass">Mot de passe :</label>
                    <input type="password" name="pass" id="pass" />
                    <br />
                    <input class="button" type="submit" name="connect" id="connect" value="Connexion"/></a>
                    {if (isset($error['error']) && $action != "register")}<span class="pure-form-message">{$error['error']}</span>{/if}
                </div>
            </form>
        </section>
        <section class="inscription">
            <div class="title_connect">Inscription</div>
            <form method="post" action="register">
                <div>
                    <label for="pseudo">Identifiant :</label><br>
                    <input type="text" name="pseudo" id="pseudo" {if (isset($post['pseudo']) && $action != "login")}value="{$post['pseudo']}" {/if}/>
                    {if (isset($error['pseudo']) && $action != "login")}<span class="pure-form-message">{$error['pseudo']}</span>{/if}
                    <br>
                    <label for="mail">Email :</label><br>
                    <input type="text" name="mail" id="mail" {if (isset($post['mail']) && $action != "login")}value="{$post['mail']}" {/if}/>
                    {if (isset($error['mail']) && $action != "login")}<span class="pure-form-message">{$error['mail']}</span>{/if}
                    <br>
                    <label for="pass">Mot de passe :</label><br>
                    <input type="password" name="pass" id="pass" />
                    {if (isset($error['pass']) && $action != "login")}<span class="pure-form-message">{$error['pass']}</span>{/if}
                    <br>
                    <label for="verifpass">Vérification mot de passe :</label><br>
                    <input type="password" name="verifpass" id="verifpass" />
                    {if (isset($error['verifpass']) && $action != "login")}<span class="pure-form-message">{$error['verifpass']}</span>{/if}
                    <br>
                    <input class="button" type="submit" name="connect" id="connect" value="Valider"/></a>
                </div>
            </form>
        </section>
    </section>
</main>
{/block}
