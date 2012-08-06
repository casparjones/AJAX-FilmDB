<?php

/* AJAX-FilmDB 1.2.4 (based on php4flicks) */

$conttype = 'text/html; charset=iso-8859-1';
$rsstype  = 'iso-8859-1';
$xmltype  = 'iso-8859-1';
$sqltype  = 'iso-8859-1';

	$trans['rss_title'] 	= 'Zeigt die 10 neuesten Filme in dieser FilmDatenBank an.';

	$trans['page_title'] 	= 'FilmDatenBank';
	$trans['work_in_progress'] = 'In Bearbeitung...';
	$trans['the_b_list']	= '<strong><big><b>Die Liste der Entleiher</b></big></strong>';
	$trans['the_u_list']	= '<strong><big><b>Die Liste der Benutzer</b></big></strong>';
	$trans['the_prefs']		= '<strong><big><b>Die Programmeinstellung</b></big></strong>';
	$trans['the_status']	= '<strong><big><b>Der neue Verleihstatus</b></big></strong>';
	$trans['the_movie']		= '<strong><big><b>Der Film...</b></big></strong><br><small><br></small>';
	$trans['the_file']		= '<strong><big><b>Die Datei...</b></big></strong><br><small><br></small>';
	$trans['cleared_alert']	= '<br><small><br></small><nobr>...wurde geleert!</nobr>';
	$trans['alert_title']	= '<strong><big><b>Achtung!</b></big></strong><br><small><br></small>';
	$trans['delete_alert'] 	= '<nobr>Sind Sie wirklich sicher das Sie diesen Film<br>...l&ouml;schen m&ouml;chten?</nobr><br><small><br></small>';
	$trans['export_alert'] 	= '<nobr>Sind Sie wirklich sicher das Sie diesen Film<br>...als XML-Datei exportieren m&ouml;chten?</nobr><br><small><br></small>';
	$trans['archive_alert'] = '<nobr>Sind Sie wirklich sicher das Sie diese Datei<br>...als ZIP-Archiv runterladen m&ouml;chten?</nobr><br><small><br></small>';
	$trans['import_alert'] 	= '<nobr>Sind Sie wirklich sicher das Sie diesen Film<br>...als XML-Datei importieren m&ouml;chten?</nobr><br><small><br></small>';
	$trans['rescan_alert'] 	= '<nobr>Sind Sie wirklich sicher das Sie diesen Film<br>...erneut von IMDb einlesen m&ouml;chten?</nobr><br><small><br></small>';
	$trans['updated_alert']	= '<br><small><br></small><nobr>...wurde in der DatenBank abgespeichert!</nobr>';
	$trans['multiple_alert']= 'Die runterzuladenden <b>Poster wurden auf mehrere ZIP-<wbr>Archive verteilt</b>, weil Ihr Zugang nur eine begrenzte Dateigr&ouml;&szlig;e zul&auml;&szlig;t';
	$trans['insert_alert']	= '<br><small><br></small><nobr>...wurde in die DatenBank neu hinzugef&uuml;gt!</nobr>';
	$trans['feature_alert'] = '<nobr>Diese F&auml;higkeit ist momentan noch <b>nicht</b> integriert!</nobr><br><small><br>Der etwas komplexere Kode ben&ouml;tigt noch etwas Zeit.</small>';
	$trans['help_alert'] 	= '<nobr>W&auml;hrend die Online-Hilfe aktiv ist k&ouml;nnen</nobr><br>Sie sich weder An- noch Abmelden und Sie k&ouml;nnen au&szlig;erdem auch nicht die DatenBank bearbeiten!';
	$trans['login_alert'] 	= '<nobr>Sie m&uuml;ssen als Benutzer angemeldet sein</nobr><br>um die DatenBank bearbeiten zu d&uuml;rfen!<br><small><br>Benutzen Sie den Login-Knopf (rechts oben) um sich anzumelden!</small>';
	$trans['logging_alert'] = '<nobr>Ihnen wurde der Zugriff verweigert, weil</nobr><br>Ihre Benutzereingaben nicht korrekt waren!<br><small><br>Versuchen Sie es erneut mit dem Login-Knopf (rechts oben)!</small>';
	$trans['logout_alert'] 	= '<nobr>Sie sind nun als Benutzer abgemeldet!</nobr><br><small><br>Benutzen Sie den Login-Knopf (rechts oben) um sich erneut anzumelden!</small>';
	$trans['saved_alert']	= '<br><small><br></small><nobr>...wurde erfolgreich gespeichert!</nobr>';
	$trans['done_alert']	= '<nobr>Operation erfolgreich durchgef&uuml;hrt.</nobr>';
	$trans['none_alert']	= '<nobr>Info: Es gab nichts zu tun.</nobr>';
	$trans['fs_alert']		= '<nobr>Dateisystemzugriff gescheitert!</nobr>';
	$trans['not_loaded']	= '<nobr>...konnte <b>nicht</b> geladen werden!</nobr>';
	$trans['not_saved']		= '<br><small><br></small><nobr>...konnte <b>nicht</b> gespeichert werden!</nobr>';
	$trans['saved_error']	= '<br><small><br></small><nobr>...konnte <b>nicht</b> gespeichert werden!</nobr><br><br><small>&Uuml;berpr&uuml;fen Sie bitte ob die benannte Datei auch wirklich Schreibrechte besitzt.</small>';
	$trans['cookie_error']	= '<br><small><br></small><nobr>...konnte <b>nicht</b> gespeichert werden!</nobr><br><br><small>&Uuml;berpr&uuml;fen Sie bitte ob Ihr Browser von dieser URL auch wirklich Cookies akzeptiert.</small>';
	
	$trans['guru_noscript'] = '<nobr><b>Guru Meditation</b> - Ohne JavaScript funktioniert dieses AJAX-Programm nicht!</nobr>';
	$trans['guru_noobject'] = '<nobr><b>Guru Meditation</b> - Dieser Browser unterst&uuml;tzt das XMLHttpRequest-Objekt nicht!</nobr>';
	$trans['guru_mqgpcon'] 	= '<nobr><b>Guru Meditation</b> - Die PHP-Einstellung \"magic_quotes_gpc\" muss auf \"Off\" stehen!</nobr>';

	$trans['b_edit_list'] 	= 'BenutzerListe';
	$trans['b_config'] 		= 'Konfiguration';
	$trans['b_edit'] 		= 'Bearbeiten';
	$trans['b_delete'] 		= 'L&ouml;schen';
	$trans['b_cancel'] 		= 'Abbrechen';
	$trans['b_update'] 		= 'Speichern';
	$trans['b_upload'] 		= 'Raufladen'; 
	$trans['b_restore'] 	= 'Wiederherstellen';
	$trans['b_import'] 		= 'Importieren';	
	$trans['b_export'] 		= 'Exportieren';
	$trans['b_rescan'] 		= 'Erneuern';
	$trans['b_clear'] 		= 'Leeren';
	$trans['b_showlog'] 	= 'Logdatei Anzeigen';
	$trans['b_save'] 		= 'Speichern';
	$trans['b_save_cookie'] = 'Cookie Speichern';
	$trans['b_insert'] 		= 'Hinzuf&uuml;gen';
	$trans['b_search'] 		= 'Suchen';
	$trans['b_print'] 		= 'Drucken';
	$trans['b_program'] 	= 'Programm';
	$trans['b_borrower'] 	= 'Entleiher';
	$trans['b_add_person'] 	= 'Entleiher hinzuf&uuml;gen';
	$trans['b_back'] 		= 'Zur&uuml;ck';
	$trans['b_start']		= 'Starten';
	$trans['b_ok'] 			= 'OK';
	
	$trans['DE'] 			= 'deutsch';
	$trans['EN'] 			= 'englisch';
	$trans['NL'] 			= 'niederl&auml;ndisch';
	$trans['ES'] 			= 'spanisch';
	$trans['FR'] 			= 'franz&ouml;sisch';
	$trans['IT'] 			= 'italienisch';
	$trans['RU'] 			= 'russisch';
	$trans['TR'] 			= 't&uuml;rkisch';
	$trans['?'] 			= 'unbekannt';
	
	$trans['1.0'] 			= 'Mono';
	$trans['1/1'] 			= 'Mono (Zweisprachig)';
	$trans['2.0'] 			= 'Stereo';
	$trans['2.1'] 			= 'Stereo & Subwoofer';
	$trans['3.0'] 			= 'Stereo & Center';
	$trans['3.1'] 			= 'Stereo & Center & Subwoofer';
	$trans['4.0'] 			= 'Quatro';
	$trans['5.1'] 			= '5 Kanal Surround';
	$trans['6.1'] 			= '6 Kanal Surround';
	$trans['7.1'] 			= '7 Kanal Surround';
	
	$trans['01'] 			= 'Jan';
	$trans['02'] 			= 'Feb';
	$trans['03'] 			= 'M&auml;r';
	$trans['04'] 			= 'Apr';
	$trans['05'] 			= 'Mai';
	$trans['06'] 			= 'Jun';
	$trans['07'] 			= 'Jul';
	$trans['08'] 			= 'Aug';
	$trans['09'] 			= 'Sep';
	$trans['10'] 			= 'Okt';
	$trans['11'] 			= 'Nov';
	$trans['12'] 			= 'Dez';

// used for "LC-Display"

	$trans['login_user'] 	= 'Benutzerkennung';
	$trans['user_mode'] 	= 'Benutzermodus';
	$trans['edit_mode'] 	= 'Bearbeiten';
	$trans['add_mode'] 		= 'Hinzuf&uuml;gen';
	$trans['help_mode'] 	= 'Hilfe';

// mostly used by "login.php"

	$trans['log_user'] 		= 'Benutzer';
	$trans['log_pw'] 		= 'Passwort';
	$trans['log_title'] 	= 'Anmeldung';
	
// used by "add.php"

	$trans['add_title'] 		= 'Film hinzuf&uuml;gen';
	$trans['add_info'] 			= 'Bitte geben Sie den (original) Titel<br>des hinzuzuf&uuml;genden Filmes ein!';
	$trans['add_results'] 		= 'Diese Filme wurden in der IMDb gefunden...';
	$trans['add_search_error']	= 'Es ist ein Fehler beim Suchen aufgetreten!';
	$trans['js_enter_title'] 	= 'Bitte geben Sie zuerst einen Titel ein!';
	$trans['js_enter_file'] 	= 'Bitte geben Sie zuerst eine Datei an!';
/**/$trans['js_enter_url']		= 'Bitte geben Sie zuerst eine URL ein!';
	$trans['js_enter_pattern'] 	= 'Bitte geben Sie eine Datei an, die dem Muster entspricht!';
	$trans['nothing_found']		= 'Es wurden keine Eintr&auml;ge gefunden!';

// used by "importfilm.php"

	$trans['import_title'] 	= 'Film importieren';
	$trans['import_info'] 	= 'Bitte w&auml;hlen Sie die Datei (XML)<br>des zu importierenden Filmes aus!';

// used by "importfile.php" 

	$trans['import_file'] 	= 'Sicherungsdatei laden';
	$trans['select_dbase'] 	= 'Bitte w&auml;hlen Sie eine Datei dieses Musters aus:<br>"filmdb_dbase_DATUM-UHRZEIT.zip"';
	$trans['select_poster'] = 'Bitte w&auml;hlen Sie eine Datei dieses Musters aus:<br>"filmdb_poster_DATUM-UHRZEIT.zip"';
	
// used by "exportfilm.php"

	$trans['dtd_internal'] 	= 'Interne DTD Referenz';
	$trans['dtd_external'] 	= 'Externe DTD Referenz';
	$trans['dtd_none'] 		= 'Ohne DTD Referenz';
	
// used by "importcheck.php"

	$trans['file_date'] 	= 'Dateidatum';
	$trans['file_type'] 	= 'Dateiformat';
	$trans['file_size'] 	= 'Dateigr&ouml;&szlig;e';
	
// used by "upload.php"

	$trans['0'] 			= 'Die Datei wurde erfolgreich heruntergeladen';
	$trans['1'] 			= 'Die zurunterladende Datei &uuml;berschreitet die UPLOAD_MAX_FILESIZE Direktive in php.ini';
	$trans['2'] 			= 'Die zurunterladende Datei &uuml;berschreitet die MAX_FILE_SIZE Direktive (50000 bytes)';
	$trans['3'] 			= 'Die Datei wurde nur teilweise heruntergeladen';
	$trans['4'] 			= 'Es wurde keine Datei heruntergeladen';
	$trans['5'] 			= 'Unbekannter Fehler beim Runterladen';
	$trans['6'] 			= 'Kein tempor&auml;res Verzeichnis gefunden';
	$trans['7'] 			= 'Die zurunterladende Datei konnte nicht gespeichert werden';
/**/$trans['90'] 			= 'Die zurunterladende Datei hat das falsche Dateiformat (kein GIF/JPG)';
	$trans['91'] 			= 'Die zurunterladende Datei hat das falsche Dateiformat (kein XML)';
	$trans['92'] 			= 'Die zurunterladende Datei unterschreitet die MIN_FILE_SIZE Direktive (1000 bytes)';
	$trans['93'] 			= 'Die heruntergeladene Datei konnte nicht gelesen werden';
	$trans['94'] 			= 'Die heruntergeladene Datei konnte nicht verschoben werden';
	$trans['95'] 			= 'Die zurunterladende Datei ist vom falschen Exporteur (nicht AJAX-FilmDB)';
	$trans['96'] 			= 'Die zurunterladende Datei enth&auml;lt keine g&uuml;lltige IMDb Film-ID';
	$trans['97'] 			= 'Der zurunterladende Film ist schon in der Datenbank enthalten';
	$trans['98'] 			= 'Die zurunterladende Datei &uuml;berschreitet die MAX_FILE_SIZE Direktive';
	$trans['99'] 			= 'Die zurunterladende Datei hat das falsche Dateiformat (kein ZIP)'; 

// used by "getperson.php"

	$trans['show_people'] 	= 'Diese Personen wurden in der IMDb gefunden...';
	$trans['show_person'] 	= 'Die Person wurde in der IMDb gefunden...';

// mostly used by "index.php"

	$trans['film_view'] 	= 'Filmansicht';
	$trans['row_view'] 		= 'Reihenansicht';
	$trans['poster_view'] 	= 'Posteransicht';
	$trans['list_view'] 	= 'Listenansicht';
	$trans['version'] 		= 'Version';
	$trans['ajax'] 			= 'AJAX Implementation und Betriebsvoraussetzungen';
	$trans['about'] 		= 'Copyright Informationen';
	$trans['add_film'] 		= 'Film hinzuf&uuml;gen';
	$trans['import_film'] 	= 'Film importieren';
	$trans['edit_prefs'] 	= 'Einstellungen';
	$trans['search_dbase'] 	= 'komplexe Suche';
	$trans['print_dbase'] 	= 'DatenBank drucken';
	$trans['db_info'] 		= 'DatenBank-Statistik';
	$trans['prog_help'] 	= 'Online-Hilfe';
	$trans['log_in'] 		= 'Anmelden';
	$trans['log_out'] 		= 'Abmelden';
	$trans['log_file'] 		= 'Logdatei';

// mostly used by "list.php" and "filmform.php"

	$trans['t_no']			= 'Nr.';
	$trans['t_number'] 		= 'Nummer';
	$trans['t_title'] 		= 'Titel';
	$trans['t_original']	= '(original)';
	$trans['t_local'] 		= '(deutscher)';
	$trans['t_alias'] 		= '(alias)';
	$trans['t_filminfo'] 	= 'Filminfos';
	$trans['t_filmposter'] 	= 'Filmposter';
	$trans['t_category'] 	= 'Genres';
	$trans['t_director'] 	= 'Regie';
	$trans['t_writer'] 		= 'Drehbuch';
	$trans['t_actor'] 		= 'Darsteller';
	$trans['t_comment'] 	= 'Kommentar';
	$trans['t_format'] 		= 'TV-Format';
	$trans['t_ratio'] 		= 'Aspektratio';
	$trans['t_rating'] 		= 'Wertung';
	$trans['t_language'] 	= 'Sprachen';
	$trans['t_languages'] 	= 'Sprachen';
	$trans['t_audio'] 		= 'Audio';
	$trans['t_video'] 		= 'Video';
	$trans['t_datatype'] 	= 'Format';
	$trans['t_container'] 	= 'Container';
	$trans['t_country'] 	= 'Land';
	$trans['t_countries'] 	= 'Produktionsl&auml;nder';
	$trans['t_lent'] 		= 'Verliehen';
	$trans['t_to'] 			= 'an';
	$trans['t_at'] 			= 'am';
	$trans['t_year'] 		= 'Jahr';
	$trans['t_date'] 		= 'eingef&uuml;gt am';
	$trans['t_since'] 		= 'Datum';
	$trans['t_runtime'] 	= 'Dauer';
	$trans['t_minutes'] 	= 'min.';
	$trans['t_medium'] 		= 'Medium';
	$trans['t_imdb'] 		= 'IMDb';
	$trans['t_poster'] 		= 'Poster';
	$trans['t_film'] 		= 'Film';

	$trans['click_to_edit'] = 'Zur Bearbeitung anklicken...';
	$trans['no_matches'] 	= '...keine Eintr&auml;ge gefunden...';
	$trans['is_equal_to'] 	= '1<b>=</b>Wahr/Ja/An - 0<b>=</b>Unwahr/Nein/Aus';

	$trans['show_moviedata'] 	= 'Zeige alle Daten des Filmes an (Filmansicht)!';
	$trans['edit_moviedata'] 	= 'Diesen Film bearbeiten!';
/**/$trans['show_movieinfo'] 	= 'Zeige alle Daten des Filmes an!'; 
/**/$trans['close_movieinfo'] 	= 'Infobox schliessen'; 
/**/$trans['export_moviedata'] 	= 'Diesen Film exportieren!'; 

	$trans['show_imdb'] 		= 'Zeige diese IMDb-Seite an!';
	$trans['show_imdbpage'] 	= 'Zeige die IMDb-Seite des Filmes an!';
	$trans['click_imdbpage'] 	= 'Anklicken um die IMDb-Seite des Filmes anzuzeigen!';
	$trans['show_imdbperson'] 	= 'Zeige die IMDb-Seite der Person an!';
	$trans['imdb_rating'] 		= 'Sortiere aufsteigend nach IMDb-Wertungen!';
	$trans['is_available'] 		= 'Sortiere absteigend nach Verf&uuml;gbarkeit!';
	$trans['imdb_poster'] 		= 'Sortiere absteigend nach IMDb-Poster!';
	$trans['available'] 		= 'verf&uuml;gbar';

	$trans['sort_asc'] 		= 'Sortiere die Spalte aufsteigend!';
	$trans['sort_desc'] 	= 'Sortiere die Spalte absteigend!';

	$trans['sort_to_asc'] 	= 'Sortiere aufsteigend!';
	$trans['sort_to_desc'] 	= 'Sortiere absteigend!';

	$trans['show_first'] 	= 'Zeige die ersten ';
	$trans['show_prev'] 	= 'Zeige die vorigen ';
	$trans['x_of_x'] 		= 'von';
	$trans['done']			= 'Fertig';
	$trans['x_all'] 		= 'alle';
	$trans['x_films'] 		= ' Filme an!';
	$trans['show_next'] 	= 'Zeige die n&auml;chsten ';
	$trans['show_last'] 	= 'Zeige die letzten ';

	$trans['the_first'] 	= 'Zeige den ersten ';
	$trans['the_prev'] 		= 'Zeige den vorigen ';
	$trans['x_film'] 		= ' Film an!';
	$trans['the_next'] 		= 'Zeige den n&auml;chsten ';
	$trans['the_last'] 		= 'Zeige den letzten ';

	$trans['search_info'] 	= 'Suche (auf/zuklappen)';
	$trans['search_genres']	= 'In diesen Genres...';
	$trans['search_for']	= '...nach';
	$trans['x_with']		= 'mit';
	$trans['o_all_title']	= '(allen) Titeln';
	$trans['o_all_people']	= '(allen) Personen';
	$trans['o_name']		= '(original) Titeln';
	$trans['o_local']		= '(deutschen) Titeln';
	$trans['o_director'] 	= 'Regieseuren';
	$trans['o_writer'] 		= 'Autoren';
	$trans['o_actor'] 		= 'Darstellern';
	$trans['o_avail'] 		= 'Verf&uuml;gbarkeit';
	$trans['o_rate'] 		= 'IMDb-Wertungen';
	$trans['o_imdb'] 		= 'IMDb-Nummern';
	$trans['o_poster'] 		= 'IMDb-Postern';
	$trans['o_id'] 			= 'ID-Nummern';
	$trans['o_country'] 	= 'Produktionsl&auml;ndern';
	$trans['o_year'] 		= 'Erscheinungsjahr';
	$trans['o_runtime'] 	= 'Filml&auml;nge';
	$trans['o_lang'] 		= 'Sprachen';
	$trans['o_comment']		= 'Kommentaren';
	$trans['o_medium'] 		= 'Medientypen';
	$trans['o_disks'] 		= 'Medienanzahl';
	$trans['o_container'] 	= 'Containern';
	$trans['o_video'] 		= 'Video-Codecs';
	$trans['o_width'] 		= 'Video-Breiten';
	$trans['o_height'] 		= 'Video-H&ouml;hen';
	$trans['o_format'] 		= 'Video-Format';
	$trans['o_ratio'] 		= 'Video-Aspektratio';
	$trans['o_audio'] 		= 'Audio-Codecs';
	$trans['o_channel'] 	= 'Audio-Kan&auml;len';
	$trans['o_herz'] 		= 'Audio-Frequenzen';
	$trans['o_lentto'] 		= 'Film-Entleihern';
	$trans['all_genres']	= 'Alle Genres...';
	$trans['link_on']		= 'An';
	$trans['link_off']		= 'Aus';
	$trans['is_like']		= 'enth&auml;lt';
	$trans['is_equal']		= 'entspricht';
	$trans['full_text']		= 'volltext';
	$trans['do_search']		= 'Suchen';

	$trans['filter_all'] 	= 'Zeige alle Filme an!';
	$trans['filter_0-9'] 	= 'Zeige nur Filme an, deren Titel mit Ziffern beginnen!';
	$trans['filter_a-z'] 	= 'Zeige nur Filme an, deren Titel mit diesem Buchstaben beginnen!';

	$trans['js_title_alert'] 	= 'Bitte geben Sie zuerst den original Titel ein!';
	$trans['js_local_alert'] 	= 'Bitte geben Sie zuerst einen deutschen Titel ein!';
	$trans['js_number_alert'] 	= 'Bitte geben Sie zuerst eine Nummer ein!';
	$trans['js_lang_alert'] 	= 'Bitte geben Sie zuerst eine Sprache an!';
	
// mostly used by "info.php"

	$trans['statistic'] 	= 'Statistik';
	$trans['poster_size']	= 'Poster-Gr&ouml;&szlig;en';
	$trans['blob_size']		= 'Blobs';
	$trans['post_size']		= 'Dateien';
	$trans['db_size'] 		= 'DB-Gr&ouml;&szlig;e';
	$trans['total_films'] 	= 'Filme Total';
	$trans['total_media'] 	= 'Medien Total';
	$trans['total_people'] 	= 'Personen insgesamt';
	$trans['i_writers'] 	= 'Autoren';
	$trans['i_directors'] 	= 'Regisseure';
	$trans['i_actors'] 		= 'Schauspieler';

// used by execute.php

	$trans['b2f_info']		= 'Extrahiere alle Poster-<wbr>Blobs und speichere die Daten als Poster-<wbr>Dateien auf dem Server!';
	$trans['f2b_info']		= 'Extrahiere alle Poster-<wbr>Dateien und speichere die Daten als Poster-<wbr>Blobs in die Datenbank!';
	$trans['b2f_copy']		= 'Kopiere alle Poster-<wbr>Blobs und speichere die Daten als Poster-<wbr>Dateien auf dem Server!';
	$trans['f2b_copy']		= 'Kopiere alle Poster-<wbr>Dateien und speichere die Daten als Poster-<wbr>Blobs in die Datenbank!';
	$trans['blob_del']		= 'Leere alle Poster-<wbr>Blobs in der Datenbank!';
	$trans['file_del']		= 'Entferne alle Poster-<wbr>Dateien auf dem Server!';
	$trans['save_log']		= '<nobr>In Logdatei protokollieren!</nobr>';

// used by editposter.php
	
	$trans['edit_poster'] 	= 'Poster bearbeiten';
/**/$trans['upload_poster'] = 'Bitte w&auml;hlen Sie die Datei (JPG/GIF)<br>des zu importierenden Bildes aus!';
/**/$trans['upload_url']	= 'Bitte w&auml;hlen Sie die URL (JPG/GIF)<br>des zu importierenden Bildes aus!';
	$trans['ep_poster'] 	= 'Poster';
	$trans['ep_file'] 		= 'Datei';
	$trans['ep_url'] 		= 'URL';
	$trans['do_not_store'] 	= 'Kein Poster f&uuml;r diesen Film speichern';
	$trans['do_store'] 		= 'Das Poster f&uuml;r diesen Film speichern';
	$trans['error_info'] 	= 'Folgender Fehler trat auf...';

// used by "askprint.php"

	$trans['print_title'] 	= 'Druckseite erstellen';
	$trans['print_page'] 	= 'Druckseite';
	$trans['print_info'] 	= '<nobr>Es wird eine Seite im eigenen Fenster erzeugt,</nobr><br>die die <b>aktuelle Auflistung</b> der auszudruckenden Filme widerspiegelt.<br>';
	$trans['print_help'] 	= '<nobr>Es wird eine Seite im eigenen Fenster erzeugt,</nobr><br>die die auszudruckenden <b>Dokumentation</b> vollst&auml;ndig  enth&auml;lt.<br>';
	$trans['print_hint'] 	= '<br><small><b>TIPP:</b> Da die aktuellen Browser fast keine der M&ouml;glichkeiten zur Druckaufbereitung von CSS 2.1 unterst&uuml;tzen, sollten Sie solange mit der Druckvorschau experimentieren, bis Ihnen das Ergebnis gef&auml;llt!</small>';

// used by "askprefs.php"

	$trans['prefs_title'] 	= 'Einstellungen';
	$trans['prefs_info'] 	= '<nobr>Was genau m&ouml;chten Sie denn einstellen?</nobr><ul><li><nobr>Die Programmkonfiguration</nobr></li><li><nobr>Die Liste der Entleiher</nobr></li></ul>';
	$trans['admin_info'] 	= 'Der <b>Administrator</b> hat die <b>Berechtigungen</b> zu folgenden Bearbeitungen und Ausf&uuml;hrungen:';
	$trans['l_blob2file']	= 'Extrahiere alle Poster aus der Datenbank und speichere sie auf dem Server!';
	$trans['l_file2blob']	= 'Extrahiere alle Poster vom Server und speichere sie in der Datenbank!';
	$trans['l_copy_b2f']	= 'Kopiere alle Poster von der Datenbank auf den Server!';
	$trans['l_copy_f2b']	= 'Kopiere alle Poster vom Server in die Datenbank!';
	$trans['l_del_blobs']	= '<strong>Leere</strong> alle Poster in der Datenbank!';
	$trans['l_del_files']	= '<strong>L&ouml;sche</strong> alle Poster auf dem Server!';
	$trans['l_bak_dbase']	= 'Sicherungsdatei der Datenbank als ZIP-Archiv speichern!';
	$trans['l_bak_poster']	= 'Sicherungsdatei aller Posterdateien als ZIP-Archiv speichern!';
	$trans['l_res_dbase']	= 'Wiederherstellung der Datenbank mittels Sicherungsdatei!';
	$trans['l_res_poster']	= 'Wiederherstellung der Posterdateien mittels Sicherungsdatei!';
	$trans['l_edit_list']	= 'Bearbeite die Benutzer<wbr>liste';
	$trans['l_edit_config']	= 'Bearbeite die Grund<wbr>konfiguration';
	$trans['l_edit_program']= 'Bearbeite die Programm<wbr>einstellungen';
	$trans['l_edit_borrower']='Bearbeite die Entleiher<wbr>liste';

// used by "askfiles.php"

	$trans['pro_file_size'] = 'Voraussichtliche Dateigr&ouml;&szlig;e';
	$trans['tt_download'] 	= 'Anklicken zum Runterladen!';

// used by "editlent.php"

	$trans['lent_title'] 	= 'Status des Films';

// used by "editprefs.php"

	$trans['t_edit_prefs'] 	= 'Programmeinstellungen';
	$trans['list_height'] 	= 'Listenh&ouml;he';
	$trans['p_language'] 	= 'Sprache';
	$trans['p_fontsize'] 	= 'Schriftgr&ouml;&szlig;e';
	$trans['p_fonttype']	= 'Schrifttype';
	$trans['p_visible'] 	= 'sichtbare Filme';
	$trans['p_requester'] 	= 'in Dialogen';
	$trans['max_value'] 	= 'max. Anzahl';
	$trans['use_progressbar']= '<b>Fortschrittsanzeige</b> benutzen!';
	$trans['use_blobposter']= 'Die <b>Poster</b> werden <b>in der Datenbank</b> als Bin&auml;rdaten <b>abgespeichert</b>!';
	$trans['no_wrapping'] 	= 'Der <b>Titel</b> in der Listenansicht <b>wird nicht</b> automatisch <b>umgebrochen</b>!';
	$trans['both_title'] 	= 'Darstellung von <b>lokal</b>em <b>und original</b>em <b>Titel</b> in der Listenansicht!';
	$trans['no_poster'] 	= 'Ohne <b>Poster</b> in der <b>Listenansicht</b>!';

// used by "editpeople.php"

	$trans['t_edit_people'] = 'Entleiherliste';
	$trans['unnamed'] 		= 'Unbenannt';
	$trans['edit_name'] 	= 'Ausgew&auml;hlten Namen bearbeiten';

// used by "editusers.php"

	$trans['t_edit_users'] 	= 'Benutzerliste';
	$trans['edit_pass'] 	= 'Passwort bearbeiten';
	
// used by "restore.php"

	$trans['restore_dbase'] = '<nobr>Sind Sie wirklich sicher das Sie mittels dieser Sicherungsdatei<br>...die Wiederherstellung der Datenbank veranlassen m&ouml;chten?</nobr><br><small><br></small>';
	$trans['restore_poster']= '<nobr>Sind Sie wirklich sicher das Sie mittels dieser Sicherungsdatei<br>...die Wiederherstellung aller Poster veranlassen m&ouml;chten?</nobr><br><small><br></small>';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Selektiere nach';
	$trans['sort_to'] 	= 'Sortiere nach';
	$trans['search_at'] = 'Suche in';
	$trans['search_for']= 'Suche nach';
	$trans['ascending']	= 'Aufsteigend';
	$trans['descending']= 'Absteigend';
?>