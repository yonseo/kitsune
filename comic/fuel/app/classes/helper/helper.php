<?php

class Helper
{
	public static function navLinks() 
	{
		$posts = Model_Link::getLinks();
		$data = ['posts' => $posts];
		//$this->template->navlinks = View::forge('sidebar', $data);
	} 
	public static function sublinks() 
	{

	}
	public static function trilinks() 
	{

	}

}