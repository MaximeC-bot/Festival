{block name="head"}
<link rel="stylesheet" href="{$BASE_PATH}/include/css/liste.css">
{/block}
{block name="title"}Liste des utilisateurs{/block}
{block name="body"}
{include file="menu.tpl" admin=true}
<table>
    <th>Pseudo</th>
    <th>Adresse mail</th>
    
    {foreach $liste as $index => $user}
        <tr>
            <td>{$user[0]}</td>
            <td>{$user[1]}</td>                
        </tr>
    {/foreach}
</table>
{/block}