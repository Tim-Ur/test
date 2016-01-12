<?php

	require 'vendor/autoload.php';
	require 'php/utils.php';
	require 'php/storage.php';

	$storage = new ContactsStorage('test','contacts');

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
	    $_POST = json_decode(file_get_contents('php://input'), true);

	switch (GRIIS('action'))
	{
		case 'get_contacts':
			$storage->get_contacts(GRIIS('first_name'),GRIIS('country'));
			break;
		case 'get_record':
			$storage->get_record(GRIIS('id'));
			break;
		case 'delete_all_contacts':
			$storage->delete_all_contacts();
			break;
	};
	switch (PRIIS('action'))
	{
		case 'import_contacts':
			if (isset($_FILES['data'])){
				$storage->import_contacts(json_decode(file_get_contents($_FILES['data']['tmp_name'])));
				unlink($_FILES['data']['tmp_name']);
			}
			break;
		case 'update_record':
			$storage->update_record(PRIIS('data'));
			break;			
	};

?>