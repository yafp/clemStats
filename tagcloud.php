<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="a clementine database analyzer">
	<meta name="author" content="yafp">

	<link rel="icon" href="img/favicon.ico">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">



	<?php
		include "conf/settings.php";
		include "inc/version.php";
		echo "<title>".$appname." - ".$version." - ".$tagline."</title>";	// generate html header-title
	?>
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
					<li><a href="index.php"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Home</a></li>
					<li><a href="queries.php"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Queries</a></li>
					<li><a href="timeline.php"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Timeline</a></li>
					<li class="active"><a href="tagcloud.php"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Tagcloud</a></li>
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
		<form name="form1" Method="GET" Action="tagcloud.php">

			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">WIP - Tagcloud configuration</a></h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
							<br>

							<select name="tagCloudDataSource" required>
								<option selected disabled >Choose...</option>
								 <option value="1">Most played Artists</option>
								 <option value="2">Most played Genres</option>
								 <option value="3">Most played Albums</option>
								</select>

							<div class="form-group">
						    <label for="sel1">Select amount</label>
						    <select class="form-control" id="amount" name="amount">
						      <option>10</option>
						      <option>25</option>
						      <option>50</option>
						      <option>100</option>
						    </select>
						  </div>

							<button type="submit" class="btn btn-lg btn-default">Generate Tagcloud</button>

							<a href="tagcloud.html">First test with d3-cloud js lib</a>

						</div>
					</div>
				</div>

			</div>
		</form>
	</div>
	<!-- /container -->


	<!-- JavaScript -- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" language="javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>

	<script type="text/javascript" language="javascript" src="js/d3-cloud/build/d3.layout.cloud.js"></script>
</body>
</html>



<?php
	//
	// SHOWING QUERY RESULT
	//
	if(isset($_GET["amount"]))
	{
		// init stuff
		include "conf/settings.php";			// contains some core-strings


		$cloudPattern = $_GET["tagCloudDataSource"];
		$amount = $_GET["amount"];

		echo $amount;
		echo "<br>";
		//echo $cloudPattern;

		switch ($cloudPattern)
		{
		    case 1:
		        echo "SELECT distinct artist, sum(playcount) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(playcount) desc LIMIT 10";
		        break;
		    case 2:
		        echo "SELECT distinct genre, sum(playcount), count(*) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY genre ORDER BY sum(playcount) desc LIMIT 10";
		        break;
		    case 3:
		        echo "SELECT distinct album, sum(playcount), artist FROM songs WHERE playcount > 0 and unavailable != '1'  and album!='' GROUP BY album ORDER BY sum(playcount) desc LIMIT 10";
		        break;
		}
	}

?>
