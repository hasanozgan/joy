<div id="left">
    <table>
        <tr>
        <td>
            <div class="searchbox"><input type="text" id="box1Filter" /><button type="button" id="box1Clear"></button></div>
            <select id="box1View" multiple="multiple" style="height:300px;width:300px;">
                <option tal:repeat="item get/subscriptions" tal:content="item/name" tal:attributes="value item/id"></option>
            </select>
            <span id="box1Counter" class="countLabel"></span>
            <select id="box1Storage"></select>
        </td>
        <td style="text-align:center; vertical-align:middle; width: 100px">
            <button class="sexybutton sexysimple" id="to2" type="button">&nbsp;&gt;&nbsp;</button>
            <br/><br/>
            <button class="sexybutton sexysimple" id="to1" type="button">&nbsp;&lt;&nbsp;</button>
        </td>
        <td>
            <div class="searchbox"><input type="text" id="box2Filter" /><button type="button" id="box2Clear"></button></div>
            <select id="box2View" multiple="multiple" style="height:300px;width:300px;">
                <option tal:repeat="item get/feeds" tal:content="item/name" tal:attributes="value item/id"></option>
            </select>
            <span id="box2Counter" class="countLabel"></span>
            <select id="box2Storage"></select>
        </td>
        </tr>
    </table>
    <input type="hidden" id="list_type" name="list_type" tal:attributes="value get/listType" />
    <input type="hidden" id="list_id" name="list_id" tal:attributes="value get/listId" />
</div>
<div id="right" tal:condition="exists: get/lists">
    <h4 tal:content="application/i18n/friendfeed lists"></h4>
    <ul>
        <li tal:repeat="item get/lists" tal:attributes="class item/class">
            <a tal:content="item/name" tal:attributes="href item/link" href="name">Developers</a>
        </li>
    </ul>
</div>

