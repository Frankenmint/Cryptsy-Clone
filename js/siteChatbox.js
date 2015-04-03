$(document).ready(function(){
    var cryptosock = "ws://192.99.7.87:9000/chat/server.php";
    var username = $('#pseudo').text();

    // connexion au websocket
    websocket = new WebSocket(cryptosock); 
    websocket.onopen = function(ev) { 
      //Ouverture du socket
      box = $("#chat_div").chatbox({id:"chat_div", 
        user: username,
        title : "Chatbox",
        messageSent : function(id, user, msg) {
             //prepare json data
             var msg = {
              message: msg,
              name: user,
              color : 'blue'
            };
          //convert and send data to server
          websocket.send(JSON.stringify(msg));
        }});

      //Charge le chat depuis 5mn
      <?php 
        $chat = BaseDonne::execQuery($bdd, "SELECT * FROM Chat");
        echo "var a =".json_encode($chat);
      ?>
      //Ferme l'onglet du chat
     $( "div .ui-widget-header" ).trigger( "click" );

    }

    websocket.onmessage = function(ev){
      var msg = JSON.parse(ev.data); //PHP sends Json data
      var type = msg.type; //message type
      var umsg = msg.message; //message text
      var uname = msg.name; //user name
      var ucolor = msg.color; //color

      if(type == 'usermsg') {
        $("#chat_div").chatbox("option", "boxManager").addMsg(uname, umsg);
      }else{
        $("#chat_div").chatbox("option", "boxManager").addMsg("system", umsg);
      }
    }
  });