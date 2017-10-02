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
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <?PHP 
    if ($DebugMode) {
        echo "<div><span class='error'>". $handler->GetErrorMessage() ."</span></div>";
    }
    ?>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="../">Career Fair</a>
        </div>
        <ul class="nav navbar-nav">
          <li ><a href="manage">Manage Jobs</a></li>
          <li class="active"><a href="success">Add New Job</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../">Home</a></li>
          <li><a href="../search">Job Search</a></li>
          <li><a href="../student">Students</a></li>
          <li><a href="../company">Companies</a></li>
        </ul>
      </div>
    </nav>

<div class='container'>
<h2>Welcome <?php echo $companyName; ?> </h2>

</div>

<?php include'add_job.php'; ?>

</body>
</html>
