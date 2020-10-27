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
    if(isset($_POST['title']))
    {
        $data_title = urlencode($_POST['title']);
        $title_lenght = strlen($data_title);
		$data_author1 = urlencode($_POST['author1']);
        $data_author2 = urlencode($_POST['author2']);
        if ($title_lenght < 3 ||  $title_lenght > 23 ) {
                echo '<div id="error-block">';
				echo "Title length must be 3-23 symbols.";
				echo "</div>";
        } else {
			if(isset($_POST['grade'])) {
				$data_r1 = urlencode($_POST["grade"]);
			} else {
				$data_r1 = 0;
			}
			$data_r2 = 0;
			if(isset($_POST['isRead'])) {
				$data_r2 = urlencode($_POST["isRead"]);
			}

			echo $data_title;
			echo $data_r1;
			echo $data_r2;
			$qu = $conn->prepare("insert into book (title, grade, is_read) values (:data_title, :data_r1 , :data_r2 )")
            ->execute([':data_title' => $data_title, ':data_r1' => $data_r1, ':data_r2' => $data_r2]);
            
            $sql = "SELECT * FROM book ORDER BY id DESC LIMIT 1";
            $conn2 = $conn->query($sql);
            $bookDD = $conn2->fetchAll(PDO::FETCH_NUM);
            $bookId = $bookDD[0][0];

            
            if ($data_author1 != '-1') {
                $qu10 = $conn->prepare("insert into book_author (book_id, author_id) values (:bookId , :data_author1)");
                $qu10->execute([':bookId' => $bookId, ':data_author1' => $data_author1]);
            }
            if ($data_author2 != '-1') {
                $qu20 = $conn->prepare("insert into book_author (book_id, author_id) values (:bookId , :data_author2)");
                $qu20->execute([':bookId' => $bookId, ':data_author2' => $data_author2]);
            }
            header("Location: /index.php?books=4");
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
<form method="post">
<div id="author-add">
    <div class="input-row"><span class="name-col">Pealkiri:</span>
        <span class="input-col"><input class="input-text" type="text" name="title" id="fn" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>">></span>
    </div>
    <div class="input-row">
        <span class="name-col">Author1:</span>
                <span class="input-col">
                    <select name="author1">
                        <option value="-1"></option>
                        <?php
                        $selection1 = "select * from author";
                        $quarr = $conn->query($selection1);
                        $info = $quarr->fetchAll(PDO::FETCH_NUM);
                        foreach($info as $line) {
                            $ind = $line[0];
                            $name = $line[1];
                            $lastname = $line[2];
                            $grade = $line[3];
                            if(isset($_POST['author1']) && $_POST['author1'] == $ind ){
                                $output = "selected";
                            } else {
                                $output = "";
                            }
                            $variable = <<<XYZ
                                <option value=$ind $output>$name $lastname</option>
                            XYZ;
                            echo $variable;
                        }
                        ?>
                    </select>
                </span>
                </div>
                <div class="input-row">
                <span class="name-col">Author2:</span>
                <span class="input-col">
                    <select name="author2">
                        <option value="-1"></option>
                        <?php
                        foreach($info as $line) {
                            $id9 = $line[0];
                            $name = $line[1];
                            $lastname = $line[2];
                            $grade = $line[3];
                            if(isset($_POST['author2']) && $_POST['author2'] == $id9 ){
                                $select = "selected";
                            } else {
                                $select = "";
                            }
                      
                            echo $variable;
							echo "<option value=";
							echo $id9;
							echo " ";
							echo $select;
							echo ">";
							echo $name;
							echo " ";
							echo $lastname;
							echo "</option>";
                        }
                        ?>
                    </select>
                </span>
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
			<div class="input-row">
                <span class="name-col">Loetud:</span>
                <span class="input-col">
                <input class="input-text" type="checkbox" id="read" name="isRead" value="1" <?php if(isset($_POST['isRead']) && $_POST['isRead'] == "1" ){echo "checked";}?>>
                 </span>
            </div>
        </div>
    </div>
</div>
<input class="button" type="submit" name="submitButton" value="Salvesta" />
</form>
</body>
</html>