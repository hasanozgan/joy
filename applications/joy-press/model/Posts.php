<?php

/**
 * Posts
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5318 2008-12-19 20:44:54Z jwage $
 */
class Posts extends BasePosts
{
    public function getFormatedDate()
    {
        setlocale(LC_TIME, "tr_TR.UTF-8");
        return strftime("%d %B %Y", strtotime($this->created_on));
    }
}