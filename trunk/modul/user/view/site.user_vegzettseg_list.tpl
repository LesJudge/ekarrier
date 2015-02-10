<form action="" method="POST" name="{$FormName}" id="{$FormName}" class="form form_list" enctype="multipart/form-data">
    {include file='page/all/view/page.message.tpl'}
    <div class="jobFindList-cont">
        <div class="jobFindList-top">
            <i class="icomoon icomoon-library">&nbsp;</i>
        </div>
        <div class="jobFindList-title">
            <a href="{$DOMAIN}profil/vegzettsegeim/szerkesztes/" class="bigBtn-link" style="font-size: 1em;">Új végzettség</a>
        </div>
        <br />
        {if $Lista}
        <table class="DTable">
            <thead>
                <tr class="DTable-head">
                    <th class="textAlign-center">Iskola</th>
                    <th class="textAlign-center">Típus</th>
                    <th class="textAlign-center">Kezdés éve</th>
                    <th class="textAlign-center">Végzés éve</th>
                    <th class="textAlign-center">Szak</th>
                    <th class="textAlign-center">Szerkesztés</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$Lista key=for_id item=education}
                <tr class="DTable-tr">
                    <td class="textHighlighting-1">{$education.iskola}</td>
                    <td class="textAlign-center">{$education.vegzettseg_nev}</td>
                    <td class="textAlign-center">{$education.kezdet}</td>
                    <td class="textAlign-center">{$education.veg}</td>
                    <td class="textAlign-center">{$education.szak}</td>
                    <td class="textAlign-center">
                        <a href="{$DOMAIN}profil/vegzettsegeim/szerkesztes/{$education.pk}" class="iconCont" title="Szerkesztés">
                            <i class="icomoon icomoon-pencil">&nbsp;</i>
                        </a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {/if}
        <div class="clear"></div>
    </div>
    {include file='page/all/view/page.paging.tpl'} 
</form>