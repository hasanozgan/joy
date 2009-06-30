<html>
<head>
<title>RSS/XML Syndicated Publications Parser</title>
</head>
<body>
<table border=0 cellpadding=0 cellspacing=0 width=250>
<tr>

<td width=250 style="font-family:verdana;font-size:8pt">

<?php

// Sample links to illustrate all RSS versions
// Version 0.91
$file="http://www.computerworld.com/news/xml/0,5000,29,00.xml";
// Version 2.0
$file="http://services.devx.com/outgoing/webdevfeed.xml";
// Version RDF (1.0)
$file="http://rss.azstarnet.com/index.php?section=s1a";

include_once ("class_RSS_feed.php");

$px = new RSS_feed();
$px->Set_URL($file);
$px->Set_Limit("0"); // 0 = Default = All
$px->Show_Image(true); // Default = false
$px->Show_Description(true); // Default = false
$r = $px->Get_Results();
echo $r;
// Pretty simple
?>

</td></tr></table>

<?
$px = "";  // Get the memory and threads back
$r = "";
?>

</body>
</html>
