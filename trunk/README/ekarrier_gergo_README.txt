Ezekben modositottam biztosan

allashirdetes
allaskereses
beallitas (szektoredit model �s view)
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

a view t�bl�kban �t kellett �rnom a definer-t, hogy m�k�dj�n, szal azt �t�rtam


**
Az �ll�shirdet�s felad�sban k�ls� munk�ltat�i oldalon annyit nyultam bele, hogy fel lehet vinni kompetenci�kat az �ll�shirdet�sekhez. Azt n�zd m�r meg l�gy sz�ves, mert az isten�rt se tudtam megcsin�lni h norm�lisan m�k�dj�n. (Most perpill ugy muxik, hogy a groupsconfigb�l, �s a site.js-b�l kiszedtem a custominputs-t, meg �rtam kis js-t k�dot, h norm�lisan visszat�ltse a kompetenci�kat)


**
AFTER Edua UPDATE1

�ll�shirdet�sn�l, ha az adott tev csoporton bel�li, tevk�r�n bel�l nincs olyan munkak�r, amit akar felvinni a munk�ltat�, akkor tudja be�rni, �s akkor ad�djon hozz� az adott kateg�ri�hoz. (de ink�bb besz�lj�l/j�nk �du�val/csab�val el�tte miel�tt megcsin�lod, nehogy az legyen h �dua megint f�lrebesz�lt)

