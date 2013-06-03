<?php
	//
	// outputs what track clementine is currently playing
	//
	include "dbus-checkStatus.php";

	if(isClemPlaying() == true) // if clementine is playing - display it
	{
		putenv("DISPLAY=:0");	

		$dbus = new Dbus(Dbus::BUS_SESSION, true);
		$clem = $dbus->createProxy(
			'org.mpris.clementine',
			'/Player',
			'org.freedesktop.MediaPlayer'
		); 

		// get track info
		$nextAction2 = $clem->GetMetadata();
		ob_start();
		print "<pre>";
		print_r($nextAction2);
		print "</pre>";
		ob_end_clean();

		// display track info
		echo "&nbsp;<b>Clemetine is playing: </b>";
		print_r($nextAction2->dict['title']->variant);
		echo " <b>by </b>";
		print_r($nextAction2->dict['artist']->variant);
		echo " <b>from the </b>";
		print_r($nextAction2->dict['album']->variant);
		echo "&nbsp;<b>album.</b>&nbsp;";
	}
	else // otherwise show a notice that nothing is played right now
	{
		echo "&nbsp;<b>Clementine is</b> idle <b>or </b>not running<b> at all.</b>&nbsp;";
	}
?>