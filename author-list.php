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
    <?php
        if (isset($_GET['added'])) {
            $added_get = urlencode($_GET['added']);
            if ($added_get == "5") {
                echo '<div id="message-block">';
				echo "Added";
				echo "</div>";
            }
        }
    ?>
    <div id="book-list">
    <div class="head-cell">
        <div class = "title-cell header-cell">Nimi</div>
        <div class = "author-cell header-cell">Perekonnanimi</div>
        <div class = "grade-cell header-cell">Hinne</div>
    </div>
	</div>
               
                <tbody>
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
			$sql = "select * from author";
            $quare = $conn->query($sql);
            $fin = $quare->fetchAll(PDO::FETCH_NUM);
            foreach($fin as $line) {
                $id = $line[0];
                $name = $line[1];
                $lastname = $line[2];
                $grade = $line[3];
                echo '<tr class="head-cell"><td class="title-cell"><a href="/edit-authors.php?id=';
				echo $id;
				echo '">';
				echo $name;
				echo '</a></td><td class="author-cell">';
                echo $lastname;
                echo '</td><td class="grade-cell">';
                echo $grade;
                echo '</td></tr>';
                $id += 1;
                }
                ?>
                </tbody>
              
           
  
</body>
</html>