<?PHP
require_once("/../util/config.php");
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

        $handler->RedirectToURL("success");
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
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="STYLESHEET" type="text/css" href="util/css/fg_membersite.css" />
    <!-- The main CSS file -->
    <link href="util/css/style.css" rel="stylesheet" />
  </head>       
  <body>     
    <?PHP 
    if ($DebugMode) {
        echo "<div><span class='error'>". $handler->GetErrorMessage() ."</span></div>";
    }
    ?>

    <div id='fg_membersite'>
    <form action='../'method='post'>
        <input type='submit' name='Home' value='Home' />
    </form>

    <form id='register' action='' method='post' accept-charset='UTF-8'>
    <fieldset >
    <h2> 
      <legend>Register</legend>
    </h2>

    <input type='hidden' name='submitted' id='submitted' value='1'/>

    <div class='short_explanation'>*required fields </div>
    
    <div class='container'>
        <label for='name' >Your Full Name*: </label><br/>
        <input type='text' name='name' id='name' value='<?php echo $handler->SafeDisplay('name') ?>' maxlength="50" /><br/>
        <span id='register_name_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='department' >Department*:</label><br/>
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
        <label for='degree' >Degree Level*:</label><br/>
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
        <label for='intl' >Are you an International Student?*</label><br/>
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
  </body>       
</html>