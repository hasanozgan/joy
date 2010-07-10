<?php

class FFEdit_Subscription extends Joy_Module
{
    protected function _update()
    {
        $succeed = false;
        $message = "Not OK, Please re-login site.";
        $access_token = $this->session->get("access_token");

        if (is_array($access_token)) {
            try {
                $method = ($_REQUEST["method"] == "add") ? "subscribe" : "unsubscribe";
                $lists = $this->session->get($_REQUEST["id"]);
                $type = $_REQUEST["type"];
                
                $ff = FriendFeed_Helper::getInstance($access_token);
                for ($i = 0; $i < count($_REQUEST["values"]); $i++) {
                    $id = $_REQUEST["values"][$i];
                    $name = $_REQUEST["texts"][$i];

                    $ff->$method($id, array("list"=>$_REQUEST["id"]));
                    if ($method == "subscribe") {
                        $lists->feeds[] = (object) array("id"=>$id, "name"=>$name, "type"=>$type);
                    }
                    else {
                        foreach ($lists->feeds as $key => $feed) {
                            if ($feed->id == $id) {
                                unset($lists->feeds[$key]);
                            }
                        }
                    }
                }

                $this->session->set($_REQUEST["id"], $lists);
                $message = "OK";
                $succeed = true;
            }
            catch (Exception $ex) {
                $message = "Not OK: {$ex->getMessage()}";
            }

        }

        header("Content-type: text/plain");
        $result = array(
                        "succeed"=>$succeed,
                        "message"=>$message
                 );
        printf("result = %s", json_encode($result));
        die;
    }

    protected function _list($id=null, $type="users")
    {
        $view = new FFEdit_Subscription_Widget_List();

        return $view;     
    }
}
