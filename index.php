<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />

	<?php 
		include "conf/settings.php";
		echo "<title>".$appname." - ".$version." - ".$tagline."</title>";	// generate html header-title
	?>

	<meta name="keywords" content="clementine" />
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
	<script>
	function doPost() 
	{ 
		form1.Submit1.click();
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

		/*
		var r=confirm("dummy: Do you want to backup your Clementine database?");
		if (r==true)
		{
	
		}
		*/
	}
	</script>

	<script type="text/javascript" charset="utf-8">
		var asInitVals = new Array();

		$(document).ready(function() {
			var oTable = $('#example').dataTable( {
				"sDom": 'T<"clear">lfrtip',
				"oTableTools": {
					//"aButtons": [{"sExtends":    "collection","sButtonText": "Save", "aButtons":    [ "csv", "xls", "pdf" ]}],
					"sSwfPath": "js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
					"aButtons": [
		                  "csv",
		                  {
		                     "sExtends": "print",
		                     "sButtonText": "Printview"
		                  },
		                  {
		                     "sExtends": "pdf",
		                     "sTitle": "clemStats - Portrait", // ansonsten steht hier: KIS Kniel Inventar System - aka doc-title
		                     "sFileName": "<?php print('clemStats_export_portrait'); ?>.pdf",
		                     "sPdfOrientation": "portrait",
		                     "sPdfMessage": "PDF (portrait)",
		                     "sButtonText": "PDF (portrait)"
		                  },
		                  {
		                     "sExtends": "pdf",
		                     "sTitle": "clemStats - Landscape", // ansonsten steht hier: KIS Kniel Inventar System - aka doc-title
		                     "sFileName": "<?php print('clemStats_export_landscape'); ?>.pdf",
		                     "sPdfOrientation": "landscape",
		                     "sPdfMessage": "PDF (landscape)",
		                     "sButtonText": "PDF (landscape)"
		                  }
		               ]
				},
				
				"bSortClasses": false, // should speed it up a little - TESTING
				"aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
			    "iDisplayLength": 10,
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
	<form name ="form1" Method ="POST" Action ="index.php">
	<div id="wrapper">

		<!-- #header-->
		<header id="header">
			<a href="index.php"><img src="img/appLogo.png" align="left" height="80pt" style="padding-top:10px;"></a>
			<h1><a href="index.php"><?php  echo $appname; ?></a></h1>
			<h2><?php  echo $tagline; ?></h2>

			<?php
				echo '<div id="header_info">';

					// insert old basic table here
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



			<table border="0" >
				<tr>
					<td colspan="4"><b>version: </b><?php echo $version; ?>&nbsp;|&nbsp;<a href="https://github.com/macfidelity/clemStats/wiki">Wiki</a>&nbsp;|&nbsp;<a href="https://github.com/macfidelity/clemStats/issues">Issues</a>&nbsp;|&nbsp;Page generated at: <?php echo $now; ?></td>
				</tr>
				<tr>
					<td>
						<select name="dropdown" value="options" onchange="doPost();">
							<option disabled selected>Tracks <?php echo "(".$tracks_all.")"; ?></option>	
							<option value="track_per_lastplayed">- Last played</option>
							<option value="track_per_playcount">- Most played track</option>
							<option value="track_per_skipcount">- Most skipped track</option>
							<option value="track_per_rating">- Best rated track</option>
							<option value="track_per_score">- Best scored track</option>
							<option value="track_per_year">- Tracks per year</option>
							<option value="track_per_bitrate">- Tracks per bitrate</option>
							<option value="track_per_genre">- Tracks per genre</option>
							<option value="all_tracks">- All tracks (slow)</option>
						</select>
					</td>
					<td>
						<select name="dropdown" value="options" onchange="doPost();">
							<option disabled selected>Artists <?php echo "(".$overall_artists.")"; ?></option>			
							<option value="track_per_artist">- Artist with most tracks</option>
							<option value="artist_per_genre">- Artists per genre</option>
							<option value="artist_per_playcount">- Most played artist</option>
							<option value="artist_per_skipcount">- Most skipped artist</option>
							<option value="artist_per_rating">- Best rated artist</option>
							<option value="artist_per_score">- Best scored artist</option>
						</select>
					</td>
					<td>
						<select name="dropdown" value="options" onchange="doPost();">
							<option disabled selected>Albums <?php echo "(".$overall_albums.")"; ?></option>	
							<option value="album_per_playcount">- Most played album</option>
							<option value="album_per_skipcount">- Most skipped album</option>
							<option value="album_per_year">- Album per year</option>
							<option value="album_per_genre">- Albums per genre</option>	
						</select>
					</td>
					<td>
						<select name="dropdown" value="options" onchange="doPost();">
							<option disabled selected>Genre <?php echo "(".$overall_genres.")"; ?></option>	
							<option value="genre_per_playcount">- Most played genre</option>
							<option value="genre_per_playtime">- Approximate time per genre</option>					
						</select>
					</td>
					<td><input hidden type="Submit" Name="Submit1" value="Load"></td>
				</tr>
				<tr><td colspan="2">Tracks played: <?php echo $tracks_played." ".round($tracks_played_ratio, 2)."%"; ?></td></tr>
				<tr><td colspan="2">Approximate collection time: <?php echo $tracks_playtime." days"; ?></td></tr>
			</table>
		</div>
		
		</header>
		<!-- #header-->


		<!-- #content-->
		<div id="content">

			<!-- No JavaScript support? -->
			<noscript>
				<h3>Warning</h3>
				<font color="red">Your browser does not support JavaScript - which is needed for clemStats. Please enable it and then reload this page.</font><br>
				<img src="img/noscript.gif" alt="image description">
			</noscript> 

				<br>

				<?php 
					//
					// Check if db file is valid
					//	
					if (file_exists($dbpath)) 
					{
						echo "<a href='javascript:void(0);'' onclick='dbOptions()'><img src='img/database_good.png' width='32' alt='db_icon' title='Database: $dbpath' align='right'></a>";

						if (!extension_loaded('dbus')) 
						{
  							//die('Extension dbus is not loaded');
  							//echo "<b>Error:</b> dbus pecl extension is NOT loaded. It is not needed so far.";
						}
						else
						{
							//echo "<b>Notice:</b> dbus pecl extension is loaded.";
							//$dbus = new Dbus(Dbus::BUS_SESSION, true);
							//$dbus = new Dbus(Dbus::BUS_SESSION); 

							// basic clemdbus infos:
							// http://wiki.clementine-player.googlecode.com/git/MPRIS.wiki

							// get current track:
							// terminal: qdbus org.mpris.clementine /Player org.freedesktop.MediaPlayer.GetMetadata
							//
							// play/pause:
							// terminal: qdbus org.mpris.clementine /Player org.freedesktop.MediaPlayer.Pause
							// terminal:
						}

					} 
					else 
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
	// EMPTY - No query was selected
	//
	if(!isset($_POST['dropdown'])) 
	{
		if($enableRandomAlbum == true)
		{
			echo "<h3>Random pick <a href='index.php'><img src='img/reload.png' width='20' title='Refresh the random pick'></a></h3>";

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
			//echo "<br><b>Random cover:</b> ".$random_cover;
			if($random_year !="")
			{
				echo "&nbsp;<b>Release:</b>&nbsp;".$random_year;
			}
			echo "&nbsp;<b>Genre:</b> ".$random_genre."<br>";

			if($enableRandomCover == true)
			{
				$searchtag = $random_artist." ".$random_album;
				$searchtag = urlencode($searchtag);
				$link = "http://images.google.at/images?hl=de&q=$searchtag&btnG=Bilder-Suche&gbv=1";
				echo "<br>";

				$code = file_get_contents($link,'r');
				ereg ("imgurl=http://www.[A-Za-z0-9-]*.[A-Za-z]*[^.]*.[A-Za-z]*", $code, $img);
				ereg ("http://(.*)", $img[0], $img_pic);

				if($img_pic[0] != '')  // show random cover
				{
					echo "<img src=".$img_pic[0]." width='500' border='1'>";
				}

				// further links
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
	}




	//
	// SUBMIT BUTTON
	//
	if (isset($_POST['Submit1'])) 
	{		
		// init stuff
		include "conf/settings.php";			// contains some core-strings
		$sql_statement = "";
		$hits = 0;								// counting results
		$selected_stats = $_POST['dropdown']; 	// get selected option
	
		// sqlite handling
		class MyDB extends SQLite3
		{
			function __construct()
			{
				$this->open('/home/fidel/.config/Clementine/clementine.db');
			}
		}

		$db = new MyDB();
	
		switch ($selected_stats)
		{
			// ALL TRACKS
			case "all_tracks":
				$graph_title = "All Tracks";
				$sql_statement = "SELECT artist, album, title, genre, year FROM songs WHERE unavailable != '1' ORDER BY album";
				$cols = 6;
				$tableColumns = "<th>No.</th><th>Artist.</th><th>Album</th><th>Title</th><th>Genre</th><th>Year</th>";
				$graph = false;
			break;

			// TRACKS
			case "track_per_genre":
				$graph_title = "Tracks per Genre";
				$sql_statement = "SELECT distinct genre, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Tracks</th>";
				$graph = true;
			break;

			case "track_per_year":
				$graph_title = "Tracks per Year";
				$sql_statement = "SELECT distinct year, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY year ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Year</th><th>Tracks</th>";
				$graph = true;
			break;

			case "track_per_bitrate":
				$graph_title = "Tracks per Bitrate";
				$sql_statement = "SELECT distinct bitrate, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY bitrate ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Bitrate</th><th>Tracks</th>";
				$graph = true;
			break;
				
			case "track_per_artist":
				$graph_title = "Artist with most tracks";
				$sql_statement = "SELECT distinct artist, COUNT(*) FROM songs WHERE unavailable != '1' and artist!='Various Artists' GROUP BY artist ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Tracks</th>";
				$graph = false;
			break;
							
			case "track_per_lastplayed":
				$graph_title = "Last played";
				$sql_statement = "SELECT title, artist, album, lastplayed FROM songs WHERE unavailable != '1' ORDER by lastplayed DESC LIMIT 1000";
				$cols = 'y';
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Lastplayed</th>";
				$graph = false;
			break;
							
			case "track_per_playcount":
				$graph_title = "Most played track";
				$sql_statement = "SELECT distinct title, artist, album, sum(playcount) FROM songs WHERE playcount > 0 and title != '' and unavailable != '1' GROUP BY title ORDER BY sum(playcount) desc ";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Playcount</th>";
				$graph = false;
			break;
													
			case "track_per_skipcount":
				$graph_title = "Most skipped track";
				$sql_statement = "SELECT title, artist, album, skipcount FROM songs WHERE skipcount > 0 and unavailable != '1' ORDER by skipcount DESC";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Album</th><th>Skipcount</th>";
				$graph = false;
			break;
							
			case "track_per_rating":
				$graph_title = "Best rated track";
				$sql_statement = "SELECT title, rating, artist, album FROM songs WHERE rating > -1 and unavailable != '1' ORDER BY rating DESC";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Track</th><th>Rating</th><th>Artist</th><th>Album</th>";
				$graph = false;
			break;
															
			case "track_per_score":
				$graph_title = "Best scored track";
				$sql_statement = "SELECT title, score, artist, album FROM songs WHERE score > 0 and unavailable != '1' ORDER BY score DESC";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Track</th><th>Score</th><th>Artist</th><th>Album</th>";
				$graph = false;
			break;
										
			// ARTISTS
			case "artist_per_genre":
				$graph_title = "Artist per Genre";
				$sql_statement = "SELECT distinct genre, COUNT(distinct artist) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(distinct artist) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Artists</th>";
				$graph = true;
			break;
							
			case "artist_per_playcount":	
				$graph_title = "Most played artist";
				$sql_statement = "SELECT distinct artist, sum(playcount) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(playcount) desc";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Playcount</th>";
				$graph = false;
			break;
										
			case "artist_per_skipcount":	
				$graph_title = "Most skipped artist";
				$sql_statement = "SELECT distinct artist, sum(skipcount) FROM songs WHERE skipcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(skipcount) desc";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Skipcount</th>";
				$graph = false;
			break;
										
			case "artist_per_score":
				$graph_title = "Best scored artist";
				$sql_statement = "SELECT distinct artist, count(*), sum(score)/count(*), sum(score) FROM songs WHERE score > 0 and unavailable != '1' GROUP BY artist HAVING count(*) > 9 ORDER BY sum(score)/count(*) desc";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Scored Tracks</th><th>Average Score</th><th>Overall Score</th>";
				$graph = false;
			break;

			case "artist_per_rating":
				$graph_title = "Best rated artist";
				$sql_statement = "SELECT distinct artist, count(*), sum(rating)/count(*), sum(rating) FROM songs WHERE rating > 0  and unavailable != '1' GROUP BY artist ORDER BY sum(rating)/count(*) desc";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Rated Tracks</th><th>Average Rating</th><th>Overall Rating</th>";
				$graph = false;
			break;
										
			// ALBUM
			case "album_per_playcount":
				$graph_title = "Most played album";
				$sql_statement = "SELECT distinct album, sum(playcount), artist FROM songs WHERE playcount > 0 and unavailable != '1'  and album!='' GROUP BY album ORDER BY sum(playcount) desc ";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Album</th><th>Playcount</th><th>Artist</th>";
				$graph = false;
			break;

			case "album_per_year":
				$graph_title = "Albums per Year";
				$sql_statement = "SELECT distinct year, COUNT(distinct album) FROM songs WHERE unavailable != '1' GROUP BY year ORDER by COUNT(distinct album) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Year</th><th>Albums</th>";
				$graph = true;
			break;

			case "album_per_skipcount":	
				$graph_title = "Most skipped album";
				$sql_statement = "SELECT distinct album, sum(skipcount), artist FROM songs WHERE skipcount > 0 and unavailable != '1'  and album!='' GROUP BY album ORDER BY sum(skipcount) desc";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Album</th><th>Overall Skipcount</th><th>Artist</th>";
				$graph = false;
			break;								
							
			// GENRE
			case "genre_per_playcount":
				$graph_title = "Most played genre";
				$sql_statement = "SELECT distinct genre, sum(playcount), count(*) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY genre ORDER BY sum(playcount) desc ";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Overall Playcount</th><th>Played tracks</th>";
				$graph = true;
			break;

			case "genre_per_playtime":
				$graph_title = "Approximate time per genre";
				$sql_statement = "SELECT distinct genre, sum(length) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER BY sum(length) desc ";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Available playtime (days)</th>";
				$graph = true;
			break;


			case "album_per_genre":
				$graph_title = "Albums per  Genre";
				$sql_statement = "SELECT distinct genre, COUNT(distinct album) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(distinct album) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Albums</th>";
				$graph = true;
			break;
				

			// SPECIAL-CASE ;)
			case "";
				$graph_title = "";
				$sql_statement = "";
				$graph = false;
			break;
		}
		// endswitch case


		// chart.js - generate a Graph placeholder if needed
		if($graph == true)
		{
			echo '<div id="graph1">';
			echo '<h3>Graph</h3>';
			echo '<canvas id="myChart" width="400" height="200"></canvas>';
			echo '<input type="button" Name="hideButton" value="Hide Graph" onclick="doHide();">';
			echo '</div>';
		}

		?>

		<script>
			// create the array object to store values 
			var data = [];
		</script>

		<?php									
		// do query & output
		if($sql_statement != "")
		{
			echo "<h3>".$graph_title."</h3>";
			$result = $db->query($sql_statement);	// run sql query
			echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
			echo "<thead><tr>$tableColumns</tr></thead><tbody>";
																							
			while ($row = $result->fetchArray()) 
			{
				// add data to array for graph
				if($graph == true)
				{
					$randomColor = sprintf("#%x%x%x", rand(200,240), rand(50,200), rand(20,70));
			?>
					<script>
						// prepare chart-js graph
						//
						// Get the context of the canvas element we want to select
						var ctx = document.getElementById("myChart").getContext("2d");
						//var randomColor = '#'+(0x1000000+(Math.random())*0xff0000).toString(16).substr(1,6);
						
						// push data to js- graph data
						data.push({
		        			value: <?php echo $row[1]; ?>,
		        			label: "<?php echo $row[0]; ?>",
		        			//color: '#'+(0x1000000+(Math.random())*0xffffff).toString(16).substr(1,6),
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
						if($selected_stats == "genre_per_playtime")
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

					case "y":	
						// lastplayed: converting epoche time to human-readable timestamp
						$epochetimestamp = $row[3];
						$epochetimestamp = $epochetimestamp +7200; // +2 hours time-correction
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
			echo '<tfoot>';
			echo '<tr>';

			switch ($cols)
			{
					case "3":	
						echo '<th><input type="text" name="search engines" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_browser" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
					break;

					case "4":	
						echo '<th><input type="text" name="search engines" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_browser" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
					break;
										
					case "5":
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';	
					break;

					case "y":
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';	
					break;

					case "6":	
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';	
						echo '<th><input type="text" name="search_platform" value="Search" class="search_init" /></th>';
					break;
			}
			echo '</tr>';
			echo '</tfoot>';
			echo '<table>';

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
?>