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



	<!-- Idee -->
	<!--
	anwender hat einige Dropdown-boxen:
	- genres
	- year (from - to)
	- Button: Generate

	- App generiert eine timeline daraus - die das irgendwie visualisiert

	Lib for graph:
	http://d3js.org/


	vorbild:
	https://music-timeline.appspot.com/about.html
	-->

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
					<li class="active"><a href="timeline.php"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Timeline</a></li>
					<li><a href="tagcloud.php"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Tagcloud</a></li>
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
		<form name="form1" Method="GET" Action="timeline.php">

			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Timeline</a></h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
							This is a dummy page so far ....
							<br>

							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
									Genre
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
								</ul>
							</div>

							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
									From
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
								</ul>
							</div>

							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
									To
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
									<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
								</ul>
							</div>

							<button type="button" class="btn btn-lg btn-default">Generate</button>

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
</body>
</html>
