<div id="menu">
  <ul>
    <li class="first"><a href="{$web_root}">home</a></li>
    {if isset($smarty.session.account) && ($smarty.session.account.logged_in)}
    <li><a href="{$web_root}process/logout.php">logout</a></li>
    {else}
    <li><a href="{$web_root}login">login</a></li>
    {/if}
    <li><a href="{$web_root}profile">profile</a></li>
    <li><a href="{$web_root}members">search</a></li>
    <li><a href="{$web_root}about">about us</a></li>
    <li><a href="{$web_root}admin">admin panel</a></li>
  </ul>
</div>
