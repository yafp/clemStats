<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<link rel="icon" href="img/favicon.ico">
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="theme.css" rel="stylesheet">
	<!-- Main CSS -->
	<link href="css/main.css" rel="stylesheet">
	<script src="js/ie-emulation-modes-warning.js"></script>

	<?php
		include "conf/settings.php";
		include "inc/version.php";
		echo "<title>".$appname." - ".$version." - ".$tagline."</title>";	// generate html header-title

		if (file_exists($dbpath))
					{
						// sqlite stuff - access clementine db file
						class MyDB2 extends SQLite3
						{
							function __construct()
							{
								include "conf/settings.php";
								$this->open($dbpath);
							}

						}
						$db2 = new MyDB2();

						// Show: TRACKS
						$result5 = $db2->query('SELECT COUNT(*) FROM songs WHERE unavailable !="1"');
						while ($row5 = $result5->fetchArray())
						{
							$tracks_all = $row5[0];
						}

						// Show: PLAYED
						$result6 = $db2->query('SELECT COUNT(*) FROM songs WHERE lastplayed <> "-1" and unavailable !="1"');
						while ($row6 = $result6->fetchArray())
						{
							$tracks_played = $row6[0];
							$tracks_played_ratio =  ($tracks_played/$tracks_all)*100;
						}

						// Show: ARTISTS
						$result4 = $db2->query('SELECT COUNT(DISTINCT artist) FROM songs WHERE unavailable !="1"');
						while ($row4 = $result4->fetchArray())
						{
							$overall_artists = $row4[0];
						}

						// Show: ALBUMS
						$result3 = $db2->query('SELECT COUNT(DISTINCT album) FROM songs WHERE unavailable !="1"');
						while ($row3 = $result3->fetchArray())
						{
							$overall_albums = $row3[0];
						}

						// Show: GENRES
						$result2 = $db2->query('SELECT COUNT(DISTINCT genre) FROM songs WHERE unavailable !="1"');
						while ($row2 = $result2->fetchArray())
						{
							$overall_genres = $row2[0];
						}

						// Show: PLAYTIME
						$result7 = $db2->query('SELECT SUM(length) FROM songs WHERE unavailable !="1"');
						while ($row7 = $result7->fetchArray())
						{
							$tracks_playtime = $row7[0] / 60 / 60 /24 /1000000000;
							$tracks_playtime = round($tracks_playtime, 2);
						}
						$now = date("Ymd G:i");				// generate a timestamp
					}
	?>

		<script>
			function updateRandomPick() {
				$('#load').load('inc/updateRandomPick.php').fadeIn("slow");
			}
		</script>
</head>


<body role="document">
	<!-- Fixed navbar -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">clemStats</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="index.php">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Home</a>
					</li>
					<li>
						<a href="queries.php">
							<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Queries</a>
					</li>
					<li>
						<a href="timeline.php">
							<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Timeline</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Help
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Version</li>
							<li><a href="#" onclick="checkForUpdates();">clemStats v<?php echo $version;?></a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Documentation</li>
							<li><a href="https://github.com/yafp/clemStats/wiki">Wiki</a></li>
							<li><a href="https://github.com/yafp/clemStats/issues">Issues</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>



	<div class="container theme-showcase" role="main">
		<br>
		<br>
		<br>

		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
        General Library Informations <small>(<?php echo $dbpath; ?>)</small></a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse in">
					<div class="panel-body">
						<?php
      echo "<h4>Your library comes with a total of <span>".$tracks_all." tracks</span> from <span>".$overall_artists." artists</span> with overall <span>".$overall_albums." albums</span> featuring <span>".$overall_genres." genres</span>.</h4>";

			echo "<h4>This sums up to an approx playtime of <span>".$tracks_playtime." days</span>.</h4>";

			echo "<h4>So far you listened to <span>".$tracks_played." </span> of those <span>".$tracks_all." tracks</span>.</h4>";

			echo "<h4>Insane isn't it</h4>";

      ?>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        Random Album Pick</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse in">
					<div class="panel-body">
						<a href="#" onclick="updateRandomPick();">
							<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
						</a>
						<div id="load">
							<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
							...loading random album pick
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/docs.min.js"></script>
	<script>
		$(document).ready(function() {
			console.log("ready!");
			updateRandomPick();
		});
	</script>
</body>
</html>
