<html>
    <head>
        <title>XMLP Projekt - Register</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                    <label for="firstname" class="form-label">Firstname</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" />
                </div>

                <div class="col-md-4">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" />
                </div>

                <div class="col-md-4">
                    <label for="role" class="form-label">User Role</label>
                    <select id="role" name="role" class="form-control"> 
                        <option value="Administrator">Administrator</option>
                        <option value="User" selected>User</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <input type="submit" value="REGISTER" class="btn btn-primary" />
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
    else if(empty($_POST["role"])) {
        echo "Role cannot be empty.";
    }
	else {
		$username= $_POST["username"];
		$password= $_POST["password"];
        $role = $_POST["role"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
	
		$result = register($username, $password, $role, $firstname, $lastname);

        if($result->Code == 0) {
            echo "<p class=\"text-success\">Registration successful!</p>";
        }
        else {
            echo '<p class="text-danger">Registration failed. Result code: ' . $result->Message . '</p>';
        }
	}
}

class RegistrationResult {
    public $Code;
    public $Message;
}


function register($username, $password, $role, $firstname, $lastname) {
	$registerResult = new RegistrationResult();

    try {
        $xml = simplexml_load_file("users.xml");
        $xpathResult = $xml->xpath("//user[not(@id < //user/@id)]/@id");
        $newId = intval($xpathResult[0]) + 1;

        $element = $xml->addChild("user");
        $element->addAttribute("id", $newId);

        $element->addChild("username", $username);
        $element->addChild("password", $password);
        $element->addChild("role", $role);
        $element->addChild("firstname", $firstname);
        $element->addChild("lastname", $lastname);

        $dom = new DOMDocument("1.0");

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        $dom->save("users.xml");

        $registerResult->Code = 0;
    }
    catch(Exception $e) {
        $registerResult->Code = -1;
        $registerResult->Message = $e->getMessage();
    }
	
	return $registerResult;
}

?>

            </form>
        </main>
    </body>
</html>