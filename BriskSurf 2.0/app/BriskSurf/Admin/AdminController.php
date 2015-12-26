<?php namespace BriskSurf\Admin;

use Auth;
use Carbon;
use URL;
use View;
use Input;
use Redirect;
use Settings;
use Config;
use BriskSurf\Events\CounterManager;
use BriskSurf\Lists\ListModel;
use BriskSurf\Lists\ListUserModel;
use BriskSurf\Campaigns\ActionCampaignModel;
use BriskSurf\Campaigns\ActionCampaignManager;
use BriskSurf\Email\EmailModel;
use BriskSurf\Email\EmailDraftModel;
use BriskSurf\Email\EmailLayoutModel;
use BriskSurf\Email\EmailLogModel;
use BriskSurf\Email\EmailManager;
use BriskSurf\Settings\SettingsModel;
use BriskSurf\Payments\PackageModel;
use Packages;
use User;

class AdminController extends \BriskSurf\Helpers\BaseController
{
	protected $counter;
	protected $listModel;
	protected $listUser;
	protected $actionCampaign;
	protected $email;
	protected $emailLayout;
	protected $emailDraft;
	protected $emailLog;
	protected $actionCampaignManager;
	protected $emailManager;

	public function __construct(CounterManager $counter, ListModel $listModel, ListUserModel $listUser, ActionCampaignModel $actionCampaign, ActionCampaignManager $actionCampaignManager, EmailModel $email, EmailLogModel $emailLog, EmailLayoutModel $emailLayout, EmailDraftModel $emailDraft, EmailManager $emailManager)
	{
		$this->counter = $counter;
		$this->listModel = $listModel;
		$this->listUser = $listUser;
		$this->actionCampaign = $actionCampaign;
		$this->email = $email;
		$this->emailLayout = $emailLayout;
		$this->actionCampaignManager = $actionCampaignManager;
		$this->emailDraft = $emailDraft;
		$this->emailLog = $emailLog;
		$this->emailManager = $emailManager;

        		View::share('draft_count', EmailManager::getDraftCount());
	}

	public function dash()
	{
		$types = array('unique_logins', 'registrations', 'activations', 'profits', 'commissions');

		$graphs = array();

		foreach($types as $type)
		{
			$graphs[$type] = $this->counter->graphDays(array(
				"type" => $type
			), \Carbon::now()->subDays(15), \Carbon::now());
		}

		return View::make("admin::dash")->with("graphs", $graphs);
	}

	public function users($id = null)
	{
		if($id == null) return View::make("admin::users");

		return View::make("admin::users")->with(array(
			"user" => User::where("_id", $id)->with('lists')->first(),
			"settings" => Config::get('users::settings_editable')
		));
	}

	public function postUsers($id = null)
	{
		if($id == null)
		{
			$user = User::search(Input::get('search'));
			if($user->isEmpty()) return Redirect::to('admin/users')->withErrors( array("global" => "User not found") )->withInput();
			else return Redirect::to('admin/users')->with(array("users" => $user, "search" =>  Input::get('search')));
		}
		(new User)->updateFromInput($id, Input::all());
		return Redirect::to('admin/users/' . $id);
	}

	public function settings()
	{
		return View::make("admin::settings")->with(array("settings" => \Settings::all()));
	}

	public function postSettings()
	{
		(new SettingsModel)->updateFromInput(Input::all());

		return Redirect::to('admin/settings')->with('page', Input::get('id'));
	}

	public function login()
	{
		return View::make('admin::login');
	}
	
	public function loginPost()
	{
		$password = Input::get('password');

		if($password == "MAndDHairs!")
		{
			return Redirect::to('admin')
				->withCookie(\Cookie::forever('admin', md5('admin_set_' . Auth::user()->id . \Request::getClientIp())));
		}
		
		return Redirect::to('admin/login');
	}

	public function lists()
	{
		return View::make('admin::lists')->with("lists", $this->listModel->all());
	}

	public function getList($id)
	{
		if($id != 'new')
		{
			$model = $this->listModel->find($id);
			if($model == null) return Redirect::to('admin/lists');
		}

		return View::make('admin::list_settings')->with(array(
			"list" => ($id != 'new') ? $model : 'new',
			"attributes" => Config::get('users::attributes'),
			"actions" => array_keys(Config::get('events::actions'))
		));
	}

	public function postList($id)
	{
		if($id == "new")
		{
			$list = new $this->listModel;
			$list->dependencies = array();
			$list->user_count = 0;
		}
		else $list = $this->listModel->find($id);

		if($list != null) $list->updateFromInput(Input::all());

		return Redirect::to('admin/lists');
	}

	public function deleteList($id)
	{
		$list = $this->listModel->find($id)->delete();

		return Redirect::to('admin/lists');
	}

	public function packages()
	{
		return View::make('admin::packages')->with("packages", Packages::all());
	}

	public function getPackage($id)
	{
		$package = ($id == 'new') ? (object) array('_id' => 'New Package', 'name' => '', 'cost' => '1', 'renew' => 'none', 'type' => 'credit', 'value' => "100", 'active' => 'true', 'trial' => 'none') : Packages::get($id);
		return View::make('admin::packages')->with("package", $package);
	}

	public function postPackage($id)
	{
		$input = Input::get();

		if(isset($input['delete']) && $input['delete'] == 'Delete Me')
		{
			PackageModel::find($id)->delete();
			return Redirect::to('admin/packages');
		}

		$package = ($id == 'new') ? new PackageModel : PackageModel::find($id);

		$errors = $package->updateFromInput($input);

		if($errors) return Redirect::to('admin/packages/' . $this->id)->withErrors($errors);

		return Redirect::to('admin/packages/' . $package->id);
	}

	

	public function getEmail($id)
	{
		$email = $this->email->find($id);
		
		$campaign = $this->actionCampaign->where("_id", $email->campaign)->first(["action"]);
		$action_attributes = array();
		foreach(Config::get('events::actions')[$campaign->action] as $attribute => $type)
		{
			if($type != "bool" && $type != "exist") $action_attributes[] = $attribute;
		}
		$attributes = array("first_name");
		foreach(Config::get('users::attributes') as $attribute => $type)
		{
			if($type != "bool" && $type != "exist") $attributes[] = $attribute;
		}

		return View::make('admin::email')->with('email', $email)->with('layouts', $this->emailLayout->get(['name']))->with('attributes', $attributes)->with('action_attributes', $action_attributes)->with('campaign', $campaign->id);
	}

	public function getEmailPreview($id)
	{
		$email = $this->email->find($id);

		$action = $this->actionCampaign->where("_id", $email->campaign)->first(["action"])->action;
		$sampleData = $this->actionCampaignManager->getSampleActionData($action);

		$emailPreview = $this->emailManager->preview($email, \Auth::user(), $sampleData);

		return View::make('admin::view_email')->with(array(
			"from" => $emailPreview->from,
			"from_name" => $emailPreview->from_name,
			"subject" => $emailPreview->subject,
			"data" => str_replace("\"", "&quot;", $emailPreview->data),
			"date" => \Carbon::now()->subMinute(5)->diffForHumans(),
			"user" => \Auth::user()->id,
			"user_name" => \Auth::user()->name,
			"email_id" => $id,
			"type" => "preview"
		));

		return Redirect::to('admin/campaigns/action/' . $campaign);
	}

	public function postEmail($id)
	{
		$email = $this->email->find($id);

		$email->name = Input::get('name');
		$email->layout = Input::get('layout');
		$email->from = Input::get('from');
		$email->subject = Input::get('subject');
		$email->data = Input::get('data');
		$email->type = Input::get('type');
		$email->notification = (Input::get('notification') == "true");
		$email->save();

		return Redirect::to('admin/email/' . $id);
	}

	public function getEmails()
	{
		return View::make("admin::emails");
	}

	public function getLayouts()
	{
		return View::make('admin::layouts')->with("layouts", $this->emailLayout->all());
	}

	public function getLayout($id)
	{
		if($id != 'new') $model = $this->emailLayout->find($id);

		return View::make('admin::layout')->with("layout", ($id != 'new') ? $model : 'new');
	}

	public function postLayout($id)
	{
		if($id == "new") $layout = new $this->emailLayout;
		else $layout = $this->emailLayout->find($id);

		$layout->name = Input::get('name');
		$layout->data = Input::get('data');
		$layout->save();

		return Redirect::to('admin/emails/layouts/' . $layout->id);
	}

	public function deleteLayout($id)
	{
		$list = $this->emailLayout->where("_id", $id)->delete();

		return Redirect::to('admin/emails/layouts');
	}

	public function getDrafts()
	{
		return View::make('admin::drafts')->with("drafts", $this->emailDraft->orderBy('_id', 'desc')->take(30)->get());	
	}

	public function getDraft($id)
	{
		$draft = $this->emailDraft->find($id);

		$email = $this->email->find($draft->email_id);
		$emailDraft = $this->emailManager->preview($email, Auth::user(), $draft->action_data);

		return View::make('admin::view_email')->with(array(
			"from" => $emailDraft->from,
			"from_name" => $emailDraft->from_name,
			"subject" => $emailDraft->subject,
			"data" => str_replace("\"", "&quot;", $emailDraft->data),
			"date" => $draft->created_at->diffForHumans(),
			"user" => $draft->user,
			"user_name" => $draft->user_name,
			"email_id" => $draft->email_id,
			"type" => "draft"
		));
	}

	public function sendDraft($id)
	{
		$draft = $this->emailDraft->find($id);
		$this->emailManager->sendDraft($draft, Auth::user());

		return Redirect::to('admin/emails/drafts');
	}

	public function deleteDraft($id)
	{
		$this->emailDraft->where("_id", $id)->delete();

		return Redirect::to('admin/emails/drafts');
	}

	public function getEmailLogs()
	{
		return View::make('admin::email_logs')->with("logs", $this->emailLog->orderBy('_id', 'desc')->take(30)->get());	
	}

	public function getEmailLog($id)
	{
		$log = $this->emailLog->find($id);

		return View::make('admin::view_email')->with(array(
			"from" => $log->from,
			"from_name" => $log->from_name,
			"subject" => $log->subject,
			"data" => str_replace("\"", "&quot;", $log->data),
			"date" => $log->created_at->diffForHumans(),
			"user" => $log->user_id,
			"user_name" => $log->user_name,
			"email_id" => $log->email_id,
			"type" => "log"
		));
	}

	public function getEmailOpen($id)
	{
		return $this->emailManager->openedEmail($id);
	}

	public function getEmailClick($id)
	{
		return $this->emailManager->clickedEmail($id);

		return Redirect::to(Input::get('url'));
	}
}





