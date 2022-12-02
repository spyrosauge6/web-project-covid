<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/Login.css">
<script src="external_code/jquery.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div id="id01" class="modal">



    <div class="container">
      <div class="signup">
      <form>
        <label for="chk" aria-hidden="true">Login</label>

        <input type="text" placeholder="Enter Username..." name="uname" id="uname" class="a_input_text" maxlength="128" required>
        <div class="not_found"></div>

        <input type="password" placeholder="Enter Password..." name="pswd" id="pswd" class="a_input_pswd" maxlength="1024" required>

        <button type="button" onclick="Login()">Login</button>
      </div>
    </div>

    <div class="login">

      <label for="chk" class="psw"><a href="Registration_form.php">Not a user?</a></label>

     </div>
   </form>
 </div>
</body>
<script type="text/javascript">
//check login of fb

function Login(){

  //dom of the inputs
  const input_username = document.querySelector("#uname");
  const input_pswd = document.querySelector('#pswd');

  //dom of div below the username
  var div_below_username = document.getElementsByClassName('not_found');

  //empty the mistakes if there are any
  $('.not_found').empty();

  $.ajax({

    url:"Login_backend.php",
    type:"POST",
    data:{username:input_username.value, password:input_pswd.value},
    success:function(response){
      console.log(response);
      if(response == 0){

        Swal.fire({
          text:"You are logged in",
          showConfirmButton:false,
          timer: 1000
        }).then(function(){
          window.location.assign("Welcome_page.php");
        });

      }else if(response == 1){

        Swal.fire({
          text:"Welcome admin",
          showConfirmButton:false,
          timer: 1000
        }).then(function(){
          window.location.assign("Welcome_page_admin.php");
        });

      }else if(response == 2){

        //content of alert
        const link = document.createElement('div');
        link.innerHTML = "<a href='Registration_form.php'>Not a user?</a>";

        Swal.fire({
          title:"The password you’ve entered is incorrect.",
          html: link,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'OK, got it',
        }).then(function(){
          $('.not_found').empty();
          var user_not_found = document.createElement("div");
          var node_not_found = document.createTextNode("The password you’ve entered is incorrect.");
          user_not_found.className = "not_found_msg";
          user_not_found.appendChild(node_not_found);
          div_below_username[0].appendChild(user_not_found);
        });

      }else if(response == 3){

        //content of alert
        const link = document.createElement('div');
        link.innerHTML = "<a href='Registration_form.php'>Not You?</a>";

        Swal.fire({
          title:"Is this your account?",
          html:link,
          text:"We couldn't find an account that matches what you entered",
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, continue'
        }).then(function(){
          $('.not_found').empty();
          var user_not_found = document.createElement("div");
          var node_not_found = document.createTextNode("The username you entered isn’t connected to an account.");
          user_not_found.className = "not_found_msg";
          user_not_found.appendChild(node_not_found);
          div_below_username[0].appendChild(user_not_found);
        });

      }
    }

  })
}

</script>
</html>
