
<!-- This is online web chatting application  -->



<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js";

  // include firebase database
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.10/firebase-database.js";

  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "AIzaSyCGUBnCxO95W95Lliiatm4Fk28PoZJ2kqU",
    authDomain: "my-chatting-application-c54fe.firebaseapp.com",
    projectId: "my-chatting-application-c54fe",
    storageBucket: "my-chatting-application-c54fe.appspot.com",
    messagingSenderId: "466407608035",
    appId: "1:466407608035:web:e3f9bcd8aca0b3084abfd6"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);

  var myName = prompt("Enter your name");
  
  function sendMessage() {
    //get message
    var message = document.getElementById("message").value;

    //save in database
    firebase.database().ref("message").push().set({
      "sender": myName, 
      "message": message
    });

    
    //pervent form from submitting
    return false;
  }

  // listen for incoming message
  firebase.database().ref("messages").on("child_added", function (snapshot){
    var html = "";
    // give each message a unique ID
    html += "<li id='message-" + snapshot.key +"'>";
      // show delete button if message is sent by me
      if (snapshot.val().sender == myName) {
        html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>";
          html += "Delete";
        html += "</button>";
      }
      html += snapshot.val().sender + ": " + snapshot.val().message;
    html += "</li>";

    document.getElementById("messages").innerHTML += html;

  });

  function deleteMessage(self) {
    // get message ID
    var messageId = self.getAttribute("data-id");

    // delete message
    firebase.database().ref("messages").child(messageId).remove();
  }

  //attach listener for delete message
  firebase.database().ref("messages").on("child_removed", function (snapshot){
    // remove message node 
    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
  });

</script>

// Create a form to send message

<form onsubmit="return sendMessage();">
  <input id="message" placeholder="Enter message" autocomplete="off">

  <input type="submit">


</form>


// create a list
<ul id="messages"></ul>