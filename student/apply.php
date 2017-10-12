<?PHP
require_once("../util/config.php");
session_start();
$studentID = htmlspecialchars($_SESSION['studentID'] );
$studentName = htmlspecialchars($_SESSION['studentName'] );
$jobID = htmlspecialchars($_SERVER['QUERY_STRING']);


if($handler->InsertApplication($studentID, $jobID))
{
    //TODO Success Notification 
    $handler->RedirectToURL("success.php");
}

?>