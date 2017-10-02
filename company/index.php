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
          <li><a href="../search">Job Search</a></li>
          <li><a href="../student">Students</a></li>
          <li class="active"><a href="../company">Companies</a></li>
        </ul>
      </div>
    </nav>

    <div class='container'>
    <div class='container'>
    <div class='container'>
    <div class="row">
    <div class="col-sm-4">

    <div class='container'> 
    <fieldset >
    <form class="form-inline" id='login' action='' method='post' accept-charset='UTF-8'>
    <h2>Login</h2><br/>
    <input type='hidden' name='loggedin' id='loggedin' value='1'/>
    <div class='container'>
        <label for='cName' >Enter Company Name: </label><br/>
        <input class="form-control" type='text' name='cName' id='cName' value='<?php echo $handler->SafeDisplay('cName') ?>' maxlength="50" /><br/>
    </div>
    <br/>
    <div class='container'>
        <button type="submit" class="btn btn-default" name='in' >Log In</button>
    </div>
    </form>
    </fieldset>
    </div>

    </div>
    <div class="col-sm-2"> 
        <br/><br/><br/><br/><br/><br/><h1> OR </h1>
    </div>
    <div class="col-sm-6">

    <div class='container'>
    <form class="form-inline" id='register' action='' method='post' accept-charset='UTF-8'>
    <fieldset >
    <h2> Register    </h2><br/>

    <input type='hidden' name='submitted' id='submitted' value='1'/>

    <div class='short_explanation'>*required  </div>

    <div  class='container'>
        <label for='name' >Company Name*: </label><br/>
        <input class="form-control" type='text' name='name' id='name' value='<?php echo $handler->SafeDisplay('name') ?>' maxlength="50" /><br/>
        <span id='register_name_errorloc' class='error'></span>
    </div>
    <br/>
    <div class='container'>
        <label for='site' >Website:</label><br/>
        <input class="form-control" type='text' name='site' id='site' value='<?php echo $handler->SafeDisplay('site') ?>' maxlength="50" /><br/>
        <span id='register_department_errorloc' class='error'></span>
    </div>
    <br/>
    <div class='container'>
        <label for='amount' >Sponsorship Amount* (in USD): <br/>
          (Be a Platinum sponsor for $15k and Gold Sponsor for $10k)
        </label><br/>
        <input class="form-control" type='text' name='amount' id='amount' value='<?php echo $handler->SafeDisplay('amount') ?>' maxlength="50" /><br/>
        <span id='register_degree_errorloc' class='error'></span>
    </div>
    <br/>
    <div class='container'>
        <button type="submit" class="btn btn-default" name='Submit'>Submit</button>
    </div>

    </fieldset>
    </form>  
    </div>     
</div>
    </div>
    </div> 
  </body>       
</html>