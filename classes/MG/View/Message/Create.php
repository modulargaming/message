<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * View for Message Create
 *
 * @package    MG/Message
 * @category   View
 * @author     Modular Gaming
 * @copyright  (c) 2013 Modular Gaming
 * @license    BSD http://www.modulargaming.com/license
 */
class MG_View_Message_Create extends Abstract_View_Message {

	public $title = 'Create Message';


	public function username()
	{
		return $this->username;
	}

	protected function get_breadcrumb()
	{
		return array_merge(parent::get_breadcrumb(), array(
			array(
				'title' => 'Create Message',
				'href'  => Route::url('message.create', array('username' => $this->username))
			)
		));
	}

}
