<html>
    <head>
        <title>Álláshirdetés - {$pj.megnevezes}</title>
        <style type="text/css">
        @page {
            background: url('{$DOMAIN}modul/allashirdetes/resource/ekarrier_allashirdetes_bg.png');
            background-image-resize:6;
            background-repeat: no-repeat;
            margin-bottom: 20px;
            margin-top: 20px;
            margin-left: 0px;
            margin-right: 0px;
            padding: 0px;
            font-family: serif;
        }
        #allashirdetes-table td {
            text-align: left;
        }
        #allashirdetes-table,
        #allashirdetes-cols {
            margin: 0 auto;
            width: 90%;
        }
        #allashirdetes-cols .allashirdetes-col {
            float: left;
            width: 50%;
        }
        p.allashirdetes-label {
            font-weight: bold;
        }
        </style>
    </head>
    <body style="margin: 0px; padding: 0px;">
        <table id="allashirdetes-table" style="margin-bottom: 40px;">
            <tr>
                <td colspan="2" style="height: 100px;"></td>
            </tr>
            <tr>
                <td style="width: 10%;">
                    <strong>Munkakör:</strong>
                </td>
                <td style="font-size: 20px; width: 30%;">
                    <strong>{$pj.megnevezes}</strong>
                </td>
            </tr>
            <tr>
                <td style="width: 10%;">
                    <strong>Hirdető:</strong>
                </td>
                <td style="width: 30%;">
                    {if $pj.egyedi eq 1}
                    {$pj.hirdeto}
                    {else}
                    {$pj.ceg_nev}
                    {/if}
                </td>
            </tr>
            <tr>
                <td style="width: 10%;" valign="top">
                    <strong>Leírás:</strong>
                </td>
                <td style="width: 30%;">
                    <!--<div style="width: 100px !important;">{$pj.ismerteto}</div>-->
                    {$pj.ismerteto}
                </td>
            </tr>
        </table>
        <div id="allashirdetes-cols">
            <div class="allashirdetes-col">
                {if not empty($elvarasok)}
                <p class="allashirdetes-label">Elvárások:</p>
                <ul class="allashirdetes-ul fixed">
                    {foreach from=$elvarasok item=elvaras}
                    <li>{$elvaras.elvaras}</li>
                    {/foreach}
                </ul>
                {/if}
                {if not empty($feladatok)}
                <p class="allashirdetes-label">Feladatok:</p>
                <ul class="allashirdetes-ul">
                    {foreach from=$feladatok item=feladat}
                    <li>{$feladat.feladat}</li>
                    {/foreach}
                </ul>
                {/if}
                {if not empty($amitKinalunk)}
                <p class="allashirdetes-label">Amit kínálunk:</p>
                <ul class="allashirdetes-ul">
                    {foreach from=$amitKinalunk item=ak}
                    <li>{$ak.amit_kinalunk}</li>
                    {/foreach}
                </ul>
                {/if}
                <p class="allashirdetes-label">Munkavégzés jellege</p>
                <p class="allashirdetes-content">{$pj.munkavegzes_jellege}</p>
            </div>
            <div class="allashirdetes-col">
                <p class="allashirdetes-label">Munkavégzés helye:</p>
                <p class="allashirdetes-content">{$pj.cim_varos_nev}{if $pj.cim_megye_nev}, {$pj.cim_megye_nev}{/if}</p>
                <p class="allashirdetes-label">Jelentkezés módja:</p>
                <p class="allashirdetes-content">{strip_tags($pj.jelentkezes_modja)}</p>
            </div>
            <div class="clear"></div>
        </div>
        <div>{$pj.elvarasok}</div>
        <div>{$pj.tevekenyseg}</div>
        {if $pj.mas_hirdetese}
        <!--<div style="margin: 0 auto; width: 90%; position: absolute; bottom: 120px; left: 34px;">-->
        <div style="margin: 0 auto; width: 90%;">
            Az álláshirdetés nem a saját adatbázisunkból származik, így tartalmáért nem tudunk felelősséget vállalni.
            <br />
            A hirdetés forrása: {$pj.mas_hirdetese_link}
        </div>
        {/if}
    </body>
</html>
