<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"       
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">       
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">       
  <head>       
    <title>Career Fair</title>       
    <meta http-equiv="content-type"       
        content="text/html; charset=utf-8"/>       
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

    <!-- The main CSS file -->
    <link href="css/style.css" rel="stylesheet" />
  </head>       
  <body>     

    <h1>Register as a</h1>   
      <?php

        echo
        "<form action= 'student' method='post'>
        <input type='submit' name='S_button' value='Student' />
        </form>";

        echo
        "<form action='company' method='post'>
        <input type='submit' name='C_button' value='Company' />
        </form>";


      ?>       
  </body>       
</html>