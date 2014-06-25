<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Controller for Message Create
 *
 * @package    MG/Message
 * @category   Controller
 * @author     Modular Gaming
 * @copyright  (c) 2013 Modular Gaming
 * @license    BSD http://www.modulargaming.com/license
 */
class MG_Controller_Message_Create extends Abstract_Controller_Message {

	public function action_index()
	{
		$username = $this->request->param('username');

		$this->view = new View_Message_Create;
		$this->view->username = $username;

		if ($this->request->method() == HTTP_Request::POST)
		{
			try
			{
				$post = $this->request->post();
				$receiver = ORM::factory('User')->where('username', '=', $post['receiver'])->find();

				if ( ! $receiver->loaded())
				{
					throw HTTP_Exception::Factory('404', 'No such user');
				}
				elseif ($this->user->id === $receiver->id)
				{
					return Hint::error('You cannot send a message to yourself!');
				}

				$message_data = Arr::merge($this->request->post(), array(
					'sender_id' => $this->user->id,
					'receiver_id' => $receiver->id,
				));

				$message = ORM::factory('Message')
					->create_message($message_data, array(
						'receiver_id',
						'subject',
						'content',
						'sender_id',
					));

				$message_data_sent = Arr::merge($this->request->post(), array(
					'receiver_id' => $this->user->id,
					'sender_id' => $receiver->id,
					'sent' => 1,
					'read' => 1,
				));

				ORM::factory('Message')
					->create_message($message_data_sent, array(
						'receiver_id',
						'subject',
						'content',
						'sender_id',
						'sent',
						'read',
					));

				Hint::success('You have sent a message');
				$this->redirect(Route::get('message.inbox')->uri());
			}
			catch (ORM_Validation_Exception $e)
			{
				Hint::error($e->errors('models'));
			}

		}
	}

}
