<?php

import("system.module.IModule");
import("univarsel.RssGenerator");


class NotesModule extends system_web_Context implements system_module_IModule 
{
    public function index()
    {
    }

    public function post($name=null)
    {
        if ($name == null) {
            $this->goto_index_page();
        }

        $this->assign["post-slug"] = $name;
    }

    public function all()
    {
    }

    public function feed()
    {

        $rss_channel = new rssGenerator_channel();
        $rss_channel->atomLinkHref = '';
        $rss_channel->title = 'Hasan Ozgan';
        $rss_channel->link = 'http://hasanozgan.com';
        $rss_channel->description = 'Internet Stratejileri, Yazılım Geliştirme ve Mimarileri Üzerine';
        $rss_channel->language = 'tr-tr';
        $rss_channel->generator = 'Joy Framework RSS Generator';
        $rss_channel->managingEditor = 'hasan@ozgan.net (Hasan Ozgan)';
        $rss_channel->webMaster = 'hasan@ozgan.net (Hasan Ozgan)';
        $rss_channel->pubDate = date("r", time());

        $posts = $this->Models->Posts->getLastEntryList();
        foreach($posts as $post) {
            $item = new rssGenerator_item();
            $item->title = "<![CDATA[{$post["title"]}]]>";
            $item->description = "<![CDATA[{$post["body"]}]]>";
            $item->link = "http://hasanozgan.com/notes/post/{$post["slug"]}";
            $item->guid = "http://hasanozgan.com/notes/post/{$post["slug"]}";
            $item->pubDate = date("r", strtotime($post["created_on"]));
            $rss_channel->items[] = $item;
        }

        $rss_feed = new rssGenerator_rss();
        $rss_feed->encoding = 'UTF-8';
        $rss_feed->version = '2.0';
        header('Content-Type: text/xml');
        echo $rss_feed->createFeed($rss_channel); 
        die();
    }

    public function search()
    {
    }

    public function tag($name=null)
    {
        if ($name == null) {
            $this->goto_index_page();
        }

        $this->assign["tag-slug"] = $name;
    }

    public function category($name=null)
    {
        if ($name == null) {
            $this->goto_index_page();
        }

        $this->assign["category-slug"] = $name;
    }


    private function goto_index_page()
    {
        $notes_root = sprintf("%s/notes", rtrim($this->Config->app["site_root"], '/'));

        header("Location: $notes_root");
        die();
    }
}

?>
