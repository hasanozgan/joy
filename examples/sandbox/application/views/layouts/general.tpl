<html>
    <head>
<!-- @Page.Stylesheets -->
    </head>
    <body>
        <div class="container_12">
            <div class="grid_12" tal:content="structure import/block/header"></div>
            <div class="grid_12">
                <div class="reset"></div>
                <div tal:content="structure import/action"></div>
            </div>
            <div class="grid_12" tal:content="structure import/block/footer"></div>
        </div>
    </body>
<!-- @Page.Javascripts -->
</html>
