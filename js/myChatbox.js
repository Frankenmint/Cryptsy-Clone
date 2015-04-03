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
            //Si le message est plus long que 140 caractere, on ne fait rien
            if(msg.length > 140) return false;
             //prepare json data
             var msg = {
              message: msg,
              name: user,
              color : 'blue'
            };
          //convert and send data to server
          websocket.send(JSON.stringify(msg));
        }});

      //Charge les 20 derniers messages
      $.ajax({                                      
      url: '../chat/getChatData.php',                  //the script to call to get data          
      data: { usr : username },                        //you can insert url argumnets here to pass to api.php
      dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
        for (var i = data.length-1; i >= 0; i--) {
         var obj = data[i];
         $("#chat_div").chatbox("option", "boxManager").addMsg(obj.Username, obj.Message);
      }
    } 
  });
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