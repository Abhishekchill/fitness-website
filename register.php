<?php

    include("dataBase.php");

    $message = '';

	if(isset($_POST["loginBtn"])){
		$formData = array();
if(empty($_POST["userEmail"])){
			$message .= '<li>Email Address is required</li>';
		}
		else{
			if(!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)){
				$message .= '<li>Invalid Email Address</li>';
			}
			else{
				$formData['userEmail'] = $_POST['userEmail'];
			}
		}

		if(empty($_POST['userName'])){
			$message .= '<li>user Name is Required</li>';
		}
		else{
			$formData['userName'] = $_POST['userName'];
		}

		if(empty($_POST['userPassword'])){
			$message .= '<li>Password is Required</li>';
		}
		else{
			$formData['userPassword'] = $_POST['userPassword'];
		}

		if($message == ''){
			$data = array(
				':userEmail' => $formData['userEmail']
			);

			$query = "
				SELECT user_name FROM user 
				WHERE user_email = :userEmail
			";

			$statement = $connection->prepare($query);
			$statement->execute($data);

			if($statement->rowCount() > 0){
				$message = '<li>Email Already Exists</li>';
			}	
			else{
                $data = array(
                    ':userEmail'			=>	$formData['userEmail'],
                    ':userName'			=>	$formData['userName'],
                    ':userPassword'	    =>	$formData['userPassword'],
                );

                $query = "
                    INSERT INTO login 
                    (name, password, email) 
                    VALUES (:userName, :userPassword, :userEmail)
			    ";

                $statement = $connection->prepare($query);
                $statement->execute($data);
                header('location:login.php');
            }
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>
<style>
/* Add some CSS styles for a colorful login form */
body {
            background-color: rgb(10, 202, 245)
            ;
        }
        form {
            background-color: #FFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #BBB;
            margin: 10% auto;
            width: 400px;
        }
        input {
            border-radius: 5px;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #DDD;
            width: 100%;
        }
        input[type="submit"] {
            background-color: rgb(10, 202, 245);
            color: #FFF;
            font-weight: bold;
            cursor: pointer;
        }
        .error {
            color: #F00;
            font-weight: bold;
            text-align: center;
        }


</style>
<body>
<?php 
            if($message != ''){
                echo '<div class="center"><ul class="list-unstyled alert-danger">'.$message.'</ul></div>';
            }
		?>
    <form method="POST">
        <h5>User Name</h5>
        <input type="text" id="userName" name="userName">
        <h5>User Email</h5>
        <input type="text" id="userEmail" name="userEmail">
        <h5>Password</h5>
        <input type="password" id="userPassword" name="userPassword">
        <input type="submit" value="Register" name="loginBtn"/>
    </form>
</body>
</html>