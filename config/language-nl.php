<?php

/* AJAX-FilmDB 1.2.4 (based on php4flicks) */

$conttype = 'text/html; charset=iso-8859-1';
$rsstype  = 'iso-8859-1';
$xmltype  = 'iso-8859-1';
$sqltype  = 'iso-8859-1';

	$trans['rss_title'] 	= 'Toon de 10 nieuwste Films in deze Film Data Base.';

	$trans['page_title'] 	= 'FilmDataBase';
	$trans['work_in_progress'] = 'Werk in Uitvoering...';
	$trans['the_b_list']	= '<strong><big><b>The lijst van leners</b></big></strong>';
	$trans['the_u_list']	= '<strong><big><b>De lijst van Geruikers</b></big></strong>';
	$trans['the_prefs']		= '<strong><big><b>Programma Configuratie</b></big></strong>';
	$trans['the_status']	= '<strong><big><b>De nieuwe Film status</b></big></strong>';
	$trans['the_movie']		= '<strong><big><b>De Film...</b></big></strong><br><small><br></small>';
	$trans['the_file']		= '<strong><big><b>Het Dossier...</b></big></strong><br><small><br></small>';
	$trans['cleared_alert']	= '<br><small><br></small><nobr>...is ontruimd!</nobr>';
	$trans['alert_title']	= '<strong><big><b>Attentie!</b></big></strong><br><small><br></small>';
	$trans['delete_alert'] 	= '<nobr>Weet u zeker dat u dit wilt <br>...de Film verwijderen?</nobr><br><small><br></small>';
	$trans['export_alert'] 	= '<nobr>Weet u zeker dat u dit wilt <br>...het uitvoeren van de Film als XML?</nobr><br><small><br></small>';
	$trans['archive_alert'] = '<nobr>Weet u zeker dat u dit wilt <br>...download dit ZIP Archief?</nobr><br><small><br></small>';
	$trans['import_alert'] 	= '<nobr>Weet u zeker dat u dit wilt <br>...het invoeren van de Film als XML?</nobr><br><small><br></small>';
	$trans['rescan_alert'] 	= '<nobr>Weet u zeker dat u dit wilt <br>...rescan de Film van de IMDb?</nobr><br><small><br></small>';
	$trans['updated_alert']	= '<br><small><br></small><nobr>...is ge&uuml;pdate!</nobr>';
	$trans['multiple_alert']= '<b>De te downloaden affiches werden verspreid op verscheidene ZIP archieven</b>, omdat uw rekening slechts beperkt uploadt dossiergrootte toelaat!';
	$trans['insert_alert']	= '<br><small><br></small><nobr>...is toegevoegd!</nobr>';
	$trans['feature_alert'] = '<nobr>Deze functie is op dit moment <b>niet</b> geïntergreerd!</nobr><br><small><br>Het ingewikkelde programmeren is iets meer werk.</small>';
	$trans['help_alert'] 	= '<nobr>Als de Online-Help mode actief is </nobr><br>kunt u niet in of uitloggen en de database aanpassen!';
	$trans['logging_alert'] = '<nobr>De gebruikersnaam of wachtwoord is onjuist!</nobr><br><small><br>Gebruik de Login-Button (rechtersboven) om het opnieuw te proberen!</small>';
	$trans['login_alert'] 	= '<nobr>U moet ingelogd zijn als een <br>gebruiker om de database aan te passen!</nobr><br><small><br>Gebruik de Login-Button (rechtersboven) om in te loggen!</small>';
	$trans['logout_alert'] 	= '<nobr>U bent nu uitgelogd als geautoriseerde gebruiker!</nobr><br><small><br>Gebruik de Login-Button (rechtersboven) om opnieuw in te loggen!</small>';
	$trans['saved_alert']	= '<br><small><br></small><nobr>...is succesvol weggeschreven!</nobr>';
	$trans['done_alert']	= '<nobr>Met succes verwezenlijkte verrichting.</nobr>';
	$trans['none_alert']	= '<nobr>Wenk: Er zijn te doen niets.</nobr>';
	$trans['fs_alert']		= '<nobr>Ontbroken het systeemtoegang van het dossier!</nobr>';
	$trans['not_saved']		= '<br><small><br></small><nobr>...kan <b>niet</b> weggeschreven worden!</nobr>';
	$trans['not_loaded']	= '<nobr>...kan <b>niet</b> geladen worden!</nobr>';
	$trans['saved_error']	= '<br><small><br></small><nobr>...kan <b>niet</b> weggeschreven worden!</nobr><br><br><small>controlleer of het genoemde bestand de rechten heeft om weggeschreven te worden.</small>';
	$trans['cookie_error']	= '<br><small><br></small><nobr>...kan <b>niet</b> weggeschreven worden!</nobr><br><br><small>Controlleer of de browser cookies accepteerd van deze site.</small>';

	$trans['guru_noscript'] = '<b>Guru Meditation</b> - met deactiveerde JavaScript zal dit AJAX programma niet werken!';
	$trans['guru_noobject'] = '<b>Guru Meditation</b> - Deze Browser ondersteund geen XMLHttpRequest-Object!';
	$trans['guru_mqgpcon'] 	= '<b>Guru Meditation</b> - De PHP configuratie \"magic_quotes_gpc\" moet op \"Off\" staan!';

	$trans['b_edit_list'] 	= 'Gebruikerslijst';
	$trans['b_config'] 		= 'Configuratie';
	$trans['b_edit'] 		= 'Bewerken';
	$trans['b_cancel'] 		= 'Annuleren';
	$trans['b_delete'] 		= 'Verwijderen';
	$trans['b_rescan'] 		= 'Rescan';
	$trans['b_export'] 		= 'Uitvoeren';
	$trans['b_import'] 		= 'Invoeren';
	$trans['b_update'] 		= 'Updaten';
	$trans['b_upload'] 		= 'Upload';
	$trans['b_restore'] 	= 'Herstel';
	$trans['b_clear'] 		= 'Ontruim';
	$trans['b_save'] 		= 'Opslaan';
	$trans['b_save_cookie'] = 'Cookie opslaan';
	$trans['b_showlog'] 	= 'Toon het Logboek';
	$trans['b_insert'] 		= 'Toevoegen';
	$trans['b_search'] 		= 'Zoeken';
	$trans['b_print'] 		= 'Afdrukken';
	$trans['b_program'] 	= 'Programma';
	$trans['b_borrower'] 	= 'Lener';
	$trans['b_add_person'] 	= 'Nieuwe Lener toevoegen';
	$trans['b_back'] 		= 'Terug';
	$trans['b_start']		= 'Begin';
	$trans['b_ok'] 			= 'OK';
	
	$trans['DE'] 			= 'Duits';
	$trans['EN'] 			= 'Engels';
	$trans['NL'] 			= 'Nederlands';
	$trans['ES'] 			= 'Spaans';
	$trans['FR'] 			= 'Frans';
	$trans['IT'] 			= 'Italiaans';
	$trans['RU'] 			= 'Russisch';
	$trans['TR'] 			= 'Turks';
	$trans['?'] 			= 'Onbekend';
	
	$trans['1.0'] 			= 'mono';
	$trans['1/1'] 			= 'mono (dual language)';
	$trans['2.0'] 			= 'stereo';
	$trans['2.1'] 			= 'stereo & subwoofer';
	$trans['3.0'] 			= 'stereo & center';
	$trans['3.1'] 			= 'stereo & center & subwoofer';
	$trans['4.0'] 			= 'quatro';
	$trans['5.1'] 			= '5 kanaals surround';
	$trans['6.1'] 			= '6 kanaals surround';
	$trans['7.1'] 			= '7 kanaals surround';
	
	$trans['01'] 			= 'Jan';
	$trans['02'] 			= 'Feb';
	$trans['03'] 			= 'Mar';
	$trans['04'] 			= 'Apr';
	$trans['05'] 			= 'Mei';
	$trans['06'] 			= 'Jun';
	$trans['07'] 			= 'Jul';
	$trans['08'] 			= 'Aug';
	$trans['09'] 			= 'Sep';
	$trans['10'] 			= 'Okt';
	$trans['11'] 			= 'Nov';
	$trans['12'] 			= 'Dec';

// used for "LC-Display"

	$trans['login_user'] 	= 'ingeloggde Gebruiker';
	$trans['user_mode'] 	= 'Gebruikers Mode';
	$trans['edit_mode'] 	= 'Bewerk';
	$trans['add_mode'] 		= 'Voeg toe';
	$trans['help_mode'] 	= 'Help';

// used by "login.php"

	$trans['log_user'] 		= 'Gebruikersnaam';
	$trans['log_pw'] 		= 'Wachtwoord';
	$trans['log_title'] 	= 'Login';
	
// mostly used by "add.php"

	$trans['add_title'] 	= 'Film toevoegen';
	$trans['add_info'] 		= 'Vul de (orginele) titel van <br>de film die u wilt toevoegen!';
	$trans['add_results'] 	= 'De volgende films zijn gevonden bij het IMDb...';
	$trans['add_search_error']	= 'Fout tijdens het zoeken naar de titel!';
	$trans['js_enter_title'] 	= 'Eerst de titel invoeren, Alstublieft!';
	$trans['js_enter_file'] 	= 'Eerst het Dossier selecteren, Alstublieft!';
	$trans['js_enter_url']		= 'Eerst de URL invoeren, Alstublieft!';
	$trans['js_enter_pattern'] 	= 'Gelieve te selecteren een dossier dat aan het patroon beantwoordt!';
	$trans['nothing_found']		= 'Sorry - niets gevonden!';

// used by "importfilm.php"

	$trans['import_title'] 	= 'Film invoeren';
	$trans['import_info'] 	= 'Gelieve te selecteren het Dossier<br>(XML) van de film u wilt invoeren!';

// used by "importcheck.php"

	$trans['file_date'] 	= 'Dossier-Datum';
	$trans['file_type'] 	= 'Dossier-Format';
	$trans['file_size'] 	= 'Dossier-Grootte';

// used by "importfile.php" 

	$trans['import_file'] 	= 'Het Reservearchief van de lading';
	$trans['select_dbase'] 	= 'Gelieve te selecteren een dossier van dit patroon:<br>"filmdb_dbase_DATE-TIME.zip"';
	$trans['select_poster'] = 'Gelieve te selecteren een dossier van dit patroon:<br>"filmdb_poster_DATE-TIME.zip"';

// used by "exportfilm.php"

	$trans['dtd_internal'] 	= 'interne DTD verwijzing';
	$trans['dtd_external'] 	= 'externe DTD verwijzing';
	$trans['dtd_none'] 		= 'zonder DTD verwijzing';

// used by "upload.php"

	$trans['0'] 			= 'Het bestand is succesvol ge&uuml;pload';
	$trans['1'] 			= 'Het bestand dat ge&uuml;pload wordt overschreid de upload_max_filesize richtlijn in php.ini';
	$trans['2'] 			= 'Het bestand dat ge&uuml;pload wordt overschreid de MAX_FILE_SIZE richtlijn die gespecificeerd is in het HTML formulier';
	$trans['3'] 			= 'Het bestand dat ge&uuml;pload wordt is deels geüpload';
	$trans['4'] 			= 'Geen bestand ge&uuml;pload';
	$trans['5'] 			= 'Onbekende fout tijdens het uploaden';
	$trans['6'] 			= 'Tijdelijke folder ontbreekt';
	$trans['7'] 			= 'Bestand naar schijf schrijven mislukt';
	$trans['90'] 			= 'Het bestand dat ge&uuml;pload wordt staat in het verkeerde formaat (geen GIF/JPG)';
	$trans['91'] 			= 'Het bestand dat ge&uuml;pload wordt staat in het verkeerde formaat (geen XML)';
	$trans['92'] 			= 'Het bestand dat ge&uuml;pload wordt is kleiner dan de MIN_FILE_SIZE richtlijn (1000 bytes)';
	$trans['93'] 			= 'Het inlezen van bestand dat ge&uuml;pload wordt is mislukt';
	$trans['94'] 			= 'Het verplaatsen van bestand dat ge&uuml;pload wordt is mislukt';	$trans['95'] 			= 'Het bestand dat ge&uuml;pload wordt is van een ander formaat (geen AJAX-FilmDB)';	$trans['96'] 			= 'Het bestand dat ge&uuml;pload wordt heeft geen  film id (geen IMDb-ID)';	$trans['97'] 			= 'De film die ge&uuml;pload wordt bestaat al in de database';
	$trans['98'] 			= 'Het bestand dat ge&uuml;pload wordt overschreid de  MAX_FILE_SIZE richtlijn';
	$trans['99'] 			= 'Het aan-uploadt dossier is van het verkeerde dossierformaat (niet ZIP)'; 

// used by "getperson.php"

	$trans['show_people'] 	= 'De volgende personen zijn gevonden bij het IMDb...';
	$trans['show_person'] 	= 'De volgende persoon is gevonden bij het IMDb...';

// mostly used by "index.php"

	$trans['film_view'] 	= 'Film weergave';
	$trans['row_view'] 		= 'Rij weergave';
	$trans['poster_view'] 	= 'Poster weergave';
	$trans['list_view'] 	= 'Lijst weergave';
	$trans['version'] 		= 'Versie';
	$trans['ajax'] 			= 'AJAX Implementatie en basis Condities';
	$trans['about'] 		= 'Copyright Informatie';
	$trans['add_film'] 		= 'nieuwe film toevoegen';
	$trans['import_film'] 	= 'voer een film in';
	$trans['edit_prefs'] 	= 'voorkeuren';
	$trans['search_dbase'] 	= 'complex zoeken';
	$trans['print_dbase'] 	= 'DataBase afdrukken';
	$trans['db_info'] 		= 'DataBase Info';
	$trans['prog_help'] 	= 'Online-Help';
	$trans['log_in'] 		= 'Login';
	$trans['log_out'] 		= 'Log uit';
	$trans['log_file'] 		= 'Logboek dossier';

// mostly used by "list.php" and "filmform.php"

	$trans['t_no'] 			= 'no.';
	$trans['t_number'] 		= 'no';
	$trans['t_title'] 		= 'Titel';
	$trans['t_original']	= '(origineel)';
	$trans['t_local'] 		= '(engels)';
	$trans['t_alias'] 		= '(ook bekend als)';
	$trans['t_filminfo'] 	= 'film info';
	$trans['t_filmposter'] 	= 'film poster';
	$trans['t_category'] 	= 'categorie&euml;n';
	$trans['t_director'] 	= 'regiseur';
	$trans['t_writer'] 		= 'schrijvers';
	$trans['t_actor'] 		= 'acteurs';
	$trans['t_comment'] 	= 'commentaar';
	$trans['t_format'] 		= 'tv-format';
	$trans['t_date'] 		= 'toegevoegde';
	$trans['t_since'] 		= 'datum';
	$trans['t_ratio'] 		= 'beeld verhouding';
	$trans['t_rating'] 		= 'oordeel';
	$trans['t_language'] 	= 'talen';
	$trans['t_languages'] 	= 'taal';
	$trans['t_audio'] 		= 'geluid';
	$trans['t_video'] 		= 'video';
	$trans['t_datatype'] 	= 'formaat';
	$trans['t_container'] 	= 'container';
	$trans['t_country'] 	= 'land';
	$trans['t_countries'] 	= 'landen van productie';
	$trans['t_lent'] 		= 'uitgeleend';
	$trans['t_to'] 			= 'aan';
	$trans['t_at'] 			= 'op';
	$trans['t_year'] 		= 'jaar';
	$trans['t_runtime'] 	= 'duur';
	$trans['t_minutes'] 	= 'min';
	$trans['t_medium'] 		= 'medium';
	$trans['t_imdb'] 		= 'IMDb';
	$trans['t_poster'] 		= 'poster';
	$trans['t_film'] 		= 'film';

	$trans['click_to_edit'] = 'Klik om te bewerken...';
	$trans['no_matches'] 	= '...geen gelijken...';
	$trans['is_equal_to'] 	= '1=waar/ja/aan - 0=onwaar/nee/uit';

	$trans['show_moviedata'] 	= 'Toon alle waarden van de film!';
	$trans['edit_moviedata'] 	= 'Bewerk deze Film!';
	$trans['show_movieinfo'] 	= 'Toon alle waarden van de film!'; 
	$trans['close_movieinfo'] 	= 'Sluit Infobox'; 
	$trans['export_moviedata'] 	= 'Voer deze Film uit!'; 
	
	$trans['show_imdb'] 		= 'Toon deze IMDb-Pagina!';
	$trans['show_imdbpage'] 	= 'Toon de IMDb-Pagina van deze Film!';
	$trans['click_imdbpage'] 	= 'Klik om de IMDb-Page te tonen van deze Film!';
	$trans['show_imdbperson'] 	= 'Toon de IMDb-Page van deze Persoon!';
	$trans['imdb_rating'] 		= 'Sorteer oplopend op IMDb-Rating!';
	$trans['is_available'] 		= 'Sorteer aflopend op beschikbaarheid!';
	$trans['imdb_poster'] 		= 'Sorteer aflopend op IMDb-Poster!';
	$trans['available'] 		= 'beschikbaar';
	
	$trans['sort_asc'] 		= 'Sorteer de kolom oplopend!';
	$trans['sort_desc'] 	= 'Sorteer de kolom aflopend!';

	$trans['sort_to_asc'] 	= 'Sorteer oplopend!';
	$trans['sort_to_desc'] 	= 'Sorteer aflopend!';

	$trans['show_first'] 	= 'Toon de eerste ';
	$trans['show_prev'] 	= 'Toon de vorige ';
	$trans['x_of_x'] 		= 'van';
	$trans['done']			= 'Gedaan';
	$trans['x_all'] 		= 'alle';
	$trans['x_films'] 		= ' Films!';
	$trans['show_next'] 	= 'Toon de volgende ';
	$trans['show_last'] 	= 'Toon de laaste ';

	$trans['the_first'] 	= 'Toon de eerste ';
	$trans['the_prev'] 		= 'Toon de laatste ';
	$trans['x_film'] 		= ' Film!';
	$trans['the_next'] 		= 'Toon de volgende ';
	$trans['the_last'] 		= 'Toon de laaste ';

	$trans['search_info'] 	= 'Zoek (pop aan/uit)';
	$trans['search_genres']	= 'Zoek in deze Categori&euml;n...';
	$trans['search_for']	= '...voor';
	$trans['x_with']		= 'met';
	$trans['o_all_title']	= '(alle) Titels';
	$trans['o_all_people']	= '(all) Personen';
	$trans['o_name']		= '(originele) Titels';
	$trans['o_local']		= '(engelse) Titels';
	$trans['o_director'] 	= 'Regiseurs';
	$trans['o_writer'] 		= 'Schrijvers';
	$trans['o_actor'] 		= 'Acteurs';
	$trans['o_avail'] 		= 'Beschikbaarheid';
	$trans['o_rate'] 		= 'IMDb-Ratings';
	$trans['o_imdb'] 		= 'IMDb-Nummers';
	$trans['o_poster'] 		= 'IMDb-Posters';
	$trans['o_id'] 			= 'ID-Numbers';
	$trans['o_country'] 	= 'Productie Landen';
	$trans['o_year'] 		= 'Jaar van Productie';
	$trans['o_runtime'] 	= 'Looptijd';
	$trans['o_lang'] 		= 'Talen';
	$trans['o_medium'] 		= 'Mediatypes';
	$trans['o_comment']		= 'Commentaren';
	$trans['o_medium'] 		= 'Mediatypes';
	$trans['o_disks'] 		= 'Mediacount';
	$trans['o_container'] 	= 'Containers';
	$trans['o_video'] 		= 'Video-Codecs';
	$trans['o_width'] 		= 'Video-Breedte';
	$trans['o_height'] 		= 'Video-Hoogte';
	$trans['o_format'] 		= 'Video-Formaat';
	$trans['o_ratio'] 		= 'Video-Aspectverhouding';
	$trans['o_audio'] 		= 'Audio-Codecs';
	$trans['o_channel'] 	= 'Audio-Kanalen';
	$trans['o_herz'] 		= 'Audio-Frequenties';
	$trans['o_lentto'] 		= 'Film-leners';
	$trans['all_genres']	= 'Alle Categori&euml;n...';
	$trans['link_on']		= 'Aan';
	$trans['link_off']		= 'Uit';
	$trans['is_like']		= 'is als';
	$trans['is_equal']		= 'is gelijk aan';
	$trans['full_text']		= 'fulltext';
	$trans['do_search']		= 'Zoek';

	$trans['filter_all'] 	= 'Toon alle Films!';
	$trans['filter_0-9'] 	= 'Toon alleen de films die met een cijfer beginnen!';
	$trans['filter_a-z'] 	= 'Toon alleen de films die met een teken beginnen!';

	$trans['js_title_alert'] 	= 'Voer eerst de orginele titel in!';
	$trans['js_local_alert'] 	= 'Voor eerst de Engelse titel in!';
	$trans['js_number_alert'] 	= 'Voer eerst een nummer in!';
	$trans['js_lang_alert'] 	= 'Geef eerst een taal op!';

// used by "info.php"

	$trans['statistic'] 	= 'Statistieken';
	$trans['poster_size']	= 'Affiche-Grootte';
	$trans['blob_size']		= 'Blobs';
	$trans['post_size']		= 'Dossiers';
	$trans['db_size'] 		= 'DB-Grootte';
	$trans['total_films'] 	= 'totale aantal films';
	$trans['total_media'] 	= 'totale aantal media';
	$trans['total_people'] 	= 'Personen totaal';
	$trans['i_writers'] 	= 'Schrijvers';
	$trans['i_directors'] 	= 'Regiseurs';
	$trans['i_actors'] 		= 'Acteurs';

// used by execute.php

	$trans['b2f_info']		= 'Haal alle afficheblobs en sla gegevens als affichedossiers aan op server!';
	$trans['f2b_info']		= 'Haal alle affichedossiers en sla gegevens als afficheblobs aan op database!';
	$trans['b2f_copy']		= 'Kopi&euml;er alle afficheblobs en sla gegevens als affichedossiers aan op server!';
	$trans['f2b_copy']		= 'Kopi&euml;er alle affichedossiers en sla gegevens als afficheblobs aan op database!';
	$trans['blob_del']		= 'Ontruim alle afficheblobs in het gegevensbestand!';
	$trans['file_del']		= 'Schrap alle affichedossiers op de server!';
	$trans['save_log']		= '<nobr>Schrijf in het dossier van het Logboek!</nobr>';
	
// used by editposter.php

	$trans['edit_poster'] 	= 'Bewerk Poster';
	$trans['upload_poster'] = 'Gelieve te selecteren het Dossie (JPG<br>/GIF) van het Beeld u wilt invoeren!';
	$trans['upload_url']	= 'Vul de URL (JPG/GIF) van<br>het Beeld u wilt invoeren!';
	$trans['ep_poster'] 	= 'Poster';
	$trans['ep_file'] 		= 'Bestand';
	$trans['ep_url'] 		= 'URL';
	$trans['do_not_store'] 	= 'Sla de Poster van deze film niet op';
	$trans['do_store'] 		= 'Sla de Poster op van deze film';
	$trans['error_info'] 	= 'De volgende fout is ontstaan...';

// used by "askprint.php"

	$trans['print_title'] 	= 'Genereer Printerpagina';
	$trans['print_page'] 	= 'Printerpagina';
	$trans['print_info'] 	= '<nobr>Een pagina in zijn eigen scherm is opgemaakt,</nobr><br>die geeft de <b>huidige lijst</b> aan van de films die uitgeprint zouden moeten worden.<br>';
	$trans['print_help'] 	= '<nobr>Een pagina in zijn eigen scherm is opgemaakt,</nobr><br>die geeft de <b>gehele hulpdocumenten</b>aan die uitgeprint zouden moeten worden.<br>';
	$trans['print_hint'] 	= '<br><small><b>HINT:</b> Sinds de huidige browswer één van de mogelijkheden van de css 2.1 voor afdruk bewerkingen zo goed als ondersteund, kunt u hiermee experimenteren met het afdruk voorbeeld tot u tevreden bent met de afdruk!</small>';

// used by "askprefs.php"

	$trans['prefs_title'] 	= 'Voorkeuren';
	$trans['prefs_info'] 	= '<nobr>Selecteer wat u wilt bewerken, alstublieft!</nobr><ul><li><nobr>De Programma Configuratie</nobr></li><li><nobr>De Lijst van Leners</nobr></li></ul>';
	$trans['admin_info'] 	= 'Alleen de <b>Administrator</b> krijgt de <b>Autorisaties</b> voor de volgende Manipulaties en de Uitvoeringen:';
	$trans['l_blob2file']	= 'Haal alle Affiches uit Gegevens<wbr>bestand en spaar aan Server!';
	$trans['l_file2blob']	= 'Haal alle Affiches uit Server en spaar aan Gegevens<wbr>bestand!';
	$trans['l_copy_b2f']	= 'Kopi&euml;er alle Affiches van Gegevens<wbr>bestand aan Server!';
	$trans['l_copy_f2b']	= 'Kopi&euml;er alle Affiches van Server aan Gegevens<wbr>bestand!';
	$trans['l_del_blobs']	= '<strong>Ontruim</strong> alle Affiches in het Gegevensbestand!';
	$trans['l_del_files']	= '<strong>Schrap</strong> alle Affiches op de Server!';
	$trans['l_bak_dbase']	= 'Cre&euml;er Reserve zip van de gehele DataBase als SQL!';
	$trans['l_bak_poster']	= 'Cre&euml;er Reserve zip van de dossiers van de Affiche op Server!';
	$trans['l_res_dbase']	= 'Herstel gehele DataBase van Reserve zip!';
	$trans['l_res_poster']	= 'Herstel Affiches op Server van Reserve zip!';
	$trans['l_edit_list']	= 'Geef Lijst van Gebruikers uit';
	$trans['l_edit_config']	= 'Geef basis<wbr>configuratie uit';
	$trans['l_edit_program']= 'Geef programma<wbr>configuratie uit';
	$trans['l_edit_borrower']='Geef Lijst van Lener uit';
	
// used by "askfiles.php"

	$trans['pro_file_size'] = 'Prospectieve Dossiergrootte';
	$trans['tt_download'] 	= 'Klik aan download!';
	
// used by "editlent.php"

	$trans['lent_title'] 	= 'Film status';
	
// used by "editprefs.php"

	$trans['t_edit_prefs'] 	= 'Programma Configuraties';
	$trans['list_height'] 	= 'Listhoogte';
	$trans['p_language'] 	= 'Taal';
	$trans['p_fonttype']	= 'Font Type';
	$trans['p_fontsize'] 	= 'Font Grootte';
	$trans['p_visible'] 	= 'zichtbare films';
	$trans['p_requester'] 	= 'van verzoeken';
	$trans['max_value'] 	= 'max. waarde';
	$trans['use_progressbar']= 'Gebruik de <b>Progress Indicator</b>!';
	$trans['use_blobposter']= 'De <b>Affiches</b> zullen in het gegevensbestand <b>als binaire</b> worden <b>opgeslagen</b>!';
	$trans['no_wrapping'] 	= '<b>Titel</b> in Lijst-weergave lopen <b>niet</b> automatisch terug!';
	$trans['both_title'] 	= 'Toon <b>engelse en originele Titel</b> in lijst-weergave!';
	$trans['no_poster'] 	= 'zonder <b>Posters</b> in de <b>Lijst-weergave</b>!';

// used by "editpeople.php"

	$trans['t_edit_people'] = 'Lijst van leners';
	$trans['unnamed'] 		= 'naamloze';
	$trans['edit_name'] 	= 'bewerk de geslecteerde naam';

// used by "editusers.php"

	$trans['t_edit_users'] 	= 'Lijst van gebruikers';
	$trans['edit_pass'] 	= 'bewerk wachtwoord';

// used by "restore.php"

	$trans['restore_dbase'] = '<nobr>Weet u zeker dat u dit wilt herstel<br>...het gegevensbestand door dit reservedossier?</nobr><br><small><br></small>';
	$trans['restore_poster']= '<nobr>Weet u zeker dat u dit wilt herstel<br>...de affichefolder door dit reservedossier?</nobr><br><small><br></small>';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Select by';
	$trans['sort_to'] 	= 'Sort to';
	$trans['search_at'] = 'Search at';
	$trans['search_for']= 'Search for';
	$trans['ascending']	= 'Oplopend';
	$trans['descending']= 'Aflopend';
?>
