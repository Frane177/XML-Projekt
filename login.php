<html>
    <head>
        <title>XMLP Projekt - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link href="style.css" rel="stylesheet" >
    </head>

    <body>
        <header class="py-1 my-2">
            <p class="justify-content-center" style="text-align:center;">&copy;2022 Frane Golem</p>
        </header>
        <div class="header_divider"></div>
        <div>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="./index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
        </div>
        <main class="container">
            <form method="POST" autocomplete="off">
                <div class="col-md-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required />
                </div>

                <div class="col-md-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required />
                </div>

                <div class="col-md-4">
                    <input type="submit" value="LOGIN" class="btn btn-primary" />
                </div>

<?php

$username="";
$password="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (empty($_POST["username"]))  {
        echo "Username cannot be empty.";
    }
	else if (empty($_POST["password"]))  {
        echo "Password cannot be empty.";
    }
	else {
		$username= $_POST["username"];
		$password= $_POST["password"];
	
		$result = authenticate($username, $password);

        if($result->Code == 0) {
            echo '<p class="text-success">Welcome ' . $result->Firstname . '!</p>';

            $xml = simplexml_load_file("users.xml");

            //echo $xml->asXML();
            $xsl = simplexml_load_file('users.xsl');

            $xslt = new XSLTProcessor;
            $xslt->importStyleSheet($xsl);

            echo "<div>" . $xslt->transformToXML($xml) . "</div>";
        }
        else {
            echo '<p class="text-danger">Login failed: ' . $result->Message . '</p>';
        }
	}
}

class AuthenticationResult {
    public $Code;
    public $Message;

    public $Id;
    public $Username;
    public $Firstname;
    public $Lastname;
    public $Role;
}


function authenticate($username, $password) {
	$authResult = new AuthenticationResult();

	$xml = simplexml_load_file("users.xml");
	
	foreach ($xml->user as $user) {
  	 	$userName = $user->username;
		$userPwd = $user->password;

		if($userName == $username){
            if($userPwd == $password){
                $authResult->Code = 0;

                $authResult->Id = $user->attributes()->id;
                $authResult->Username = $username;
                $authResult->Firstname = $user->firstname;
                $authResult->Lastname = $user->lastname;
                $authResult->Role = $user->role;

                return $authResult;
            }
            else{

                $authResult->Code = -1;
                $authResult->Message = "Incorrect password.";
                return $authResult;
            }
		}
	}
		
    $authResult->Code = -2;
    $authResult->Message = "User not found!";
	return $authResult;
}

?>

            </form>
        </main>
    </body>
</html>