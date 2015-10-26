<?php
	include "../conf/settings.php";

	// sqlite stuff - access clementine db file
	class MyDB2 extends SQLite3
	{
		function __construct()
		{
			include "../conf/settings.php";
			$this->open($dbpath);
		}
	}
	$db3 = new MyDB2();

	// Get random album data
	//
	$result5 = $db3->query('SELECT artist, album, art_automatic, year, genre FROM songs WHERE unavailable !="1" and artist != "" and album != "" ORDER BY RANDOM() LIMIT 1');
	while ($row5 = $result5->fetchArray())
	{
		$random_artist = $row5[0];
		$random_album = $row5[1];
		$random_cover = $row5[2];
		$random_year = $row5[3];
		$random_genre = $row5[4];
	}

	// display random album data
	//
	echo "<div id='randomPick'>";

	echo "<h4>Randomness picked <span>".$random_album."</span> by <span>".$random_artist."</span>, which was released in <span>".$random_year."</span> and belongs into the genre <span>".$random_genre."</span>.</h4>";

	// show playcount of this album
	//
	$result6 = $db3->query("SELECT distinct album, sum(playcount), artist FROM songs WHERE  unavailable != '1'  and album='$random_album' and artist='$random_artist' ORDER BY sum(playcount) desc ");
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

	// Display cover for current random album pick if enabled in settings.php
	//
	if($enableRandomCover == 1)
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
		else
		{
			echo "<br><b>Cover:</b><br>Problems fetching a cover";
		}
	}


	// Display several Links to current RandomArtist if enabled in settings.php
	//
	if($enableLinksForRandomArtist == 1) // www-links enabled?
	{
		echo "<br><br><b>More about this artist:</b>";
		echo "<br><a href='http://en.wikipedia.org/wiki/".urlencode($random_artist)."' target='_new'>Wikipedia</a>";						// wikipedia
		echo "&nbsp;<a href='http://www.youtube.com/results?search_query=".$random_artist."' target='_new'>Youtube</a>";		// youtube
		echo "&nbsp;<a href='https://vimeo.com/search?q=".$random_artist."' target='_new'>Vimeo</a>";							// vimeo
		echo "&nbsp;<a href='https://soundcloud.com/search?q=".$random_artist."' target='_new'>Soundcloud</a>";						// soundcloud
		echo "&nbsp;<a href='http://www.discogs.com/search?q=".$random_artist."' target='_new'>Discogs</a>";						// discogs
		echo "&nbsp;<a href='http://www.last.fm/search?q=".$random_artist."' target='_new'>last.fm</a>";						// last.fm
		echo "&nbsp;<a href='http://www.whosampled.com/search/artists/?q=".$random_artist."' target='_new'>WhoSampled</a>";						// whosampled
	}

?>
