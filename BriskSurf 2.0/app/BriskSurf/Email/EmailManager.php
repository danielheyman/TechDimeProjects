<?php namespace BriskSurf\Email;

use Mailgun;
use URL;

class EmailManager {

	protected $emailLayout;
	protected $emailLog;
	protected $email;
	protected $emailDraft;

	public function __construct(EmailLayoutModel $emailLayout, EmailLogModel $emailLog, EmailModel $email, EmailDraftModel $emailDraft)
	{
		$this->emailLayout = $emailLayout;
		$this->emailLog = $emailLog;
		$this->email = $email;
		$this->emailDraft = $emailDraft;
	}

	public static function getDraftCount()
	{
		return EmailDraftModel::count();
	}

	public function newTransactional($campaign_id)
	{
		$email = new $this->email;

		$email->campaign = $campaign_id;
		$email->type = "transactional";
		$email->layout = $this->emailLayout->first()->id;
		$email->from = "support";
		$email->subject = "New Email";
		$email->name = "New Email";
		$email->notification = false;
		$email->data = "";
		$email->clicks = 0;
		$email->opens = 0;
		$email->save();

		return $email;
	}

	public function deleteById($id)
	{
		$this->email->where("_id", $id)->delete();
	}

	public function find($id)
	{
		return $this->email->find($id);
	}

	public function preview($email, $user, $action_data)
	{
		$from = $this->getFrom($email->from);
		$from_name = $this->getFrom($email->from, "from_name");
		$attributes = $this->getAttributes($user, $action_data);
		$data = $this->createView($email, $attributes);

		return (object)["from" => $from, "from_name" => $from_name, "subject" => $email->subject, 'data' => $data];
	}

	public function sendDraft($draft, $user)
	{
		$email = $this->email->find($draft->email_id);

		$from = $this->getFrom($email->from);
		$from_name = $this->getFrom($email->from, "from_name");
		$attributes = $this->getAttributes($user, $draft->action_data);
		$data = $this->mailTemplate($user, $from, $from_name, $email, $attributes);

		$draft->delete();
	}

	public function processEmail($job, $data)
	{
		$email_id = $data["email_id"];
		$user = $data["user"];
		$status = $data["status"];
		$action_data = $data["action_data"];

		$email = $this->email->find($email_id);
		if($status == "draft")
		{
			$emailDraft = new $this->emailDraft;
			$emailDraft->user_id = $user["_id"];
			$emailDraft->user_name = $user["name"];
			$emailDraft->subject = $email->subject;
			$emailDraft->action_data = $action_data;
			$emailDraft->email_id = $email_id;
			$emailDraft->save();
		}
		else if($status == "auto")
		{
			$from = $this->getFrom($email->from);
			$from_name = $this->getFrom($email->from, "from_name");
			$attributes = $this->getAttributes($user, $action_data);
			$data = $this->mailTemplate($user, $from, $from_name, $email, $attributes);
		}
		$job->delete();
	}

	public function getFrom($from, $type = "email")
	{
		if($from == "support")
		{
			if($type == "email") return "support@techdime.com";
			return "Tech Dime Support";
		}
		else if($from == "news")
		{
			if($type == "email") return "news@techdime.com";
			return "Tech Dime News";
		}
		else if($from == "daniel")
		{
			if($type == "email") return "daniel@techdime.com";
			return "Daniel Heyman";
		}
		else if($from == "matt")
		{
			if($type == "email") return "matt@techdime.com";
			return "Matt Baker";
		}
	}

	public function getAttributes($user, $action_data = false)
	{
		$attributes = array("user.first_name" => $user->getFirstName());

		if($action_data)
		{
			foreach($action_data as $attribute => $data)
			{
				$attributes["action." . $attribute] = $data;
			}
		}

		foreach(\Config::get('events::attributes') as $attribute => $type)
		{
			if($type == "date") $attributes["user." . $attribute] = $user->{$attribute}->diffForHumans();
			else if($type != "bool" && $type != "exist") $attributes["user." . $attribute] = $user->{$attribute};
		}
		return $attributes;
	}

	public function createView($email, $data)
	{
		$emailLayout = $this->emailLayout->find($email->layout);

		$content = str_replace("{{content}}", $email->data, $emailLayout->data);

		foreach($data as $key => $value)
		{
			$content = str_replace("{{" . $key . "}}", $value, $content);
		}

		if($email->type == "transactional") $content = preg_replace('/<p class="unsubscribe">(.|\n)+<\/p>/i', "", $content);

		$content = preg_replace_callback('/{{url::(.+)}}/i', function($matches) {
			return URL::to($matches[1]);
		}, $content);

		return $content;
	}

	public function mailTemplate($user, $from, $from_name, $email, $data)
	{
		$data = $this->createView($email, $data);

		$emailLog = new $this->emailLog;
		$emailLog->user_id = $user->id;
		$emailLog->user_name = $user->name;
		$emailLog->data = $data;
		$emailLog->from = $from;
		$emailLog->from_name = $from_name;
		$emailLog->subject = $email->subject;
		$emailLog->email = $email->id;
		$emailLog->clicked = false;
		$emailLog->opened = false;
		$emailLog->save();

		$email_id = $emailLog->id;

		$data = str_replace('</body>', '<img alt="" src="' . URL::to("e/o/" . $email_id) . '" width="1" height="1" border="0" /></body>', $data);

		$data = preg_replace_callback("/href=\"((?:.|\n)+)\"/i", function($matches) use ($email_id) {
			return 'href="' . URL::to("e/c/" . $email_id) . "?url=" . $matches[1] . '"';
		}, $data);

		Mailgun::send('emails.empty', array("data" => $data), function ($message) use ($user, $email, $from, $from_name)
		{
			$message->from($from, $from_name);
			$message->to($user->email, $user->name)->subject($email->subject);
		});

		Event::fire('email.sent', array($email, $emailLog));
	}

	public function openedEmail($id)
	{
		$log = $this->emailLog->where("_id", $id)->first(["opened", "email"]);
		if($log != null)
		{
			if(!$log->opened)
			{
				$email = $this->email->where('_id', $log->email)->increment("opens");
				$log->opened = true;
				$log->save();
			}
		}

		$image = ImageCreate(1, 1); 
		$color = ImageColorAllocate($image, 255, 255, 255);
		ImageFill($image, 0, 0, $color); 

		header('Content-Type: image/gif');
		imagegif($image);
		imagedestroy($image);

	        	return false;
	}

	public function clickedEmail($id)
	{
		$log = $this->emailLog->where("_id", $id)->first(["clicked", "email"]);
		if($log != null)
		{
			if(!$log->clicked)
			{
				$email = $this->email->where('_id', $log->email)->increment("clicks");
				$log->clicked = true;
				$log->save();
			}
		}
	}
}