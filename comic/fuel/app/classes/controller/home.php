<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

class Controller_Home extends Controller_Template
{

	public function __construct()
	{
		//fetch sidebar links
		//Helper::navLinks();
		$posts = Model_Links::getLinks();
		$data = ['posts' => $posts];
		//$this->template->subnav = View::forge('sidebar', $data);
	}

	public function action_index()
	{
		$posts = Model_Links::getLinks();
		if(!$posts)
		{
			$posts[] = NULL;
		}
		$data = ['posts' => $posts];
        $this->template->title = 'Dashboard';
        $this->template->content = View::forge('home/index', $data);
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('home/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('home/404'), 404);
	}
}
