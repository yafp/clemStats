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
	<link rel="stylesheet" href="css/latest.css" type="text/css" media="screen, projection" />
	<!--[if lte IE 6]><link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen, projection" /><![endif]-->

	<!-- jquery & datatable stuff -->
	<script type="text/javascript" language="javascript" src="js/jquery/jquery-1.9.1-min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8">
		var asInitVals = new Array();

		$(document).ready(function() {
			var oTable = $('#example').dataTable( {
				"bSortClasses": false, // should speed it up a little - TESTING
				"aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
			    "iDisplayLength": 25,
				"oLanguage": {
					"sSearch": "Search all columns:"
				}
			} );
			
			$("tfoot input").keyup( function () {
				/* Filter on the column (the index) of this element */
				oTable.fnFilter( this.value, $("tfoot input").index(this) );
			} );
			
			/*
			 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
			 * the footer
			 */
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

	<style type="text/css" title="currentStyle">@import "css/table.css";</style>
</head>


<body>
	<form name ="form1" Method ="POST" Action ="index.php">
	<div id="wrapper">

		<!-- #header-->
		<header id="header">
			<a href="index.php"><img src="img/icon_large_rotated.png" align="left" height="90pt"></a>
			<h1><a href="index.php"><?php  echo $appname; ?></a></h1>
			<h2><?php  echo $tagline; ?></h2>
			<select required name="dropdown" value="options" >
				<option disabled selected>Choose..</option>	
				<option disabled="disabled">Tracks</option>
				<option value="track_per_genre">- per genre</option>
				<option value="track_per_artist">- per artist</option>
				<option value="track_per_lastplayed">- per lastplayed</option>
				<option value="track_per_playcount">- per playcount</option>
				<option value="track_per_skipcount">- per skipcount</option>
				<option value="track_per_rating">- per rating</option>
				<option value="track_per_score">- per score</option>
				<option value="all_tracks">- all tracks (slow)</option>			
				<option disabled="disabled">Artist</option>
				<option value="artist_per_genre">- per genre</option>
				<option value="artist_per_playcount">- per playcount</option>
				<option value="artist_per_skipcount">- per skipcount</option>
				<option value="artist_per_rating">- per rating</option>
				<option value="artist_per_score">- per score</option>		
				<option disabled="disabled">Albums</option>
				<option value="album_per_playcount">- per playcount</option>		
				<option disabled="disabled">Genre</option>
				<option value="genre_per_playcount">- per playcount</option>
			</select>

			<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Load">

			<?php
				echo '<div id="header_info">';

					$now = date("Ymd G:i:s");

					echo '<table>';
						echo '<tr>';
							echo '<td><b>version:</b></td>';
							echo '<td>'.$version.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td><b>links:</b></td>';
							echo "<td><a href='https://github.com/macfidelity/clemStats/wiki'>Wiki</a>&nbsp;|&nbsp;<a href='https://github.com/macfidelity/clemStats/issues'>Issues</a></td>";
						echo '</tr>';
						echo '<tr>';
							echo '<td><b>Loadtime:</b></td>';
							echo "<td>".$now."</td>";
						echo '</tr>';
					echo '</table>';
				echo "</div>";	
			?>
		</header>
		<!-- #header-->



		<!-- #content-->
		<div id="content">
			<h3>base-informations</h3>
				<?php 											
					// sqlite stuff - access clementine db file
					class MyDB2 extends SQLite3
					{
						function __construct()
						{
							$this->open('/home/fidel/.config/Clementine/clementine.db');
						}	
					}

					$db2 = new MyDB2();
										 
					// Show: TRACKS
					$result5 = $db2->query('SELECT COUNT(*) FROM songs');
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
											
					echo "<b>Database: </b>".$dbpath;

					echo "<table width='50%' align='right'>";
						echo "<tr>";
							echo "<th>&nbsp;</th>";
							echo "<th bgcolor='orange'>Tracks</th>";
							echo "<th bgcolor='orange'>Artists</th>";
							echo "<th bgcolor='orange'>Albums</th>";
							echo "<th bgcolor='orange'>Genres</th>";
						echo "</tr>";
						echo "<tr>";
							echo "<th bgcolor='orange'>Overall</th>";
							echo "<td><center>".$tracks_all." (100%)</center></td>";
							echo "<td><center>".$overall_artists."</center></td>";
							echo "<td><center>".$overall_albums."</center></td>";
							echo "<td><center>".$overall_genres."</center></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<th bgcolor='orange'>Played</th>";
							echo "<td><center>".$tracks_played." &nbsp;(".round($tracks_played_ratio, 2)."%)</center></td>";
						echo "</tr>";
					echo "</table>";	
				?>
		
	</form>
</body>
</html>



<?php
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
				$othersFactor = 0.05;
				$queryDescription = "Shows the amount of tracks per genre.";
			break;

			// TRACKS
			case "track_per_genre":
				$graph_title = "Tracks per Genre";
				$sql_statement = "SELECT distinct genre, COUNT(*) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Tracks</th>";
				$othersFactor = 0.05;
				$queryDescription = "Shows the amount of tracks per genre.";
			break;
							
			case "track_per_artist":
				$graph_title = "Tracks per Artist";
				$sql_statement = "SELECT distinct artist, COUNT(*) FROM songs WHERE unavailable != '1' and artist!='Various Artists' GROUP BY artist ORDER by COUNT(*) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Tracks</th>";
				$othersFactor = 0.05;
				$queryDescription = "Shows the amount of tracks per artist.";
			break;
							
			case "track_per_lastplayed":
				$graph_title = "Tracks per Artist";
				$sql_statement = "SELECT title, artist, lastplayed FROM songs WHERE unavailable != '1' ORDER by lastplayed DESC LIMIT 500";
				$cols = y;
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Lastplayed</th>";
				$othersFactor = 0.05;
				$queryDescription = "Shows the amount of tracks per playcount.";
			break;
							
			case "track_per_playcount":
				$graph_title = "Tracks per playcount";
				$sql_statement = "SELECT distinct title, artist, sum(playcount) FROM songs WHERE playcount > 0 and title != '' and unavailable != '1' GROUP BY title ORDER BY sum(playcount) desc ";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Playcount</th>";
				$othersFactor = 0.1;
			break;
													
			case "track_per_skipcount":
				$graph_title = "Tracks per Artist";
				$sql_statement = "SELECT title, artist , skipcount FROM songs WHERE skipcount > 0 and unavailable != '1' ORDER by skipcount DESC";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Track</th><th>Artist</th><th>Skipcount</th>";
				$othersFactor = 0.05;
			break;
							
			case "track_per_rating":
				$graph_title = "Tracks per rating";
				$sql_statement = "SELECT title, rating, artist FROM songs WHERE rating > -1 and unavailable != '1' ORDER BY rating DESC";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Track</th><th>Rating</th><th>Artist</th>";
				$othersFactor = 0.05;
			break;
															
			case "track_per_score":
				$graph_title = "Tracks per Score";
				$sql_statement = "SELECT title, score, artist FROM songs WHERE score > 0 and unavailable != '1' ORDER BY score DESC";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Track</th><th>Score</th><th>Artist</th>";
				$othersFactor = 0.05;
			break;
										
			// ARTISTS
			case "artist_per_genre":
				$graph_title = "Artists per Genre";
				$sql_statement = "SELECT distinct genre, COUNT(distinct artist) FROM songs WHERE unavailable != '1' GROUP BY genre ORDER by COUNT(artist) DESC";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Artists</th>";
				$othersFactor = 0.05;
			break;
							
			case "artist_per_playcount":	
				$graph_title = "Artist per playcount";
				$sql_statement = "SELECT distinct artist, sum(playcount) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(playcount) desc";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Playcount</th>";
				$othersFactor = 0.05;
			break;
										
			case "artist_per_skipcount":	
				$graph_title = "Artist per skipcount";
				$sql_statement = "SELECT distinct artist, sum(skipcount) FROM songs WHERE skipcount > 0 and unavailable != '1' GROUP BY artist ORDER BY sum(skipcount) desc";
				$cols = 3;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Overall Skipcount</th>";
				$othersFactor = 0.05;
			break;
										
			case "artist_per_score":
				$graph_title = "Artist per score";
				$sql_statement = "SELECT distinct artist, count(*), sum(score)/count(*), sum(score) FROM songs WHERE score > 0 and unavailable != '1' GROUP BY artist HAVING count(*) > 9 ORDER BY sum(score)/count(*) desc";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Scored Tracks</th><th>Average Score</th><th>Overall Score</th>";
				$othersFactor = 0.05;
			break;

			case "artist_per_rating":
				$graph_title = "Artist per rating";
				$sql_statement = "SELECT distinct artist, count(*), sum(rating)/count(*), sum(rating) FROM songs WHERE rating > 0  and unavailable != '1' GROUP BY artist ORDER BY sum(rating)/count(*) desc";
				$cols = 5;
				$tableColumns = "<th>No.</th><th>Artist</th><th>Rated Tracks</th><th>Average Rating</th><th>Overall Rating</th>";
				$othersFactor = 0.05;
			break;
										
			// ALBUM
			case "album_per_playcount":
				$graph_title = "Album per playcount";
				$sql_statement = "SELECT distinct album, sum(playcount), artist FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY album ORDER BY sum(playcount) desc ";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Album</th><th>Playcount</th><th>Artist</th>";
				$othersFactor = 0.06;
			break;								
							
			// GENRE
			case "genre_per_playcount":
				$graph_title = "Genre per playcount";
				$sql_statement = "SELECT distinct genre, sum(playcount), count(*) FROM songs WHERE playcount > 0 and unavailable != '1' GROUP BY genre ORDER BY sum(playcount) desc ";
				$cols = 4;
				$tableColumns = "<th>No.</th><th>Genre</th><th>Overall Playcount</th><th>Played tracks</th>";
				$othersFactor = 0.02;
			break;
																						
			// SPECIAL-CASE ;)
			case "";
				$graph_title = "";
				$sql_statement = "";
			break;
		}
		// endswitch case
												
		
		// do query & output
		if($sql_statement != "")
		{
			echo "<h3>selection</h3>";
			echo '<b>Selected:</b> '.$graph_title.'  ('.$queryDescription.').';
			echo '<br><b>Query:</b> '.$sql_statement.'.<br><br>';
			$result = $db->query($sql_statement);	// run sql query
			echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
			echo "<thead><tr>$tableColumns</tr></thead><tbody>";
																							
			while ($row = $result->fetchArray()) 
			{
				$hits = $hits+1;			
				switch ($cols)
				{
					case "3":	
						echo "<tr class='odd gradeU'>";
							echo "<td>".$hits."</td>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
						echo "</tr>";
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
						echo "<tr class='odd gradeU'>";
							echo "<td>".$hits."</td>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".gmdate('r', $row[2])."</td>";
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
		}
	}
?>