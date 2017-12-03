<?php

/**
 * CSV-persisted collection.
 * 
 * @author		JLP
 * @copyright           Copyright (c) 2010-2017, James L. Parry
 * ------------------------------------------------------------------------
 */
class XML_Model extends Memory_Model
{
//---------------------------------------------------------------------------
//  Housekeeping methods
//---------------------------------------------------------------------------

	/**
	 * Constructor.
	 * @param string $origin Filename of the CSV file
	 * @param string $keyfield  Name of the primary key field
	 * @param string $entity	Entity name meaningful to the persistence
	 */
	function __construct($origin, $keyfield = 'id', $entity = null)
	{
		parent::__construct();

		// guess at persistent name if not specified
		if ($origin == null)
			$this->_origin = get_class($this);
		else
			$this->_origin = $origin;

		// remember the other constructor fields
		$this->_keyfield = $keyfield;
		$this->_entity = $entity;

		// start with an empty collection
		$this->_data = array(); // an array of objects
		$this->fields = array(); // an array of strings
		// and populate the collection
		$this->load();
	}

	/**
	 * Load the collection state appropriately, depending on persistence choice.
	 * OVER-RIDE THIS METHOD in persistence choice implementations
	 */
	protected function load()
	{
		//---------------------
		if (($this->xml = simplexml_load_file($this->_origin)) !== FALSE) {
			
			//convert xml object into array
			$data =  json_decode(json_encode((array)$this->xml),true);

			$first = true;
			foreach($data[array_keys($data)[0]] as $child) {
				if(!$first)
					$this->_data[@$child['id']] = $this->objectConverter($child);
				else {
					$this->_fields = array_keys($child);
					$first = false;
				}
			}
		}

		// --------------------
		// rebuild the keys table
		$this->reindex();
	}

	function objectConverter($array) {
    	if (!is_array($array)) {
            return $array;
        }

        $object = new stdClass();
        
        if ( count($array) != 0) 
        {
            foreach ($array as $key=>$value) 
            {

                $key = strtolower(trim($key));

                if (!empty($key)) 
                {
                    $object->$key = XML_Model::objectConverter($value);
                }
            }

            return $object;
        } else 
            return FALSE;

	}




	/**
	 * Store the collection state appropriately, depending on persistence choice.
	 * OVER-RIDE THIS METHOD in persistence choice implementations
	 */
	protected function store()
	{
		// rebuild the keys table
		$this->reindex();
		//---------------------
		// if (($handle = fopen($this->_origin, "w")) !== FALSE)
		// {
		// 	fputcsv($handle, $this->_fields);
		// 	foreach ($this->_data as $key => $record)
		// 		fputcsv($handle, array_values((array) $record));
		// 	fclose($handle);
		// }
		// --------------------
		$xml = new DomDocument();
		$xml->formatOutput = true;

		$row = $xml->createElement("task");
		$node = $xml->appendChild($row);
		 

		foreach( $this->_data as $row ){

			//create a node 
			$rowItem = $xml->createElement('task');

			//create elements and assign to the node
			foreach($row as $key => $value) {

				//setup keys for each elements
				$property = $xml->createElement($key);

				//assign values match with keys
				$property->appendChild($xml->createTextNode($value));
				
				//var_dump($property);
			}

			//add a node
			$node->appendChild($rowItem);
		}

		$xml->saveXML();
	}

}
