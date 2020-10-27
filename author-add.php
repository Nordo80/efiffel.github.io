<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Best website</title>
    <link rel="stylesheet" href="mycss.css" />
</head>
<body>
<nav>
    <a id="author-form-link" href="author-add.php"><b>Lisa autor</b></a>
    <span>|</span>
    <a id="author-list-link" href="author-list.php"><b>Autorid</b></a>
    <span>|</span>
    <a id="book-form-link" href="book-add.php"><b>Lisa raamat</b></a>
    <span>|</span>
    <a id="book-list-link" href="index.php"><b>Raamatud</b></a>
</nav>
<div>
        <form method="post"> 
        <div id="author-add">
            <div class="input-row"><span class="name-col">Eesnimi:</span>
                <span class="input-col"><input class="input-text" type="text" id="fn" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : '' ?>"></span>
            </div>
            <div class="input-row"><span class="name-col">Perekonnanimi:</span>
                <span class="input-col"><input class="input-text" type="text" id="fn" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : '' ?>"></span>
            </div>
            <div class="input-row">
                <span class="name-col">Hinne:</span>
                <div class="input-col input-buttons">
                    <div class="div-button">
                        <input type="radio" name="grade" value="1" <?php if(isset($_POST['grade']) && $_POST['grade'] =='1' ){echo "checked";}?>> 1
                        <input type="radio" name="grade" value="2" <?php if(isset($_POST['grade']) && $_POST['grade'] =='2' ){echo "checked";}?>> 2
                        <input type="radio" name="grade" value="3" <?php if(isset($_POST['grade']) && $_POST['grade'] =='3' ){echo "checked";}?>> 3
                        <input type="radio" name="grade" value="4" <?php if(isset($_POST['grade']) && $_POST['grade'] =='4' ){echo "checked";}?>> 4
                        <input type="radio" name="grade" value="5" <?php if(isset($_POST['grade']) && $_POST['grade'] =='5' ){echo "checked";}?>> 5
                    </div>
                </div>
            </div>
            <input type="submit" value="Salvesta" name="submitButton"/>
        </div>
		</form>
    </div>
<?php

	if(isset($_POST['firstName']) and isset($_POST['lastName']))
              {
                $data_name = urlencode($_POST['firstName']);
                $data_lastname = urlencode($_POST['lastName']);
                $first_lenght = strlen($data_name);
                $last_lenght = strlen($data_lastname);
	if ($first_lenght > 21 || $first_lenght < 1 || $last_lenght < 2 || $last_lenght > 22) {
                    if ($first_lenght < 1 || $first_lenght > 21) {
                        echo '<div id="error-block">';
						echo "First name length must be 1-21 symbols.";
						echo "</div>";
                    }
                    if ($last_lenght < 2 || $last_lenght > 22) {
                        echo '<div id="error-block">';
						echo "Last name length must be 2-22 symbols.";
						echo "</div>";
					}
                } else {
	$servername = "db.mkalmo.xyz";
	$username = "efiffel";
	$password = "A3D8";
	$dbname = "efiffel";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully";
		
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	$data_r1 = 0;
	if(isset($_POST["grade"])){
		$data_r1 = urlencode($_POST["grade"]);
	};
	echo $data_name;
	echo $data_lastname;
	echo $data_r1;
	echo $data_r2;
	$sql = "INSERT INTO author (name, lastname, grade) values ('$data_name','$data_lastname',$data_r1);";
    $qu = $conn->query($sql);
    $res = $qu->fetch();
	header("Location: /author-list.php?added=5");
	echo '<div id="error-block">';
	echo "Added.";
	echo "</div>";
				}
			  }
?>
</body>
</html>