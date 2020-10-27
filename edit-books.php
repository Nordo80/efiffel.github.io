<!DOCTYPE html>
<?php
    $getMessage = urlencode($_GET['id']);
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

    if(isset($_POST['title']) == false) {
        $creates1 = "select * from book where id=$getMessage"; 
        $que1 = $conn->query($creates1);
        $parts = $que1->fetchAll(PDO::FETCH_NUM);
        $title = $parts[0][1];
        $grade = intval($parts[0][4]);
        $read = intval($parts[0][5]);
		$selBookAu = "select * from book_author where book_id=$getMessage"; 
        $qu12 = $conn->query($selBookAu);
        $data12 = $qu12->fetchAll(PDO::FETCH_NUM);
		if (count($data12) >= 1) {
            $auth1 = $data12[0][1];
        } else {
            $auth1 = "-1";
        }
        if (count($data12) == 2) {
            $auth2 = $data12[1][1];
        } else {
            $auth2 = "-1";
        }
		
    }
	

    if (isset($_POST['deleteButton'])) {
        $deleteBook = <<<XYZ
            delete from book WHERE id=$getMessage;
        XYZ;
        $qu3 = $conn->query($deleteBook);
        $res = $qu3->fetch();

        $authbooks = <<<XYZ
                    delete from book_author WHERE book_id=$getMessage;
        XYZ;
        $qu11 = $conn->query($authbooks);
        $res = $qu11->fetch();
			header("Location: /index.php?books=4");
    }

    if(isset($_POST['title']) && isset($_POST['submitButton']))
    {
		$auth1 = urlencode($_POST['author1']);
        $auth2 = urlencode($_POST['author2']);
        $title = urlencode($_POST['title']);
        $title_lenght = strlen($title);
		$grade = 0;
        if (isset($_POST['grade'])) {
            $grade = intval($_POST['grade']);
        }
        $read = 0;
        if (isset($_POST['isRead'])) {
                $read = 1;
        }
        if ($title_lenght < 3 ||  $title_lenght > 23) {
            echo '<div id="error-block">';
			echo "Title length must be 3-23 symbols.";
			echo "</div>";
        } else {
			$saveBook = <<<XYZ
            UPDATE book SET title='$title', grade=$grade, is_read=$read WHERE id=$getMessage;
            XYZ;
            $qu211 = $conn->query($saveBook);
            $res = $qu211->fetch();

            $delBookAuth = <<<XYZ
                    delete from book_author WHERE book_id=$getMessage;
            XYZ;
            $qu11 = $conn->query($delBookAuth);
            $res = $qu11->fetch();

			
            if ($auth1 != '-1') {
                $saveAuth1 = <<<XYZ
                insert into book_author (book_id, author_id) values ($getMessage, $auth1);
                XYZ;;
                $qu31 = $conn->query($saveAuth1);
                $res = $qu31->fetch();
            }
            if ($auth2 != '-1') {
                $saveAuth2 = <<<XYZ
                insert into book_author (book_id, author_id) values ($getMessage, $auth2);
                XYZ;
                $qu32 = $conn->query($saveAuth2);
                $res = $qu32->fetch();
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
        <span class="input-col"><input class="input-text" type="text" name="title" id="fn" value="<?php echo isset($_POST['title']) ? $_POST['title'] : $title ?>"></span>
    </div>
    <div class="input-row">
        <span class="name-col">Author1:</span>
                <span class="input-col">
                    <select name="author1">
                        <option value="-1"></option>
                        <?php
                        $selected1 = "select * from author";
                        $quary5 = $conn->query($selected1);
                        $info1 = $quary5->fetchAll(PDO::FETCH_NUM);
                        foreach($info1 as $line) {
                            $idid = $line[0];
                            $name = $line[1];
                            $lastname = $line[2];
                            if($auth1 == $idid ){
                                $select = "selected";
                            } else {
                                $select = "";
                            }
							echo "<option value=";
							echo $idid;
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
                <span class="name-col">Author2:</span>
                <span class="input-col">
                    <select name="author2">
                        <option value="-1"></option>
                        <?php
                        foreach($info1 as $line) {
                            $id4 = $line[0];
                            $name = $line[1];
                            $lastname = $line[2];
                            if($auth2 == $id4 ){
                                $select = "selected";
                            } else {
                                $select = "";
                            }
							echo "<option value=";
							echo $id4;
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
                <input type="radio" name="grade" value="1" <?php if($grade == 1 ){echo "checked";}?>> 1
                <input type="radio" name="grade" value="2" <?php if($grade == 2 ){echo "checked";}?>> 2
                <input type="radio" name="grade" value="3" <?php if($grade == 2 ){echo "checked";}?>> 3
                <input type="radio" name="grade" value="4" <?php if($grade == 4 ){echo "checked";}?>> 4
                <input type="radio" name="grade" value="5" <?php if($grade == 5 ){echo "checked";}?>> 5
            </div>
			<div class="input-row">
                <span class="name-col">Loetud:</span>
                <span class="input-col">
                <input class="input-text" type="checkbox" id="read" name="isRead" value="1" <?php if($read == 1){echo "checked";}?>>
                 </span>
            </div>
        </div>
    </div>
<input class="button" type="submit" name="submitButton" value="Salvesta" />
<input class="delete" type="submit" value="Kustuta" name="deleteButton" />
</div>
</form>
</body>
</html>