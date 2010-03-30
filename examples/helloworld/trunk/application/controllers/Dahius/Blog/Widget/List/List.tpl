<strong>List Template</strong>
<label tal:content="application/site_root"></label>
<!--

    ; import objesi olacak 

        __import/block/Head
        __import/stack/List

        application/site_root
        __application/i18n/hello


    ; helper - modifier olacak

        helper: get/image_root('image/sdff');
        helper: i18n('hello.world');
        helper: get('version');
        helper: set('version', '0.5.6');

-->


