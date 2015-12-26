<?php

use App\Modules\History\Models\HistoryAction as HistoryAction;
use App\Modules\History\Models\HistoryDayCounter as HistoryDayCounter;
use App\Modules\History\Models\HistoryMegaCounter as HistoryMegaCounter;
use App\Modules\History\Models\HistoryYearCounter as HistoryYearCounter;
use App\Modules\History\Models\RecordAction as RecordAction;
use App\Modules\Lists\Models\ListModel as ListModel;
use App\Modules\Lists\Models\ListUser as ListUser;
use App\Modules\Events\Models\ActionCampaign;
use App\Modules\EmailManager\Models\EmailLayout;
use App\Modules\EmailManager\Models\Email;
use App\Modules\EmailManager\Models\EmailDraft;
use App\Modules\EmailManager\Models\EmailLog;

class GeneralSettingsSeeder extends Seeder {
	
	public function run() 
	{
		HistoryAction::truncate();
		HistoryDayCounter::truncate();
		HistoryMegaCounter::truncate();
		HistoryYearCounter::truncate();
		RecordAction::truncate();
		ListModel::truncate();
		ListUser::truncate();
		ActionCampaign::truncate();
		EmailLayout::truncate();
		Email::truncate();
		EmailDraft::truncate();
		EmailLog::truncate();

		DB::collection('settings')->insert(array(
			"_id" => "main",
			"website_name" => "Brisk Surf",
			"paypal_email" => "payments@techdime.com",
			"sandbox_email" => "payments-facilitator@techdime.com",
			"sandbox" => false
		));

		DB::collection('settings')->insert(array(
			"_id" => "memberships",
			"free" => array("commission" => 10, "credits_per_view" => 0.5, "referral_percent" => 1, "timer" => 8, "monthly_credits" => 0, "targeting" => false, "maximum_websites" => 5, "popular" => false),
			"premium" => array("commission" => 30, "credits_per_view" => 1, "referral_percent" => 3, "timer" => 6, "monthly_credits" => 500, "targeting" => true, "maximum_websites" => 10, "popular" => true),
			"platinum" => array("commission" => 50, "credits_per_view" => 1, "referral_percent" => 5, "timer" => 6, "monthly_credits" => 1000, "targeting" => true, "maximum_websites" => 50, "popular" => false)
		));

		DB::collection('settings')->insert(array(
			"_id" => "faq",
			"list" => array(
				"What_is_SurfDuel?" => "SurfDuel is a web service designed to provide your website with traffic. Better websites are shown more often, and therefore receive more traffic. Our system, however, still allows everyone to get a good amount of views to their site. We've created a win-win scenario for everyone.",
				"What_are_some_guidelines_for_submitting_my_website?" => "#LIST# \r\n#BULLET#Autoplaying videos with audio are discouraged.#ENDBULLET# \r\n#BULLET#Please try to keep your content family friendly, or filter it to be displayed to the appropriate age group.#ENDBULLET# \r\n#BULLET#For our rules, please check our Terms of Service #LINK=HELP/TOS#here.#ENDLINK# #ENDBULLET# \r\n#ENDLIST#",
				"What_is_the_voting_system?" => "Here is how it works: #LIST# #BULLET#If someone submits a site, then that site is shown randomly, side-by-side with another site.#ENDBULLET# #BULLET#The site that the user picks to be better gets a vote.#ENDBULLET# #BULLET#Over the course of the day, the highest voted sites are shown more and more often.#ENDBULLET# #BULLET#At midnight, the vote counter resets, and all sites are once again shown equally.#ENDBULLET# #BULLET#The top voted sites of the previous day are shown full screen to all surfers and are hailed as winners.#ENDBULLET# #ENDLIST# This way, it does not matter how many referrals you have or how much money you spent. Your site is advertised based solely on how good it is. All you have to do is keep it active.",
				"What_does_it_mean_to_keep_my_site_active?" => "Keeping a website active means to have it be shown while users surf. It's very important to keep your sites active, otherwise they will not be shown at all. Think of it this way: an active website means that it will be advertised, while an inactive one is useless because it's never shown. As a free or premium member, to keep your website active, you have to view a certain number of websites per day. If you don't, your website will not be active the next day. As a platinum member, you don't have to do anything to keep your site active!",
			       	"Can_I_see_my_own_website_while_surfing?" => "Yes! In SurfDuel, you do not have to deal with credit nonsense, so your site is shown more the better it is. There is no harm in you seeing your own site.",
			        	"What_are_the_benefits_of_becoming_a_premium_member?" => "Well, among other things, it's much easier to keep your site active. In fact, as a platinum member, you don't have to do anything! There are also other benefits such as increased commission rates. To view this information in more detail, please visit this page #LINK=MEMBERSHIPS#here#ENDLINK#."
			)
		));

		DB::collection('settings')->insert(array(
			"_id" => "tos",
			"list" => array(
				"Disclaimer" => "SurfDuel displays content from many other websites, so please exercise caution when entering information in them. We cannot be held accountable for any content on these websites, or misuse of any information you have provided them.",
				"Spam" => "We do not condone spam of any form. If you have been found spamming, harassing, or mistreating other users (or anyone else) through your submitted website or by any other means, we reserve the right to cancel your account, and prevent the creation of another.",
				"Website_Content" => "Harassing other members or anyone else is strictly forbidden. If you have been found harassing other members in any way, including but not limited to offensive usernames and offensive or threatening websites, your account will be terminated.",
				"Website_Rules" => "#LIST#\r\n#BULLET#Your site must not contain popups.#ENDBULLET#\r\n#BULLET#Your site may not close the surf frame#ENDBULLET#\r\n#BULLET#Your site may not contain prompts or alerts or anything else that must be closed before surfing can continue#ENDBULLET#\r\n#BULLET#Your site must not attempt to automatically download files#ENDBULLET#\r\n#BULLET#Your site may not contain illegal content#ENDBULLET#\r\n#BULLET#Your site may not load banned or illegal websites in iframes#ENDBULLET#\r\n#BULLET#Sites can be removed for reasons not listed above#ENDBULLET#\r\n#ENDLIST#",
				"Account_Rules" => "#LIST#\r\n#BULLET#You may only have ONE account per person#ENDBULLET#\r\n#BULLET#You cannot login from two different computers at the same time#ENDBULLET#\r\n#BULLET#You may not use any programs, scripts, etc that will surf for you#ENDBULLET#\r\n#ENDLIST#",
				"Changing_Referrals" => "Deleting your account only to re-join again in an effort to change your referrer is not allowed. Asking members to delete their account and re-join under you is strictly forbidden.",
				"Upgraded_Accounts" => "You are responsible for cancelling your Paypal subscription should you be upgraded and no longer wish to be.",
				"Surfing_Rules" => "#LIST#\r\n#BULLET#Only you may surf for your account#ENDBULLET#\r\n#BULLET#You must surf with the site being displayed visible#ENDBULLET#\r\n#BULLET#You may not use any kind of software to surf for you#ENDBULLET#\r\n#ENDLIST#",
				"Newsletter" => "We have the right to send you occasional emails at the email you provided, unless you opt-out. The link to do so will be provided at the bottom of every newsletter we send.",
				"Failure_to_Follow" => "Failure to follow these terms will result in cancellation of your account. Your credits, subscription, etc. will be lost.",
				"Future_Changes" => "SurfDuel may change any of these rules at any time, with or without notification."
			)
		));
	}
}