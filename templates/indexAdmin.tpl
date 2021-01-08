{extends file="base.tpl"}
{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/indexAdmin.css">
{/block}
{block name="title"}Accueil{/block}
{block name="body"}
<header>
    {include file="menu.tpl" admin=true}
    <div class="title"><img src="{$BASE_PATH}/include/img/xoxo.png"></div>
</header>
<main>
    <div class="registred">CANDIDATS DEJA INSCRIT (les 10 derniers)</div>
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Departement</th>
                <th>Scène</th>
                <th>Style</th>
                <th>Année</th>
                <th>Présentation</th>
                <th>Expérience</th>
                <th>Details</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            {foreach $liste_candidature as $index => $candiature}
            <tr>
                <td>{$candiature[0]}</td>
                <td>{$candiature[1]}</td>
                <td>{$candiature[2]}</td>
                <td>{$candiature[3]}</td> 
                <td>{$candiature[4]}</td>
                <td>{$candiature[5]}</td> 
                <td>{$candiature[6]}</td>
                <td>{$candiature[7]}</td>                 
                <td><a href="{$BASE_PATH}/candidature/{$candiature[8]}">Details</a></td>
                <td> 
                    <form method="post" action="{$BASE_PATH}/candidatures/">
                        <input type="submit" name="supprimer" value="{$candiature[0]}">
                    </form> 
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</main>
{/block}