<?PHP
require_once("/../util/config.php");
$search_results = null;
if(isset($_POST['submitted']))
{
    $search_results = $handler->SearchJobs($_POST['department'], $_POST['degree'], $_POST['intl']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"       
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">       
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">       
  <head>       
    <title>Career Fair</title>       
    <meta http-equiv="content-type"       
        content="text/html; charset=utf-8"/>       
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="STYLESHEET" type="text/css" href="util/css/fg_membersite.css" />
    <!-- The main CSS file -->
    <link href="util/css/style.css" rel="stylesheet" />
  </head>       
  <body>     

    <div id='fg_membersite'>

    <form action='../'method='post'>
        <input type='submit' name='Home' value='Home' />
    </form>

    <form id='register' action='' method='post' accept-charset='UTF-8'>
    <fieldset >
    <h2> 
      <legend>Job Search</legend>
    </h2>

    <input type='hidden' name='submitted' id='submitted' value='1'/>

    <div><span class='error'><?php echo $handler->GetErrorMessage(); ?></span></div>
    
    <div class='container'>
        <label for='department' >Department:</label><br/>
        <select name='department' id='department'>
            <option value=0>Select Department</option>
            <option value=1>Computer Science</option>
            <option value=2>Computer Engineering</option>
            <option value=3>Electronics</option>
            <option value=4>Mechanical</option>
            <option value=5>Civil</option>
            <option value=6>Chemical</option>
            <option value=7>Performing Arts</option>
            <option value=8>Mathematics</option>
            <option value=9>Psychology</option>
        </select><br/>
        <span id='register_department_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='degree' >Degree Level:</label><br/>
        <select name='degree' id='degree'> 
            <option value=0>Select Degree</option>
            <option value=1>Freshmen</option>
            <option value=2>Sophomores</option>
            <option value=3>Juniors</option>
            <option value=4>Seniors</option>
            <option value=5>Masters</option>
            <option value=6>PhD</option>
        </select><br/>
        <span id='register_degree_errorloc' class='error'></span>
    </div>
    
    <div class='container'>
        <label for='intl' >Filter for International Student</label><br/>
        <select name='intl' id='intl'>
            <option value=0>No</option>
            <option value=1>Yes</option>
        </select><br/>
        <span id='register_international_errorloc' class='error'></span>
    </div>

    <div class='container'>
        <input type='submit' name='Submit' value='Submit' />
    </div>

    </fieldset>
    </form>  

    <div class='container'>   
        <table class="striped">
            <tr class="header">
                <td>Job Id</td>
                <td>Company</td>
                <td>Position</td>
                <td>Booth</td>
                <td>Location</td>
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
                       echo "</tr>";
                       $i = ($i==0) ? 1:0;
                   }
                }
            ?>
        </table>
    </div>
  </body>       
</html>