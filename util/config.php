<?PHP
require_once("handler.php");

$handler = new FairHandler();

//Provide your database login details here:
//hostname, user name, password, database name and table name
$handler->InitDB(
				  // 'database2.cs.tamu.edu', 
				  /*hostname*/'localhost',
                  // 'mayank.sharma',  
                  /*username*/'id3205165_mayank',
                  //BlaBla123
                  /*password*/'H0stM@yank',
                  /*database name*/'id3205165_mayankdb',
                  /*table name*/'Student');

$handler->SetRandomKey('qSRcVS6DrTzssdM1SdrPvr');

$DebugMode = 0; // Set Error Debugging Mode ON{1} or OFF{0}

// List all Degree Levels here
$Degree_Level_List = array("Select Degree", "Freshmen", "Sophomores", "Juniors", "Seniors", "Masters", "PhD");

// List all Departments here
$Department_List = array("Select Department", "Computer Science", "Computer Engineering", "Electronics", "Mechanical", "Civil", "Chemical", "Performing Arts", "Mathematics", "Psychology");

?>