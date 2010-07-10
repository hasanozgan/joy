                <ul class="membership">
                    <li tal:condition="get/member/logged">
                        <img tal:attributes="src get/member/picture|default" 
                                src="http://friendfeed-media.com/p-d6e7d2624e6611dd8411003048343a40-medium-1000"/>
                    </li>
                    <li tal:condition="get/member/logged">
                        <a tal:attributes="href get/member/link|default" href="" tal:content="get/member/fullname|default">HasanOzgan</a>
                    </li>
                    <li tal:condition="get/member/logged">
                        <a tal:attributes="href string:${application/site_root}/logout" tal:content="application/i18n/logout">Çıkış</a>
                    </li>
                    <li tal:condition="not: get/member/logged">
                        <a tal:attributes="href string:${application/site_root}/login"><div
                        class="friendfeed-signin">&nbsp;</div></a></li>
                </ul>

