<?php
	include_once("./databaseTools.php");
?>

<html>

<head>
	<title>Twitter 
		<?php
			if ( isset($_SESSION['username']) ) {
				echo $_SESSION['username'];
			}
		?>
	</title>
</head>

<body>
	<div id="header">
		<h1>Twitter Project</h1>
	</div>
	
	<div id="content">
		<h2>News Feed:</h2>
		<ul id="newsList">
			<?php
				//Query the db for all tweets/PMs related to the current user
				$query = "SELECT users.id as usr, tweets.message as msg\n"
					   . "FROM users, tweeted, tweets\n"
					   . "WHERE users.id=tweeted.userid and tweeted.tid=tweets.id";
				$result = run_sql($query);
				//Loop through the set of tweets
				while ( $row=mysql_fetch_array($result) ) {
					?>
					<li> @<?php echo $row['usr'] ?> tweeted "<?php echo $row['msg'] ?>" </li>
					<?php
				}
			?>
		</ul>
	</div>
</body>

</html>
