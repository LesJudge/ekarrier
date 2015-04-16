<div class="grid_24">
    <div class="box_top"><h2 class="icon time">Ügyfélkezelő - Hiba</h2></div>
    <div class="box_content padding">
        <div class="notice error"><p>Végzetes hiba!</p></div>
        <div id="error-description">
            <p>Nem lehet megjeleníteni a lapot, mert végzetes hiba történt!</p>
            <br />
            <p>A hiba lehetséges okai:</p>
            <ul>
                <li>Nem megfelelő adatok.</li>
                <li>A szervernek nem sikerült értelmeznie a kérést.</li>
                <li>Adatbázishiba.</li>
                <li>Rendszerhiba.</li>
            </ul>
        </div>
        {include file="modul/ugyfel/view/Admin/Partial/Back.tpl"}
    </div>
</div>
<style type="text/css">
#error-description {
    background: pink;
    border: 1px solid #A30000;
    border-radius: 5px;
    margin-bottom: 10px;
    margin-top: 20px;
    padding: 10px 16px;
    text-shadow: none;
}
#error-description p {
    color: #A30000;
    font-size: 16px;
    margin: 0px;
}
#error-description ul {
    color: #A30000;
    list-style-position: inside;
    margin: 0px;
}
</style>