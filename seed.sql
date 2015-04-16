SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
/* Site típus */
INSERT INTO `site_tipus` (`site_tipus_id`, `site_tipus_nev`, `site_tipus_torolt`) VALUES
(1, 'Admin', 0),
(2, 'Site', 0);
/* Modul */
INSERT INTO `modul` (`modul_id`, `modul_azon`, `modul_nev`, `modul_aktiv`, `modul_torolt`) VALUES
(1, 'user', 'Felhasználó', 1, 0),
(2, 'nyelv', 'Nyelv', 1, 0),
(3, 'menu', 'Menükezelés', 1, 0),
(4, 'beallitas', 'Beállítások', 1, 0),
(5, 'ugyfel', 'Ügyfél', 1, 0),
(6, 'projekt', 'Projekt', 1, 0),
(7, 'szolgaltatas', 'Szolgáltatás', 1, 0);
/* Modul function */
INSERT INTO `modul_function` (`modul_function_id`, `site_tipus_id`, `modul_azon`, `modul_function_azon`, `modul_function_nev`, `modul_function_tipus`, `modul_function_root`, `modul_function_torolt`) VALUES
(1, 1, 'ugyfel', 'list', 'Ügyfél listázás', '__loadController', 0, 0),
(2, 1, 'ugyfel', 'create', 'Ügyfél létrehozás', '__loadController', 0, 0),
(3, 1, 'ugyfel', 'edit', 'Ügyfél megtekintése', '__loadController', 0, 0),
(4, 1, 'ugyfel', 'update', 'Ügyfél szerkesztése', '__loadController', 0, 0);
/* Jogcsoport */
INSERT INTO `jogcsoport` (`jogcsoport_id`, `site_tipus_id`, `jogcsoport_nev`, `jogcsoport_aktiv`, `jogcsoport_torolt`) VALUES
(1, 1, 'Root', 1, 0),
(2, 2, 'Regisztrált felhasználók (ügyfél)', 1, 0),
(3, 2, 'Regisztrált felhasználók (cég)', 1, 0),
(4, 1, 'Szerkesztő', 1, 0),
(5, 1, 'Adminisztrátor', 1, 0);
/* Jogcsoport function */
INSERT INTO `jogcsoport_function` (`jogcsoport_id`, `jogcsoport_function_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);
/* Nyelv */
INSERT INTO `nyelv` (`nyelv_id`, `nyelv_nev`, `nyelv_azon`, `nyelv_zaszlo_nev`, `nyelv_aktiv`, `nyelv_torolt`) VALUES
(1, 'Magyar', 'hu', 'flag_HU.gif', 1, 0);
/* Nyelv szótár */
INSERT INTO `nyelv_szotar` (`nyelv_szotar_id`, `nyelv_id`, `modul_id`, `nyelv_szotar_azon`, `nyelv_szotar_szo`, `nyelv_szotar_torolt`) VALUES
(1, 1, 1, '1_szerzo', 'Szerző', 0),
(2, 1, 9999, 'indikator', 'Itt jár most', 0),
(3, 1, 9999, 'lapozas_tetelek_szama', 'Tételek', 0),
(4, 1, 9999, 'lapozas_oldal', 'Oldal', 0),
(5, 1, 2, 'sikertelen_belepes', 'Felhasználónév és/vagy a jelszó nem megfelelő', 0),
(6, 1, 2, 'sikertelen_belepes_megerosites', 'Ön nem megerősített felhasználó', 0),
(7, 1, 2, 'emlekezteto_sikeres', 'Sikeres e-mail küldés', 0),
(8, 1, 2, 'emlekezteto_sikertelen_mail', 'A megadott e-mail cím nem szerepel a rendszerünkben', 0),
(9, 1, 2, 'emlekezteto_sikertelen_mail_send', 'Sikertelen e-mail küldés', 0),
(10, 1, 9998, 'kotelezo', 'Kötelező kitölteni', 1),
(11, 1, 9998, 'form_mess_kotelezo', 'Kötelező kitölteni', 0),
(12, 1, 9998, 'form_mess_number', 'Csak számot adhat meg', 0),
(13, 1, 9998, 'form_mess_select', 'Kötelező választani', 0),
(14, 1, 9998, 'form_mess_file', 'Kötelező file-t feltölteni', 0),
(15, 1, 9998, 'form_mess_kep', 'Csak képet tölthet fel', 0),
(16, 1, 9998, 'form_mess_maxchar_start', 'Maximum', 0),
(17, 1, 9998, 'form_mess_maxchar_end', 'karaktert adhat meg', 0),
(18, 1, 9998, 'form_mess_maxfile_start', 'Maximum', 0),
(19, 1, 9998, 'form_mess_maxfile_end', 'méretű fájlt adhat meg', 0),
(20, 1, 9998, 'form_mess_datetimegreaterthan', 'A vég dátum nem lehet kisebb mint a kezdő dátum', 0),
(21, 1, 9998, 'form_mess_datetime', 'Dátumot és órát és percet adjon meg', 0),
(22, 1, 9998, 'form_mess_date', 'Dátumot adjon meg', 0),
(23, 1, 9998, 'form_mess_equalTo', 'Meg kell egyeznie a két értéknek', 0),
(24, 1, 9998, 'form_mess_equalToCaptcha', 'Nem megfelelő ellenőrző kód', 0),
(25, 1, 9998, 'form_mess_email', 'Nem megfelelő e-mail cím formátum', 0),
(26, 1, 9998, 'form_mess_unique', 'Az adatbázisban már szerepel ilyen elem', 0),
(27, 1, 9999, 'Nyelv_Valaszto', 'Nyelv', 1),
(28, 1, 9999, 'hirek', 'Legfrissebb híreink', 0),
(29, 1, 0, 'Hibás form kitöltés', 'Hibás form kitöltés', 0),
(30, 1, 0, 'Sikeres adatmódosítás', 'Sikeres adatmódosítás', 0),
(31, 1, 0, 'Sikeres regisztráció és e-mail értesítés', 'Sikeres regisztráció és e-mail értesítés', 0),
(32, 1, 0, 'Felhasználónév és vagy a jelszó nem megfelelő', 'Felhasználónév és vagy a jelszó nem megfelelő', 0);
/* User */
INSERT INTO `user` (`user_id`, `nyelv_id`, `user_fnev`, `user_jelszo`, `user_email`, `user_vnev`, `user_knev`, `user_kep_nev`, `user_hirlevel`, `user_reg_date`, `user_megerositve`, `user_megerositve_date`, `user_last_login`, `user_szum_login`, `user_aktiv`, `user_torolt`) VALUES
(1, 1, 'admin', '6301bb858f92dd554afc1d54b3d715e93603e88b7172', 'teszt@uniweb.hu', 'UniWeb', 'Admin', '', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '2015-02-07 10:37:57', 0, 1, 0);
/* User jogcsoport */
INSERT INTO `user_jogcsoport` (`user_jogcsoport_id`, `user_id`) VALUES
(1, 1),
(2, 1);
/* Admin menü */
INSERT INTO `admin_menu` (`admin_menu_id`, `nyelv_id`, `szint`, `baloldal`, `jobboldal`, `menu_nev`, `menu_link`, `modul_function_id`, `admin_menu_aktiv`, `admin_menu_torolt`) VALUES
(1, 1, 0, 1, 134, 'Felső menü', '', 0, 1, 0),
(2, 1, 1, 112, 127, 'Vezérlőpult', '', 52, 1, 0),
(3, 1, 2, 113, 118, 'Nyelvesítés', 'nyelv', 21, 0, 0),
(4, 1, 1, 88, 93, 'Felhasználók', 'user', 3, 1, 0),
(5, 1, 2, 89, 90, 'Jogosultság csoportok', 'user/jogcsoport', 5, 1, 0),
(6, 1, 2, 91, 92, 'Felhasználók', 'user', 3, 1, 0),
(7, 1, 1, 30, 49, 'Tartalom', '', 1, 1, 0),
(8, 1, 2, 37, 38, 'Tartalmak', 'tartalom', 1, 1, 0),
(12, 1, 2, 31, 36, 'Hírek', 'hir', 9, 1, 0),
(13, 1, 3, 32, 33, 'Hír kategóriák', 'hir/kategoria', 7, 1, 0),
(14, 1, 3, 34, 35, 'Hírek', 'hir', 9, 1, 0),
(16, 1, 3, 124, 125, 'Admin menü', 'menu/admin', 19, 1, 0),
(17, 1, 3, 122, 123, 'Site menü', 'menu', 17, 1, 0),
(18, 1, 3, 114, 115, 'Nyelvek', 'nyelv', 11, 0, 0),
(19, 1, 3, 116, 117, 'Szótár', 'nyelv/szotar', 21, 0, 0),
(20, 1, 1, 94, 111, 'Hírlevélküldő', '', 33, 1, 0),
(21, 1, 2, 95, 102, 'Címlista', 'hirlevel/user', 23, 1, 0),
(22, 1, 3, 98, 99, 'Személyek', 'hirlevel/user', 23, 1, 0),
(23, 1, 3, 96, 97, 'Csoportok', 'hirlevel/usercsoport', 25, 1, 0),
(24, 1, 3, 100, 101, 'Próba személyek', 'hirlevel/userproba', 29, 1, 0),
(25, 1, 2, 103, 110, 'Hírlevél', 'hirlevel', 33, 1, 0),
(26, 1, 3, 104, 105, 'Hírlevél sablon', 'hirlevel/sablon', 31, 1, 0),
(27, 1, 3, 106, 107, 'Hírlevelek', 'hirlevel', 33, 1, 0),
(28, 1, 3, 108, 109, 'Sikertelen levelek', 'hirlevel/sikertelen', 35, 1, 0),
(37, 1, 2, 119, 120, 'Rendszerüzenetek', 'email', 50, 1, 0),
(44, 1, 2, 39, 40, 'Bannerek', 'banner', 64, 1, 0),
(68, 1, 2, 121, 126, 'Menü kezelő', 'menu', 17, 1, 0),
(100, 1, 1, 14, 23, 'Munkakör', '', 0, 1, 0),
(101, 1, 2, 15, 16, 'Munkakörök', 'munkakor', 1024, 1, 0),
(102, 1, 2, 17, 18, 'Munkakör kategóriák', 'munkakor/kategoria', 1022, 1, 0),
(103, 1, 2, 41, 42, 'Kompetenciák', 'kompetencia', 1026, 1, 0),
(104, 1, 1, 24, 29, 'Cég', '', 1028, 1, 0),
(105, 1, 2, 43, 44, 'Súgó', 'sugo', 1030, 1, 0),
(106, 1, 2, 25, 26, 'Cégek', 'ceg', 1028, 1, 0),
(109, 1, 2, 45, 46, 'SEO', 'seo', 1035, 1, 0),
(110, 1, 2, 19, 20, 'Tartalom kiegészítés', 'munkakor/tartalomkiegeszites', 1037, 1, 0),
(111, 1, 2, 21, 22, 'Elvárások kiegészítés', 'munkakor/elvarasokkiegeszites', 1039, 1, 0),
(112, 1, 2, 47, 48, 'Infobox', 'infobox', 1041, 1, 0),
(113, 1, 1, 50, 87, 'Beállítások', '', 0, 1, 0),
(114, 1, 2, 57, 58, 'Iskolai végzettségek', 'beallitas/vegzettseg', 1043, 1, 0),
(115, 1, 2, 51, 52, 'Alkalmazotti viszony', 'beallitas/alkalmazottiviszony', 1050, 1, 0),
(116, 1, 2, 55, 56, 'Iparág', 'beallitas/iparag', 1048, 1, 0),
(117, 1, 2, 63, 64, 'Szektor', 'beallitas/szektor', 1046, 1, 0),
(118, 1, 2, 53, 54, 'Álláshirdetés előny', 'beallitas/elony', 1052, 1, 0),
(119, 1, 2, 61, 62, 'Munkakör tevékenység', 'beallitas/tevekenyseg', 1054, 1, 0),
(120, 1, 2, 27, 28, 'Telephelyek', 'ceg/telephely', 1056, 1, 0),
(121, 1, 2, 7, 8, 'Kapcsolatfelvétel', 'user/kapcsolat', 1058, 1, 0),
(124, 1, 2, 59, 60, 'Képzések', 'kepzes', 1063, 1, 0),
(125, 1, 2, 65, 66, 'Szolgáltatások', 'szolgaltatas', 1065, 1, 0),
(126, 1, 1, 6, 13, 'Ügyfélkezelés', '', 0, 1, 0),
(127, 1, 2, 67, 68, 'Munkarend', 'beallitas/munkarend', 1067, 1, 0),
(128, 1, 2, 69, 70, 'Program információ', 'beallitas/programinformacio', 1069, 1, 0),
(129, 1, 1, 2, 5, 'Álláshirdetés', 'allashirdetes', 1071, 1, 0),
(130, 1, 2, 3, 4, 'Álláshirdetések', 'allashirdetes', 1071, 1, 0),
(131, 1, 2, 71, 72, 'Hova érkezett', 'beallitas/hovaerkezett', 1073, 1, 0),
(132, 1, 2, 73, 78, 'Nyelvtudás', '', 0, 1, 0),
(133, 1, 3, 74, 75, 'Nyelvek', 'nyelvtudas/nyelv', 1075, 1, 0),
(134, 1, 3, 76, 77, 'Szintek', 'nyelvtudas/szint', 1077, 1, 0),
(135, 1, 2, 9, 10, 'Projektek', 'projekt', 1081, 1, 0),
(136, 1, 2, 79, 84, 'Ügyfél', '', 0, 1, 0),
(137, 1, 3, 80, 81, 'Állapot', 'beallitas/ugyfelallapot', 1083, 1, 0),
(138, 1, 3, 82, 83, 'Státusz', 'beallitas/ugyfelstatusz', 1085, 1, 0),
(139, 1, 2, 85, 86, 'Esetnapló típus', 'beallitas/esetnaplotipus', 1087, 1, 0),
(143, 1, 1, 128, 133, 'Fórumok', '', 1090, 1, 0),
(145, 1, 2, 129, 130, 'Fórum témák', 'forum', 1090, 1, 0),
(146, 1, 2, 131, 132, 'Hozzászóllások', 'forum/hozzaszolas', 1092, 1, 0),
(147, 1, 2, 11, 12, 'Ügyfelek', 'ugyfel', 1094, 1, 0);
/* Menü */
INSERT INTO `menu` (`menu_id`, `nyelv_id`, `szint`, `baloldal`, `jobboldal`, `menu_nev`, `menu_link`, `kapcsolodo_id`, `jogcsoport_id`, `menu_aktiv`, `menu_torolt`) VALUES
(1, 1, 0, 1, 16, 'Főmenü', '', '', 0, 1, 0),
(2, 1, 0, 17, 32, 'Felhasználó menü', '', '', 2, 1, 0),
(3, 1, 0, 33, 42, 'Lábléc menü', '', '', 0, 1, 0),
(4, 1, 1, 2, 3, 'Nyitó oldal', '/', '', 0, 1, 0),
(5, 1, 1, 6, 7, 'Hírek', 'hirek/', '', 0, 1, 0),
(6, 1, 1, 20, 21, 'Álláshirdetések', 'ceg/allashirdetes/', '', 3, 1, 0),
(7, 1, 1, 36, 37, 'Partnereink', '/', '', 0, 1, 0),
(8, 1, 1, 34, 35, 'Kapcsolat', 'kapcsolat', 'tart__17', 0, 1, 0),
(9, 1, 1, 22, 23, 'Profil', 'ceg/profil/', '', 3, 1, 0),
(10, 1, 1, 4, 5, 'Rólunk', 'rolunk', 'tart__9', 0, 1, 0),
(11, 1, 1, 8, 9, 'Álláskeresés', 'allaskereses/', '', 0, 1, 0),
(12, 1, 1, 10, 11, 'Fórum', 'forum/', '', 0, 1, 0),
(13, 1, 1, 12, 13, 'Tanácsok', 'hirek/4-hasznos-tanacsok/', '', 0, 1, 0),
(14, 1, 1, 14, 15, 'Kapcsolat', 'kapcsolat', 'tart__13', 0, 1, 0),
(15, 1, 1, 38, 39, 'Álláskeresés', '/', '', 0, 1, 0),
(16, 1, 1, 40, 41, 'Rólunk', '/', '', 0, 1, 0),
(17, 1, 1, 24, 25, 'Adatmódosítás', 'adatmodositas/', '', 2, 1, 0),
(19, 1, 1, 26, 27, 'Telephelyek', 'ceg/telephely/', '', 3, 1, 0),
(20, 1, 1, 28, 29, 'Megjelölt álláshirdetések', 'profil/megjelolt-allashirdetesek/', '', 2, 1, 0),
(21, 1, 1, 30, 31, 'Végzettségeim', 'profil/vegzettsegeim/', '', 2, 1, 0),
(23, 1, 0, 43, 54, 'Munkáltató külső', '', NULL, 0, 1, 0),
(24, 1, 1, 50, 51, 'Szolgáltatások', 'szolgaltatasok', 'tart__16', 0, 1, 0),
(25, 1, 1, 44, 45, 'Nyitó oldal', 'nyito-oldal', '', 0, 1, 0),
(27, 1, 1, 48, 49, 'Hírek', 'hirek/', '', 0, 1, 0),
(28, 1, 1, 46, 47, 'Rólunk', 'bemutatkozas', '', 0, 1, 0),
(29, 1, 1, 52, 53, 'Kapcsolat', 'kapcsolat-ceg', '', 0, 1, 0),
(30, 1, 1, 18, 19, 'Profil', 'profil/', '', 2, 1, 0);
/* Szolgáltatás */
INSERT INTO `szolgaltatas` (`szolgaltatas_id`, `nev`, `leiras`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `szolgaltatas_aktiv`, `szolgaltatas_torolt`) VALUES
(1, 'Pszicho-szociális tanácsadás', '<p>pszicho-szoci&aacute;lis tan&aacute;csad&aacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:40:17', 1, 1, 0),
(2, 'Képzési tanácsadás', '<p>k&eacute;pz&eacute;si tan&aacute;csad&aacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:40:29', 1, 1, 0),
(3, 'Munkatanácsadás', '<p>munkatan&aacute;csad&aacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:40:40', 1, 1, 0),
(4, 'Álláskeresési technikák megismerése', '<p>&aacute;ll&aacute;skeres&eacute;si technik&aacute;k megismer&eacute;se</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:40:52', 1, 1, 0),
(5, 'Kulcsképességek fejlesztése', '<p>kulcsk&eacute;pess&eacute;gek fejleszt&eacute;se</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:03', 1, 1, 0),
(6, 'Álláskereső klub', '<p>&aacute;ll&aacute;skereső klub</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:14', 1, 1, 0),
(7, 'Grafológiai munkakörelemzés', '<p>grafol&oacute;giai munkak&ouml;relemz&eacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:25', 1, 1, 0),
(8, 'Pszichológiai tanácsadás', '<p>pszichol&oacute;giai tan&aacute;csad&aacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:35', 1, 1, 0),
(9, 'Jogi tanácsadás', '<p>jogi tan&aacute;csad&aacute;s</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:46', 1, 1, 0),
(10, 'Élő álláskereső klub', '<p>&eacute;lő &aacute;ll&aacute;skereső klub</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:41:55', 1, 1, 0),
(11, 'Call Center és Karrier Irodák szolgáltatásai', '<p>Call Center &eacute;s a Karrier Irod&aacute;k szolg&aacute;ltat&aacute;sai</p>', 1, 1, '2014-07-02 10:46:13', '2014-10-18 13:42:07', 1, 1, 0),
(12, 'Álláskeresési Tanácsadó és Karrier Pont Iroda vezető képzés', '<p class="p1">&Aacute;ll&aacute;skeres&eacute;si Tan&aacute;csad&oacute; &eacute;s Karrier Pont Iroda vezető k&eacute;pz&eacute;s</p>', 1, 1, '2014-10-18 13:42:29', '0000-00-00 00:00:00', 0, 1, 0),
(13, 'Állásvadász tábor', '<p class="p1">&Aacute;ll&aacute;svad&aacute;sz t&aacute;bor</p>', 1, 1, '2014-10-18 13:42:38', '0000-00-00 00:00:00', 0, 1, 0),
(14, 'Munkáltatói kapcsolattartó', '<p class="p1">Munk&aacute;ltat&oacute;i kapcsolattart&oacute;</p>', 1, 1, '2014-10-18 13:42:50', '0000-00-00 00:00:00', 0, 1, 0),
(15, 'Telefonos és elektonikus ügyfélkapcsolati asszisztens képzés', '<p class="p1">Telefonos &eacute;s elektonikus &uuml;gyf&eacute;lkapcsolati asszisztens k&eacute;pz&eacute;s</p>', 1, 1, '2014-10-18 13:43:05', '0000-00-00 00:00:00', 0, 1, 0),
(16, 'Vállalkozóvá válás elősegítése', '<p class="p1">V&aacute;llalkoz&oacute;v&aacute; v&aacute;l&aacute;s előseg&iacute;t&eacute;se</p>', 1, 1, '2014-10-18 13:43:20', '0000-00-00 00:00:00', 0, 1, 0);
/* Karrierpont */
INSERT INTO `karrierpont` (`karrierpont_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `karrierpont_aktiv`, `karrierpont_torolt`) VALUES
(1, 'Csat központi iroda', 1, 1, '2014-08-26 10:25:36', '2014-08-26 10:33:11', 1, 1, 0),
(2, 'Debreceni Karrier Pont', 1, 1, '2014-08-26 10:33:30', '0000-00-00 00:00:00', 0, 1, 0),
(3, 'Hajdúböszörményi Karrier Pont', 1, 1, '2014-08-26 10:33:44', '0000-00-00 00:00:00', 0, 1, 0),
(4, 'Berettyóújfalui Karrier Pont', 1, 1, '2014-08-26 10:34:10', '0000-00-00 00:00:00', 0, 1, 0);
/* Munkarend */
INSERT INTO `munkarend` (`munkarend_id`, `nev`, `has_field`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `munkarend_aktiv`, `munkarend_torolt`) VALUES
(1, 'Részmunkaidő', 0, 1, 1, '2014-07-08 14:35:35', '2014-10-18 13:26:15', 6, 1, 0),
(2, 'Egy műszakos', 0, 1, 1, '2014-08-12 10:59:37', '2014-10-18 13:26:37', 2, 1, 0),
(3, 'Határozott idejű', 0, 1, 1, '2014-08-12 10:59:46', '2014-10-18 13:27:02', 2, 1, 0),
(4, 'Alkalmi', 0, 1, 1, '2014-08-12 10:59:54', '2014-10-18 13:27:20', 2, 1, 0),
(5, 'Állandó', 0, 1, 1, '2014-08-27 17:16:47', '2014-10-18 13:27:31', 1, 1, 0),
(6, 'Több műszakos', 0, 1, 1, '2014-08-27 17:16:58', '2014-10-18 13:26:51', 2, 1, 0),
(7, 'Határozatlan idejű', 0, 1, 1, '2014-08-27 17:17:22', '2014-10-18 13:27:11', 1, 1, 0),
(8, 'Teljes munkaidő', 0, 1, 1, '2014-08-27 17:17:36', '2014-10-18 13:26:25', 1, 1, 0),
(9, 'Egyéb', 1, 1, 1, '2014-10-18 13:27:42', '0000-00-00 00:00:00', 0, 1, 0),
(10, 'Vállalkozói', 0, 1, 1, '2014-10-30 15:46:00', '0000-00-00 00:00:00', 0, 1, 0),
(11, 'Jutalékos rendszer', 0, 1, 1, '2014-10-30 15:46:04', '2014-10-31 09:01:25', 1, 1, 0);
/* Végzettség */
INSERT INTO `vegzettseg` (`vegzettseg_id`, `nev`, `modositas_szama`, `letrehozas_timestamp`, `modositas_timestamp`, `letrehozo_id`, `modosito_id`, `vegzettseg_aktiv`, `vegzettseg_torolt`) VALUES
(1, '8 általános', 4, '2014-02-11 08:55:43', '2014-10-18 13:23:52', 1, 1, 1, 0),
(2, 'szakközépiskola/gimnázium', 2, '2014-02-11 08:59:16', '2014-10-18 13:24:31', 1, 1, 1, 0),
(3, 'főiskola/egyetem', 2, '2014-02-11 08:59:45', '2014-10-18 13:25:32', 1, 1, 1, 0),
(4, 'kevesebb, mint 8 osztály', 1, '2014-08-11 14:54:34', '2014-10-18 13:23:38', 1, 1, 1, 0),
(5, 'szakmunkásképző/szakiskola/OKJ', 1, '2014-08-11 14:55:06', '2014-10-18 13:24:20', 1, 1, 1, 0),
(6, 'OKJ-s szakma', 0, '2014-08-11 14:55:16', '0000-00-00 00:00:00', 1, 0, 1, 1),
(7, 'felsőfokú szakképzés', 1, '2014-08-11 14:55:45', '2014-10-18 13:24:40', 1, 1, 1, 0),
(8, 'egyéb', 1, '2014-10-18 09:36:11', '2014-10-18 13:25:40', 1, 1, 1, 0),
(9, 'technikum', 1, '2014-11-06 15:47:39', '0000-00-00 00:00:00', 1, 1, 1, 0);
/* Ügyfél munkakör kategória */
INSERT INTO `ugyfel_munkakor_kategoria` (`ugyfel_munkakor_kategoria_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `ugyfel_munkakor_kategoria_aktiv`, `ugyfel_munkakor_kategoria_torolt`) VALUES
(1, 'A', 1, 1, '2015-01-27 09:36:14', '0000-00-00 00:00:00', 0, 1, 0),
(2, 'K', 1, 1, '2015-01-27 09:36:22', '0000-00-00 00:00:00', 0, 1, 0),
(3, 'F', 1, 1, '2015-01-27 09:36:29', '0000-00-00 00:00:00', 0, 1, 0);
/* Ügyfél munkába állás állapot */
INSERT INTO `ugyfel_munkaba_allas_allapot` (`ugyfel_munkaba_allas_allapot_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `ugyfel_munkaba_allas_allapot_aktiv`, `ugyfel_munkaba_allas_allapot_torolt`) VALUES
(1, '1', 1, 1, '2015-01-27 09:44:02', '0000-00-00 00:00:00', 0, 1, 0),
(2, '2', 1, 1, '2015-01-27 09:44:08', '0000-00-00 00:00:00', 0, 1, 0),
(3, '3', 1, 1, '2015-01-27 09:44:14', '0000-00-00 00:00:00', 0, 1, 0);
/* Ügyfél státusz */
INSERT INTO `ugyfel_statusz` (`ugyfel_statusz_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `ugyfel_statusz_aktiv`, `ugyfel_statusz_torolt`) VALUES
(1, 'Aktív', 1, 1, '2014-09-29 09:19:38', '2014-10-18 11:22:03', 2, 1, 0),
(2, 'Utánkövetés', 1, 1, '2014-09-29 09:19:56', '2014-10-18 11:22:14', 5, 1, 0),
(3, 'Passzív - csak állásinfó', 1, 1, '2014-09-29 09:20:08', '2014-10-18 11:22:24', 2, 1, 0),
(4, 'Passzív', 1, 1, '2014-10-16 11:52:13', '2014-10-18 11:22:35', 1, 1, 0),
(5, 'Hideg', 1, 1, '2014-10-16 11:52:19', '2014-10-18 11:22:46', 1, 1, 0),
(6, 'Robinson', 1, 1, '2014-10-16 11:52:25', '2014-10-18 11:22:55', 1, 1, 0);
/* Ügyfél tab */
INSERT INTO `ugyfel_tab` (`ugyfel_tab_id`, `nev`, `letrehozo_id`, `modosito_id`, `modositas_szama`, `ugyfel_tab_aktiv`, `ugyfel_tab_torolt`) VALUES
(1, 'Ügyfél információ', 1, 1, 0, 1, 0),
(2, 'Személyes adatok', 1, 1, 0, 1, 0),
(3, 'Munkaerőpiaci helyzete', 1, 1, 0, 1, 0),
(4, 'Projektinformációk', 1, 1, 0, 1, 0),
(5, 'Munkakörök/munkarend', 1, 1, 0, 1, 0),
(6, 'Végzettségek/Nyelvtudás/Tanulmányok/Számítógépes ismeretek', 1, 1, 0, 1, 0),
(7, 'Álláskeresési aktivitás', 1, 1, 0, 1, 0),
(8, 'Projekt', 1, 1, 0, 1, 0),
(9, 'Esetnapló', 1, 1, 0, 1, 0),
(10, 'Dokumentumok', 1, 1, 0, 1, 0),
(11, 'Belépés adatok', 1, 1, 0, 1, 0);
/* Ügyfél cím típus */
INSERT INTO `ugyfel_cim_tipus` (`ugyfel_cim_tipus_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `ugyfel_cim_tipus_aktiv`, `ugyfel_cim_tipus_torolt`) VALUES
(1, 'Lakcím', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 1, 0),
(2, 'Tartkózkodási hely', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 1, 0),
(3, 'Ideiglenes lakcím', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 1, 0);
/* Program információk */
INSERT INTO `program_informacio` (`program_informacio_id`, `nev`, `has_field`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `program_informacio_aktiv`, `program_informacio_torolt`) VALUES
(1, 'újsághirdetés', 0, 1, 1, '2014-07-08 15:40:24', '2014-10-18 13:29:14', 4, 1, 0),
(2, 'az Egyesület honlapja', 0, 1, 1, '2014-07-08 15:44:45', '2014-10-18 13:30:00', 1, 1, 0),
(3, 'Facebook', 0, 1, 1, '2014-07-08 15:45:00', '2014-10-18 13:30:09', 1, 1, 0),
(4, 'ismerős', 0, 1, 1, '2014-07-08 15:45:12', '2014-10-18 13:30:17', 2, 1, 0),
(5, 'Munkaügyi Központ', 0, 1, 1, '2014-07-08 15:45:33', '2014-10-18 13:30:28', 1, 1, 0),
(6, 'intézmény/civil szervezet', 0, 1, 1, '2014-07-08 15:45:45', '2014-10-18 13:30:37', 1, 1, 0),
(7, 'szórólap, plakát', 0, 1, 1, '2014-07-08 15:46:01', '2014-10-18 13:30:45', 1, 1, 0),
(8, 'rendezvény', 0, 1, 1, '2014-07-08 15:46:18', '2014-10-18 13:30:58', 1, 1, 0),
(9, 'egyéb', 1, 1, 1, '2014-07-09 10:24:16', '2014-10-18 13:31:23', 2, 1, 0),
(10, 'Tv reklám', 1, 1, 1, '2014-10-18 13:29:37', '0000-00-00 00:00:00', 0, 1, 0),
(11, 'Rádió', 1, 1, 1, '2014-10-18 13:29:51', '0000-00-00 00:00:00', 0, 1, 0),
(12, 'telefonos megkeresés', 1, 1, 1, '2014-10-18 13:31:14', '0000-00-00 00:00:00', 0, 1, 0);
/* Nyelvtudás - nyelv */
INSERT INTO `nyelvtudas_nyelv` (`nyelvtudas_nyelv_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `nyelvtudas_nyelv_aktiv`, `nyelvtudas_nyelv_torolt`) VALUES
(1, 'Magyar', 1, 1, '2014-05-16 12:23:33', '0000-00-00 00:00:00', 0, 1, 0),
(2, 'Angol', 1, 1, '2014-05-16 12:23:44', '2014-08-26 15:05:35', 2, 1, 0),
(3, 'Német', 1, 1, '2014-05-16 12:23:56', '0000-00-00 00:00:00', 0, 1, 0),
(4, 'Spanyol', 1, 1, '2014-05-20 11:59:22', '2014-05-20 12:13:41', 1, 1, 0),
(5, 'Román', 1, 1, '2014-08-26 15:06:49', '0000-00-00 00:00:00', 0, 1, 0),
(6, 'Orosz', 1, 1, '2014-08-26 17:03:18', '0000-00-00 00:00:00', 0, 1, 0),
(7, 'Arab', 1, 1, '2014-08-26 17:03:45', '0000-00-00 00:00:00', 0, 1, 0);
/* Nyelvtudás - szint */
INSERT INTO `nyelvtudas_szint` (`nyelvtudas_szint_id`, `nev`, `letrehozo_id`, `modosito_id`, `letrehozas_timestamp`, `modositas_timestamp`, `modositas_szama`, `nyelvtudas_szint_aktiv`, `nyelvtudas_szint_torolt`) VALUES
(1, 'Alapfokú', 1, 1, '2014-05-16 12:18:09', '0000-00-00 00:00:00', 0, 1, 0),
(2, 'Középfokú', 1, 1, '2014-05-20 07:48:06', '2014-08-26 15:12:49', 1, 1, 0),
(3, 'Felsőfokú', 1, 1, '2014-05-20 12:15:06', '2014-05-20 12:16:14', 2, 1, 0),
(4, 'Szaknyelv', 1, 1, '2014-10-30 14:48:44', '0000-00-00 00:00:00', 0, 1, 0),
(5, 'Anyanyelvi', 1, 1, '2014-10-30 14:48:48', '0000-00-00 00:00:00', 0, 1, 0);
COMMIT;
