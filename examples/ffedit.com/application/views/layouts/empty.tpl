<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>FFEdit - FriendFeed List Editor</title>
	<meta name="Robots" content="index,follow" />
	<meta name="author" content="Hasan Ozgan at Dahius" />

<!-- @Page.Stylesheets -->

</head>
<body>
	<div id="wrapper">
		<div id="logo">
			<h1>
				<a tal:attributes="href application/site_root">FriendFeed <span>List Editor</span></a>
			</h1>
		</div>
	
		<div id="content">
			<div id="all" style="margin-top:20px;" tal:content="structure import/action"></div>
			<div class="x"></div>
			<div class="break no-border"></div>
		</div>
		
		<!-- footer -->
		<div id="footer">
			<p><a href="http://dahius.com">Copyright &copy; 2009 - 2010 Dahius</a> &middot; Design: Borut Jegrišnik</p>
		</div>
	</div>

<!-- @Page.Javascripts -->

</body>
</html>
