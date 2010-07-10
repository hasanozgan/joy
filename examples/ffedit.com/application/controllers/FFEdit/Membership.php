<?php

class FFEdit_Membership extends Joy_Module
{
    protected function _callback($type="friendfeed")
    {
        $site_root = $this->config->application->get("application/site_root");    
        $action = $this->request->getAction();

        if ($type == "friendfeed") {
            $access_token = $this->session->get("access_token");
            $request_token = $this->session->get("request_token");

            // Access Policy
            if (!is_array($access_token) && ($_REQUEST["oauth_token"] == $request_token["oauth_token"])) {
                $ff = FriendFeed_Helper::getInstance();
                $access_token = $ff->fetch_oauth_access_token($request_token);

                $this->session->set("access_token", $access_token);
            }
            
            // Access Token Has Truested
            if (is_array($access_token)) {
                $ff = FriendFeed_Helper::getInstance($access_token);
 
                // Home list preparing..
                $listSubscriptions = $lists = array();
                $lists[] = array("id" =>"home", "name" => "Home");

                // Fetch All Lists..
                $feed = $ff->fetch_feed_list();
                foreach ($feed->lists as $list) {
                    //Prepare Lists.
                    $lists[] = array("id" =>$list->id, "name" => "$list->name");
                }

                $feed = $ff->fetch_feed_info($access_token["username"]);
                
                $member = array("username"=>$access_token["username"],
                                "sup_id"=>$feed->sup_id,
                                "fullname"=>$feed->name,
                                "subscriptions"=>$feed->subscriptions,
                                "lists"=>$lists);

                try {
                    // Save Records...
                    $q = $this->models->Users->createQuery('u');
                    $q->where("u.username = ?", $member["username"]);
                    $result = $q->execute();
                    
                    if ($result[0]->username == $member["username"]) {
                        $u = $result[0];
                    }
                    else {
                        $u = $this->models->users->create();
                        $u->username = $member["username"];
                        $u->sup_id = $member["sup_id"];
                        $u->created_on = time();
                    }
                    $u->frequency++;
                    $u->updated_on = time();
                    $u->access_token = $access_token["oauth_token"];
                    $u->access_token_secret = $access_token["oauth_token_secret"];
                    $u->lists = serialize($member["lists"]);
                    $u->save();
                }
                catch (Exception $ex) {}
                
                $this->session->set("member", $member);
            }
        }

        header("Location: $site_root/home/users");
        die;
    }

    protected function _index()
    {
    }

    protected function _logout()
    {
        $this->session->delete("member");
        $site_root = $this->config->application->get("application/site_root");
        header("Location: $site_root");
        die;
    }

    protected function _login()
    {
        list($request_token, $url) = FriendFeed_Helper::getAuthentication();
        $this->session->set("request_token", $request_token);

        header("Location: $url");
        die;
    }

    protected function _profile()
    {
    }    

}
