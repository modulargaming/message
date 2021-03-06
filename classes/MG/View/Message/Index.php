<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * View for Message Index
 *
 * @package    MG/Message
 * @category   View
 * @author     Modular Gaming
 * @copyright  (c) 2013 Modular Gaming
 * @license    BSD http://www.modulargaming.com/license
 */
class MG_View_Message_Index extends Abstract_View_Message {

	public $title = 'Inbox';

	public function messages()
	{
		$messages = array();

		foreach ($this->messages as $message)
		{
			$messages[] = array(
				'created' => Date::format($message->created),
				'subject' => $message->subject,
				'content' => substr(strip_tags($message->content), 0, 100),
				'id'	  => $message->id,
				'read'    => $message->read,
				'href'    => Route::url('message.view', array('id' => $message->id)),

				'sender' => array(
					'id' => $message->sender->id,
					'username'  => $message->sender->username,
					'avatar' => $message->sender->avatar(),
					'href'      => Route::url('user.profile', array(
						'id'     => $message->sender->id,
					)),
				),
			);
		}

		return $messages;
	}

	public function total_messages()
	{
		return count($this->messages);
	}

	public function links()
	{
		return array(
			'create' => Route::url('message.create', array(
				'action' => 'create',
			)),
			'inbox' => Route::url('message.inbox'),
			'outbox' => Route::url('message.outbox')
		);
	}

	protected function get_breadcrumb()
	{
		return array_merge(parent::get_breadcrumb(), array(
			array(
				'title' => 'Inbox',
				'href'  => Route::url('message.inbox')
			)
		));
	}


}
