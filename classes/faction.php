<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    
    class Faction extends \OFW\OFWObject {
        public $factionid = "";
        public $factionname = "";
		public $description = "";
		
		public $killteams = null;
        
        function __construct() {
            $this->TableName = "Faction";
            $this->Keys = ["factionid"];
			$this->skipfields = ["killteams"];
        }
		
		public function GetFaction($factionid) {
			global $dbcon;
			
			// Get the requested Faction
			$faction = Faction::FromDB($factionid);
			
			return $faction;
		}
		
		public function GetFactions() {
			global $dbcon;
			
			$sql = "SELECT * FROM Faction ORDER BY CASE WHEN factionid = 'SPEC' THEN 9999 ELSE 1 END, factionname;";
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			$factions = [];

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$faction = Faction::FromRow($row);
					
					// Add this faction to the output
					$factions[] = $faction;
				}
			}
			
			
			// Done - Return our array of factions
			return $factions;
		}

		public function loadKillteams() {
			$this->killteams = [];
			
			global $dbcon;
			$sql = "SELECT * FROM Killteam WHERE factionid = ? AND killteamid NOT LIKE '%_OLD' ORDER BY killteamname;";
			
			
			$cmd = $dbcon->prepare($sql);
			if (!$cmd) {
				//There was an error preparing the SQL statement
				echo "Error preparing SQL: " . $dbcon->error;
			}
			
			//Set the parameters
			$cmd->bind_param('s', $this->factionid);
			
			//Run the query
			if (!$cmd->execute()) {
				//There was an error running the SQL statement
				echo "Error running SQL: " . $dbcon->error;
			}

			//Parse the result
			if ($result = $cmd->get_result()) {
				while ($row = $result->fetch_object()) {
					$kt = Killteam::FromRow($row);
					$this->killteams[] = $kt;
				}
			}
		}
	}
?>