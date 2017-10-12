<?PHP
require_once("../util/config.php");
session_start();
$companyID = htmlspecialchars($_SESSION['companyID'] );
$companyName = htmlspecialchars($_SESSION['companyName'] );

$info = $handler->getCompanyInfo($companyID);
$jobs = $handler->getJobs($companyID);

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
        <div class="navbar-header" >
          <a class="navbar-brand" href="../" style="background-color: #660000; color: white;">Career Fair</a>
        </div>
        <ul class="nav navbar-nav"  style="background-color: #660000; color: white;">
          <li class="active" style="background-color: #660000; color: white;"><a href="manage.php">Manage Jobs</a></li>
          <li><a href="success.php" style="background-color: #660000; color: white;">Add New Job</a></li>
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
<h2>Welcome <?php echo $companyName; ?></h2>
<h3><legend>Details</legend></h3>
</div>
<fieldset>
	<div class='container'>   
        <table class="table table-striped">
            <tr class="header">
                <th>Booth Number</th>
                <th>Location</th>
                <th>Space Allocated</th>
                <th>Sponsorship Amount</th>
                <th>Category</th>
            </tr>
            <?php
                if (!is_null($info)) {
                   $i = 0;
                   while ($row = mysqli_fetch_array($info)) {
                       $class = ($i == 0) ? "" : "alt";
                       echo "<tr class=\"".$class."\">";
                       echo "<td>".$row['bID']."</td>";
                       echo "<td>".$row['location']."</td>";
                       echo "<td>".$row['size']." sq feet"."</td>";
                       echo "<td>"."USD ".$row['amount']."</td>";
                       if ($row['category'] == 1) {echo "<td>Silver</td>";}
                       else if ($row['category'] == 2) echo "<td>Gold</td>";
                       else echo "<td>Platinum</td>";
                       
                       echo "</tr>";
                       $i = ($i==0) ? 1:0;
                   }
                }
            ?>
        </table>
    </div>
</fieldset>
<div class='container'>
<h3><legend>Job Postings</legend></h3>
</div>
<fieldset>
	<div class='container'>   
        <table class="table table-striped">
            <tr class="header">
                <th>Job Id</th>
                <th>Position</th>
                <th>International Students</th>
                <th>Departments</th>
                <th>Degree Level</th>
                <th>Modify</th>
            </tr>
            <?php
                if (!is_null($jobs)) {
                   $i = 0;
                   while ($row = mysqli_fetch_array($jobs)) {
                       $class = ($i == 0) ? "" : "alt";
                       echo "<tr class=\"".$class."\">";
                       echo "<td>".$row['jID']."</td>";
                       echo "<td>".$row['position']."</td>";

                       if ($row['intl'] == 1) echo "<td>Allowed</td>";
                       else echo "<td>Not Allowed</td>";

          					   	$departments = "<td>";
          					   	$query = $handler->getDepartments($row['jID']);
          					   	if (!is_null($query)) {
                  						   	while ($dept = mysqli_fetch_array($query)) 
                  						   	{
          	                       		$departments .= $Department_List[$dept['department']].", ";
          	                       	}
          	                       	$departments = rtrim(trim($departments),',');
                             	  	}
                                 	$departments .= "</td>";
                                 	echo $departments;

                       $degrees = "<td>";
                       $query = $handler->getDegrees($row['jID']);
                       if (!is_null($query)) {
        						   	while ($deg = mysqli_fetch_array($query)) 
        						   	{
	                       		$degrees .= $Degree_Level_List[$deg['degree']].", ";
	                       	}
	                       	$degrees = rtrim(trim($degrees),',');
	                     }
                       $degrees .= "</td>";
                       echo $degrees;

                       echo '<td><a href="edit_job.php?'.$row['jID'].'">Edit</a>  
                        <a href="delete_job.php?'.$row['jID'].'" onclick="return confirm("Are you sure?");">Delete</a></td>';
                       
                       echo "</tr>";
                       $i = ($i==0) ? 1:0;
                   }
                }
            ?>
        </table>

    </div>
</fieldset>



</body>
</html>
