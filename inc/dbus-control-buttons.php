<?php
	/*

	//
	// Handles the dbus control buttons
	//

	// Reminder: Available Methods
	//
	GetCaps
	GetMetadata()
	GetStatus()
	Mute()
	Next()
	Pause()
	Play()
	PositionGet()
	PositionSet()
	Prev()
	Repeat()
	ShowOSD()
	Stop()
	VolumeDown()
	VolumeGet()
	VolumeSet()
	VolumeUp()
	*/

	$task = $_POST['task'];

	$dbus = new Dbus(Dbus::BUS_SESSION, true);
							
	$clem = $dbus->createProxy
	(
        'org.mpris.clementine',
        '/Player',
        'org.freedesktop.MediaPlayer'
    ); 

	// do it
	//
	switch ($task) 
	{
		case "Play":
		    $nextAction = $clem->Play();
		    break;

		case "Pause":
		    $nextAction = $clem->Pause();
		    break;

		case "Stop":
		    $nextAction = $clem->Stop();
		    break;

		case "Prev":
		    $nextAction = $clem->Prev();
		    break;

		case "Next":
			$nextAction = $clem->Next();
		    break;

		case "OSD":
			$nextAction = $clem->ShowOSD();
		    break;

		case "Mute":
			$nextAction = $clem->Mute();
		    break;

		case "VolUp":
			$nextAction = $clem->VolumeUp();
		    break;

		case "VolDown":
			$nextAction = $clem->VolumeDown();
		    break;
	}

?> 