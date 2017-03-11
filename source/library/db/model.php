<?php 
	/**
	* 
	*/
	class Model 
	{
		private $db =null;
		private $_table=null;
		function __construct($tableName)
		{
			$this->db=Flight::db();
			$this->_table=$tableName;
		}
		function select($join,$where){
			return $this->db->select($this->_table,$join,$where);
		}
		function has($join,$where){
			return $this->db->has($this->_table,$join,$where);
		}
		function insert($column){
			return $this->db->insert($this->_table,$column);
		}
		
	}
 ?>