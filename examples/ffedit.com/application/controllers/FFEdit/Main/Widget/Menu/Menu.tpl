    <ul class="menu" id="jMenu">
        <li tal:repeat="item get/menuItems" tal:attributes="class item/class"><a tal:attributes="href item/link" tal:content="item/title"></a></li>
    </ul>

