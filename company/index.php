<?PHP
require_once("/../util/config.php");
session_start();

if(isset($_POST['loggedin']))
{
   if($handler->CheckCompany($_POST['cName']))
   {
        $_SESSION['companyID'] = $GLOBALS['companyID'];
        $_SESSION['companyName'] = $GLOBALS['companyName'];

        //Todo Registration Success Notification
        $handler->RedirectToURL("manage");
   } else {
        echo "First Things First. Register yourself ".$_POST['cName'];
   }
}

if(isset($_POST['submitted']))
{
   if($handler->RegisterCompany())
   {
        $_SESSION['companyID'] = $GLOBALS['companyID'];
        $_SESSION['companyName'] = $GLOBALS['companyName'];
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
    <fieldset >
    <form id='login' action='' method='post' accept-charset='UTF-8'>
    <h2><legend>Login</legend></h2>
    <input type='hidden' name='loggedin' id='loggedin' value='1'/>
    <div class='container'>
        <label for='cName' >Enter Company Name: </label><br/>
        <input type='text' name='cName' id='cName' value='<?php echo $handler->SafeDisplay('cName') ?>' maxlength="50" /><br/>
    </div>
    <div class='container'>
        <input type='submit' name='in' value='Log In' />
    </div>
    </form>
    </fieldset>
    </div>

    <div id='fg_membersite'>
    <form id='register' action='' method='post' accept-charset='UTF-8'>
    <fieldset >
    <h2> 
      <legend>Register</legend>
    </h2>

    <input type='hidden' name='submitted' id='submitted' value='1'/>

    <div class='short_explanation'>*required fields </div>

    <div class='container'>
        <label for='name' >Company Name*: </label><br/>
        <input type='text' name='name' id='name' value='<?php echo $handler->SafeDisplay('name') ?>' maxlength="50" /><br/>
        <span id='register_name_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='site' >Website:</label><br/>
        <input type='text' name='site' id='site' value='<?php echo $handler->SafeDisplay('site') ?>' maxlength="50" /><br/>
        <span id='register_department_errorloc' class='error'></span>
    </div>
    <div class='container'>
        <label for='amount' >Sponsorship Amount* (in USD): <br/>
          (Be a Platinum sponsor for $15k and Gold Sponsor for $10k)
        </label><br/>
        <input type='text' name='amount' id='amount' value='<?php echo $handler->SafeDisplay('amount') ?>' maxlength="50" /><br/>
        <span id='register_degree_errorloc' class='error'></span>
    </div>

    <div class='container'>
        <input type='submit' name='Submit' value='Register' />
    </div>

    </fieldset>
    </form>  
  </div>     
  </body>       
</html>