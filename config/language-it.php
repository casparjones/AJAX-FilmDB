<?php

/* AJAX-FilmDB 1.2.4 (based on php4flicks) */
/* Translate by tuxinside (Simone Giusti). 24/09/2007. */
/* Some phrases are not translate in optimal way, these are evidenced in file by a comment '???'. */

$conttype = 'text/html; charset=iso-8859-1';
$rsstype  = 'iso-8859-1';
$xmltype  = 'iso-8859-1';
$sqltype  = 'iso-8859-1';

	$trans['rss_title'] 	= 'Ultimi 10 film inseriti nel DataBase.';
	$trans['page_title'] 	= 'Film DataBase';
	$trans['work_in_progress'] = 'Attendi...';
	$trans['the_b_list']	= '<strong><big><b>Lista dei Prestiti</b></big></strong>';
	$trans['the_u_list']	= '<strong><big><b>Lista degli Utenti</b></big></strong>';
	$trans['the_prefs']		= '<strong><big><b>Configurazione del programma</b></big></strong>';
	$trans['the_status']	= '<strong><big><b>Stato dei nuovi Film</b></big></strong>';
	$trans['the_movie']		= '<strong><big><b>Film...</b></big></strong><br><small><br></small>';
	$trans['the_file']		= '<strong><big><b>File...</b></big></strong><br><small><br></small>';

	
	$trans['cleared_alert']	= '<br><small><br></small><nobr>...è stato cancellato!</nobr>';
	$trans['alert_title']	= '<strong><big><b>Attenzione!</b></big></strong><br><small><br></small>';
	$trans['delete_alert'] 	= '<nobr>Sei veramente sicuro di voler <br>...cancellare questo Film?</nobr><br><small><br></small>';
	$trans['archive_alert'] = '<nobr>Sei veramente sicuro di voler <br>...scaricare questo archivio ZIO?</nobr><br><small><br></small>';
	$trans['rescan_alert'] 	= '<nobr>Sei veramente sicuro di voler <br>...ricontrollare il film in IMDb?</nobr><br><small><br></small>';
	$trans['export_alert'] 	= '<nobr>Sei veramente sicuro di voler <br>...esportare questo film come XML?</nobr><br><small><br></small>';
	$trans['import_alert'] 	= '<nobr>Sei veramente sicuro di voler <br>...importare questo film come XML?</nobr><br><small><br></small>';

	$trans['updated_alert']	= '<br><small><br></small><nobr>...è stato aggiornato!</nobr>';
	$trans['multiple_alert']= '<b>Il poster da scaricare è distribuito su più archivi ZIP</b>, poichè il tuo account permette solo una dimensione di upload limitata!'; /*???*/
	$trans['insert_alert']	= '<br><small><br></small><nobr>...è stato inserito!</nobr>';
	$trans['feature_alert'] = '<nobr>Questa funzione non è <b>not</b> implementata al momento!</nobr><br><small><br>Il codice più complesso richiede più lavoro.</small>';
	$trans['help_alert'] 	= '<nobr>Se stai visualizzando l\'Help </nobr><br>non puoi eseguire login o logout e non puoi modificare il DataBase!';
	$trans['logging_alert'] = '<nobr>Username o password errati!</nobr><br><small><br>Usa il pulsante a forma di lucchetto in alto sulla destra per provare di nuovo!</small>';
	$trans['login_alert'] 	= '<nobr>Devi essere loggato come<br> amministratore per modificare il Database!</nobr><br><small><br>Usa il pulsante a forma di lucchetto in alto a destra per provare di nuovo</small>';

$trans['logout_alert'] 	= '<nobr>Hai eseguito il logout da amministratore!</nobr><br><small><br>Usa il pulsante a forma di lucchetto per connetterti di nuovo!</small>';
	$trans['done_alert']	= '<nobr>Operazione conclusa con successo.</nobr>';
	$trans['none_alert']	= '<nobr>Suggerimento: non c\'era niente da fare.</nobr>'; /*???*/
	$trans['fs_alert']		= '<nobr>Accesso al file system fallito!</nobr>';


	$trans['saved_alert']	= '<br><small><br></small><nobr>...è stato salvato correttamente!</nobr>';
	$trans['not_saved']		= '<br><small><br></small><nobr>...Impossibile<b>not</b> salvare!</nobr>';
	$trans['not_loaded']	= '<nobr>...Impossibile<b>not</b> caricare!</nobr>';
	$trans['saved_error']	= '<br><small><br></small><nobr>...Impossibile <b>not</b> salvare!</nobr><br><br><small>Controlla se il file ha i permessi per essere scritto.</small>';
	$trans['cookie_error']	= '<br><small><br></small><nobr>...Impossibile <b>not</b> salvare!</nobr><br><br><small>Controlla se il tuo Browser accetta i cookies da questo URL.</small>';

	$trans['guru_noscript'] = '<b>Guru Meditation</b> - Disattivando i JavaScript queso programma non può funzionare!';
	$trans['guru_noobject'] = '<b>Guru Meditation</b> - Il Browser non supporta l\'XMLHttpRequest-Object!';
	$trans['guru_mqgpcon'] 	= '<b>Guru Meditation</b> - La configurazione PHP \"magic_quotes_gpc\" deve essere impostata a \"Off\"!';

	$trans['b_edit_list'] 	= 'Lista degli Utenti';
	$trans['b_config'] 		= 'Configuration';
	$trans['b_edit'] 		= 'Modifica';
	$trans['b_cancel'] 		= 'Annulla';
	$trans['b_delete'] 		= 'Cancella';
	$trans['b_update'] 		= 'Aggiorna';
	$trans['b_upload'] 		= 'Upload';
	$trans['b_restore'] 	= 'Reimposta';
	$trans['b_rescan'] 		= 'Ricontrolla';
	$trans['b_export'] 		= 'Esporta';
	$trans['b_import'] 		= 'Importa';
	$trans['b_clear'] 		= 'Pulisci';
	$trans['b_save'] 		= 'Salva';
	$trans['b_save_cookie'] = 'Salva i cookie';
	$trans['b_showlog'] 	= 'Visualizza i file di log';
	$trans['b_insert'] 		= 'Inserisci';
	$trans['b_search'] 		= 'Ricerca';
	$trans['b_print'] 		= 'Stampa';
	$trans['b_program'] 	= 'Programma';
	$trans['b_borrower'] 	= 'Prestiti';
	$trans['b_add_person'] 	= 'aggiungi nuovo Prestito';
	$trans['b_back'] 		= 'indietro';
	$trans['b_start']		= 'Start';
	$trans['b_ok'] 			= 'OK';
	
	$trans['DE'] 			= 'tedesco';
	$trans['EN'] 			= 'inglese';
	$trans['NL'] 			= 'olandese';
	$trans['ES'] 			= 'spagnolo';
	$trans['FR'] 			= 'francese';
	$trans['IT'] 			= 'italiano';
	$trans['RU'] 			= 'russo';
	$trans['TR'] 			= 'turco';
	$trans['?'] 			= 'sconosciuto';
	
	$trans['1.0'] 			= 'mono';
	$trans['1/1'] 			= 'mono (doppia lingua)';
	$trans['2.0'] 			= 'stereo';
	$trans['2.1'] 			= 'stereo & subwoofer';
	$trans['3.0'] 			= 'stereo & center';
	$trans['3.1'] 			= 'stereo & center & subwoofer';
	$trans['4.0'] 			= 'quattro';
	$trans['5.1'] 			= '5 canali surround';
	$trans['6.1'] 			= '6 canali surround';
	$trans['7.1'] 			= '7 canali surround';
	
	$trans['01'] 			= 'Gen';
	$trans['02'] 			= 'Feb';
	$trans['03'] 			= 'Mar';
	$trans['04'] 			= 'Apr';
	$trans['05'] 			= 'Mag';
	$trans['06'] 			= 'Giu';
	$trans['07'] 			= 'Lug';
	$trans['08'] 			= 'Ago';
	$trans['09'] 			= 'Set';
	$trans['10'] 			= 'Ott';
	$trans['11'] 			= 'Nov';
	$trans['12'] 			= 'Dic';

// used for "LC-Display"

	$trans['login_user'] 	= 'User loggato';
	$trans['user_mode'] 	= 'Modalita Utente';
	$trans['edit_mode'] 	= 'MODIFICA';
	$trans['add_mode'] 		= 'AGGIUNGI';
	$trans['help_mode'] 	= 'HELP';

// used by "login.php"

	$trans['log_user'] 		= 'Username';
	$trans['log_pw'] 		= 'Password';
	$trans['log_title'] 	= 'Login';
	
// mostly used by "add.php"

	$trans['add_title'] 	= 'Aggiungi Film';
	$trans['add_info'] 		= 'Digita il titolo (originale) del <br>Film che vuoi inserire!';
	$trans['add_results'] 	= 'Trovato il seguente Film in IMDb...';
	$trans['add_search_error']	= 'Si è verificato un errore nella ricerca del titolo!';
	$trans['js_enter_title'] 	= 'Inserisci il titolo prima!';
	$trans['js_enter_file'] 	= 'Seleziona un file prima!';
	$trans['js_enter_url']		= 'Inserisci un URL prima!';
	$trans['js_enter_pattern'] 	= 'Seleziona un file che corrisponda al pattern!';
	$trans['nothing_found']		= 'Spiacente - non trovato!';

// used by "importfilm.php"

	$trans['import_title'] 	= 'Importa Film';
	$trans['import_info'] 	= 'Seleziona il file (XML) del<br>Film che vuoi importare!';

// used by "importfile.php" 

	$trans['import_file'] 	= 'Carica l\'Archivio di Backup';
	$trans['select_dbase'] 	= 'Seleziona un file di questo sample:<br>\"filmdb_dbase_DATE-TIME.zip\"';
	$trans['select_poster'] = 'Seleziona un file di questo  sample:<br>\"filmdb_poster_DATE-TIME.zip\"';

// used by "exportfilm.php"

	$trans['dtd_internal'] 	= 'riferimento DTD interno' ;
	$trans['dtd_external'] 	= 'riferimento DTD esterno';
	$trans['dtd_none'] 		= 'senza riferimento DTD';

// used by "importcheck.php"

	$trans['file_date'] 	= 'Data del File';
	$trans['file_type'] 	= 'Tipo di File';
	$trans['file_size'] 	= 'Dimensione del File';
	
// used by "upload.php"

	$trans['0'] 			= 'Upload eseguito con successo';
	$trans['1'] 			= 'Il file caricato non rispetta la direttiva upload_max_filesize in php.ini';
	$trans['2'] 			= 'Il file caricato non rispetta la direttiva MAX_FILE_SIZE specificata nel form HTML';
	$trans['3'] 			= 'L\'Upload del file è stato eseguito parzialmente';
	$trans['4'] 			= 'Nessun file caricato';
	$trans['5'] 			= 'Errore sconosciuto durante l\' upload';
	$trans['6'] 			= 'Manca una directory temporanea';
	$trans['7'] 			= 'Scrittura del file su disco fallita';
	$trans['90'] 			= 'Il file caricato è in un formato errato (non GIF/JPG)';
	$trans['91'] 			= 'Il file caricato è in un formato errato (non XML)';
	$trans['92'] 			= 'Il file caricato non rispetta la direttiva MIN_FILE_SIZE (1000 bytes)';
	$trans['93'] 			= 'Impossibile leggere il file caricato';
	$trans['94'] 			= 'Impossibile muovere il file caricato';
	$trans['95'] 			= 'Il file caricato era errato (non AJAX-FilmDB)';
	$trans['96'] 			= 'In file caricato non contiene id (non IMDb-ID)';
	$trans['97'] 			= 'Il film caricato è gia presente nel Database';
	$trans['98'] 			= 'Il file caricato non rispetta la direttiva MAX_FILE_SIZE';
	$trans['99'] 			= 'Il file da caricare è in un formato non valido (non ZIP)'; 

// used by "getperson.php"

	$trans['show_people'] 	= 'Trovata la seguente Persona in IMDb...';
	$trans['show_person'] 	= 'Trovata la Persona specificata in IMDb...';

// mostly used by "index.php"

	$trans['film_view'] 	= 'Film';
	$trans['row_view'] 		= 'Righe';
	$trans['poster_view'] 	= 'Poster';
	$trans['list_view'] 	= 'Lista';
	$trans['version'] 		= 'Versione';
	$trans['ajax'] 			= 'Implementazione AJAX e COndizioni base';
	$trans['about'] 		= 'Informazioni sul Copyright';
	$trans['add_film'] 		= 'aggiungi un nuovo Film';
	$trans['import_film'] 	= 'importa un Film';
	$trans['edit_prefs'] 	= 'preferenze';
	$trans['search_dbase'] 	= 'Ricerca avanzata';
	$trans['print_dbase'] 	= 'stampa DataBase';
	$trans['db_info'] 		= 'Informazioi sul DataBase';
	$trans['prog_help'] 	= 'Help in linea';
	$trans['log_in'] 		= 'Login';
	$trans['log_out'] 		= 'Logout';
	$trans['log_file'] 		= 'Log file';

// mostly used by "list.php" and "filmform.php"

	$trans['t_no'] 			= 'no.';
	$trans['t_number'] 		= 'id';
	$trans['t_title'] 		= 'Titolo';
	$trans['t_original']	= '(originale)';
	$trans['t_local'] 		= '(italiano)';
	$trans['t_alias'] 		= '(a.k.a.)';
	$trans['t_filminfo'] 	= 'info';
	$trans['t_filmposter'] 	= 'poster';
	$trans['t_category'] 	= 'categorie';
	$trans['t_director'] 	= 'regista';
	$trans['t_writer'] 		= 'sceneggiatura';
	$trans['t_actor'] 		= 'attori';
	$trans['t_comment'] 	= 'commento';
	$trans['t_format'] 		= 'formato-tv';
	$trans['t_date'] 		= 'inserito';
	$trans['t_since'] 		= 'data';
	$trans['t_ratio'] 		= 'dimensioni';
	$trans['t_rating'] 		= 'punteggio';
	$trans['t_language'] 	= 'lingue';
	$trans['t_languages'] 	= 'ling.';
	$trans['t_audio'] 		= 'audio';
	$trans['t_video'] 		= 'video';
	$trans['t_datatype'] 	= 'formato';
	$trans['t_container'] 	= 'contenitore';
	$trans['t_country'] 	= 'paese';
	$trans['t_countries'] 	= 'paese di produzione';
	$trans['t_lent'] 		= 'prestato';
	$trans['t_to'] 			= 'a';
	$trans['t_at'] 			= 'il';
	$trans['t_year'] 		= 'anno';
	$trans['t_runtime'] 	= 'durata';
	$trans['t_minutes'] 	= 'min.';
	$trans['t_medium'] 		= 'supporto';
	$trans['t_imdb'] 		= 'IMDb';
	$trans['t_poster'] 		= 'poster';
	$trans['t_film'] 		= 'film';

	$trans['click_to_edit'] = 'Clicca per modificare...';
	$trans['no_matches'] 	= '...nessun risultato...';
	$trans['is_equal_to'] 	= ' ';

	$trans['show_moviedata'] 	= 'Visualizza tutti i campi del Film!';
	$trans['edit_moviedata'] 	= 'Modifica il Film!';
	$trans['show_imdb'] 		= 'Visualizza la pagina IMDb!';
	$trans['show_imdbpage'] 	= 'Visualizza la pagina IMDb del Film!';
	$trans['click_imdbpage'] 	= 'Clicca per visualizzare la pagina IMDb del Film!';
	$trans['show_imdbperson'] 	= 'Visualizza la pagina IMDb della persona!';
	$trans['imdb_rating'] 		= 'Ordinamento crescente del punteggio IMDb!';
	$trans['is_available'] 		= 'Ordinamento decrescente reperibilità!';
	$trans['imdb_poster'] 		= 'Ordinamento decrescente per Poster IMDb!';
	$trans['available'] 		= 'reperibile';
	
	$trans['sort_asc'] 		= 'Ordinamento crescente della Colonna!';
	$trans['sort_desc'] 	= 'Ordinamento decrescente della Colonna!';

	$trans['sort_to_asc'] 	= 'Ordina in modo crescente!';
	$trans['sort_to_desc'] 	= 'Ordina in modo descrescente!';

	$trans['show_first'] 	= 'Visualizza il primo ';
	$trans['show_prev'] 	= 'Visualizza il precedente ';
	$trans['x_of_x'] 		= 'di';
	$trans['done']			= 'Fatto';
	$trans['x_all'] 		= 'Tutti';
	$trans['x_films'] 		= ' Film!';
	$trans['show_next'] 	= 'Visualizza il prossimo ';
	$trans['show_last'] 	= 'Visualizza l\'ultimo ';

	$trans['the_first'] 	= 'Visualizza il primo ';
	$trans['the_prev'] 		= 'Visualizza il precedente ';
	$trans['x_film'] 		= ' Film!';
	$trans['the_next'] 		= 'Visualizza il seguente ';
	$trans['the_last'] 		= 'Visualizza l\'ultimo ';

	$trans['search_info'] 	= 'Ricerca (on/off)';
	$trans['search_genres']	= 'Cerca in questa Categoria...';
	$trans['search_for']	= '...per';
	$trans['x_with']		= 'con';
	$trans['o_all_title']	= '(tutti) Titoli';
	$trans['o_all_people']	= '(tutte) Persone';
	$trans['o_name']		= '(originale) Titolo';
	$trans['o_local']		= '(italiano) Titolo';
	$trans['o_director'] 	= 'Regista';
	$trans['o_writer'] 		= 'Sceneggiatura';
	$trans['o_actor'] 		= 'Attori';
	$trans['o_avail'] 		= 'Reperibilità';
	$trans['o_rate'] 		= 'Voto IMDb';
	$trans['o_imdb'] 		= 'Id IMDb';
	$trans['o_poster'] 		= 'Poster IMDb';
	$trans['o_id'] 			= 'Numero di ID';
	$trans['o_country'] 	= 'Luogo di produzione';
	$trans['o_year'] 		= 'Anno di produzione';
	$trans['o_runtime'] 	= 'Durata';
	$trans['o_lang'] 		= 'Lingua';
	$trans['o_medium'] 		= 'Supporto';
	$trans['o_comment']		= 'Commento';
	$trans['o_medium'] 		= 'Supporto';
	$trans['o_disks'] 		= 'Numero di Supporti';
	$trans['o_container'] 	= 'Contenitori';
	$trans['o_video'] 		= 'Codecs';
	$trans['o_width'] 		= 'Larghezza';
	$trans['o_height'] 		= 'Altezza';
	$trans['o_format'] 		= 'Formato';
	$trans['o_ratio'] 		= 'AspectRatio';
	$trans['o_audio'] 		= 'Codecs';
	$trans['o_channel'] 	= 'Canali';
	$trans['o_herz'] 		= 'Frequenza';
	$trans['o_lentto'] 		= 'Prestiti';
	$trans['all_genres']	= 'Tutte le categorie...';
	$trans['link_on']		= 'On';
	$trans['link_off']		= 'Off';
	$trans['is_like']		= 'è come';
	$trans['is_equal']		= 'è uguale a';
	$trans['full_text']		= 'testo completo';
	$trans['do_search']		= 'ricerca';

	$trans['filter_all'] 	= 'Visualizza tutti i film!';
	$trans['filter_0-9'] 	= 'Visualizza solo i film che iniziano per un Numero!';
	$trans['filter_a-z'] 	= 'Visualizza solo i film che iniziano per questo Carattere!';

	$trans['js_title_alert'] 	= 'Inserisci il Titolo originale prima!';
	$trans['js_local_alert'] 	= 'Inserisci il Titolo italiano prima!';
	$trans['js_number_alert'] 	= 'Inserisci il Numero prima!';
	$trans['js_lang_alert'] 	= 'Seleziona la lingua prima!';

// used by "info.php"

	$trans['statistic'] 	= 'Statistiche';
	$trans['poster_size']	= 'Dimensioni del Poster';
	$trans['blob_size']		= 'Blobs';
	$trans['post_size']		= 'File';
	$trans['db_size'] 		= 'Dimensione del DB';
	$trans['total_films'] 	= 'Film totali';
	$trans['total_media'] 	= 'Supporti totali';
	$trans['total_people'] 	= 'Persone totali';
	$trans['i_writers'] 	= 'Scrittori';
	$trans['i_directors'] 	= 'Registi';
	$trans['i_actors'] 		= 'Attori';
	
// used by execute.php

	$trans['b2f_info']		= 'Estrai tutti i poster e salvali come Poster nel server!';
	$trans['f2b_info']		= 'Estrai tutti i file dei poster e salvali come Poster-file file nel server!';
	$trans['b2f_copy']		= 'Copia tutti i file dei poster e salvali come Poster nel server!';
	$trans['f2b_copy']		= 'Copia tutti i file dei poster e salvali come Poster-file file nel server!';
	$trans['blob_del']		= 'Cancella tutti i poster nel database!';
	$trans['file_del']		= 'Cancella tutti i file dei poster nel database!';
	$trans['save_log']		= '<nobr>Scrivi nel file di Log!</nobr>';
	
// used by editposter.php

	$trans['edit_poster'] 	= 'Modifica il Poster';
	$trans['upload_poster'] = 'Seleziona il file (JPG/GIF) dell<br>Immagine che vuoi importare!';
	$trans['upload_url']	= 'Inserisci l\'URL (JPG/GIF) dell<br>Immagine che vuoi importare!';
	$trans['ep_poster'] 	= 'Poster';
	$trans['ep_file'] 		= 'File';
	$trans['ep_url'] 		= 'URL';
	$trans['do_not_store'] 	= 'Non immagazzinare un Poster per questo Film';
	$trans['do_store'] 		= 'Immagazzina un Poste per questo Film';
	$trans['error_info'] 	= 'Si è verificato il seguente errore...';

// used by "askprint.php"

	$trans['print_title'] 	= 'Genera Pagina di stampa';
	$trans['print_page'] 	= 'Pagina di stampa';


   


	$trans['print_info'] 	= '<nobr>È stata prodotta una nuova pagina, </nobr><br>che contiene la lista dei film <b>attualmente visualizzati</b> che verrà stampata.<br>';
	$trans['print_help'] 	= '<nobr>È stata prodotta una nuova pagina, </nobr><br>che contiene l\' <b>intera documentazione</b> che verrà stampata.<br>';
	$trans['print_hint'] 	= '<br><small><b>HINT:</b> Poichè il Browser attuale non supporta quasi nessuna delle possibilità da CSS 2.1 per la preparazione della stampa, dovresti provare con l\'anteprima di stampa finchè il risultato sarà come quello desederato!</small>';

// used by "askprefs.php"

	$trans['prefs_title'] 	= 'Preferenze';
	$trans['prefs_info'] 	= '<nobr>Seleziona ciò che vuoi modificare!</nobr><ul><li><nobr>La Configurazione del Programma</nobr></li><li><nobr>La Lista dei Prestiti</nobr></li></ul>';
	$trans['admin_info'] 	= 'Solo l\'<b>Amministratore</b> ha l\'<b>Autorizzazione</b> per la seguente Manipolazione e Esecuzione:';
	$trans['l_blob2file']	= 'Estrai tutti i Posters dal DataBase e salvali sul Server!';
	$trans['l_file2blob']	= 'Estrai tutti i Posters dal Server e salvali sul DataBase!';
	$trans['l_copy_b2f']	= 'Copia tutti i Posters dal DataBase al Server!';
	$trans['l_copy_f2b']	= 'Copia tutti i Poster dal Server al DataBase!';
	$trans['l_del_blobs']	= '<strong>Elimina</strong> tutti i Posters nel DataBase!';
	$trans['l_del_files']	= '<strong>Elimina</strong> tutti i Posters nel Server!';
	$trans['l_bak_dbase']	= 'Salva l\'intero DataBase come zip!';
	$trans['l_bak_poster']	= 'Salva i file di Poster del Server come zip!';
	$trans['l_res_dbase']	= 'Ripristina l\'intero DataBase da un file zip!';
	$trans['l_res_poster']	= 'Ripristina i Posters nel Server da uno zip di Backup!';
	$trans['l_edit_list']	= 'Modifica la Lista degli Utenti';
	$trans['l_edit_config']	= 'Modifica la Configurazione Base';
	$trans['l_edit_program']= 'Modifica la Configurazione del Programma';
	$trans['l_edit_borrower']='Modifica la Lista dei Prestiti';
	
// used by "askfiles.php"

	$trans['pro_file_size'] = 'Prospective file size';
	$trans['tt_download'] 	= 'Clicca per scaricare!';
	
// used by "editlent.php"

	$trans['lent_title'] 	= 'Stati dei Film';
	
// used by "editprefs.php"

	$trans['t_edit_prefs'] 	= 'Configurazione del Programma';
	$trans['list_height'] 	= 'Lunghezza della Lista';
	$trans['p_language'] 	= 'Lingua';
	$trans['p_fonttype']	= 'Tipo di carattere';
	$trans['p_fontsize'] 	= 'Dimensione del carattere';
	$trans['p_visible'] 	= 'Film visibili';
	$trans['p_requester'] 	= 'della richiesta';
	$trans['max_value'] 	= 'valore max.';
	$trans['use_progressbar']= 'Usa l\'<b>Indicatore di Progresso</b>!';
	$trans['use_blobposter']= 'Il <b>posters</b> verrà <b>salvato</b> nel database <b>come dati binari</b>!';
	$trans['no_wrapping'] 	= '<b>Il Titolo</b> nella Lista <b>non sarà impacchettato</b> automaticamente!';
	$trans['both_title'] 	= 'Visualizza sia <b>il titolo italiano che originale</b> nella lista!';
	$trans['no_poster'] 	= 'Senza <b>Posters</b> nella <b>Lista</b>!';

// used by "editpeople.php"

	$trans['t_edit_people'] = 'Lista dei Prestiti';
	$trans['unnamed'] 		= 'senza nome';
	$trans['edit_name'] 	= 'modifica Nome selezionato';

// used by "editusers.php"

	$trans['t_edit_users'] 	= 'Lista degli Utenti';
	$trans['edit_pass'] 	= 'modifica la Password';
	
// used by "restore.php"

	$trans['restore_dbase'] = '<nobr>Sei sicuro di voler ripristinare<br>...attraverso questa copia di Backup?</nobr><br><small><br></small>';
	$trans['restore_poster']= '<nobr>Sei sicuro di voler ripristinare<br>...la cartella dei poster attraverso questa copia di Backup?</nobr><br><small><br></small>';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Select by';
	$trans['sort_to'] 	= 'Sort to';
	$trans['search_at'] = 'Search at';
	$trans['search_for']= 'Search for';
	$trans['ascending']	= 'Crescente';
	$trans['descending']= 'Decrescente';
?>
