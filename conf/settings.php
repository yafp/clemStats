<?php
	//
	// about:		Defines some core-strings/values
	//

	// GENERAL
	$appname	= "clemStats";
	$tagline	= "a clementine database analyzer";
	$version 	= "20130522.01";

	// CONFIG
	$dbpath		= '/home/fidel/.config/Clementine/clementine.db';		// not yet in use

	// Random album & cover on main page when no search occured
	$enableRandomAlbum = true;			// random local album
	// next values depend on $enableRandomAlbum (true)
	$enableRandomCover = true;			// cover via google search - needs internet access.
	$enableLinksForRandomArtist = true;	// displays some www-links for additional informations about the random artist.
?>
