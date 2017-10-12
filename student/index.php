<?PHP
require_once("../util/config.php");
session_start();
    
if(isset($_POST['submitted']))
{
    
   if($handler->RegisterStudent())
   {
        $_SESSION['studentID'] = $GLOBALS['studentID'];
        $_SESSION['studentName'] = $GLOBALS['studentName'];
        $_SESSION['sDepartment'] = $GLOBALS['sDepartment'];
        $_SESSION['sDegree'] = $GLOBALS['sDegree'];
        $_SESSION['sIntl'] = $GLOBALS['sIntl'];

        $handler->RedirectToURL("success.php");
   }
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
        <div class="navbar-header">
          <a class="navbar-brand" href="../" style="background-color: #660000; color: white;">Career Fair</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../" style="background-color: #660000; color: white;">Home</a></li>
          <li><a href="../search" style="background-color: #660000; color: white;">Job Search</a></li>
          <li class="active" style="background-color: #660000; color: white;"><a href="../student">Students</a></li>
          <li><a href="../company" style="background-color: #660000; color: white;">Companies</a></li>
        </ul>
      </div>
    </nav>

    <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-4">

    <div class='container'>    

    <fieldset >
    <h2> 
      Student Registration
    </h2><br/>
    <div class='container'> 

    <form class='form-inline'id='register' action='' method='post' accept-charset='UTF-8'>
        <input type='hidden' name='submitted' id='submitted' value='1'/>
    <div class='short_explanation'>*required </div><br/>
    
    <div class='container'>
        <label for='name' >Your Full Name*: </label><br/>
        <input class="form-control" type='text' size="40" name='name' id='name' value='<?php echo $handler->SafeDisplay('name') ?>' /><br/>
        <span id='register_name_errorloc' class='error'></span>
    </div><br/>
    <div class='container'>
        <label for='department' >Department*:</label><br/>
        <select class="form-control" name='department' id='department'>
            <?php
            for ($i=0; $i < count($Department_List); $i++) { 
                echo '<option value='.$i.'>'.$Department_List[$i].'</option>';
            }
            ?>
        </select><br/>
        <span id='register_department_errorloc' class='error'></span>
    </div><br/>
    <div class='container'>
        <label for='degree' >Degree Level*:</label><br/>
        <select class="form-control" name='degree' id='degree'> 
            <?php
            for ($i=0; $i < count($Degree_Level_List); $i++) { 
                echo '<option value='.$i.'>'.$Degree_Level_List[$i].'</option>';
            }
            ?>
        </select><br/>
        <span id='register_degree_errorloc' class='error'></span>
    </div><br/>
    
    <div class='container'>
        <label for='intl' >Are you an International Student?*</label><br/>
        <select class="form-control" name='intl' id='intl'>
            <option value=0>No</option>
            <option value=1>Yes</option>
        </select><br/>
        <span id='register_international_errorloc' class='error'></span>
    </div>
    <br/> 
    <div class='container col-md-6'>
        <button type="submit" class="btn btn-primary"> Submit</button>
    </div>
    </fieldset>
    </form>     
    </div>
    
  </body>       
</html>