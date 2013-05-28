<?php
	// ########################################################################################
	// GENERAL
	// ########################################################################################
	$appname	= "clemStats";
	$tagline	= "a clementine database analyzer";
	$version 	= "20130528.01";



	// ########################################################################################
	// CLEMENTINE DATABASE 
	// ########################################################################################
	$dbpath		= '/home/fidel/.config/Clementine/clementine.db';		// not yet in use



	// ########################################################################################
	// RANDOM PICK 
	// ########################################################################################
	// Random album & cover on main page when no search occured
	$enableRandomAlbum = true;			// random local album
	// next values depend on $enableRandomAlbum (true)
	$enableRandomCover = true;			// cover via google search - needs internet access.
	$enableLinksForRandomArtist = true;	// displays some www-links for additional informations about the random artist.



	// ########################################################################################
	// DBUS HACKERY
	// ########################################################################################
	// controling clementine via dbus
	//
	// this function needs several ugly hacks:
	// 01. apache must run as the same user as clementine does. (see /etc/apache/envvars)
	// 02. dbus php pecl extension installed (see http://pecl.php.net/package/DBus)
	//
	// and results in
	// - dbus control buttons for clementine (play, pause, stop, next, prev etc)
	// - clemStats displaying the clementine status (playing, paused, stopped)
	$enableDBusHackery = true;
?>
