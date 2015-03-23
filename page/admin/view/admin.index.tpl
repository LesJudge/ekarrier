<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset={$PAGE_CHARSET}" />
<meta name="author" content="" />
<title>Referenciasite - ADMIN</title>
<base href="{$DOMAIN_ADMIN}"/>
<meta http-equiv="cache-control" content="private"/>
{include file='page/admin/view/admin.included.tpl'}
<script type="text/javascript">
    var DOMAIN_ADMIN="{$DOMAIN_ADMIN}";
    tinyMCESablon="";
</script>

{foreach from=$head key=for_id item=headitem}
	{$headitem}
	{/foreach}
		
</head>

<body>
<p style="display: none;">
      <input type="hidden" id="DOMAIN" value="{$DOMAIN}"/>
</p>
{$LoginForm}
    {if not isset($LoginForm)}
        {include file='page/admin/view/admin.confirm.tpl'}
<div id="wrap" class="container_24">
      <div class="grid_24">
        {if !$notiferror}
        <div id="notifications" style="color:red; font-weight: bolder; text-shadow: black 0px 0px; font-size: 20px;">
            {if $urMessages > 0}
              {$urMessages} elolvasatlan üzenet <br/>  
            {/if}
            {if $urComments > 0}
              {$urComments} elolvasatlan hozzászólás <br/>  
            {/if}
            {if $urLinks > 0}
              {$urLinks} ellenőrizetlen URL <br/>  
            {/if}
            {if $urOpinions > 0}
              {$urOpinions} megválaszolatlan szakértői vélemény <br/>  
            {/if}
            {if $urForumTopics > 0}
              {$urForumTopics} ellenőrizetlen fórum téma <br/>  
            {/if}
            {if $urForumComments > 0}
              {$urForumComments} ellenőrizetlen fórum hozzászólás <br/>  
            {/if}
            {if $urComps > 0}
              {$urComps} ellenőrizetlen kompetencia <br/>  
            {/if}
        {else}
        {$notiferror}
        {/if}
        </div>
            <div id="userpanel">
                  <ul id="user" class="dropdown">
                        {$LogoutForm}
                  </ul>
                  <ul id="user" class="dropdown right">
                        <li class="topnav">{$Nyelv_Valaszto}</li>
                  </ul>
            </div>
            <div id="header"> <a href="/admin/" id="logo">Admin Panel</a>
                    {$Menu_all}
            </div>
            <div id="breadcrumb">
                  <ul class="left">
                        {if Menu_one}
                        {$Menu_one}
                        {/if}
                  </ul>
                  <ul class="right">
                        <li><a href="{$DOMAIN} " class="icon home tip" title="A honlap fĹ‘oldala" target="_blank">FĹ‘oldal</a></li>
                  </ul>
            </div>
            {$ErrorMessage}
 {$Form}
 {$Chat}
<div class="grid_24">
	<div id="footer">
		<p class="left">
			Powered by <a href="http://www.uniweb.hu">UniWeb Plusz Kft.</a>
		</p>
	</div>
</div>
      </div>
</div>

{/if}
</body>
</html>