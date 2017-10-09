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
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <?PHP 
    if ($DebugMode) {
        echo "<div><span class='error'>". $handler->GetErrorMessage() ."</span></div>";
    }
    ?>
    <nav class="navbar navbar-default" style="background-color: #660000; color: white;">
      <div class="container-fluid" style="background-color: #660000; color: white;">
        <div class="navbar-header" style="background-color: #660000; color: white;">
          <a class="navbar-brand" href="../" style="background-color: #660000; color: white;">Career Fair</a>
        </div>
        <ul class="nav navbar-nav" style="background-color: #660000; color: white;">
          <li ><a href="manage" style="background-color: #660000; color: white;">Manage Jobs</a></li>
          <li class="active"><a href="success" style="background-color: #660000; color: white;">Add New Job</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../" style="background-color: #660000; color: white;">Home</a></li>
          <li><a href="../search" style="background-color: #660000; color: white;">Job Search</a></li>
          <li><a href="../student" style="background-color: #660000; color: white;">Students</a></li>
          <li><a href="../company" style="background-color: #660000; color: white;">Companies</a></li>
        </ul>
      </div>
    </nav>

<div class='container'>
<h2>Welcome <?php echo $companyName; ?> </h2>
<h2> 
      <legend>Edit Job Posting Id <?php echo $jobID; ?> </legend>
</h2>
</div>

<?php include'add_job.php'; ?>

</body>
</html>
