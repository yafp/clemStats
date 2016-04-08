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
	<style type="text/css" title="currentStyle">
	@import "css/table.css";
	</style>
	<link href="css/main.css" rel="stylesheet">
	<script type="text/javascript" language="javascript" src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTables-1.10.9/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTables-1.10.9/extensions/Scroller/js/dataTables.scroller.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/Chart.js_Regaddi/Chart.min_20130509.js"></script>
	<script type="text/javascript" charset="utf-8">
	var asInitVals = new Array();

	$(document).ready(function() {
		var oTable = $('#example').dataTable({
			"sDom": 'T<"clear">lfrtip',
			scrollY:        400,
			deferRender:    true,
			scroller:       true,
			"bSortClasses": false, // should speed it up a little - TESTING
			"aLengthMenu": [
				[10, 25, 50, 100, 500, -1],
				[10, 25, 50, 100, 500, "All"]
			],
			"iDisplayLength": 100,
			"oLanguage": {
				"sSearch": "Search all columns:"
			}
		});
		$("tfoot input").keyup(function() {
			/* Filter on the column (the index) of this element */
			oTable.fnFilter(this.value, $("tfoot input").index(this));
		});
		// Support functions to provide a little bit of 'user friendlyness' to the textboxes in the footer
		$("tfoot input").each(function(i) {
			asInitVals[i] = this.value;
		});
		$("tfoot input").focus(function() {
			if (this.className == "search_init") {
				this.className = "";
				this.value = "";
			}
		});
		$("tfoot input").blur(function(i) {
			if (this.value == "") {
				this.className = "search_init";
				this.value = asInitVals[$("tfoot input").index(this)];
			}
		});
	});
	</script>


	<script>
	function doPost() {
		form1.s.click();
	}


	function checkForUpdates() {
		alert("Dummy Update-check function");
	}
	</script>



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
					<li class="active"><a href="queries.php"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Queries</a></li>
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
							<li class="dropdown-header">Development</li>
							<li><a href="https://github.com/yafp/clemStats/">Code</a></li>
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
		<form name="form1" Method="GET" Action="queries.php">

			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Query-Selector</a></h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
							<select name="q" value="options" onchange="doPost();">
								<option disabled selected>Tracks
									<?php echo "(".$tracks_all.")"; ?>
								</option>
								<option value="11">- Last played</option>
								<option value="12">- Most played</option>
								<option value="13">- Most skipped</option>
								<option value="14">- Best rated</option>
								<option value="15">- Best scored</option>
								<option value="16">- By year</option>
								<option value="17">- By bitrate</option>
								<option value="18">- By genre</option>
								<option value="19">- All tracks (slow)</option>
							</select>

							<select name="q" value="options" onchange="doPost();">
								<option disabled selected>Artists
									<?php echo "(".$overall_artists.")"; ?>
								</option>
								<option value="21">- Most tracks</option>
								<option value="27">- Most albums</option>
								<option value="23">- Most played</option>
								<option value="24">- Most skipped</option>
								<option value="25">- Best rated</option>
								<option value="26">- Best scored</option>
								<option value="22">- By genre</option>
								<option value="28">- By approx. playtime</option>
							</select>

							<select name="q" value="options" onchange="doPost();">
								<option disabled selected>Albums
									<?php echo "(".$overall_albums.")"; ?>
								</option>
								<option value="31">- Most played</option>
								<option value="32">- Most skipped</option>
								<option value="33">- By year</option>
								<option value="34">- By genre</option>
							</select>

							<select name="q" value="options" onchange="doPost();">
								<option disabled selected>Genre
									<?php echo "(".$overall_genres.")"; ?>
								</option>
								<option value="41">- Most played</option>
								<option value="42">- By approx. playtime</option>
							</select>

							<input hidden type="Submit" Name="s" value="go">

						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- /container -->




	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>




<?php
//
// SHOWING QUERY RESULT
//
if(isset($_GET["q"]))
{
	// init stuff
	include "conf/settings.php";			// contains some core-strings
	$sql_statement = "";
	$hits = 0;								// counting results
	$selected_stats = $_GET["q"];			// selected query id

	// sqlite handling
	class MyDB extends SQLite3
	{
		function __construct()
		{
			include "conf/settings.php";
			$this->open($dbpath);
		}
	}

	$db = new MyDB();

	switch ($selected_stats)
	{
		//
		// TRACKS
		//
		case "11":
		$graph_title = "Last played";
		$sql_statement = "SELECT title, artist, album, lastplayed FROM songs WHERE unavailable != '1' ORDER by lastplayed DESC LIMIT 1000";
		$cols = 'y';
		$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Lastplayed</th>";
		$graph = false;
		break;

		case "12":
		$graph_title = "Most played track";
		$sql_statement = "SELECT distinct title, artist, album, sum(playcount) FROM songs WHERE playcount > 0 and title != '' and unavailable != '1' GROUP BY title ORDER BY sum(playcount) desc ";
		$cols = 5;
		$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Playcount</th>";
		$graph = false;
		break;

		case "13":
		$graph_title = "Most skipped track";
		$sql_statement = "SELECT title, artist, album, skipcount FROM songs WHERE skipcount > 0 and unavailable != '1' ORDER by skipcount DESC";
		$cols = 5;
		$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Skipcount</th>";
		$graph = false;
		break;

		case "14":
		$graph_title = "Best rated track";
		$sql_statement = "SELECT title, rating, artist, album FROM songs WHERE rating > -1 and unavailable != '1' ORDER BY rating DESC";
		$cols = 5;
		$tableColumns = "<th>No.</th><th>Track</th><th>Rating</th><th>Artist</th><th>Album</th>";
		$graph = false;
		break;

		case "15":
		$graph_title = "Best scored track";
		$sql_statement = "SELECT title, score, artist, album, playcount FROM songs WHERE score > 0 and unavailable != '1' ORDER BY score DESC";
		$cols = 6;
		$tableColumns = "<th>No.</th><th>Track</th><th>Score</th><th>Artist</th><th>Album</th><th>Playcount</th>";
		$graph = false;
		break;

		case "16":
		$graph_title = "Tracks per Year";
		$sql_statement = "SELECT distinct year, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY year ORDER by COUNT(*) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Year</th><th>Tracks</th>";
		$graph = true;
		break;

		case "17":
		$graph_title = "Tracks per Bitrate";
		$sql_statement = "SELECT distinct bitrate, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY bitrate ORDER by COUNT(*) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Bitrate</th><th>Tracks</th>";
		$graph = true;
		break;

		case "18":
		$graph_title = "Tracks per Genre";
		$sql_statement = "SELECT distinct genre, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(*) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Genre</th><th>Tracks</th>";
		$graph = true;
		break;

		// Special - ALL TRACKS - might be slow (big collection results in slow datatable)
		case "19":
		$graph_title = "All Tracks";
		$sql_statement = "SELECT artist, album, title, genre, year FROM songs WHERE unavailable != '1' ORDER BY album";
		$cols = 6;
		$tableColumns = "<th>No.</th><th>Artist.</th><th>Album</th><th>Title</th><th>Genre</th><th>Year</th>";
		$graph = false;
		break;

		//
		// ARTIST
		//
		case "21":
		$graph_title = "Artist with most tracks";
		$sql_statement = "SELECT distinct artist, COUNT(*) FROM songs WHERE unavailable != '1' and artist!='Various Artists' GROUP BY artist ORDER by COUNT(*) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Tracks</th>";
		$graph = false;
		break;

		case "22":
		$graph_title = "Artist per Genre";
		$sql_statement = "SELECT distinct genre, COUNT(distinct artist) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(distinct artist) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Genre</th><th>Artists</th>";
		$graph = true;
		break;

		case "23":
		$graph_title = "Most played artist";
		$sql_statement = "SELECT distinct artist, sum(playcount) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(playcount) desc";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Playcount</th>";
		$graph = false;
		break;

		case "24":
		$graph_title = "Most skipped artist";
		$sql_statement = "SELECT distinct artist, sum(skipcount) FROM songs WHERE skipcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(skipcount) desc";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Skipcount</th>";
		$graph = false;
		break;

		case "25":
		$graph_title = "Best rated artist";
		$sql_statement = "SELECT distinct artist, count(*), sum(rating)/count(*), sum(rating) FROM songs WHERE rating > 0  and unavailable != '1' GROUP BY artist ORDER BY sum(rating)/count(*) desc";
		$cols = 5;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Rated Tracks</th><th>Average Rating</th><th>Overall Rating</th>";
		$graph = false;
		break;

		case "26":
		$graph_title = "Best scored artist";
		$sql_statement = "SELECT distinct artist, count(*), sum(score)/count(*), sum(score) FROM songs WHERE score > 0 and unavailable != '1' GROUP BY artist HAVING count(*) > 9 ORDER BY sum(score)/count(*) desc";
		$cols = 5;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Scored Tracks</th><th>Average Score</th><th>Overall Score</th>";
		$graph = false;
		break;

		case "27":
		$graph_title = "Artist with most albums";
		$sql_statement = "SELECT distinct artist, COUNT(distinct album) FROM songs WHERE unavailable != '1' and artist!='Various Artists' GROUP BY artist ORDER by COUNT(distinct album) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Albums</th>";
		$graph = false;
		break;

		case "28":
		$graph_title = "Artist with most approx. playtime";
		$sql_statement = "SELECT distinct artist, sum(length) FROM songs WHERE unavailable != '1' and artist!='Various Artists' GROUP BY artist ORDER by SUM(length) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Artist</th><th>Approx. playtime (in days)</th>";
		$graph = false;
		break;

		//
		// ALBUM
		//
		case "31":
		$graph_title = "Most played album";
		$sql_statement = "SELECT distinct album, sum(playcount), artist FROM songs WHERE playcount > 0 and unavailable != '1'  and album!='' GROUP BY album ORDER BY sum(playcount) desc ";
		$cols = 4;
		$tableColumns = "<th>No.</th><th>Album</th><th>Playcount</th><th>Artist</th>";
		$graph = false;
		break;

		case "32":
		$graph_title = "Most skipped album";
		$sql_statement = "SELECT distinct album, sum(skipcount), artist FROM songs WHERE skipcount > 0 and unavailable != '1'  and album!='' GROUP BY album ORDER BY sum(skipcount) desc";
		$cols = 4;
		$tableColumns = "<th>No.</th><th>Album</th><th>Overall Skipcount</th><th>Artist</th>";
		$graph = false;
		break;

		case "33":
		$graph_title = "Albums per Year";
		$sql_statement = "SELECT distinct year, COUNT(distinct album) FROM songs WHERE unavailable != '1' GROUP BY year ORDER by COUNT(distinct album) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Year</th><th>Albums</th>";
		$graph = true;
		break;

		case "34":
		$graph_title = "Albums per  Genre";
		$sql_statement = "SELECT distinct genre, COUNT(distinct album) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(distinct album) DESC";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Genre</th><th>Albums</th>";
		$graph = true;
		break;

		//
		// GENRE
		//
		case "41":
		$graph_title = "Most played genre";
		$sql_statement = "SELECT distinct genre, sum(playcount), count(*) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY genre ORDER BY sum(playcount) desc ";
		$cols = 4;
		$tableColumns = "<th>No.</th><th>Genre</th><th>Overall Playcount</th><th>Played tracks</th>";
		$graph = true;
		break;

		case "42":
		$graph_title = "Approximate time per genre";
		$sql_statement = "SELECT distinct genre, sum(length) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER BY sum(length) desc ";
		$cols = 3;
		$tableColumns = "<th>No.</th><th>Genre</th><th>Available playtime (days)</th>";
		$graph = true;
		break;

		//
		// SPECIAL-CASE
		//
		case "";
		$graph_title = "";
		$sql_statement = "";
		$graph = false;
		break;
	}
	// endswitch case

	?>

	<script>
	// create the array object to store values
	var data = [];
	</script>

	<?php
	// do query & output
	if($sql_statement != "")
	{
		echo '<div class="container theme-showcase" role="main">';

		echo "<h4>".$graph_title." <a href='#'><span class='glyphicon glyphicon-refresh' aria-hidden='true' style='color:orange'></span></a></h4>";

		if($graph == true)
		{
			echo '<div id="graph1">'; // chart.js - generate a Graph placeholder if needed
			echo '<input type="button" Name="hideButton" value="Hide Graph" onclick="doHide();"><br>';
			echo '<canvas id="myChart" width="400" height="200"></canvas>';
			echo '</div>';
		}
		$result = $db->query($sql_statement);	// run sql query

		echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
		echo "<thead><tr>$tableColumns</tr></thead><tbody>";

		while ($row = $result->fetchArray()) // handle the data
		{
			if($graph == true)   // add data to array for graph if graph is enabled
			{
				$randomColor = sprintf("#%x%x%x", rand(200,240), rand(50,200), rand(20,70)); // random color creation for each graph element
				?>
				<script>
				// prepare chart-js graph - Get the context of the canvas element we want to select
				var ctx = document.getElementById("myChart").getContext("2d");

				// push data to js- graph data
				data.push({
					value: <?php echo $row[1]; ?>,
					label: "<?php echo $row[0]; ?>",
					color: "<?php echo $randomColor; ?>",
					labelColor: 'black',
					labelFontSize: '16'
				});
				</script>
				<?php
			}
			// fill table
			//
			$hits = $hits+1;
			switch ($cols)
			{
				case "3":
				if($selected_stats == "42" or $selected_stats == "28")
				{
					echo "<tr class='odd gradeU'>";
					echo "<td>".$hits."</td>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".round($row[1] / 60 / 60 /24 /1000000000,2);"</td>";
					echo "</tr>";
				}
				else
				{
					echo "<tr class='odd gradeU'>";
					echo "<td>".$hits."</td>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "</tr>";
				}
				break;

				case "4":
				echo "<tr class='odd gradeU'>";
				echo "<td>".$hits."</td>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "</tr>";
				break;

				case "y": // lastplayed: converting epoche time to human-readable timestamp
				$epochetimestamp = $row[3] +7200;
				$humanTimestamp = gmdate('Ymd H:i:s', $epochetimestamp);
				echo "<tr class='odd gradeU'>";
				echo "<td>".$hits."</td>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "<td>".$humanTimestamp."</td>";
				echo "</tr>";
				break;

				case "5":
				echo "<tr class='odd gradeU'>";
				echo "<td>".$hits."</td>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "<td>".$row[3]."</td>";
				echo "</tr>";
				break;

				case "6":
				echo "<tr class='odd gradeU'>";
				echo "<td>".$hits."</td>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "<td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td>";
				echo "</tr>";
				break;
			}
		}

		// table footer
		echo '<tfoot><tr>';
		switch ($cols)
		{
			case "3":
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			break;

			case "4":
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			break;

			case "5":
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			break;

			case "y":
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			break;

			case "6":
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			echo '<th><input type="text" name="search" value="Search" class="search_init" /></th>';
			break;
		}
		echo '</tr></tfoot><table>';

		echo '<br><br><b>Query:</b><font color="gray"> '.$sql_statement.'.</font><br><br>';

		if($graph == true)
		{
			?>
			<script>
			// Default-values here: http://www.chartjs.org/docs/
			var pieoptions = {
				// no options so far
			}

			// chart.js: generate the graph
			new Chart(ctx).Pie(data, pieoptions);
			</script>
			<?php
		}
	}
}

?>
