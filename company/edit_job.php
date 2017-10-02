<?PHP
require_once("/../util/config.php");
session_start();
$companyID = htmlspecialchars($_SESSION['companyID'] );
$companyName = htmlspecialchars($_SESSION['companyName'] );
$jobID = htmlspecialchars($_SERVER['QUERY_STRING']);

//TODO validate user  

if(isset($_POST['submitted']))
{
   if($handler->EditPosting($jobID))
   {
        //TODO Success Notification 
        $handler->RedirectToURL("manage");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Career Fair</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
    <?PHP 
    if ($DebugMode) {
        echo "<div><span class='error'>". $handler->GetErrorMessage() ."</span></div>";
    }
    ?>
<div id='fg_membersite_content'>
<h2>Welcome <?php echo $companyName; ?> </h2>
<form action='../'method='post'>
<input type='submit' name='Home' value='Home' />
</form>
</div>
<div>
	<form action='manage'method='post'>
	<input type='submit' name='manage' value='Manage Jobs' />
	</form>
</div>

<?php include'add_job.php'; ?>

</body>
</html>
