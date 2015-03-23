{if $linkMode}
<style>
#linksCont{
position: fixed;
right: 20px;
top: 340px;
width: 150px;
height: auto;
z-index: 99999;
}

</style>
<div id="linksCont">

    <h3>Linkjeim</h3>

    {if not empty($links)}
        {foreach from=$links item=link}    
            <form name="{$FormName}" method="post" action="">
            <input type="hidden" id="delLink" name="delLink" value="{$link.link}"/>
            <a href="{$link.link}" target="_blank">{$link.nev}</a>
            <!--button class="" name="{$BtnDeleteLink}" id="{$BtnDeleteLink}" type="submit"><b>x</b></button-->
            </form>
            <br/>
        {/foreach}

    {else}
        Nincs még link hozzáadva!
    {/if}

    {if $addLinkOption}
        <div onClick="$('#linkFormCont').toggle();">Adja hozzá az oldalt</div>
        <div id="linkFormCont" style="display:none">
            <form name="{$FormName}" method="post" action="">
                <label for="linkName">Név <span class="require">*</span></label>
                <input type="text" id="linkName" name="linkName" maxlength="50"/>
                <label for="linkUrl">URL <span class="require">*</span></label>
                <input type="text" id="linkUrl" name="linkUrl" maxlength="200"/>
                <div class="clear"></div>
                <button class="submit btn" name="{$BtnAddLink}" id="{$BtnAddLink}" type="submit">Hozzáadás</button>
            </form>
        </div>
    {/if}

</div>
    {/if}