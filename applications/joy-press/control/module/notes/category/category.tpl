<div style="font-size:1em; padding-top:50px;">
    <h2>~$ tac /var/log/mind | tr category | grep <span tal:content="category/slug"></span></h2>
    <div class="clear"></div>
    <div class="last_posts" style="font-size:1em" tal:repeat="post posts">
        <a tal:attributes="href site_root:notes/post/${post/slug}" href="ozgur-internet">
            <div class="grid_2 alpha" style="text-align:right" tal:content="post/getFormatedDate">22 Kasım 2009</div>
            <div class="grid_7 omega" tal:content="post/title">“Özgür İnternet Bildirgesi” İmza Kampanyası</div>
        </a>
    </div>
</div>
