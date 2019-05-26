<?php

class Model_Links extends Orm\Model
{
    protected static $_properties = [
        'id',
        'title'
    ];

	public static function getLinks()
    {
        // get all Links
        $posts = Model_Links::find('all');
        return $posts;
    }

	public static function getSubLinks()
    {
    	//get all Sub Links
        $post = Model_Links::find('all', [
            'where' => ['group' => $userid]
        ]);
    }

    public static function getTriLinks()
    {
    	//get all Tri Links
        $post = Model_Links::find('all', [
            'where' => ['group' => $userid]
        ]);
    }


}