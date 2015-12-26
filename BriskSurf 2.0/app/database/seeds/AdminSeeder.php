<?php

use App\Modules\Lists\Models\ListModel as ListModel;
use App\Modules\Events\Models\ActionCampaign;
use App\Modules\EmailManager\Models\EmailLayout;
use App\Modules\EmailManager\Models\Email;

class AdminSeeder extends Seeder {
	
	public function run() 
	{
		$emailLayout = new EmailLayout;
		$emailLayout->name = "Basic";
		$emailLayout->data = "<html>\r\n    <head>\r\n        <style type=\"text/css\">\r\n            body { max-width:500px; margin:10; padding: 0; font-family: sans-serif; font-size:13px; font-style: normal;}\r\n            .unsubscribe { color:#727272; line-height:18px; }\r\n            .unsubscribe a { color: #333 }\r\n\r\n            @media only screen and (max-device-width: 480px) {\r\n                body { width: 320px !important; margin: 0; padding: 0; }\r\n                td img { height:auto !important; max-width:100% !important;}\r\n            }\r\n        </style>\r\n    </head>\r\n    <body>\r\n        {{content}}\r\n        \r\n        <p class=\"unsubscribe\"><br/>\r\n            Don't want to receive amazing emails from us?\r\n            <a href=\"{{ unsubscribe_url }}\">Unsubscribe</a>\r\n        </p>\r\n    </body>\r\n</html>\r\n";
		$emailLayout->save();

		$email = new Email;
		$email->type = "transactional";
		$email->layout = $emailLayout->id;
		$email->from = "support";
		$email->name = "Activation Welcome Email";
		$email->subject = "Welcome to Brisk Surf!";
		$email->clicks = 0;
		$email->opens = 0;
		$email->data = "Hi {{user.first_name}},<br /><br />Welcome to Brisk Surf!<br /><br />Click&nbsp;<a href=\"{{action.activate_link}}\">here</a>&nbsp;to confirm your account.<br /><br />Best Regards,<br />The BriskSurf Team";
		$email->save();

		$actionCampaign = ActionCampaign::create(array(
			"name" => "Request Activation Link",
			"action" => "send_activation",
		   	"filters" => array(),
		    	"results" => array( 
			        array( "email", $email->id, "draft")
			)
		));

		$email->campaign = $actionCampaign->id;
		$email->save();

		$email = new Email;
		$email->type = "transactional";
		$email->layout = $emailLayout->id;
		$email->from = "support";
		$email->name = "Remind Password Email";
		$email->subject = "Brisk Surf Password Reminder!";
		$email->clicks = 0;
		$email->opens = 0;
		$email->data = "Hi {{user.first_name}},<br /><br />We have changed your password. Make sure to update your password in your settings as soon as you login.<br /><br />Temporary password: {{action.password}}<br /><br />You may login <a href=\"{{url::login}}\">here</a>.<br /><br />Best Regards,<br />The BriskSurf Team";
		$email->save();

		$actionCampaign = ActionCampaign::create(array(
			"name" => "Request Password Reminder",
			"action" => "remind_password",
		   	"filters" => array(),
		    	"results" => array( 
			        array( "email", $email->id, "draft")
			)
		));

		$email->campaign = $actionCampaign->id;
		$email->save();

		ListModel::create(array(
			"name" => "Signed up",
			"dependencies" => array(),
			"status" => "process",
			"user_count" => 0,
			"data" => array(
				array(
					array(
						"type" => "attribute",
						"field" => "activation",
						"comparison" => "does not exist",
						"value" => null
					)
				)
			)
		));

		ListModel::create(array(
			"name" => "Has not logged in recently",
			"dependencies" => array(),
			"status" => "process",
			"user_count" => 0,
			"data" => array(
				array(
					array(
						"type" => "attribute",
						"field" => "last_login",
						"comparison" => "is a timestamp before",
						"value" => 30
					)
				)
			)
		));

		ListModel::create(array(
			"name" => "Has a subscription",
			"dependencies" => array(),
			"status" => "process",
			"user_count" => 0,
			"data" => array(
				array(
					array(
						"type" => "attribute",
						"field" => "membership",
						"comparison" => "is not equal to",
						"value" => "free"
					)
				)
			)
		));

		ListModel::create(array(
			"name" => "Does not have a subscription",
			"dependencies" => array(),
			"status" => "process",
			"user_count" => 0,
			"data" => array(
				array(
					array(
						"type" => "attribute",
						"field" => "membership",
						"comparison" => "is equal to",
						"value" => "free"
					)
				)
			)
		));

	}
}