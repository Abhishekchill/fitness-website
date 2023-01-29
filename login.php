<?php

include("dataBase.php");

$message = "";

    if(isset($_POST["loginBtn"])){
        $formdata = array();

		if(empty($_POST["userName"])){
			$message .= '<li>User Name is required</li>';
		}
		else{
			$formdata['userName'] = $_POST['userName'];
		}

		if(empty($_POST['userPassword'])){
			$message .= '<li>Password is Required</li>';
		}
		else{
			$formdata['userPassword'] = $_POST['userPassword'];
		}

        if(empty($_POST['userEmail'])){
			$message .= '<li>Email is Required</li>';
		}
		else{
			$formdata['userEmail'] = $_POST['userEmail'];
		}

		if($message == ''){
			$data = array(
				':userEmail' => $formdata['userEmail']
			);

			$query = "
				SELECT * FROM login 
				WHERE email = :userEmail
			";

			$statement = $connection->prepare($query);
			$statement->execute($data);

			if($statement->rowCount() > 0){
				foreach($statement->fetchAll() as $row){
					if($row['password'] == $formdata['userPassword']){
						$_SESSION['userId'] = $row['id'];
						header('location:fitnessService.php');
					}
					else{
						$message = '<li>Wrong Password</li>';
					}
				}
			}	
			else{
				$message = '<li>Wrong User Name</li>';
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
    <title>Document</title>
</head>
<style>
   
    /* Add some CSS styles for a colorful login form */
    body {
            background-color: #233067;
        }
        form {
            background-color: #B9BFFF;

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
            background-color: #5F9EA0;
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
        <h5>User Name </h5>
        <input type="text" id="userName" name="userName">
        <h5>User Email</h5>
        <input type="text" id="userEmail" name="userEmail">
        <h5>Password</h5>
        <input type="password" id="userPassword" name="userPassword">
        <input type="submit" value="Login" name="loginBtn"/>
    </form>
</body>
</html>