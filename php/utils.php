<?php

	function GRIIS ($val) // $_GET - Return If Is Set
	{
		if (isset($_GET[$val])) return $_GET[$val];
		return '';
	}

	function PRIIS ($val) // $_POST - Return If Is Set
	{
		if (isset($_POST[$val])) return $_POST[$val];
		return '';
	}

?>