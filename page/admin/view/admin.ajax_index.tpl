<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset={$PAGE_CHARSET}" />
	<meta name="author" content="RimoFamily" />
    <base href="{$ROOT_PATH}"/>
    {include file='page/admin/view/admin.included.tpl'}
	
	{foreach from=$head key=for_id item=headitem}
	{$headitem}
	{/foreach}
</head>
<body>
    <p style="display: none;"><input type="hidden" id="DOMAIN" value="{$DOMAIN}"/></p>
    {$LoginForm}
    {if not isset($LoginForm)}
        {include file='page/admin/view/admin.confirm.tpl'}
        <div class="ui-widget-overlay" style="display: none;"></div>
        <div class="outer-center">
            <div class="content middle-center">
                {$Form}
            </div>    
        </div>
        <div class="outer-north">
            <div class="header">
            {$ErrorMessage}
            </div>
        </div> 
    {/if}
</body>
</html>