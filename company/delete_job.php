<?PHP
require_once("/../util/config.php");
session_start();
$companyID = htmlspecialchars($_SESSION['companyID'] );
$companyName = htmlspecialchars($_SESSION['companyName'] );
$jobID = htmlspecialchars($_SERVER['QUERY_STRING']);

//TODO confirm delete operation 


if($handler->DeletePosting($jobID))
{
    //TODO Success Notification 
    $handler->RedirectToURL("manage");
}

?>