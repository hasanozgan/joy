<html>
	<head>
		<title tal:content="joy_page/Header/Title |default">Activity.fm</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<!-- @Page.Stylesheets -->
	</head>

	<body>
        <div class="container_12">
            <div class="clear"></div>
            <div class="grid_12 header" tal:content="structure joy_render/block/header"></div>
            
            <div class="clear"></div>
            <div class="grid_12"><hr/></div>

            <div class="clear"></div>
            <div class="grid_8" tal:content="structure joy_render/block/request"></div>
            <div class="grid_4" tal:content="structure joy_render/block/sidebar"></div>

            <div class="clear"></div>
            <div class="grid_12"><hr/></div>

            <div class="clear"></div>
            <div class="grid_12 footer" tal:content="structure joy_render/block/footer"></div>
            
            <div class="clear"></div>
        </div>

<!-- @Page.Javascripts -->
	</body>

</html>
