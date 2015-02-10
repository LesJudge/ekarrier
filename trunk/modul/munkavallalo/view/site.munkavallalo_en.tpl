<div>
    <div class="floatLeft">
        <div>
            <img src="" alt="" width="200" height="200" />
        </div>
        <div>
            {$userData.lastname} {$userData.firstname}
        </div>
        <div>{$userData.email}</div>
    </div>
    
    <div class="floatLeft">
        <ul class="uw-nav-list uw-nav-list-block">
            <li>
                <a title="Adatmódosítás" href="#">Adatmódosítás</a>
            </li>
            <li>
                <a title="Végzettségeim" href="{$DOMAIN}{$routes.vegzettseg}">Végzettségeim</a>
            </li>
        </ul>
    </div>
</div>