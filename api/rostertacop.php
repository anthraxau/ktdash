<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . '/include.php';
    global $dbcon;
    
    switch ($_SERVER['REQUEST_METHOD']) {
		case "GET":
			// Get the requested roster tacop
			GETRosterTacOp();
			break;
		case "POST":
			// Create a new roster tacop
			POSTRosterTacOp();
			break;
		case "DELETE":
			// Delete an existing roster tacop
			DELETERosterTacOp();
			break;
        default:
            // Invalid verb
            header('HTTP/1.0 500 Server Error - Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
			die();
            break;
    }

    function GETRosterTacOp() {
		// Get the requested tacop
        $userid = getIfSet($_REQUEST['uid']);
		$rosterid = getIfSet($_REQUEST['rid']);
        $tacopid = getIfSet($_REQUEST['toid']);
		
		if ($userid == null || $userid == '' || strlen($userid) > 10) {
			// No userid specified - fail
			header('HTTP/1.0 404 Invalid userid');
			die();
		} elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 10) {
			// No rosterid specified - fail
			header('HTTP/1.0 404 Invalid rosterid');
			die();
		} elseif ($tacopid == null || $tacopid == '' || strlen($tacopid) > 10) {
			// No tacopid specified - fail
			header('HTTP/1.0 404 Invalid tacopid');
			die();
		} else {
			// Try to find this tacop
            $rto = RosterTacOp::FromDB($userid, $rosterid, $tacopid);
			if ($rto == null) {
				header('HTTP/1.0 404 Roster TacOp not found');
				die();
			} else {
				header('Content-Type: application/json');
				echo json_encode($rto);
			}
		}
    }
	
	function DELETERosterTacOp() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();

            $userid = getIfSet($_REQUEST['uid']);
            $rosterid = getIfSet($_REQUEST['rid']);
            $tacopid = getIfSet($_REQUEST['toid']);
            
            if ($userid == null || $userid == '' || strlen($userid) > 10) {
                // No userid specified - fail
                header('HTTP/1.0 404 Invalid userid');
                die();
            } elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 10) {
                // No rosterid specified - fail
                header('HTTP/1.0 404 Invalid rosterid');
                die();
            } elseif ($tacopid == null || $tacopid == '' || strlen($tacopid) > 10) {
                // No tacopid specified - fail
                header('HTTP/1.0 404 Invalid tacopid');
                die();
            } else {
                // Try to find this tacop
                $rto = RosterTacOp::FromDB($userid, $rosterid, $tacopid);
                if ($rto == null) {
                    header('HTTP/1.0 404 Roster TacOp not found');
                    die();
                } else {
                    // Check that current user owns this roster
                    if ($userid != $u->userid) {
                        // Not theirs - fail
                        header('HTTP/1.0 403 This is not your roster');
                        die();
                    } else {
                        $rto->DBDelete();
                        echo "OK";
                    }
                }
            }
		}
	}
	
	function POSTRosterTacOp() {
		// Check that the user is currently logged in
		if (!Session::IsAuth()) {
			// Not logged in - Return error				
			header('HTTP/1.0 401 Unauthorized - You are not logged in"');
			die();
		} else {
			// Get the current user
			$u = Session::CurrentUser();

            $userid = getIfSet($_REQUEST['uid']);
            $rosterid = getIfSet($_REQUEST['rid']);
            $tacopid = getIfSet($_REQUEST['toid']);
            
            if ($userid == null || $userid == '' || strlen($userid) > 10 || $userid != $u->userid) {
                // No userid specified - fail
                header('HTTP/1.0 404 Invalid userid');
                die();
            } elseif ($rosterid == null || $rosterid == '' || strlen($rosterid) > 10) {
                // No rosterid specified - fail
                header('HTTP/1.0 404 Invalid rosterid');
                die();
            } elseif ($tacopid == null || $tacopid == '' || strlen($tacopid) > 10) {
                // No tacopid specified - fail
                header('HTTP/1.0 404 Invalid tacopid');
                die();
            } else {
                // Prepare a new roster tacop
                $rto = new RosterTacOp();
                $rto->userid = $userid;
                $rto->rosterid = $rosterid;
                $rto->tacopid = $tacopid;
                $rto->isrevealed = 0;
                $rto->VP1 = 0;
                $rto->VP2 = 0;

                // Commit to DB
                $rto->DBSave();
            }
		}
	}
?>
