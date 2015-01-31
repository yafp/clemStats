<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="clementine, stats, statistics, analyzer, database, music, library, lib" />
	<meta name="description" content="clementine stats" />
	<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

	<!-- CSS STUFF -->
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen, projection" />
	<!--[if lte IE 6]><link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->
	<style type="text/css" title="currentStyle">@import "css/table.css";</style>
	<link rel="stylesheet" href="js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css" type="text/css" media="screen, projection" />

	<!-- jquery, chart,js & datatable stuff -->
	<script type="text/javascript" language="javascript" src="js/jquery/jquery-1.9.1-min.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
	<script src="js/Chart.js_Regaddi/Chart.min_20130509.js"></script>
	
	<?php 
		include "conf/settings.php";
		include "inc/version.php";
		include "inc/dbus-checkStatus.php";
		echo "<title>".$appname." - ".$version." - ".$tagline."</title>";	// generate html header-title

		if (!extension_loaded('dbus')) 
		{
  			//echo "<font color='red'><b>Error:</b></font> dbus pecl extension is NOT loaded. You need that for the dbus-hackery.";
		}
		else // dbus pecl extension is loaded
		{
			if($enableDBusHackery == true) // user enabled dbus hackery in settings.conf
			{
				?>
				<!-- reload nowPlaying informations periodicly -->
				<script type="text/javascript">
					var auto_refresh = setInterval(
					function ()
					{
					$('#load').load('inc/dbus-nowPlaying.php').fadeIn("slow");
					}, 1000); // refresh every 10000 milliseconds = 10 seconds
				</script>

				<?php
			}
		}
	?>

	<script>
		// dbus - control function
		function doPlay() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Play" } );
		}

		function doPause() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Pause" } );
		}

		function doStop() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Stop" } );
		}  

		function doNext() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Next" } );
		}

		function doPrev() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Prev" } );
		} 

		function doOSD() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "OSD" } );
		}

		function doMute() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Mute" } );
		} 

		function doVolUp() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "VolUp" } );
		}

		function doVolDown() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "VolDown" } );
		}

		function doVol100() 
		{ 
			$.post("inc/dbus-controlButtons.php", { task: "Vol100" } );
		}  


		// other non-dbus related functions
		function doPost() 
		{ 
			form1.s.click();
		} 

		function doHide()
		{
	        document.getElementById('graph1').style.display = "none";
		}

		function doHideRandom()
		{
	        document.getElementById('randomPick').style.display = "none";
		}

		function dbOptions()
		{
			alert("Everything is fine.");
		}
	</script>

	<script type="text/javascript" charset="utf-8">
		var asInitVals = new Array();

		$(document).ready(function() {
		var oTable = $('#example').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
		"sSwfPath": "js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
		"aButtons": [
		"csv",
		{
		"sExtends": "print",
		"sButtonText": "Printview"
		},
		{
		"sExtends": "pdf",
		"sTitle": "clemStats - Portrait", // aka doc-title
		"sFileName": "<?php print('clemStats_export_portrait'); ?>.pdf",
		"sPdfOrientation": "portrait",
		"sPdfMessage": "PDF (portrait)",
		"sButtonText": "PDF (portrait)"
		},
		{
		"sExtends": "pdf",
		"sTitle": "clemStats - Landscape", // aka doc-title
		"sFileName": "<?php print('clemStats_export_landscape'); ?>.pdf",
		"sPdfOrientation": "landscape",
		"sPdfMessage": "PDF (landscape)",
		"sButtonText": "PDF (landscape)"
		}
		]
		},
		"bSortClasses": false, // should speed it up a little - TESTING
		"aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
		"iDisplayLength": 50,
		"oLanguage": {
		"sSearch": "Search all columns:"
		}
		} );
		$("tfoot input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("tfoot input").index(this) );
		} );
		// Support functions to provide a little bit of 'user friendlyness' to the textboxes in the footer
		$("tfoot input").each( function (i) {
		asInitVals[i] = this.value;
		} );
		$("tfoot input").focus( function () {
		if ( this.className == "search_init" )
		{
		this.className = "";
		this.value = "";
		}
		} );
		$("tfoot input").blur( function (i) {
		if ( this.value == "" )
		{
		this.className = "search_init";
		this.value = asInitVals[$("tfoot input").index(this)];
		}
		} );
		} );
		</script>
</head>


<body>
	<form name ="form1" Method ="GET" Action ="index.php">
	<div id="wrapper">

		<!-- #header-->
		<header id="header">
			<a href="index.php"><img src="img/appLogo.png" align="left" height="80pt" style="padding-top:10px;"></a>
			<h1><a href="index.php"><?php  echo $appname; ?></a></h1>
			<h2><?php  echo $tagline; ?></h2>

			<?php
				echo '<div id="header_info">';
					// if clementine datbase configured in settings.php is valid
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

			<!-- MAIN NAVIGATION TABLE INCLUDING THE VERSION AND THE QUERY-DROPDOWNS -->
			<table border="0">
				
				<tr>
					<td colspan="3"><b>version: </b><?php echo $version; ?>&nbsp;|&nbsp;<a href="https://github.com/macfidelity/clemStats/wiki">Wiki</a>&nbsp;|&nbsp;<a href="https://github.com/macfidelity/clemStats/issues">Issues</a>&nbsp;|&nbsp; Time: <?php echo $now; ?></td>
				</tr>
				<tr>
					<td>
						<select name="q" value="options" onchange="doPost();">
							<option disabled selected>Tracks <?php echo "(".$tracks_all.")"; ?></option>	
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
					</td>
					<td>
						<select name="q" value="options" onchange="doPost();">
							<option disabled selected>Artists <?php echo "(".$overall_artists.")"; ?></option>			
							<option value="21">- Most tracks</option>
							<option value="27">- Most albums</option>
							<option value="23">- Most played</option>
							<option value="24">- Most skipped</option>
							<option value="25">- Best rated</option>
							<option value="26">- Best scored</option>
							<option value="22">- By genre</option>
							<option value="28">- By approx. playtime</option>
						</select>
					</td>
					<td>
						<select name="q" value="options" onchange="doPost();">
							<option disabled selected>Albums <?php echo "(".$overall_albums.")"; ?></option>	
							<option value="31">- Most played</option>
							<option value="32">- Most skipped</option>
							<option value="33">- By year</option>
							<option value="34">- By genre</option>	
						</select>
					</td>
					<td>
						<select name="q" value="options" onchange="doPost();">
							<option disabled selected>Genre <?php echo "(".$overall_genres.")"; ?></option>	
							<option value="41">- Most played</option>
							<option value="42">- By approx. playtime</option>					
						</select>
					</td>
					<td><input hidden type="Submit" Name="s" value="go"></td>
				</tr>
				<tr>
					<td colspan="2">Tracks played: <?php echo $tracks_played." ".round($tracks_played_ratio, 2)."%"; ?></td>
					<td colspan="2">Approximate collection time: <?php echo $tracks_playtime." days"; ?></td>
				</tr>

				<?php

					if (!extension_loaded('dbus')) 
					{
  						//echo "<font color='red'><b>Error:</b></font> dbus pecl extension is NOT loaded. You need that for the dbus-hackery.";
					}
					else
					{
						if($enableDBusHackery == true)
						{
							echo '
							<tr>
								<td colspan="4">
									<a href="#" onClick="doPlay()"><img src="img/control_icons/125220-matte-white-square-icon-media-a-media22-arrow-forward1.png" width="20" title="play"></a>
									<a href="#" onClick="doPause()"><img src="img/control_icons/125225-matte-white-square-icon-media-a-media27-pause-sign.png" width="20" title="pause"></a>
									<a href="#" onClick="doStop()"><img src="img/control_icons/125226-matte-white-square-icon-media-a-media28-stop.png" width="20" title="stop"></a>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#" onClick="doPrev()"><img src="img/control_icons/125223-matte-white-square-icon-media-a-media25-arrows-skip-back.png" width="20" title="prev"></a>
									<a href="#" onClick="doNext()"><img src="img/control_icons/125224-matte-white-square-icon-media-a-media26-arrows-skip-forward.png" width="20" title="next"></a>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#" onClick="doMute()"><img src="img/control_icons/125230-matte-white-square-icon-media-a-media292-speaker-volume-right.png" width="20" title="mute"></a>
									<a href="#" onClick="doVolUp()"><img src="img/control_icons/125228-matte-white-square-icon-media-a-media291-volume1.png" width="20" title="vol up"></a>
									<a href="#" onClick="doVolDown()"><img src="img/control_icons/125229-matte-white-square-icon-media-a-media292-minus3.png" width="20" title="vol down"></a>
									<a href="#" onClick="doVol100()"><img src="img/control_icons/125273-matte-white-square-icon-media-music-speaker1.png" width="20" title="vol 100"></a>
									&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#" onClick="doOSD()"><img src="img/control_icons/125267-matte-white-square-icon-media-music-piano-keys.png" width="20" title="show OSD"></a>
								</td>
							</tr>';
						}
					}
				?>
			</table>
		</div>
		</header>
		<!-- #header-->


		<!-- dbus control line -->
		<div id="dbusLine">	
			<?php
				if (!extension_loaded('dbus')) 
				{
  					//echo "<font color='red'><b>Error:</b></font> dbus pecl extension is NOT loaded. You need that for the dbus-hackery.";
				}
				else
				{
					if($enableDBusHackery == true)
					{
						echo '<div id="dbusPlay"><div id="load"><img src="img/loading.gif" width="12"><small>... gathering informations&nbsp;</small></div></div>';
					}
				}
			?>
		</div>


		<!-- #content-->
		<div id="content">
			<br>
			<!-- No JavaScript support? -->
			<noscript>
				<meta HTTP-EQUIV="REFRESH" content="0; url=nojs.php">  <!--  redirect to error page -->
			</noscript> 
				
			<?php 
				// Check if db file is valid	
				if (file_exists($dbpath)) 
				{
					echo "<a href='javascript:void(0);'' onclick='dbOptions()'><img src='img/database_good.png' width='32' alt='db_icon' title='Database: $dbpath' align='right'></a>";
				} 
				else // db path is invalid
				{
					echo "<img src='img/database_bad.png' width='32' title='Database: $dbpath' align='right'>";
					echo "&nbsp;<b>Database: </b> <font color='red'>invalid. Please check conf/settings.php</font>";
				}
			?>
	</form>
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
			echo "<h3>".$graph_title." <a href=''><img src='img/reload.png' width='20' title='Reload this query'></a></h3>";

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
		        			labelColor : 'black',
		                	labelFontSize : '16'
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
					new Chart(ctx).Pie(data,pieoptions);
				</script>
		<?php
			}
		}
	}
	//
	// SHOWING EITHER RANDOM ALBUM OR BLANK PAGE NOTIFICATION
	//
	else // showing random page
	{
		if($enableRandomAlbum == true) // random albumpick enabled?
		{
			echo "<h3>Random album pick <a href='index.php'><img src='img/reload.png' width='20' title='Refresh the random pick'></a></h3>";

			$result5 = $db2->query('SELECT artist, album, art_automatic, year, genre FROM songs WHERE unavailable !="1" and artist != "" and album != "" ORDER BY RANDOM() LIMIT 1');
			while ($row5 = $result5->fetchArray()) 
			{
				$random_artist = $row5[0];	
				$random_album = $row5[1];
				$random_cover = $row5[2];
				$random_year = $row5[3];
				$random_genre = $row5[4];
			} 
			
			echo "<div id='randomPick'>";
			echo "<b>Artist:</b> ".$random_artist;
			echo "<br><b>Album:</b> ".$random_album;
			if($random_year !="")
			{
				echo "&nbsp;<b>Release:</b>&nbsp;".$random_year;
			}
			echo "&nbsp;<b>Genre:</b> ".$random_genre."<br>";

			// show playcount of this album
			$result6 = $db2->query("SELECT distinct album, sum(playcount), artist FROM songs WHERE  unavailable != '1'  and album='$random_album' and artist='$random_artist' ORDER BY sum(playcount) desc ");
			while ($row6 = $result6->fetchArray()) 
			{
				$random_album_playcount = $row6[1];	
			} 

			if($random_album_playcount == 0)
			{
				echo "<b>Listened: </b> 0 songs of this album.";
			}
			else
			{
				echo "<b>Listened: </b>one or more songs of this album (Track-Playcount: ".$random_album_playcount.")";
			}
			
			if($enableRandomCover == true) // Random Cover enabled?
			{
				$searchtag = $random_artist." ".$random_album;
				$searchtag = urlencode($searchtag);
				$link = "http://images.google.at/images?hl=de&q=$searchtag&btnG=Bilder-Suche&gbv=1";
				echo "<br>";

				$code = file_get_contents($link,'r');
				ereg ("imgurl=http://www.[A-Za-z0-9-]*.[A-Za-z]*[^.]*.[A-Za-z]*", $code, $img);
				ereg ("http://(.*)", $img[0], $img_pic);

				if($img_pic[0] != '')  // if we found an image - show it (random cover)
				{
					echo "<img src=".$img_pic[0]." width='300' border='1' title='cover art is fetched online.'>";
				}
			}

			if($enableLinksForRandomArtist == true) // www-links enabled?
			{
				echo "<br><b>More about this artist:</b>";
				echo "<br><a href='http://en.wikipedia.org/wiki/".urlencode($random_artist)."' target='_new'>Wikipedia</a>";						// wikipedia
				echo "&nbsp;<a href='http://www.youtube.com/results?search_query=".$random_artist."' target='_new'>Youtube</a>";		// youtube
				echo "&nbsp;<a href='https://vimeo.com/search?q=".$random_artist."' target='_new'>Vimeo</a>";							// vimeo
				echo "&nbsp;<a href='https://soundcloud.com/search?q=".$random_artist."' target='_new'>Soundcloud</a>";						// soundcloud
				echo "&nbsp;<a href='http://www.discogs.com/search?q=".$random_artist."' target='_new'>Discogs</a>";						// discogs
				echo "&nbsp;<a href='http://www.last.fm/search?q=".$random_artist."' target='_new'>last.fm</a>";						// last.fm
				echo "&nbsp;<a href='http://www.whosampled.com/search/artists/?q=".$random_artist."' target='_new'>WhoSampled</a>";						// whosampled
			}
			echo "</div>";
		}
		else // random artist is false
		{
			echo "<h4>Your library comes with a total of <span>".$tracks_all." tracks</span>, coming from <span>".$overall_artists." artists</span> with overall <span>".$overall_albums." albums</span> featuring <span>".$overall_genres." genres</span>.</h4>";
			
			echo "<h4>Altogether an approx playtime of <span>".$tracks_playtime." days</span>.</h4>";

			echo "<h4>So far you listened to <span>".$tracks_played." </span> of those <span>".$tracks_all." tracks</span>.</h4>";
					
			echo "<h4>Insane isn't it</h4>";
			
			
			echo "<h3>Want more?</h3>";
			echo "Consider enabling the random album pick option in <i>conf/settings.php</i> or just select one of the pre-defined sql-queries in the navigation to have even more fun.";

			//
		}
	}	
?>
