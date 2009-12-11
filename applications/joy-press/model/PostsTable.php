<?php
/**
 */
class PostsTable extends Doctrine_Table
{
    const PUBLISH = "publish",
          DRAFT = "draft",
          DELETED = "deleted";

    const TAG = 'tag',
          CATEGORY = 'category';

    public function queryEntryList()
    {
        return $this->createQuery("p")->
                select("p.slug, p.title, p.created_on, p.created_by, p.body")->
                where("p.status = ?", self::PUBLISH)->
                orderBy("created_on desc");
    }

    public function getEntryList()
    {
        return $this->queryEntryList()->execute();
    }

    public function getLastEntryList()
    {
        $q = $this->queryEntryList()->limit(10);
        
        return $q->execute();
    }

    public function getPostBySlug($slug)
    {
        $post = $this->createQuery("p")->
                where("p.status = ?", self::PUBLISH)->
                andWhere("p.slug = ?", $slug)->
                execute();

        if (!count($post)) return false;

        return $post[0];
    }

    public function getTagsByPostId($id)
    {
        $q = Doctrine_Query::create();

        return $q->select("m.title as title, m.slug as slug, r.post_id, t.id")->
                    from("Relations r")->
                    leftJoin("r.Taxonomies t")->
                    leftJoin("t.Marks m")->
                        where("t.status = ?", self::PUBLISH)->
                        andWhere("m.status = ?", self::PUBLISH)->
                        andWhere("t.type = ?", self::TAG)->
                        andWhere("r.post_id = ?", $id)->
                    execute();
    }

    public function getCategoriesByPostId($id)
    {
        $q = Doctrine_Query::create();

        return $q->select("m.title as title, m.slug as slug, r.post_id, t.id")->
                    from("Relations r")->
                    leftJoin("r.Taxonomies t")->
                    leftJoin("t.Marks m")->
                        where("t.status = ?", self::PUBLISH)->
                        andWhere("m.status = ?", self::PUBLISH)->
                        andWhere("r.post_id = ?", $id)->
                        andWhere("t.type = ?", self::CATEGORY)->
                    execute();
    }

    public function getEntryListByCategorySlug($slug) 
    {
        $q = Doctrine_Query::create();
        $q->select("r.post_id as id, p.title as title, p.slug as slug, p.created_on as created_on")->
            from("Relations r")->
                leftJoin("r.Taxonomies t")->
                leftJoin("t.Marks m")->
                leftJoin("r.Posts p")->
            where("m.slug = ?", $slug)->
                andWhere("m.status = ?", self::PUBLISH)->
                andWhere("p.status = ?", self::PUBLISH)->
                andWhere("t.status = ?", self::PUBLISH)->
                andWhere("t.type = ?", self::CATEGORY)->
            orderBy("p.created_on desc");
    
    $a = $q->execute();
    return $a;
    }


    public function getEntryListByTagSlug($slug) 
    {
        $q = Doctrine_Query::create();

        $q->select("r.post_id as id, p.title as title, p.slug as slug, p.created_on as created_on")->
            from("Relations r")->
                leftJoin("r.Taxonomies t")->
                leftJoin("t.Marks m")->
                leftJoin("r.Posts p")->
            where("m.slug = ?", $slug)->
                andWhere("m.status = ?", self::PUBLISH)->
                andWhere("p.status = ?", self::PUBLISH)->
                andWhere("t.status = ?", self::PUBLISH)->
                andWhere("t.type = ?", self::TAG)->
            orderBy("p.created_on desc");

        return $q->execute();
    }

    public function getPostsByCategorySlug($slug) 
    {
    }

}
