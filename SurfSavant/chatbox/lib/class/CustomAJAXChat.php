<?php
/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

class CustomAJAXChat extends AJAXChat {

    
    function getTemplateFileName() {
        if(isset($_GET["small"])) $this->_view = 'small';
        switch($this->getView()) {
			case 'chat':
				return AJAX_CHAT_PATH.'lib/template/loggedIn.html';
			case 'logs':
				return AJAX_CHAT_PATH.'lib/template/logs.html';
			case 'small':
				return AJAX_CHAT_PATH.'lib/template/small.html';
			default:
				return AJAX_CHAT_PATH.'lib/template/loggedOut.html';
		}
	}
    
    function initCustomRequestVars() { 
        include '../cleanConfig.php';
        if($usr->loggedIn)
        {
            $this->setRequestVar('userName', $this->trimUserName($usr->data->fullName)); 
            $this->setRequestVar('userID', $usr->data->id); 
            $this->setRequestVar('login', true); 
        }
        else die("<body style='background:#fff;'><br><br><b><center><a target='_blank' href='http://surfsavant.com' style='color:#F90;text-decoration:none; '>You must be logged into<br>Surf Savant to chat.<br><br>Login Here!</a><br><br><br><a href='javascript:location.reload();' style='color:#F90;text-decoration:none; '>I'm done, let's chat!</a></center></b></body>");
    } 
     
    // Returns an associative array containing userName, userID and userRole 
    // Returns null if login is invalid 
    function getValidLoginUserData() { 
        if($this->getRequestVar('userName')) { 
            $userName = $this->getRequestVar('userName'); 
            $userName = $this->convertEncoding($userName, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding')); 
            $userData = array(); 
            $userData['userID'] = $this->getRequestVar('userID'); 
            $userData['userName'] = $userName; 
            $userData['userRole'] = AJAX_CHAT_USER; 
            
            if($userData['userID'] <= 3) $userData['userRole'] = AJAX_CHAT_ADMIN;
            
            return $userData; 
        }
        return null;
    }
    
	/*function getValidLoginUserData() {
		$userData = array();
        $userData['userID'] = "2";
        $userData['userName'] = $this->trimUserName("Daniel Heyman");
        $userData['userRole'] = "admin";
        return $userData;
        
		$customUsers = $this->getCustomUsers();
		
		if($this->getRequestVar('password')) {
			// Check if we have a valid registered user:

			$userName = $this->getRequestVar('userName');
			$userName = $this->convertEncoding($userName, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

			$password = $this->getRequestVar('password');
			$password = $this->convertEncoding($password, $this->getConfig('contentEncoding'), $this->getConfig('sourceEncoding'));

			foreach($customUsers as $key=>$value) {
				if(($value['userName'] == $userName) && ($value['password'] == $password)) {
					$userData = array();
					$userData['userID'] = $key;
					$userData['userName'] = $this->trimUserName($value['userName']);
					$userData['userRole'] = $value['userRole'];
					return $userData;
				}
			}
			
			return null;
		} else {
			// Guest users:
			return $this->getGuestUser();
		}
	}*/

	// Store the channels the current user has access to
	// Make sure channel names don't contain any whitespace
	function &getChannels() {
		if($this->_channels === null) {
			$this->_channels = array();
			
			$customUsers = $this->getCustomUsers();
			
			// Get the channels, the user has access to:
			if($this->getUserRole() == AJAX_CHAT_GUEST) {
				$validChannels = $customUsers[0]['channels'];
			} else {
				$validChannels = $customUsers[$this->getUserID()]['channels'];
			}
			
			// Add the valid channels to the channel list (the defaultChannelID is always valid):
			foreach($this->getAllChannels() as $key=>$value) {
				// Check if we have to limit the available channels:
				if($this->getConfig('limitChannelList') && !in_array($value, $this->getConfig('limitChannelList'))) {
					continue;
				}
				
				if(in_array($value, $validChannels) || $value == $this->getConfig('defaultChannelID')) {
					$this->_channels[$key] = $value;
				}
			}
		}
		return $this->_channels;
	}

	// Store all existing channels
	// Make sure channel names don't contain any whitespace
	function &getAllChannels() {
		if($this->_allChannels === null) {
			// Get all existing channels:
			$customChannels = $this->getCustomChannels();
			
			$defaultChannelFound = false;
			
			foreach($customChannels as $key=>$value) {
				$forumName = $this->trimChannelName($value);
				
				$this->_allChannels[$forumName] = $key;
				
				if($key == $this->getConfig('defaultChannelID')) {
					$defaultChannelFound = true;
				}
			}
			
			if(!$defaultChannelFound) {
				// Add the default channel as first array element to the channel list:
				$this->_allChannels = array_merge(
					array(
						$this->trimChannelName($this->getConfig('defaultChannelName'))=>$this->getConfig('defaultChannelID')
					),
					$this->_allChannels
				);
			}
		}
		return $this->_allChannels;
	}

	function &getCustomUsers() {
		// List containing the registered chat users:
		$users = null;
		require(AJAX_CHAT_PATH.'lib/data/users.php');
		return $users;
	}
	
	function &getCustomChannels() {
		// List containing the custom channels:
		$channels = null;
		require(AJAX_CHAT_PATH.'lib/data/channels.php');
		return $channels;
	}

}
?>