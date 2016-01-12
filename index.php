<?php

	require 'vendor/autoload.php';
	require 'php/utils.php';
	require 'php/storage.php';

	$twig_loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($twig_loader, array(
		'cache'       => 'compilation_cache',
	    'auto_reload' => true
	));

	switch (GRIIS('page'))
	{
		case 'import':
			echo $twig->render('import.html');
			break;

		case 'editor':
			echo $twig->render('editor.html',array('id' => GRIIS('id')));
			break;

		default:
			$storage = new ContactsStorage('test','contacts');
			$countries = $storage->get_countries();
			echo $twig->render('contacts.html',array('countries' => $countries));
			break;
	}


?>