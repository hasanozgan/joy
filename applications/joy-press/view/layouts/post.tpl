<html>
	<head>
		<title tal:content="joy_page/Header/Title |default">Hasan Ozgan - Internet Stratejileri, Yazılım Geliştirme ve
        Mimarileri Üzerine</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="shortcut icon" tal:attributes="href site_root:favicon.ico" />
<!-- @Page.Stylesheets -->
	</head>

	<body>
        <div class="container_12">
            
            <div class="grid_12 header" style="border-bottom:2px solid #666;"></div>

            <div class="clear"></div>
            <div class="grid_9">
                <div class="clear"></div>
                <div class="grid_6 alpha menu">
                    <a tal:attributes="href site_root:/notes">Notlarım</a> &nbsp; 
                    <a tal:attributes="href site_root:/works">Çalışmalarım</a> &nbsp;
                    <a tal:attributes="href site_root:/about">Hakkımda</a>
                </div>
                <div class="grid_3 omega blog-menu">
                    <a href="http://ikikalasbirheves.com" target="theatre">Tiyatro</a> &nbsp;
                    <a href="http://meddah.org" target="meddah">English</a>
               </div>
               <div tal:content="structure joy_render/block/request"></div>
            </div>
            <div class="grid_3" tal:content="structure joy_render/block/sidebar"></div>

            <div class="clear"></div>
            <div class="grid_9" tal:content="structure joy_render/block/comment"></div>

            <div class="clear"></div>
            <div class="grid_12 footer" tal:content="structure joy_render/block/footer"></div>

        </div>

<!-- @Page.Javascripts -->

	</body>

</html>
