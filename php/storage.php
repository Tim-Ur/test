<?php

	class Storage 
	{
		private $m, $db;

		function __construct($dbname)
		{
			$this->m = new MongoClient();
			$this->db = $this->m->{$dbname};
		}

		function db()
		{
			return $this->db;
		}
	}

	class ContactsStorage extends Storage 
	{
		private $storage, $collection;

		function __construct($dbname, $collectionname)
		{
			$this->storage = new Storage($dbname);
			$this->collection = $this->storage->db()->{$collectionname};
		}

		function collection()
		{
			return $this->collection;
		}

		function delete_all_contacts()
		{
			$this->collection->drop();
		}	

		function get_contacts($f_first_name,$f_country)
		{
			$cursor = $this->collection->find(array(
				'first_name' => array('$regex' => '.*'.$f_first_name.'.*'), 
				'country' => array('$regex' => '.*'.$f_country.'.*')
			));
			// Выводим JSON-объект, собирая его на лету из выбранных документов
			// экономя тем самым память на сервере:
			echo '[';
			$f = true; // $f - first element flag
			foreach ($cursor as $key => $value) {
				if ($f === true)
				{
					$f = false;
				} else
					echo ',';
		    	echo json_encode($value);
		    }
		    echo ']';
		}

		function import_contacts($contacts)
		{
			foreach ($contacts as $key => $value) {
				$this->collection->insert($value);
			}
		}

		function get_record($id)
		{
			$record = $this->collection->findOne(array('id' => ($id + 0)));
			echo json_encode($record);
		}

		function update_record($record)
		{
			unset($record['_id']);
			$this->collection->update(array('id' => ($record['id'] + 0)),$record);
		}

		function get_countries()
		{
			$countries = $this->collection->distinct('country');
			$countries[] = '';
			asort($countries);
			return $countries;
		}
	}

?>