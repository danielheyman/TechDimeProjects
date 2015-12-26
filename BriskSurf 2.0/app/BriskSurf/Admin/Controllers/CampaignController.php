<?php namespace BriskSurf\Admin\Controllers;

use Auth;
use Carbon;
use URL;
use View;
use Input;
use Redirect;
use Settings;
use Config;
use BriskSurf\Campaigns\ActionCampaignManager;
use BriskSurf\Lists\ListManager;
use BriskSurf\Email\EmailManager;
use User;

class CampaignController extends \BriskSurf\Helpers\BaseController
{
	protected $actionCampaign;
	protected $list;

	public function __construct(ActionCampaignManager $actionCampaign, ListManager $list)
	{
		$this->actionCampaign = $actionCampaign;
		$this->list = $list;

        		View::share('draft_count', EmailManager::getDraftCount());
	}

	public function getCampaigns()
	{
		return View::make("admin::campaigns");
	}

	public function getActionCampaigns()
	{
		return View::make("admin::action_campaigns")->with("campaigns", $this->actionCampaign->getAll());
	}

	public function getActionCampaign($id)
	{
		return View::make('admin::action_campaign')->with(array(
			"campaign" => ($id != 'new') ? $this->actionCampaign->find($id) : 'new',
			'lists' => $this->list->getAllWithName(),
			'actions' => $this->actionCampaign->getAllActionKeys()
		));
	}

	public function postActionCampaign($id)
	{
		if($id == "new") $campaign = $this->actionCampaign->createFromInput();
		else $campaign = $this->actionCampaign->updateFromInput($id);

		return Redirect::to('admin/campaigns/action/' . $campaign->id);
	}

	public function deleteActionCampaign($id)
	{
		$campaign = $this->actionCampaign->delete($id);

		return Redirect::to('admin/campaigns/action');
	}
}





