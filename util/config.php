<?PHP
require_once("handler.php");

$handler = new FairHandler();

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$handler->InitDB(/*hostname*/'localhost:3307',
                      /*username*/'root',
                      /*password*/'',
                      /*database name*/'mayank.sharma-careerfair',
                      /*table name*/'student');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$handler->SetRandomKey('qSRcVS6DrTzrPvr');

?>