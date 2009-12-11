<div class="title">
    <h2 tal:content="post/title">Internet Stratejileri, Yazılım Geliştirme ve Mimarileri Üzerine</h2>
    <span style="text-align:right;" tal:content="post/getFormatedDate">22 Kasım 2009</span>
</div>
<div class="content" tal:content="structure post/body"></div>
<span class="category" tal:condition="exists:categories">
    <div class="clear"></div>
    <strong>Kategori</strong><br/>
    <ul tal:repeat="category categories">
        <li><a tal:attributes="href site_root:/notes/category/${category/slug}" tal:content="category/title" href="">general</a></li>
    </ul>
</span>

<span class="tag" tal:condition="exists:tags">
    <div class="clear"></div>
    <strong>Etiket</strong><br/>
    <ul tal:repeat="tag tags">
        <li><a tal:attributes="href site_root:/notes/tag/${tag/slug}" tal:content="tag/title" href="">linux</a></li>
    </ul>
</span>


