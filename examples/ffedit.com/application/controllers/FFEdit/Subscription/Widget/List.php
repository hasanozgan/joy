<?php

class FFEdit_Subscription_Widget_List extends FFEdit_Subscription_Widget
{
    public function onInit()
    {
        // Require parameters
        $this->setName("List");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
        $site_root = $this->config->application->get("application/site_root");    
        $action = $this->request->getAction();
        $data = $this->session->get("member");
        $actionType = substr($action->parameters["type"], 0, -1);
        $listName = $action->parameters["id"];

        if (is_array($data)) {
            $subscriptions = array();
            foreach($data["subscriptions"] as $subscribe) {
                if ($actionType == $subscribe->type) {
                    $subscriptions[$subscribe->id] = $subscribe;
                }
            }

            // Get List Subscriptions
            $list_subscriptions = $this->session->get($listName);
            if (!is_object($list_subscriptions)) {
                $access_token = $this->session->get("access_token");
                $ff = FriendFeed_Helper::getInstance($access_token);

                // Fetch List Subcsribers..
                $list_subscriptions = $ff->fetch_feed_info($listName);
                $this->session->set($listName, $list_subscriptions);
            }

            $feeds = array();
            foreach($list_subscriptions->feeds as $feed) {
                if ($actionType == $feed->type) {
                    $feeds[$feed->id] = $feed;
                    unset($subscriptions[$feed->id]);
                }
            }

            $lists = array();
            foreach($data["lists"] as $list) {
                $list["class"] = (($action->parameters["id"] == $list["id"]) ? "current" : "no");
                $list["link"] = "{$site_root}/{$list["id"]}/{$action->parameters["type"]}";
                $lists[] = $list;
            }

            $this->assign("feeds", (array)$feeds);
            $this->assign("subscriptions", (array)$subscriptions);
            $this->assign("lists", (array)$lists);
        }
        else {
            $this->assign("feeds", array());
            $this->assign("subscriptions", array());
            $this->assign("lists", array());
        }

        $this->assign("listType", $actionType);
        $this->assign("listId", $action->parameters["id"]);
    }
}
