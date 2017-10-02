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
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../">Home</a></li>
          <li class="active"><a href="../search">Job Search</a></li>
          <li><a href="../student">Students</a></li>
          <li><a href="../company">Companies</a></li>
        </ul>
      </div>
    </nav>

    <div class='container'>
   
    <fieldset >
    <h2> 
      <legend>Job Search</legend>
    </h2>

    <form class="form-inline" id='register' action='' method='post' accept-charset='UTF-8'>
    <input type='hidden' name='submitted' id='submitted' value='1'/>
    
    <div class='form-group'>
        <label for='department' >Department:</label><br/>
        <select class="form-control" name='department' id='department'>
            <?php
            for ($i=0; $i < count($Department_List); $i++) { 
                echo '<option value='.$i.'>'.$Department_List[$i].'</option>';
            }
            ?>
        </select><br/>
        <span id='register_department_errorloc' class='error'></span>
    </div>
    <div class='form-group'>
        <label for='degree' >Degree Level:</label><br/>
        <select class="form-control" name='degree' id='degree'> 
            <?php
            for ($i=0; $i < count($Degree_Level_List); $i++) { 
                echo '<option value='.$i.'>'.$Degree_Level_List[$i].'</option>';
            }
            ?>
        </select><br/>
        <span id='register_degree_errorloc' class='error'></span>
    </div>
    
    <div class='form-group'>
        <label for='intl' >International Student Filter</label><br/>
        <select class="form-control" name='intl' id='intl'>
            <option value=0>No</option>
            <option value=1>Yes</option>
        </select><br/>
        <span id='register_international_errorloc' class='error'></span>
    </div>
    <div class='form-group'>
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
    </fieldset>
    </form>  

    <br/>

    <div >   
        <table class="table table-striped">
            
            <tr class="header">
                <th>Job Id</th>
                <th>Company</th>
                <th>Position</th>
                <th>Booth</th>
                <th>Location</th>
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