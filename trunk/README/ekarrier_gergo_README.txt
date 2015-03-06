Ezekben modositottam biztosan

allashirdetes
allaskereses
beallitas (szektoredit model és view)
ceg
en
kompetencia
pozicioteszt(uj)
szakertovelemenye (uj)
szektor(uj)
szektorteszt
tevekenysegikor (uj)
ugyfellinkek(uj)
ugyfeluzenetek(uj)


htaccess



Adatb.(ami biztos)

admin_menu
allashirdetes_attr_kompetencia (uj)
email(egy uj rekord van benne)
jogcsoport_function
kompetencia
kompetenciarajz(uj)
kompetenciarajz_kompetencia(uj)
kompetencia_hozzaszolas(uj)
szektor_hozzaszolas(uj)
menu
modul_function
szakertovelemenye(uj)
szektor_hozzaszolas(uj)
tartalom
tevekenysegikor_hozzaszolas(uj)
ugyfel_attr_kompetencia(uj)
ugyfel_attr_tevkor(uj)
ugyfel_attr_allashirdetes_kedvenc (uj)
ugyfel_attr_linkek (uj)
ugyfel_attr_szektorteszt (uj)
ugyfel_attr_stats (uj)
ugyfel_attr_uzenetek (uj)

a view táblákban át kellett írnom a definer-t, hogy mûködjön, szal azt átírtam


**
Az álláshirdetés feladásban külsõ munkáltatói oldalon annyit nyultam bele, hogy fel lehet vinni kompetenciákat az álláshirdetésekhez. Azt nézd már meg légy szíves, mert az istenért se tudtam megcsinálni h normálisan mûködjön. (Most perpill ugy muxik, hogy a groupsconfigból, és a site.js-bõl kiszedtem a custominputs-t, meg írtam kis js-t kódot, h normálisan visszatöltse a kompetenciákat)


**
AFTER Edua UPDATE1

Álláshirdetésnél, ha az adott tev csoporton belüli, tevkörön belül nincs olyan munkakör, amit akar felvinni a munkáltató, akkor tudja beírni, és akkor adódjon hozzá az adott kategóriához. (de inkább beszéljél/jünk éduával/csabával elõtte mielõtt megcsinálod, nehogy az legyen h édua megint félrebeszélt)

