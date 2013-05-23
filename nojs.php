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
</head>



<body>
	<div id="wrapper">
		<!-- #header-->
		<header id="header">
			<a href="index.php"><img src="img/appLogo.png" align="left" height="80pt" style="padding-top:10px;"></a>
			<h1><a href="index.php"><?php  echo $appname; ?></a></h1>
			<h2><?php  echo $tagline; ?></h2>			
		</header>
		<!-- #header-->


		<!-- #content-->
		<div id="content">
			<h3>Warning</h3>
			<font color="red">Your browser does not support JavaScript - which is needed for clemStats. Please enable it and then <a href="index.php">try it again</a>.</font><br>
			<img src="img/noscript.gif" alt="image description">
		</div>	
	</div>	
</body>
</html>