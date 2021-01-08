{if ($admin)}
<!-- Si admin -->
<div class="menu">
    <a style="text-decoration:none" href="{$BASE_PATH}/logout"><div class="deconnect">Déconnexion</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/"><div class="users">Acceuil</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/profil"><div class="users">Profil</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/candidatures"><div class="users">Candidatures</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/users"><div class="users">Utilisateurs</div></a>
</div>
{else}
<!-- Si user -->
<div class="menu">
    <a style="text-decoration:none" href="{$BASE_PATH}/logout"><div class="deconnect">Déconnexion</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/"><div class="users">Acceuil</div></a>
    <a style="text-decoration:none" href="{$BASE_PATH}/candidature"><div class="users">Candidature</div></a>
</div>
{/if}