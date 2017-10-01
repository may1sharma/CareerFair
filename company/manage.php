<?PHP
require_once("/../util/config.php");
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
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
<div id='fg_membersite_content'>
<h2>Welcome <?php echo $companyName; ?></h2>
<form action='../'method='post'>
<input type='submit' name='Home' value='Home' />
</form>
</div>

<fieldset>
	<div class='container'>   
        <table class="striped">
            <tr class="header">
                <td>Booth Number</td>
                <td>Location</td>
                <td>Space Allocated</td>
                <td>Sponsorship Amount</td>
                <td>Category</td>
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

<fieldset>
	<div class='container'>   
        <table class="striped">
            <tr class="header">
                <td>Job Id</td>
                <td>Position</td>
                <td>International Students</td>
                <td>Departments</td>
                <td>Degree Level</td>
                <td>Modify</td>
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

                       echo "<td><a href='edit_job?".$row['jID']."'>Edit</a>  
                        <a href='delete_job?".$row['jID']."'>Delete</a></td>";
                       
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
