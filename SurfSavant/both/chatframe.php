<?php
if($usr->loggedIn)
{
    ?>
    <!doctype html>
    <html>
    <head>
          <meta charset="utf-8" />
          <script src="https://cdn.firebase.com/v0/firebase.js"></script>
          <script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
          <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        
          <link rel="stylesheet" href="both/chat/firechat-default.min.css" />
          <script src="both/chat/firechat-default.min.js"></script>
          <style>
            
            body
              {
                color: #2f3840;   
              }
            
            #firechat-wrapper {
              padding: 0px;
              background-color: #fff;
              text-align: center;
            }
              
            #firechat .dropdown-footer {
                display:none;   
              }
              
              #firechat-header
              {
                display:none;   
              }
              
              #firechat .btn
              {
                background:#EBEBEB;   
              }
              
              #firechat .tab-pane-menu
              {
                padding:10px;   
              }
              
              #firechat .tab-pane-menu .dropdown:nth-child(1) {
                margin-right:3%;
              }
              
              #firechat .twofifth {
                width:44%;   
              }
              
              #firechat .icon.close
              {
                margin-right:2%;
                  margin-top:12px;
              }
              
              #firechat .tab-pane-menu {
                background: #efefef; 
                  -webkit-border-top-right-radius: 3px;
                    -moz-border-top-right-radius: 3px;
                    border-top-right-radius: 3px;  
              }
              
              #firechat .nav-tabs>.active>a, #firechat .nav-tabs>.active>a:hover, #firechat .nav-tabs>.active>a:focus {
                background: #efefef;     
              }
              
              #firechat input, #firechat textarea {
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px; 
                margin-top:10px;
              }
              
              #firechat .chat {
                  -webkit-border-bottom-right-radius: 3px;
                    -moz-border-bottom-right-radius: 3px;
                    border-bottom-right-radius: 3px; 
                  -webkit-border-bottom-left-radius: 3px;
                    -moz-border-bottom-left-radius: 3px;
                    border-bottom-left-radius: 3px; 
                    margin-bottom:10px;
                <?php if(isset($_GET['height'])) { $height = $_GET['height'] - 190; echo "height: {$height}px"; } ?>
              }
              
              strong[title="Daniel Heyman"], strong[title="Matt Baker"], strong[title="Yogesh Dhamija"]{
                color:#F90;   
              }
          </style>
    </head>
    
        
    <body>
      <div id="firechat-wrapper"></div>
      <script type='text/javascript'>
        var chatRef = new Firebase('https://techdime.firebaseio.com');
        var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));
        var simpleLogin = new FirebaseSimpleLogin(chatRef, function(err, user) {
          if (user) {
            chat.setUser(user.id, '<?=$usr->data->fullName?>');
            setTimeout(function() {
              chat._chat.enterRoom('-JCDgqh3dMqFQummVcfJ');
            }, 500);
          } else {
            simpleLogin.login('anonymous');    
          }
        });
      </script>
    </body>
    </html>
    <?php
}
else echo "<center><a href='{$site['url']}'>You must login to Surf Savant to access the chat</a></center>";
?>