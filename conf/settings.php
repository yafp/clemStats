<?php
	// ########################################################################################
	// CLEMENTINE DATABASE 
	// ########################################################################################
	$dbpath		= '/home/fidel/.config/Clementine/clementine.db';		// path to your clemetine database



	// ########################################################################################
	// RANDOM PICK 
	// ########################################################################################
	// Random album & cover on main page when no search occured
	$enableRandomAlbum = false;			// random local album - true or false
	// next values depend on $enableRandomAlbum = true
	$enableRandomCover = true;			// cover via google search - needs internet access. true or false
	$enableLinksForRandomArtist = true;	// displays some www-links for additional informations about the random artist. true or false



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
	$enableDBusHackery = false; // true or false
?>
