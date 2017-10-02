<?PHP
require_once("/../util/config.php");
session_start();

$studentID = htmlspecialchars($_SESSION['studentID'] );
$studentName = htmlspecialchars($_SESSION['studentName'] );
$search_results = $handler->SearchJobs(htmlspecialchars($_SESSION['sDepartment'] ), 
    htmlspecialchars($_SESSION['sDegree'] ), htmlspecialchars($_SESSION['sIntl'] ));
$appliedJobs = $handler->JobsApplied($studentID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Thank you!</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
    <?PHP 
    if ($DebugMode) {
        echo "<div><span class='error'>". $handler->GetErrorMessage() ."</span></div>";
    }
    ?>
<div id='fg_membersite_content'>
<h2>Thanks for registering! <?php echo $studentName; ?></h2>
<form action='../'method='post'>
<input type='submit' name='Home' value='Home' />
</form>

<h2> Here are some Jobs that might interest you: </h2>
<div class='container'>   
        <table class="striped">
            <tr class="header">
                <td>Job Id</td>
                <td>Company</td>
                <td>Position</td>
                <td>Booth</td>
                <td>Location</td>
                <td>Action</td>
            </tr>
            <?php
                if (!is_null($search_results)) {
                   $i = 0;
                   while ($row = mysqli_fetch_array($search_results)) {
                       $class = ($i == 0) ? "" : "alt";
                       echo "<tr class=\"".$class."\">";
                       echo "<td>".$row['jID']."</td>";
                       echo "<td>".$row['cName']."</td>";
                       echo "<td>".$row['position']."</td>";
                       echo "<td>".$row['bID']."</td>";
                       echo "<td>".$row['location']."</td>";
                       if (in_array($row['jID'], $appliedJobs)) {
                            echo "<td>Applied</td>";
                       } else {                         
                            echo "<td><a href='apply?".$row['jID']."'>Apply</a></td>";
                       }
                       echo "</tr>";
                       $i = ($i==0) ? 1:0;
                   }
                }
            ?>
        </table>
    </div>
</div>
</body>
</html>
