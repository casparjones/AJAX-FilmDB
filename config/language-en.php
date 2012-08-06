<?php

/* AJAX-FilmDB 1.2.4 (based on php4flicks) */

$conttype = 'text/html; charset=iso-8859-1';
$rsstype  = 'iso-8859-1';
$xmltype  = 'iso-8859-1';
$sqltype  = 'iso-8859-1';

	$trans['rss_title'] 	= 'Shows the 10 newest Movies in this Film Data Base.';
	$trans['page_title'] 	= 'FilmDataBase';
	$trans['work_in_progress'] = 'Work in Progress...';
	$trans['the_b_list']	= '<strong><big><b>The list of Borrower</b></big></strong>';
	$trans['the_u_list']	= '<strong><big><b>The list of Users</b></big></strong>';
	$trans['the_prefs']		= '<strong><big><b>Programs Configuration</b></big></strong>';
	$trans['the_status']	= '<strong><big><b>The new Film status</b></big></strong>';
	$trans['the_movie']		= '<strong><big><b>The Movie...</b></big></strong><br><small><br></small>';
	$trans['the_file']		= '<strong><big><b>The File...</b></big></strong><br><small><br></small>';
	$trans['cleared_alert']	= '<br><small><br></small><nobr>...has been cleared!</nobr>';
	$trans['alert_title']	= '<strong><big><b>Attention!</b></big></strong><br><small><br></small>';
	$trans['delete_alert'] 	= '<nobr>Are you really sure that you want to<br>...delete this Movie?</nobr><br><small><br></small>';
	$trans['archive_alert'] = '<nobr>Are you really sure that you want to<br>...download this ZIP Archive?</nobr><br><small><br></small>';
	$trans['rescan_alert'] 	= '<nobr>Are you really sure that you want to<br>...rescan this Movie at IMDb?</nobr><br><small><br></small>';
	$trans['export_alert'] 	= '<nobr>Are you really sure that you want to<br>...export this Movie as XML?</nobr><br><small><br></small>';
	$trans['import_alert'] 	= '<nobr>Are you really sure that you want to<br>...import this Movie as XML?</nobr><br><small><br></small>';
	$trans['updated_alert']	= '<br><small><br></small><nobr>...has been updated!</nobr>';
	$trans['multiple_alert']= '<b>The posters to download were distributed on several ZIP archives</b>, because your account permits only a limited upload file size!';
	$trans['insert_alert']	= '<br><small><br></small><nobr>...has been inserted!</nobr>';
	$trans['feature_alert'] = '<nobr>This Feature ist <b>not</b> integrated at the time!</nobr><br><small><br>The more complex code needs a bit of work.</small>';
	$trans['help_alert'] 	= '<nobr>If Online-Help mode is aktiv</nobr><br>you can not login or logout and you are unable to modify the DataBase!';
	$trans['logging_alert'] = '<nobr>Either username or password is wrong!</nobr><br><small><br>Use the Login-Button (right top) to try again!</small>';
	$trans['login_alert'] 	= '<nobr>You need to be logged in as a<br>user to modify the DataBase!</nobr><br><small><br>Use the Login-Button (right top) to login!</small>';
	$trans['logout_alert'] 	= '<nobr>You are now logged out as an authorized user!</nobr><br><small><br>Use the Login-Button (right top) to relog in!</small>';
	$trans['done_alert']	= '<nobr>Operation successfully accomplished.</nobr>';
	$trans['none_alert']	= '<nobr>Hint: There was nothing to do.</nobr>';
	$trans['fs_alert']		= '<nobr>File system access failed!</nobr>';
	$trans['saved_alert']	= '<br><small><br></small><nobr>...has been saved successfully!</nobr>';
	$trans['not_saved']		= '<br><small><br></small><nobr>...coul\'d <b>not</b> be saved!</nobr>';
	$trans['not_loaded']	= '<nobr>...coul\'d <b>not</b> be loaded!</nobr>';
	$trans['saved_error']	= '<br><small><br></small><nobr>...coul\'d <b>not</b> be saved!</nobr><br><br><small>Please check if the named file has the rights to be written.</small>';
	$trans['cookie_error']	= '<br><small><br></small><nobr>...coul\'d <b>not</b> be saved!</nobr><br><br><small>Please check if your Browser will do accept cookies from this URL.</small>';

	$trans['guru_noscript'] = '<b>Guru Meditation</b> - With deactivated JavaScript this AJAX program won\'t run!';
	$trans['guru_noobject'] = '<b>Guru Meditation</b> - This Browser do not support the XMLHttpRequest-Object!';
	$trans['guru_mqgpcon'] 	= '<b>Guru Meditation</b> - The PHP configuration \"magic_quotes_gpc\" has to be set \"Off\"!';

	$trans['b_edit_list'] 	= 'The Userlist';
	$trans['b_config'] 		= 'Configuration';
	$trans['b_edit'] 		= 'Edit';
	$trans['b_cancel'] 		= 'Cancel';
	$trans['b_delete'] 		= 'Delete';
	$trans['b_update'] 		= 'Update';
	$trans['b_upload'] 		= 'Upload';
	$trans['b_restore'] 	= 'Restore';
	$trans['b_rescan'] 		= 'Rescan';
	$trans['b_export'] 		= 'Export';
	$trans['b_import'] 		= 'Import';
	$trans['b_clear'] 		= 'Clear';
	$trans['b_save'] 		= 'Save';
	$trans['b_save_cookie'] = 'Save cookie';
	$trans['b_showlog'] 	= 'Show Log file';
	$trans['b_insert'] 		= 'Insert';
	$trans['b_search'] 		= 'Search';
	$trans['b_print'] 		= 'Print';
	$trans['b_program'] 	= 'Program';
	$trans['b_borrower'] 	= 'Borrower';
	$trans['b_add_person'] 	= 'add new Borrower';
	$trans['b_back'] 		= 'Back';
	$trans['b_start']		= 'Start';
	$trans['b_ok'] 			= 'OK';
	
	$trans['DE'] 			= 'german';
	$trans['EN'] 			= 'english';
	$trans['NL'] 			= 'dutch';
	$trans['ES'] 			= 'spanish';
	$trans['FR'] 			= 'french';
	$trans['IT'] 			= 'italian';
	$trans['RU'] 			= 'russian';
	$trans['TR'] 			= 'turkishly';
	$trans['?'] 			= 'unknown';
	
	$trans['1.0'] 			= 'mono';
	$trans['1/1'] 			= 'mono (dual language)';
	$trans['2.0'] 			= 'stereo';
	$trans['2.1'] 			= 'stereo & subwoofer';
	$trans['3.0'] 			= 'stereo & center';
	$trans['3.1'] 			= 'stereo & center & subwoofer';
	$trans['4.0'] 			= 'quatro';
	$trans['5.1'] 			= '5 channel surround';
	$trans['6.1'] 			= '6 channel surround';
	$trans['7.1'] 			= '7 channel surround';
	
	$trans['01'] 			= 'Jan';
	$trans['02'] 			= 'Feb';
	$trans['03'] 			= 'Mar';
	$trans['04'] 			= 'Apr';
	$trans['05'] 			= 'May';
	$trans['06'] 			= 'Jun';
	$trans['07'] 			= 'Jul';
	$trans['08'] 			= 'Aug';
	$trans['09'] 			= 'Sep';
	$trans['10'] 			= 'Oct';
	$trans['11'] 			= 'Nov';
	$trans['12'] 			= 'Dec';

// used for "LC-Display"

	$trans['login_user'] 	= 'logged User';
	$trans['user_mode'] 	= 'User Mode';
	$trans['edit_mode'] 	= 'EDIT';
	$trans['add_mode'] 		= 'ADD';
	$trans['help_mode'] 	= 'HELP';

// used by "login.php"

	$trans['log_user'] 		= 'Username';
	$trans['log_pw'] 		= 'Password';
	$trans['log_title'] 	= 'Login';
	
// mostly used by "add.php"

	$trans['add_title'] 	= 'Add Movie';
	$trans['add_info'] 		= 'Please type in the (original) Title of<br>the Movie you want to insert!';
	$trans['add_results'] 	= 'Found the following Movies at IMDb...';
	$trans['add_search_error']	= 'Error occured during search for title!';
	$trans['js_enter_title'] 	= 'Please enter a title first!';
	$trans['js_enter_file'] 	= 'Please select a file first!';
/**/$trans['js_enter_url']		= 'Please enter an URL first!';
	$trans['js_enter_pattern'] 	= 'Please select a file which corresponds to the pattern!';
	$trans['nothing_found']		= 'Sorry - nothing found!';

// used by "importfilm.php"

	$trans['import_title'] 	= 'Import Movie';
	$trans['import_info'] 	= 'Please select the File (XML) of<br>the Movie you want to import!';

// used by "importfile.php" 

	$trans['import_file'] 	= 'Load Backup Archive';
	$trans['select_dbase'] 	= 'Please select a file of this sample:<br>"filmdb_dbase_DATE-TIME.zip"';
	$trans['select_poster'] = 'Please select a file of this sample:<br>"filmdb_poster_DATE-TIME.zip"';

// used by "exportfilm.php"

	$trans['dtd_internal'] 	= 'internal DTD reference';
	$trans['dtd_external'] 	= 'external DTD reference';
	$trans['dtd_none'] 		= 'without DTD reference';

// used by "importcheck.php"

	$trans['file_date'] 	= 'File Date';
	$trans['file_type'] 	= 'File Type';
	$trans['file_size'] 	= 'File Size';
	
// used by "upload.php"

	$trans['0'] 			= 'The file uploaded with success';
	$trans['1'] 			= 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
	$trans['2'] 			= 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
	$trans['3'] 			= 'The uploaded file was only partially uploaded';
	$trans['4'] 			= 'No file was uploaded';
	$trans['5'] 			= 'Unknown Error while uploading';
	$trans['6'] 			= 'Missing a temporary folder';
	$trans['7'] 			= 'Failed to write file to disk';
/**/$trans['90'] 			= 'The uploaded file was of the wrong file format (not GIF/JPG)';
	$trans['91'] 			= 'The uploaded file was of the wrong file format (not XML)';
	$trans['92'] 			= 'The uploaded file exceeds the MIN_FILE_SIZE directive (1000 bytes)';
	$trans['93'] 			= 'Failed to read the uploaded file';
	$trans['94'] 			= 'Failed to move the uploaded file';
	$trans['95'] 			= 'The uploaded file was from the wrong Exporter (not AJAX-FilmDB)';
	$trans['96'] 			= 'The uploaded file do not include an film id (no IMDb-ID)';
	$trans['97'] 			= 'The uploaded movie is already contained in the data base';
	$trans['98'] 			= 'The uploaded file exceeds the MAX_FILE_SIZE directive';
	$trans['99'] 			= 'The to-uploading file is of the wrong file format (not ZIP)'; 

// used by "getperson.php"

	$trans['show_people'] 	= 'Found the following People at IMDb...';
	$trans['show_person'] 	= 'Found the named Person at IMDb...';

// mostly used by "index.php"

	$trans['film_view'] 	= 'Film View';
	$trans['row_view'] 		= 'Row View';
	$trans['poster_view'] 	= 'Poster View';
	$trans['list_view'] 	= 'List View';
	$trans['version'] 		= 'Version';
	$trans['ajax'] 			= 'AJAX Implementation and basic Conditions';
	$trans['about'] 		= 'Copyright Informations';
	$trans['add_film'] 		= 'add a new Film';
	$trans['import_film'] 	= 'import a Film';
	$trans['edit_prefs'] 	= 'preferences';
	$trans['search_dbase'] 	= 'complex Search';
	$trans['print_dbase'] 	= 'print DataBase';
	$trans['db_info'] 		= 'DataBase Infos';
	$trans['prog_help'] 	= 'Online-Help';
	$trans['log_in'] 		= 'Login';
	$trans['log_out'] 		= 'Logout';
	$trans['log_file'] 		= 'Log file';

// mostly used by "list.php" and "filmform.php"

	$trans['t_no'] 			= 'no.';
	$trans['t_number'] 		= 'number';
	$trans['t_title'] 		= 'Title';
	$trans['t_original']	= '(original)';
	$trans['t_local'] 		= '(english)';
	$trans['t_alias'] 		= '(a.k.a.)';
	$trans['t_filminfo'] 	= 'film infos';
	$trans['t_filmposter'] 	= 'film poster';
	$trans['t_category'] 	= 'categories';
	$trans['t_director'] 	= 'director';
	$trans['t_writer'] 		= 'writers';
	$trans['t_actor'] 		= 'actors';
	$trans['t_comment'] 	= 'comment';
	$trans['t_format'] 		= 'tv-format';
	$trans['t_date'] 		= 'inserted';
	$trans['t_since'] 		= 'date';
	$trans['t_ratio'] 		= 'aspect ratio';
	$trans['t_rating'] 		= 'rating';
	$trans['t_language'] 	= 'languages';
	$trans['t_languages'] 	= 'lang.';
	$trans['t_audio'] 		= 'audio';
	$trans['t_video'] 		= 'video';
	$trans['t_datatype'] 	= 'format';
	$trans['t_container'] 	= 'container';
	$trans['t_country'] 	= 'country';
	$trans['t_countries'] 	= 'countries of production';
	$trans['t_lent'] 		= 'loaned';
	$trans['t_to'] 			= 'to';
	$trans['t_at'] 			= 'at';
	$trans['t_year'] 		= 'year';
	$trans['t_runtime'] 	= 'duration';
	$trans['t_minutes'] 	= 'min.';
	$trans['t_medium'] 		= 'medium';
	$trans['t_imdb'] 		= 'IMDb';
	$trans['t_poster'] 		= 'poster';
	$trans['t_film'] 		= 'film';

	$trans['click_to_edit'] = 'Click to edit...';
	$trans['no_matches'] 	= '...no matches...';
	$trans['is_equal_to'] 	= '1=true/yes/on - 0=false/no/off';

	$trans['show_moviedata'] 	= 'Show all values of the Film!';
	$trans['edit_moviedata'] 	= 'Edit this Film!';
/**/$trans['show_movieinfo'] 	= 'Show all values of the Film!'; 
/**/$trans['close_movieinfo'] 	= 'Close Infobox'; 
/**/$trans['export_moviedata'] 	= 'Export this Film!'; 
	
	$trans['show_imdb'] 		= 'Show this IMDb-Page!';
	$trans['show_imdbpage'] 	= 'Show the IMDb-Page of this Film!';
	$trans['click_imdbpage'] 	= 'Click to show the IMDb-Page of this Film!';
	$trans['show_imdbperson'] 	= 'Show the IMDb-Page of this Person!';
	$trans['imdb_rating'] 		= 'Sort ascending to IMDb-Rating!';
	$trans['is_available'] 		= 'Sort descending Availability!';
	$trans['imdb_poster'] 		= 'Sort descending to IMDb-Poster!';
	$trans['available'] 		= 'available';
	
	$trans['sort_asc'] 		= 'Sort the Column ascending!';
	$trans['sort_desc'] 	= 'Sort the Column descending!';

	$trans['sort_to_asc'] 	= 'Sort ascending!';
	$trans['sort_to_desc'] 	= 'Sort descending!';

	$trans['show_first'] 	= 'Show the first ';
	$trans['show_prev'] 	= 'Show the previous ';
	$trans['x_of_x'] 		= 'of';
	$trans['done']			= 'Done';
	$trans['x_all'] 		= 'all';
	$trans['x_films'] 		= ' Films!';
	$trans['show_next'] 	= 'Show the next ';
	$trans['show_last'] 	= 'Show the last ';

	$trans['the_first'] 	= 'Show the first ';
	$trans['the_prev'] 		= 'Show the previous ';
	$trans['x_film'] 		= ' Film!';
	$trans['the_next'] 		= 'Show the next ';
	$trans['the_last'] 		= 'Show the last ';

	$trans['search_info'] 	= 'Search (pop on/off)';
	$trans['search_genres']	= 'Search in this Categories...';
	$trans['search_for']	= '...for';
	$trans['x_with']		= 'with';
	$trans['o_all_title']	= '(all) Titles';
	$trans['o_all_people']	= '(all) People';
	$trans['o_name']		= '(original) Titles';
	$trans['o_local']		= '(english) Titles';
	$trans['o_director'] 	= 'Directors';
	$trans['o_writer'] 		= 'Writers';
	$trans['o_actor'] 		= 'Actors';
	$trans['o_avail'] 		= 'Availability';
	$trans['o_rate'] 		= 'IMDb-Ratings';
	$trans['o_imdb'] 		= 'IMDb-Numbers';
	$trans['o_poster'] 		= 'IMDb-Posters';
	$trans['o_id'] 			= 'ID-Numbers';
	$trans['o_country'] 	= 'Production Countries';
	$trans['o_year'] 		= 'Year of Production';
	$trans['o_runtime'] 	= 'Runtime';
	$trans['o_lang'] 		= 'Languages';
	$trans['o_medium'] 		= 'Mediatypes';
	$trans['o_comment']		= 'Comments';
	$trans['o_medium'] 		= 'Mediatypes';
	$trans['o_disks'] 		= 'Mediacount';
	$trans['o_container'] 	= 'Containers';
	$trans['o_video'] 		= 'Video-Codecs';
	$trans['o_width'] 		= 'Video-Width';
	$trans['o_height'] 		= 'Video-Height';
	$trans['o_format'] 		= 'Video-Format';
	$trans['o_ratio'] 		= 'Video-AspectRatio';
	$trans['o_audio'] 		= 'Audio-Codecs';
	$trans['o_channel'] 	= 'Audio-Channels';
	$trans['o_herz'] 		= 'Audio-Frequencies';
	$trans['o_lentto'] 		= 'Film-Borrowers';
	$trans['all_genres']	= 'All Categories...';
	$trans['link_on']		= 'On';
	$trans['link_off']		= 'Off';
	$trans['is_like']		= 'is like';
	$trans['is_equal']		= 'is equal to';
	$trans['full_text']		= 'fulltext';
	$trans['do_search']		= 'search';

	$trans['filter_all'] 	= 'Show all Films!';
	$trans['filter_0-9'] 	= 'Show only the Films starting with a Number!';
	$trans['filter_a-z'] 	= 'Show only the Films starting with this Character!';

	$trans['js_title_alert'] 	= 'Please enter the original Title first!';
	$trans['js_local_alert'] 	= 'Please enter the english Title first!';
	$trans['js_number_alert'] 	= 'Please enter a Number first!';
	$trans['js_lang_alert'] 	= 'Please select a Language first!';

// used by "info.php"

	$trans['statistic'] 	= 'Statistics';
	$trans['poster_size']	= 'Poster-Sizes';
	$trans['blob_size']		= 'Blobs';
	$trans['post_size']		= 'Files';
	$trans['db_size'] 		= 'DB-Size';
	$trans['total_films'] 	= 'total Films';
	$trans['total_media'] 	= 'total Media';
	$trans['total_people'] 	= 'People total';
	$trans['i_writers'] 	= 'Writers';
	$trans['i_directors'] 	= 'Directors';
	$trans['i_actors'] 		= 'Actors';
	
// used by execute.php

	$trans['b2f_info']		= 'Extract all poster blobs and save data as poster files to the server!';
	$trans['f2b_info']		= 'Extract all poster files and save data as poster blobs to data base!';
	$trans['b2f_copy']		= 'Copy all poster blobs and save data as poster files to the server!';
	$trans['f2b_copy']		= 'Copy all poster files and save data as poster blobs to data base!';
	$trans['blob_del']		= 'Clear all poster blobs in the data base!';
	$trans['file_del']		= 'Delete all poster files on the server!';
	$trans['save_log']		= '<nobr>Write into Log file!</nobr>';
	
// used by editposter.php

	$trans['edit_poster'] 	= 'Edit Poster';
/**/$trans['upload_poster'] = 'Please select the File (JPG/GIF) of<br>the Image you want to import!';
/**/$trans['upload_url']	= 'Please input the URL (JPG/GIF) of<br>the Image you want to import!';
	$trans['ep_poster'] 	= 'Poster';
	$trans['ep_file'] 		= 'File';
	$trans['ep_url'] 		= 'URL';
	$trans['do_not_store'] 	= 'Do not store a Poster for this Movie';
	$trans['do_store'] 		= 'Store the Poster for this Movie';
	$trans['error_info'] 	= 'The following error occured...';

// used by "askprint.php"

	$trans['print_title'] 	= 'Generate Printerpage';
	$trans['print_page'] 	= 'Printerpage';
	$trans['print_info'] 	= '<nobr>A page in it\'s own window is produced,</nobr><br>which reflects the <b>current listing</b> of the films which shoul\'d be printed out.<br>';
	$trans['print_help'] 	= '<nobr>A page in it\'s own window is produced,</nobr><br>which reflects the <b>whole documentation</b> which shoul\'d be printed out.<br>';
	$trans['print_hint'] 	= '<br><small><b>HINT:</b> Because the actual Browsers supports nearly none of the possibilities from CSS 2.1 for print preparation, you should experiment with the print preview until the result pleases you!</small>';

// used by "askprefs.php"

	$trans['prefs_title'] 	= 'Preferences';
	$trans['prefs_info'] 	= '<nobr>Please select what you wan\'t to edit!</nobr><ul><li><nobr>The Programs Config</nobr></li><li><nobr>The List of Borrower</nobr></li></ul>';
	$trans['admin_info'] 	= 'Only the <b>Administrator</b> has the <b>Authorization</b> for the following Manipulations and Executions:';
	$trans['l_blob2file']	= 'Extract all Posters from DataBase and save to Server!';
	$trans['l_file2blob']	= 'Extract all Posters from Server and save to DataBase!';
	$trans['l_copy_b2f']	= 'Copy all Posters from DataBase to Server!';
	$trans['l_copy_f2b']	= 'Copy all Posters from Server to DataBase!';
	$trans['l_del_blobs']	= '<strong>Clear</strong> all Posters in the DataBase!';
	$trans['l_del_files']	= '<strong>Delete</strong> all Posters on the Server!';
	$trans['l_bak_dbase']	= 'Backup the whole DataBase as SQL to zip!';
	$trans['l_bak_poster']	= 'Backup Poster files from Server to zip!';
	$trans['l_res_dbase']	= 'Restore the whole DataBase from Backup zip!';
	$trans['l_res_poster']	= 'Restore Posters on Server from Backup zip!';
	$trans['l_edit_list']	= 'Edit List of Users';
	$trans['l_edit_config']	= 'Edit basic Configuration';
	$trans['l_edit_program']= 'Edit program Configuration';
	$trans['l_edit_borrower']='Edit List of Borrower';
	
// used by "askfiles.php"

	$trans['pro_file_size'] = 'Prospective file size';
	$trans['tt_download'] 	= 'Click to download!';
	
// used by "editlent.php"

	$trans['lent_title'] 	= 'Film status';
	
// used by "editprefs.php"

	$trans['t_edit_prefs'] 	= 'Program Configuration';
	$trans['list_height'] 	= 'Listheight';
	$trans['p_language'] 	= 'Language';
	$trans['p_fonttype']	= 'Font Type';
	$trans['p_fontsize'] 	= 'Font Size';
	$trans['p_visible'] 	= 'visible films';
	$trans['p_requester'] 	= 'of requests';
	$trans['max_value'] 	= 'max. value';
	$trans['use_progressbar']= 'Use the <b>Progress Indicator</b>!';
	$trans['use_blobposter']= 'The <b>posters</b> will be <b>stored</b> in the data base <b>as binary data</b>!';
	$trans['no_wrapping'] 	= '<b>Title</b> in List-View <b>won\'t wrap</b> automatically!';
	$trans['both_title'] 	= 'Show both <b>english and original Title</b> in List-View!';
	$trans['no_poster'] 	= 'Without <b>Posters</b> in the <b>List-View</b>!';

// used by "editpeople.php"

	$trans['t_edit_people'] = 'List of Borrower';
	$trans['unnamed'] 		= 'unnamed';
	$trans['edit_name'] 	= 'edit selected Name';

// used by "editusers.php"

	$trans['t_edit_users'] 	= 'List of Users';
	$trans['edit_pass'] 	= 'edit Password';
	
// used by "restore.php"

	$trans['restore_dbase'] = '<nobr>Are you really sure that you want to restore<br>...the database through this backup file?</nobr><br><small><br></small>';
	$trans['restore_poster']= '<nobr>Are you really sure that you want to restore<br>...the poster folder through this backup file?</nobr><br><small><br></small>';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Select by';
	$trans['sort_to'] 	= 'Sort to';
	$trans['search_at'] = 'Search at';
	$trans['search_for']= 'Search for';
	$trans['ascending']	= 'Ascending';
	$trans['descending']= 'Descending';

?>
