<!DOCTYPE html>
<?php
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
              $getMessage = urlencode($_GET['id']);
				if (isset($_POST['deleteButton'])) {
                    $saveBook = <<<XYZ
                        delete from author WHERE id=$getMessage;
                    XYZ;
                    $quaryNEW = $conn->query($saveBook);
                    $res = $quaryNEW->fetch();

                    $bookdelete = <<<XYZ
                        delete from book_author WHERE author_id=$getMessage;
                    XYZ;
                    $quaryold = $conn->query($bookdelete);
                    $res = $quaryold->fetch();
					header("Location: /author-list.php?added=5");
                    /*echo '<div id="message-block">';
					echo "Removed.";
					echo "</div>";*/
                }
                if(isset($_POST['firstName']) == false) {
                    $data3 = "select * from author where id=$getMessage";
                    $updates = $conn->query($data3);
                    $parts = $updates->fetchAll(PDO::FETCH_NUM);
                    $name = urldecode($parts[0][1]);
                    $lastName = urldecode($parts[0][2]);
                    $grade = urldecode($parts[0][3]);
                }

                
              if(isset($_POST['firstName']) and isset($_POST['lastName']) and isset($_POST['submitButton']))
              {
                $name = urlencode($_POST['firstName']);
                $lastName = urlencode($_POST['lastName']);
                $first_lenght = strlen($name);
                $last_lenght = strlen($lastName);
                if (isset($_POST['grade'])) {
                    $grade = intval($_POST['grade']);
                }
                if ($first_lenght < 1 || $first_lenght > 21 || $last_lenght < 2 || $last_lenght > 22) {
                    if ($first_lenght < 1 || $first_lenght > 21) {
                        echo '<div id="error-block">';
						echo "Title length must be 1-21 symbols.";
						echo "</div>";
                    }
                    if ($last_lenght < 2 || $last_lenght > 22) {
                            echo '<div id="error-block">';
							echo "Title length must be 2-22 symbols.";
							echo "</div>";
                    }
                } else {
                    $saveBook = <<<XYZ
                        UPDATE author SET name='$name', lastname='$lastName', grade=$grade WHERE id=$getMessage;
                    XYZ;
                    $querrry = $conn->query($saveBook);
                    $res = $querrry->fetch();
					header("Location: /author-list.php?added=5");
                    
                }

              }
          ?>
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
    <div class="project-content main-content">
        <form method="post"> 
        <div id="author-add">
            <div class="input-row"><span class="name-col">Eesnimi:</span>
                <span class="input-col"><input class="input-text" type="text" id="fn" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : $name ?>"></span>
            </div>
            <div class="input-row"><span class="name-col">Perekonnanimi:</span>
                <span class="input-col"><input class="input-text" type="text" id="fn" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : $lastName ?>"></span>
            </div>
            <div class="input-row">
                <span class="name-col">Hinne:</span>
                <div class="input-col input-buttons">
                    <div class="div-button">
                        <input type="radio" name="grade" value="1" <?php if($grade ==1 ){echo "checked";}?>> 1
                        <input type="radio" name="grade" value="2" <?php if($grade ==2 ){echo "checked";}?>> 2
                        <input type="radio" name="grade" value="3" <?php if($grade ==3 ){echo "checked";}?>> 3
                        <input type="radio" name="grade" value="4" <?php if($grade ==4 ){echo "checked";}?>> 4
                        <input type="radio" name="grade" value="5" <?php if($grade ==5 ){echo "checked";}?>> 5
                    </div>
                </div>
            </div>
            <input type="submit" value="Salvesta" name="submitButton"/>
            <input class="delete" type="submit" value="Kustuta" name="deleteButton" />
        </div>
		</form>
    </div>
</body>
</html>
