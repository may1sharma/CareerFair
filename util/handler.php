<?PHP
require_once("formvalidator.php");

class FairHandler
{
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;

    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;        
    }

    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysql_error());
    }

    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
    
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
    
    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="nobody@$host";
        return $from;
    } 
    
    function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
    function CheckLoginInDB($username,$password)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }          
        $username = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        $qry = "Select name, email from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }
        
        $row = mysql_fetch_assoc($result);
        
        
        $_SESSION['name_of_user']  = $row['name'];
        $_SESSION['email_of_user'] = $row['email'];
        
        return true;
    }
    
    function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = mysql_query("Select name, email from $this->tablename where confirmcode='$confirmcode'",$this->connection);   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_rec['name'] = $row['name'];
        $user_rec['email']= $row['email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }      
        return true;
    }
        
    function CollectRegistrationSubmission(&$formvars)
    {
        $formvars['name'] = $this->Sanitize($_POST['name']);
        $formvars['department'] = $this->Sanitize($_POST['department']);
        $formvars['degree'] = $this->Sanitize($_POST['degree']);
        $formvars['intl'] = $this->Sanitize($_POST['intl']);
    }

    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
    function IsFieldUnique($formvars,$fieldname)
    {
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "select username from $this->tablename where $fieldname='".$field_val."'";
        $result = mysql_query($qry,$this->connection);   
        if($result && mysql_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DBLogin()
    {

        $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
        if(!mysqli_select_db($this->connection, $this->database))
        {
            $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
            return false;
        }
        if(!mysqli_set_charset($this->connection, 'utf8'))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    
    
    function MakeConfirmationMd5($email)
    {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
    function SanitizeForSQL($str)
    {
        if( function_exists( "mysql_real_escape_string" ) )
        {
              $ret_str = mysqli_real_escape_string($this->connection, $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
    /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }    
    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }    

    //-------Main Operations ----------------------
    //----------Student----------------------------

    function ValidateStudentRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->addValidation("name","req","Please fill in Name");
        $validator->addValidation("department","req","Please fill in Department");
        $validator->addValidation("degree","req","Please fill in Degree");

        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
        return true;
    }
    
    function RegisterStudent()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateStudentRegistrationSubmission())
        {
            return false;
        }
        
        // $this->CollectRegistrationSubmission($formvars);

        $formvars['name'] = $_POST['name'];
        $formvars['department'] = $_POST['department'];
        $formvars['degree'] = $_POST['degree'];
        $formvars['intl'] = $_POST['intl'];
        
        if(!$this->AddStudent($formvars))
        {
            return false;
        }
        
        return true;
    }

    function AddStudent(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        if(!$this->EnsureStudentTable())
        {
            return false;
        }   
        if(!$this->InsertStudent($formvars))
        {
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }

    function EnsureStudentTable()
    {
        $result = mysqli_query($this->connection, "SHOW COLUMNS FROM STUDENT");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return $this->CreateStudentTable();
        }
        return true;
    }
    
    function CreateStudentTable()
    {
        $qry = "Create Table STUDENT (".
                "id_user INT NOT NULL AUTO_INCREMENT ,".
                "name VARCHAR( 45 ) NOT NULL ,".
                "department VARCHAR(45) NOT NULL,".
                "degree_level VARCHAR(45) NOT NULL,".
                "isInternational BIT(1) NOT NULL DEFAULT 0,".
                "PRIMARY KEY (id))".
                ")";
                
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function InsertStudent(&$formvars)
    {
        $insert_query = 'insert into student(
                name,
                department,
                degree_level,
                isInternational
                )
                values
                (
                "' . $formvars['name'] . '",
                "' . $formvars['department'] . '",
                "' . $formvars['degree'] . '",
                ' . $formvars['intl'] . '
                )';      
        if(!mysqli_query($this->connection, $insert_query))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }        
        return true;
    }  

    //-------------------Company-----------------------

    function ValidateCompanyRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->addValidation("name","req","Please fill in Name");
        $validator->addValidation("amount","req","Please fill in the Sponsorship Amount");
        $validator->addValidation("amount","num","Please fill in a Numeric value");
        $validator->addValidation("amount","gt=5000","Minimum value $5000");

        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
        return true;
    }
        
    function RegisterCompany()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateCompanyRegistrationSubmission())
        {
            return false;
        }
        
        // $this->CollectRegistrationSubmission($formvars);

        $formvars['name'] = $_POST['name'];
        $formvars['amount'] = $_POST['amount'];

        if($_POST['amount'] >= 15000)
        {
            $formvars['location'] = "Prime Arena, Ground floor";
            $formvars['size'] = 40;
        } elseif ($_POST['amount'] >= 10000) {
            $formvars['location'] = "Game Arena, Ground floor";
            $formvars['size'] = 25;
        } else {
            $formvars['location'] = "Assembly Ground";
            $formvars['size'] = 15;
        }
        
        if(!$this->AddCompany($formvars))
        {
            return false;
        }
        
        return true;
    }

    function AddCompany(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        if(!$this->EnsureCompanyTables())
        {
            return false;
        }   
        if(!$this->InsertCompany($formvars))
        {
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }

    function EnsureCompanyTables()
    {
        $result = mysqli_query($this->connection, "SHOW COLUMNS FROM BOOTH");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return $this->CreateBoothTable();
        }

        $result = mysqli_query($this->connection, "SHOW COLUMNS FROM COMPANY");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return $this->CreateCompanyTable();
        }

        $result = mysqli_query($this->connection, "SHOW COLUMNS FROM SPONSORSHIP");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return $this->CreateSponsorshipTable();
        }
        return true;
    }
    
    function CreateBoothTable()
    {
        $qry = "Create Table BOOTH (".
                "id INT NOT NULL AUTO_INCREMENT ,".
                "location VARCHAR( 100 ) NOT NULL ,".
                "size FLOAT UNSIGNED NULL DEFAULT 10 COMMENT 'in sqft',".
                "PRIMARY KEY (id))".
                ")";
                
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function CreateCompanyTable()
    {
        $qry = "Create Table COMPANY (".
                "id INT NOT NULL AUTO_INCREMENT,".
                "name VARCHAR(45) NOT NULL,".
                "Booth_id INT NOT NULL,".
                "PRIMARY KEY (id),".
                "CONSTRAINT fk_Company_Booth1 ".
                "FOREIGN KEY (Booth_id)".
                "REFERENCES ". $this->database.".Booth (id)".
                "ON DELETE NO ACTION".
                "ON UPDATE NO ACTION".
                ")";
                
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function CreateSponsorshipTable()
    {
        $qry = "Create Table SPONSORSHIP (".
                "amount FLOAT NOT NULL COMMENT 'in USD',".
                "category INT(10) GENERATED ALWAYS AS (amount / 5000) VIRTUAL,".
                "Company_id INT NOT NULL,".
                "PRIMARY KEY (Company_id),".
                "CONSTRAINT fk_Sponsorship_Company1".
                "FOREIGN KEY (Company_id)".
                "REFERENCES ". $this->database.".Company (id)".
                "ON DELETE NO ACTION".
                "ON UPDATE NO ACTION".
                ")";
                
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function InsertCompany(&$formvars)
    {
        $insert_query = 'insert into booth(
                location,
                size
                )
                values
                (
                "' . $formvars['location'] . '",
                ' . $formvars['size'] . '
                )';      
        if(!mysqli_query($this->connection, $insert_query))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }  
        $boothID = mysqli_insert_id($this->connection);

        $insert_query = 'insert into company(
                name,
                Booth_id
                )
                values
                (
                "' . $formvars['name'] . '",
                ' . $boothID . '
                )';      
        if(!mysqli_query($this->connection, $insert_query))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }  

        $companyID = mysqli_insert_id($this->connection);

        $insert_query = 'insert into sponsorship(
                amount,
                Company_id
                )
                values
                (
                ' . $formvars['amount'] . ',
                ' . $companyID . '
                )';      
        if(!mysqli_query($this->connection, $insert_query))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }        
        return true;
    }
}

?>