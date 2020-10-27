<!DOctype html>
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
        if (isset($_GET['books'])) {
            $books_get = urlencode($_GET['books']);
            if ($books_get == "4") {
                echo '<div id="message-block">';
				echo "Added.";
				echo "</div>";
            }
        }
    ?>
    <div id="book-list">
    <div class="head-cell">
        <div class = "title-cell header-cell">Pealkiri</div>
        <div class = "author-cell header-cell">Autorid</div>
        <div class = "grade-cell header-cell">Hinne</div>
		<div class = "grade-cell header-cell">Kas lugenud</div>
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
            $mainxyz = <<<XYZ
            SELECT id, title, grade, is_read, GROUP_CONCAT(auth) AS author
            FROM (
            SELECT books.id as id, books.title as title, books.grade as grade, books.is_read as is_read, authors.id as auth_id,
            CONCAT(authors.name, ' ', authors.lastname) as auth
            FROM book as books
            LEFT JOIN book_author as booksAauthors
            ON books.id = booksAauthors.book_id
            LEFT JOIN author as authors
            ON booksAauthors.author_id = authors.id) as book_all
            GROUP BY id;
            XYZ;
            $queryn = $conn->query($mainxyz);
            $info22 = $queryn->fetchAll(PDO::FETCH_NUM);
            foreach($info22 as $line) {
                $id10 = $line[0];
                $title = urldecode($line[1]);
                $grade = $line[2];
                $read = $line[3];
                $authors = str_replace(",",", ",$line[4]);
                echo '<tr class="head-cell"><td class="title-cell"><a href="/edit-books.php?id=';
				echo $id10;
				echo '">';
				echo $title;
				echo '</a></td><td class="author-cell">';
                echo $authors;
				echo '</td><td class="author-cell">';
                echo $grade;
                echo '</td><td class="grade-cell">';
                echo $read;
                echo '</td></tr>';
                }
            ?>
            </tbody>
         <footer class="project-footer">Made by Aleksandr Borovkov</footer>
       
</body>
</html>