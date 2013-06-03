<?php
	// basic clemdbus infos:
	// http://wiki.clementine-player.googlecode.com/git/MPRIS.wiki
	//
	// basic example
	// get current track in terminal: qdbus org.mpris.clementine /Player org.freedesktop.MediaPlayer.GetMetadata

	//
	// CHECK IF CLEMENTINE IS PLAYING (returns true if so)
	//
	function isClemPlaying()
	{
		putenv("DISPLAY=:0");	

		$dbus = new Dbus(Dbus::BUS_SESSION, true);
		$clem = $dbus->createProxy(
	    	'org.mpris.clementine',
	        '/Player',
	         'org.freedesktop.MediaPlayer'
	    ); 

		try // try - as it would crash otherwise if clementine isnt running.
		{
			// do the dbus call							
			$nextAction = $clem->GetStatus();

			// we need to output it - otherwise its not accessible - but we hide it using ob_start/ob_end_clean
			ob_start();
			print "<pre>";
			print_r($nextAction);
			print "</pre>";
			ob_end_clean();

			//
			// Now do check the result - Is clementine playing?
			//
			if($nextAction->struct[0] == "0")
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch (Exception $e)
	    {
	        //print get_class($e)." thrown within the exception handler. Message: ".$e->getMessage()." on line ".$e->getLine();
	    }
	}
?>