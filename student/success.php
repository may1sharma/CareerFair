<?PHP
require_once("../util/config.php");
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
        <ul class="nav navbar-nav navbar-right" style="background-color: #660000; color: white;">
          <li><a href="../" style="background-color: #660000; color: white;">Home</a></li>
          <li><a href="../search" style="background-color: #660000; color: white;">Job Search</a></li>
          <li class="active" style="background-color: #660000; color: white;"><a href="../student">Students</a></li>
          <li><a href="../company" style="background-color: #660000; color: white;">Companies</a></li>
        </ul>
      </div>
    </nav>

<div class='container'> <div class='container'>
<h2>Thanks for Registering! <?php echo $studentName; ?></h2>

<h3> <legend>Here are some Jobs that might interest you: </legend></h3>


        <table class="table table-striped">
            <tr class="header">
                <th>Job Id</th>
                <th>Company</th>
                <th>Position</th>
                <th>Booth</th>
                <th>Location</th>
                <th>Action</th>
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
                            echo "<td><a href='apply.php?".$row['jID']."'>Apply</a></td>";
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
