<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Equipment extends \OFW\OFWObject {
		public $factionid = "";
        public $killteamid = "";
		public $eqid = "";
		public $eqname = "";
		public $eqdescription = "";
		public $eqpts = "";
        
        function __construct() {
            $this->TableName = "equipmentid";
            $this->Keys = ["killteamid", "eqid"];
        }
		
		public function GetEquipment($killteamid, $eqid) {
			global $dbcon;
			
			//Get the requested Equipment
			$e = Ploy::FromDB($killteamid, $eqid);
			
			return $e;
		}
	}
?>