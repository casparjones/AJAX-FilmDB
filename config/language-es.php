<?php

/* AJAX-FilmDB 1.2.4 (based on php4flicks) */

$conttype = 'text/html; charset=iso-8859-1';
$rsstype  = 'iso-8859-1';
$xmltype  = 'iso-8859-1';
$sqltype  = 'iso-8859-1';

	$trans['rss_title'] 	= 'Mostrar las 10 &uacute;ltimas pel&iacute;culas en la base de datos.';
	$trans['page_title'] 	= 'FilmDataBase'; 
	$trans['work_in_progress'] = 'Cargando archivos...';
	$trans['the_b_list']	= '<strong><big><b>Lista de Prestatarios</b></big></strong>';
	$trans['the_u_list']	= '<strong><big><b>Lista de Usuarios</b></big></strong>';
	$trans['the_prefs']		= '<strong><big><b>Configuraci&oacute;n del Programa</b></big></strong>';
	$trans['the_status']	= '<strong><big><b>Nuevo Estado de la Pel&iacute;cula</b></big></strong>';
	$trans['the_movie']		= '<strong><big><b>La Pel&iacute;cula...</b></big></strong><br><small><br></small>';
	$trans['the_file']		= '<strong><big><b>El Archivo...</b></big></strong><br><small><br></small>';
	$trans['cleared_alert']	= '<br><small><br></small><nobr>...ha sido eliminado!</nobr>';
	$trans['alert_title']	= '<strong><big><b>Atenci&oacute;n!</b></big></strong><br><small><br></small>';
	$trans['delete_alert'] 	= '<nobr>Est&aacute;s seguro de querer<br>...borrar esta pel&iacute;cula?</nobr><br><small><br></small>';
	$trans['rescan_alert'] 	= '<nobr>Est&aacute;s seguro de querer<br>...renovar esta pel&iacute;cula en la IMDb?</nobr><br><small><br></small>';
	$trans['archive_alert'] = '<nobr>Est&aacute;s seguro de querer<br>...descargue este archivo ZIP?</nobr><br><small><br></small>';
	$trans['export_alert'] 	= '<nobr>Est&aacute;s seguro de querer<br>...exportar esta pel&iacute;cula en formato XML?</nobr><br><small><br></small>';
	$trans['import_alert'] 	= '<nobr>Est&aacute;s seguro de querer<br>...importar esta pel&iacute;cula en formato XML?</nobr><br><small><br></small>';	$trans['updated_alert']	= '<br><small><br></small><nobr>...ha sido actualizada!</nobr>';
	$trans['multiple_alert']= '<b>Las car&aacute;tulas descargadas han sido distribuidas en varios archivos ZIP</b>, ya que tu cuenta solo permite subir un tama&ntilde;o de archivo limitado!';
	$trans['insert_alert']	= '<br><small><br></small><nobr>......ha sido insertada!</nobr>';
	$trans['feature_alert'] = '<nobr>Esta caracteristica <b>no</b> ha sido incorporada por el momento!</nobr><br><small><br>Los c&oacute;digos complejos necesitan un poco m&aacute;s de esfuerzo.</small>';
	$trans['help_alert'] 	= '<nobr>Si la Ayuda-en-L&iacute;nea esta activada</nobr><br>no puedes entrar o salir para modificar la base de datos!';
	$trans['logging_alert'] = '<nobr>El usuario o la clave son incorrectos!</nobr><br><small><br>Usa el bot&oacute;n de acceso (arriba a la derecha) para volver a intentarlo!</small>';
	$trans['login_alert'] 	= '<nobr>Necesitas acceder como usuario autorizado<br>para editar la Base de Datos!</nobr><br><small><br>Usa el bot&oacute;n de acceso (arriba a la derecha) para entrar!</small>';
	$trans['logout_alert'] 	= '<nobr>Has finalizado sesi&oacute;n como usuario autorizado!</nobr><br><small><br>Usa el botón de acceso (arriba a la derecha) para volver a entrar!</small>';
	$trans['saved_alert']	= '<br><small><br></small><nobr>...se ha guardado con &eacute;xito!</nobr>';
	$trans['done_alert']	= '<nobr>Operaci&oacute;n lograda con &eacute;xito.</nobr>';
	$trans['none_alert']	= '<nobr>Aviso: No se ha hecho nada!</nobr>';
	$trans['fs_alert']		= '<nobr>El sistema de acceso a ficheros ha fallado!</nobr>';
	$trans['not_saved']		= '<br><small><br></small><nobr>... <b>no</b> se ha podido guardar!</nobr>';
	$trans['not_loaded']	= '<nobr>... <b>no</b> se ha podido guardar!</nobr>';
	$trans['saved_error']	= '<br><small><br></small><nobr>... <b>no</b> se ha podido guardar!</nobr><br><br><small>Por favor, comprueba si el archivo tiene derechos de escritura.</small>';
	$trans['cookie_error']	= '<br><small><br></small><nobr>... <b>no</b> se ha podido guardar!</nobr><br><br><small>Por favor, comprueba si tu Navegador acepta cookies de esta URL.</small>';

	$trans['guru_noscript'] = '<b>Reflexi&oacute;n del Gur&uacute;</b> - Con JavaScript desactivado el programa AJAX no funciona!';
	$trans['guru_noobject'] = '<b>Reflexi&oacute;n del Gur&uacute;</b> - Este Navegador no soporta el Objeto-XMLHttpRequest!';
	$trans['guru_mqgpcon'] 	= '<b>Reflexi&oacute;n del Gur&uacute;</b> - La configuraci&oacute;n PHP \"magic_quotes_gpc\" debes ponerla en \"Off\"!';

	$trans['b_edit_list'] 	= 'Lista de Usuarios';
	$trans['b_config'] 		= 'Configuraci&oacute;n';
	$trans['b_edit'] 		= 'Editar';
	$trans['b_cancel'] 		= 'Cancelar';
	$trans['b_delete'] 		= 'Borrar';
	$trans['b_update'] 		= 'Actualizar';
	$trans['b_upload'] 		= 'Cargar';
	$trans['b_restore'] 	= 'Restablecer';
	$trans['b_rescan'] 		= 'Renovar';
	$trans['b_export'] 		= 'Exportar';
	$trans['b_import'] 		= 'Importar';
	$trans['b_clear'] 		= 'Eliminar';
	$trans['b_save'] 		= 'Guardar';
	$trans['b_save_cookie'] = 'Guardar Cambios';
	$trans['b_showlog'] 	= 'Mostrar Usario';
	$trans['b_insert'] 		= 'Insertar';
	$trans['b_search'] 		= 'Buscar';
	$trans['b_print'] 		= 'Imprimir';
	$trans['b_program'] 	= 'Programa';
	$trans['b_borrower'] 	= 'Prestatario';
	$trans['b_add_person'] 	= 'A&ntilde;adir Nuevo Prestatario';
	$trans['b_back'] 		= 'Volver';
	$trans['b_start']		= 'Empezar';
	$trans['b_ok'] 			= 'OK';
	
	$trans['DE'] 			= 'alem&aacute;n';
	$trans['EN'] 			= 'ingl&eacute;s';
	$trans['NL'] 			= 'holand&eacute;s';
	$trans['ES'] 			= 'espa&ntilde;ol';
	$trans['FR'] 			= 'franc&eacute;s';
	$trans['IT'] 			= 'italiano';
	$trans['RU'] 			= 'ruso';
	$trans['TR'] 			= 'turco';
	$trans['?'] 			= 'otros';
	
	$trans['1.0'] 			= 'mono';
	$trans['1/1'] 			= 'mono (lenguaje dual)';
	$trans['2.0'] 			= 'est&eacute;reo';
	$trans['2.1'] 			= 'est&eacute;reo & subwoofer';
	$trans['3.0'] 			= 'est&eacute;reo & centro';
	$trans['3.1'] 			= 'est&eacute;reo & centro & subwoofer';
	$trans['4.0'] 			= 'quatro';
	$trans['5.1'] 			= '5 canales surround';
	$trans['6.1'] 			= '6 canales surround';
	$trans['7.1'] 			= '7 canales surround';
	
	$trans['01'] 			= 'Ene';
	$trans['02'] 			= 'Feb';
	$trans['03'] 			= 'Mar';
	$trans['04'] 			= 'Abr';
	$trans['05'] 			= 'May';
	$trans['06'] 			= 'Jun';
	$trans['07'] 			= 'Jul';
	$trans['08'] 			= 'Ago';
	$trans['09'] 			= 'Sep';
	$trans['10'] 			= 'Oct';
	$trans['11'] 			= 'Nov';
	$trans['12'] 			= 'Dic';

// used for "LC-Display"

	$trans['login_user'] 	= 'Usuario Conectado';
	$trans['user_mode'] 	= 'Funci&oacute;n en uso';
	$trans['edit_mode'] 	= 'EDICI&Oacute;N';
	$trans['add_mode'] 		= 'A&Ntilde;ADIR';
	$trans['help_mode'] 	= 'AYUDA';

// used by "login.php"

	$trans['log_user'] 		= 'Usuario';
	$trans['log_pw'] 		= 'Palabra Clave';
	$trans['log_title'] 	= 'Datos de Acceso';
	
// mostly used by "add.php"

	$trans['add_title'] 	= 'A&ntilde;adir Pel&iacute;cula';
	$trans['add_info'] 		= 'Por favor, escribe el t&iacute;tulo original<br>de la pel&iacute;cula que quieres insetar!';
	$trans['add_results'] 	= 'Se han encontrado las siguientes<br>pel&iacute;culas en IMDb...';
	$trans['add_search_error']	= 'Ha ocurrido un error mientras se buscaba el t&iacute;tulo!';
	$trans['js_enter_title'] 	= 'Por favor, escribe un t&iacute;tulo primero!';
	$trans['js_enter_file'] 	= 'Por favor, selecciona un archivo primero!';
	$trans['js_enter_url'] 		= 'Por favor, escribe una URL primero!';
	$trans['js_enter_pattern'] 	= 'Por favor, selecciona un archivo que corresponda con el patr&oacute;n!';
	$trans['nothing_found']		= 'Lo sentimos - no se ha podido encontrar!';

// used by "importfilm.php"
	$trans['import_title'] 	= 'Importar Pel&iacute;cula';	$trans['import_info'] 	= 'Por favor, selecciona el archivo (XML) de<br>la pel&iacute;cula que quieres importar!';

// used by "importfile.php" 

	$trans['import_file'] 	= 'Cargar Archivo de Respaldo';
	$trans['select_dbase'] 	= 'Por favor, Selecciona un archivo del tipo:<br>"filmdb_dbase_DATE-TIME.zip"';
	$trans['select_poster'] = 'Por favor, Selecciona un archivo del tipo:<br>"filmdb_poster_DATE-TIME.zip"';

// used by "exportfilm.php"

	$trans['dtd_internal'] 	= 'referencia interna del DTD';
	$trans['dtd_external'] 	= 'referencia externa del DTD';
	$trans['dtd_none'] 		= 'ningunos referencia del DTD';

// used by "importcheck.php"
	$trans['file_date'] 	= 'Fecha del archivo';
	$trans['file_type'] 	= 'Tipo de archivo';	$trans['file_size'] 	= 'Tama&ntilde;o de archivo';	
// used by "upload.php"

	$trans['0'] 			= 'El archivo se ha cargado con &eacute;xito';
	$trans['1'] 			= 'El archivo cargado excede la directriz de carga m&aacute;xima en php.ini';
	$trans['2'] 			= 'El archivo cargado excede la directriz especificada en el formulario HTML';
	$trans['3'] 			= 'El archivo ha sido solo parcialmente cargado';
	$trans['4'] 			= 'No se ha cargado ning&uacute;n archivo';
	$trans['5'] 			= 'Error desconocido durante la carga';
	$trans['6'] 			= 'Carpeta temporal desaparecida';
	$trans['7'] 			= 'Fallo al escribir el archivo en el disco';
	$trans['90'] 			= 'El archivo que ha intentado cargar no tiene formato v&aacute;lido (no es GIF/JPG)';
	$trans['91'] 			= 'El archivo que ha intentado cargar no tiene formato v&aacute;lido (no es XML)';
	$trans['92'] 			= 'El archivo cargado excede las directrices (1000 bytes)';
	$trans['93'] 			= 'Fallo al intentar leer el archivo cargado';
	$trans['94'] 			= 'Fallo al trasladar el archivo cargado';
	$trans['95'] 			= 'El archivo cargado no fue exportado correctamente (no es AJAX-FilmDB)';
	$trans['96'] 			= 'El archivo cargado no incluye una id de pel&iacute;cula (no tiene IMDb-ID)';	$trans['97'] 			= 'La pel&iacute;cula cargada ya existe en la base de datos';
	$trans['98'] 			= 'El archivo cargado excede la directriz MAX_FILE_SIZE';
	$trans['99'] 			= 'El archivo a cargar no tiene el formato correcto (no es ZIP)'; 

// used by "getperson.php"

	$trans['show_people'] 	= 'Se han encontrado las siguientes personas en IMDb...';
	$trans['show_person'] 	= 'Encontrada la persona en IMDb...';

// mostly used by "index.php"

	$trans['film_view'] 	= 'Vista Pel&iacute;cula';
	$trans['row_view'] 		= 'Vista en Filas';
	$trans['poster_view'] 	= 'Vista Car&aacute;tulas';
	$trans['list_view'] 	= 'Vista en Lista';
	$trans['version'] 		= 'Versi&oacute;n';
	$trans['ajax'] 			= 'Implementaci&oacute;n y Condiciones B&aacute;sicas AJAX';
	$trans['about'] 		= 'Informaci&oacute;n sobre los Derechos de Autor';
	$trans['add_film'] 		= 'A&ntilde;adir Nueva Pel&iacute;cula';
	$trans['import_film'] 	= 'Importe una Pel&iacute;cula';
	$trans['edit_prefs'] 	= 'Preferencias';
	$trans['search_dbase'] 	= 'Busqueda compleja';
	$trans['print_dbase'] 	= 'Imprimir Base de Datos';
	$trans['db_info'] 		= 'Informaci&oacute;n de la Base de Datos';
	$trans['prog_help'] 	= 'Ayuda-en-L&iacute;nea';
	$trans['log_in'] 		= 'Acceder';
	$trans['log_out'] 		= 'Salir';
	$trans['log_file'] 		= 'Fichero de Acceso';

// mostly used by "list.php" and "filmform.php"

	$trans['t_no'] 			= 'nº.';
	$trans['t_number'] 		= 'N&uacute;mero';
	$trans['t_title'] 		= 'T&iacute;tulo';
	$trans['t_original']	= '(Original)';
	$trans['t_local'] 		= '(Espa&ntilde;ol)';
	$trans['t_alias'] 		= '(Tambi&eacute;n conocida como)';
	$trans['t_filminfo'] 	= 'Informaci&oacute;n de la Pel&iacute;cula';
	$trans['t_filmposter'] 	= 'Car&aacute;tula';
	$trans['t_category'] 	= 'Categor&iacute;as';
	$trans['t_director'] 	= 'Director';
	$trans['t_writer'] 		= 'Guionista/s';
	$trans['t_actor'] 		= 'Actores';
	$trans['t_comment'] 	= 'Sinopsis';
	$trans['t_format'] 		= 'Formato-TV';
	$trans['t_date'] 		= 'Insertado';
	$trans['t_since'] 		= 'Fecha';
	$trans['t_ratio'] 		= 'Proporci&oacute;n';
	$trans['t_rating'] 		= 'Calificaci&oacute;n';
	$trans['t_language'] 	= 'Idiomas';
	$trans['t_languages'] 	= 'Idiomas<br>de Audio</br>';
	$trans['t_audio'] 		= 'Subt&iacute;tulos';
	$trans['t_video'] 		= 'Video';
	$trans['t_datatype'] 	= 'Formato';
	$trans['t_container'] 	= 'Contenedor';
	$trans['t_country'] 	= 'Pa&iacute;s';
	$trans['t_countries'] 	= 'Pa&iacute;s de Producci&oacute;n';
	$trans['t_lent'] 		= 'Prestado';
	$trans['t_to'] 			= 'a';
	$trans['t_at'] 			= 'el';
	$trans['t_year'] 		= 'a&ntilde;o';
	$trans['t_runtime'] 	= 'Duraci&oacute;n';
	$trans['t_minutes'] 	= 'min.';
	$trans['t_medium'] 		= 'Medio';
	$trans['t_imdb'] 		= 'IMDb';
	$trans['t_poster'] 		= 'Car&aacute;tula';
	$trans['t_film'] 		= 'Pel&iacute;cula';

	$trans['click_to_edit'] = 'Haz <i>click</i> para editar...';
	$trans['no_matches'] 	= '...no hay concordancias...';
	$trans['is_equal_to'] 	= '1=verdadero/si/encendido - 0=falso/no/apagado';

	$trans['show_moviedata'] 	= 'Mostrar todos los detalles de la pel&iacute;cula!';
	$trans['edit_moviedata'] 	= 'Editar esta pel&iacute;cula!';
	$trans['show_movieinfo'] 	= 'Mostrar todos los detalles de la pel&iacute;cula!'; 
	$trans['close_movieinfo'] 	= 'Infobox cercano'; 
	$trans['export_moviedata'] 	= 'Exportar esta pel&iacute;cula!'; 
	
	$trans['show_imdb'] 		= 'Mostrar esta p&aacute;gina en IMDb!';
	$trans['show_imdbpage'] 	= 'Mostrar la p&aacute;gina IMDb de esta pel&iacute;cula!';
	$trans['click_imdbpage'] 	= 'Haz <i>click</i> para mostrar la p&aacute;gina IMDb de esta pel&iacute;cula!';
	$trans['show_imdbperson'] 	= 'Mostrar la p&aacute;gina IMDb de esta persona!';
	$trans['imdb_rating'] 		= 'Orden ascendente seg&uacute;n calificaci&oacute;n en IMDb!';
	$trans['is_available'] 		= 'Orden descendente seg&uacute;n disponibilidad!';
	$trans['imdb_poster'] 		= 'Orden ascendente seg&uacute;n car&aacute;tula en IMDb!';
	
	$trans['available'] 		= 'Disponible';

    $trans['sort_asc'] 		= 'Ordenar columna ascendente!';
	$trans['sort_desc'] 	= 'Ordenar columna descendente!';

	$trans['sort_to_asc'] 	= 'Orden ascendente!';
	$trans['sort_to_desc'] 	= 'Orden descendente!';

	$trans['show_first'] 	= 'Mostrar las primeras ';
	$trans['show_prev'] 	= 'Mostrar las anteriores ';
	$trans['x_of_x'] 		= 'de';
	$trans['done']			= 'Hecho';
	$trans['x_all'] 		= 'Todas';
	$trans['x_films'] 		= ' Pel&iacute;culas!';
	$trans['show_next'] 	= 'Mostrar las siguientes ';
	$trans['show_last'] 	= 'Mostrar las &uacute;ltimas ';

	$trans['the_first'] 	= 'Mostrar la primero ';
	$trans['the_prev'] 		= 'Mostrar la anterior ';
	$trans['x_film'] 		= ' Pel&iacute;cula!';
	$trans['the_next'] 		= 'Mostrar la siguiente ';
	$trans['the_last'] 		= 'Mostrar la &uacute;ltimo ';

	$trans['search_info'] 	= 'Buscar (ventana desplegable)';
	$trans['search_genres']	= 'Buscar en esta categor&iacute;a...';
	$trans['search_for']	= '...por';
	$trans['x_with']		= 'conteniendo';
	$trans['o_all_title']	= '(todos) T&iacute;tulos';
	$trans['o_all_people']	= '(todos) Personas';
	$trans['o_name']		= '(original) T&iacute;tulo';
	$trans['o_local']		= '(espa&ntilde;ol) T&iacute;tulo';
	$trans['o_director'] 	= 'Directores';
	$trans['o_writer'] 		= 'Guinista/s';
	$trans['o_actor'] 		= 'Actores';
	$trans['o_avail'] 		= 'Disponibilidad';
	$trans['o_rate'] 		= 'Calificaci&oacute;n-IMDb';
	$trans['o_imdb'] 		= 'Numeraci&oacute;n-IMDb';
	$trans['o_poster'] 		= 'Car&aacute;tula-IMDb';
	$trans['o_id'] 			= 'N&uacute;meros-ID';
	$trans['o_country'] 	= 'Pa&iacute;ses de Producci&oacute;n';
	$trans['o_year'] 		= 'A&ntilde;o de Producci&oacute;n';
	$trans['o_runtime'] 	= 'Duraci&oacute;n';
	$trans['o_lang'] 		= 'Idiomas';
	$trans['o_medium'] 		= 'Tipo de Medios';
	$trans['o_comment']		= 'Comentarios';
	$trans['o_medium'] 		= 'Tipo de Medios';
	$trans['o_disks'] 		= 'Tipo de Cuenta';
	$trans['o_container'] 	= 'Contenedores';
	$trans['o_video'] 		= 'Compresor de Video';
	$trans['o_width'] 		= 'Anchura de Video';
	$trans['o_height'] 		= 'Altura de Video';
	$trans['o_format'] 		= 'Formato Video';
	$trans['o_ratio'] 		= 'Proporciones del Video';
	$trans['o_audio'] 		= 'C&oacute;digos de Audio';
	$trans['o_channel'] 	= 'Canales de Audio';
	$trans['o_herz'] 		= 'Frecuencias de Auido';
	$trans['o_lentto'] 		= 'Clientes de esta Pel&iacute;cula';
	$trans['all_genres']	= 'Todas las Categor&iacute;as...';
	$trans['link_on']		= 'Seleccionar';
	$trans['link_off']		= 'Deseleccionar';
	$trans['is_like']		= 'parecdio a';
	$trans['is_equal']		= 'igual a';
	$trans['full_text']		= 'texto completo';
	$trans['do_search']		= 'buscar';

	$trans['filter_all'] 	= 'Mostrar todas las Pel&iacute;culas!';
	$trans['filter_0-9'] 	= 'Mostrar solo las pel&iacute;culas que empiezan con un n&uacute;mero!';
	$trans['filter_a-z'] 	= 'Mostrar solo las pel&iacute;culas que empiezan con esta letra!';

	$trans['js_title_alert'] 	= 'Por favor, escribir el T&iacute;tulo Original primero!';
	$trans['js_local_alert'] 	= 'Por favor, escribir el T&iacute;tulo en espa&ntilde;ol primero!';
	$trans['js_number_alert'] 	= 'Por favor, escribir un n&uacute;mero primero!';
	$trans['js_lang_alert'] 	= 'Por favor, selecciona un idioma primero!';

// used by "info.php"

	$trans['statistic'] 	= 'Estad&iacute;sticas';
	$trans['poster_size']	= 'Tama&ntilde;o de las Car&aacute;tulas';
	$trans['blob_size']		= 'Car&aacute;tulas';
	$trans['post_size']		= 'Archivos';
	$trans['db_size'] 		= 'Tama&ntilde;o de la DB';
	$trans['total_films'] 	= 'Total de Pel&iacute;culas';
	$trans['total_media'] 	= 'Total de Registros';
	$trans['total_people'] 	= 'Total de Personas';
	$trans['i_writers'] 	= 'Guionistas';
	$trans['i_directors'] 	= 'Directores';
	$trans['i_actors'] 		= 'Actores';

// used by execute.php

	$trans['b2f_info']		= 'Extraer todas las car&aacute;tulas y guardar los datos como archivos de im&aacute;gen en el servidor!';
	$trans['f2b_info']		= 'Extraer todos los archivos imágen y guardar los datos como car&aacute;tulas en la base de datos!';
	$trans['b2f_copy']		= 'Copiar todas las car&aacute;tulas y guardar los datos como archivos de im&aacute;gen en el servidor!';
	$trans['f2b_copy']		= 'Copiar todos los archivos imágen y guardar los datos como car&aacute;tulas en la base de datos!';
	$trans['blob_del']		= 'Quitar todas todas las car&aacute;tulas de la base de datos!';
	$trans['file_del']		= 'Eliminar todos los archivos de im&aacute;gen del servidor!';
	$trans['save_log']		= 'Escribir en el fichero de acceso!';
	
// used by editposter.php

	$trans['edit_poster'] 	= 'Editar Car&aacute;tula';
	$trans['upload_poster'] = 'Please select the File (JPG/GIF) of<br>the Image you want to import!';
	$trans['upload_url']	= 'Please input the URL (JPG/GIF) of<br>the Image you want to import!';
	$trans['ep_poster'] 	= 'Car&aacute;tula';
	$trans['ep_file'] 		= 'Archivo';
	$trans['ep_url'] 		= 'URL';
	$trans['do_not_store'] 	= 'No almacenar car&aacute;tula para esta pel&iacute;cula';
	$trans['do_store'] 		= 'Almacenar car&aacute;tula para esta pel&iacute;cula';
	$trans['error_info'] 	= 'Ha ocurrido el siguiente error...';

// used by "askprint.php"

	$trans['print_title'] 	= '<nobr>Generar Impresi&oacute;n</nobr>';
	$trans['print_page'] 	= 'Imprimir P&aacute;gina';
	$trans['print_info'] 	= '<nobr>Se abrir&aacute; una nueva ventana, con el</nobr><br>contenido <b>de esta lista</b> de pel&iacute;culas, lista para imprimir.<br>';
	$trans['print_help'] 	= '<nobr>Se abrir&aacute; una nueva ventana, con la</nobr><br><b>documentaci&oacute;n completa</b> de la ayuda, lista para imprimir.<br>';
	$trans['print_hint'] 	= '<br><small><b>SUGERENCIA:</b> Dado que este Navegador no soporta casi ninguna de las posibilidades de CSS 2.1 para imprimir presentaciones, experimenta con la visualizaci&oacute;n de impresi&oacute;n hasta que el resultado sea satisfactorio!</small>';

// used by "askprefs.php"

	$trans['prefs_title'] 	= 'Preferencias';
	$trans['prefs_info'] 	= '<nobr>Por favor, selecciona lo que desees editar!</nobr><ul><li><nobr>El Configurador de Programas</nobr></li><li><nobr>La lista de Prestatarios</nobr></li></ul>';
	$trans['admin_info'] 	= 'Solamente el <b>Administrador</b> tiene <b>Autorizaci&oacute;n</b> para las manipulaciones y los cambios siguientes:';
	$trans['l_blob2file']	= 'Extraer todas las car&aacute;tulas de la base de datos y guardarlas en el servidor!';
	$trans['l_file2blob']	= 'Extraer todas las car&aacute;tulas del servidor y guardarlas en la base de datos!';
	$trans['l_copy_b2f']	= 'Copiar todas las car&aacute;tulas de la base de datos en el servidor!';
	$trans['l_copy_f2b']	= 'Copiar todas las car&aacute;tulas del servidor a la base de datos!';
	$trans['l_del_blobs']	= '<strong>Quitar</strong> todas las car&aacute;tulas de la base de datos!';
	$trans['l_del_files']	= '<strong>Borrar</strong> todas las car&aacute;tulas del servidor!';
	$trans['l_bak_dbase']	= 'Hacer copia de seguridad completa, de la base de datos, como SQL en un archivo zip!';
	$trans['l_bak_poster']	= 'Hacer copia de seguridad del archivo de car&aacute;tulas en formato zip!';
	$trans['l_res_dbase']	= 'Restaurar la base de datos completa desde un archivo zip!';
	$trans['l_res_poster']	= 'Restaurar las Car&aacute;tulas en el servidor desde un archivo zip!';
	$trans['l_edit_list']	= 'Editar la lista de usuarios';
	$trans['l_edit_config']	= 'Editar la Configuraci&oacute;n b&aacute;sica';
	$trans['l_edit_program']= 'Editar la Configuraci&oacute;n del programa';
	$trans['l_edit_borrower']='Editar la lista de Prestatarios';

	
// used by "askfiles.php"

	$trans['pro_file_size'] = 'Tama&ntilde;o potencial del archivo';
	$trans['tt_download'] 	= 'Hacer <i>clic</i> para descargar!';
	
// used by "editlent.php"

	$trans['lent_title'] 	= 'Estatus de la pel&iacute;cula';
	
// used by "editprefs.php"

	$trans['t_edit_prefs'] 	= '<nobr>Configuraci&oacute;n del Programa</nobr>';
	$trans['list_height'] 	= 'Alto de lista';
	$trans['p_language'] 	= 'Idioma';
	$trans['p_fonttype']	= 'Tipo de Fuente';	$trans['p_fontsize'] 	= 'Tama&ntilde;o de Fuente';
	$trans['p_visible'] 	= 'pel&iacute;culas visibles';
	$trans['p_requester'] 	= 'en petici&oacute;n';
	$trans['max_value'] 	= 'valor max.';
	$trans['use_progressbar']= 'Utilice el <b>Indicador de Progreso</b>!';
	$trans['use_blobposter']= 'Las <b>car&aacute;tulas</b> ser&aacute;n <b>almacenadas</b> en la base de datos como <b>datos binarios</b>!';
	$trans['no_wrapping'] 	= '<b>El t&iacute;tulo</b> en la Vista Lista <b>no se desplegar&aacute;</b> autom&aacute;ticamente!';
	$trans['both_title'] 	= 'Mostrar ambos <b>t&iacute;tulos original y espa&ntilde;ol</b> en la Vista Lista!';
	$trans['no_poster'] 	= 'Sin <b>car&aacute;tulas</b> en la <b>Vista Lista</b>!';

// used by "editpeople.php"

	$trans['t_edit_people'] = 'Lista de Prestatarios';
	$trans['unnamed'] 		= 'An&oacute;nimo';
	$trans['edit_name'] 	= 'edit selected Name';

// used by "editusers.php"

	$trans['t_edit_users'] 	= 'Lista de Usuarios';
	$trans['edit_pass'] 	= 'Editar Palabra Clave';
	
// used by "restore.php"

	$trans['restore_dbase'] = '<nobr>Estas realmente seguro de querer restaurar<br>...la base de datos con este archivo de seguridad?</nobr><br><small><br></small>';
	$trans['restore_poster']= '<nobr>Estas realmente seguro de querer restaurar<br>...la carpeta de las car&aacute;tulas con este archivo de seguridad?</nobr><br><small><br></small>';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Select by';
	$trans['sort_to'] 	= 'Sort to';
	$trans['search_at'] = 'Search at';
	$trans['search_for']= 'Search for';
	$trans['ascending']	= 'Ascending';
	$trans['descending']= 'Descending';

// used by "ios/ and smart/"

	$trans['select_by'] = 'Select by';
	$trans['sort_to'] 	= 'Sort to';
	$trans['search_at'] = 'Search at';
	$trans['search_for']= 'Search for';
	$trans['ascending']	= 'Ascendente';
	$trans['descending']= 'Descendente';
?>
