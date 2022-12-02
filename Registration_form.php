<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/Registration.css">
<script src="external_code/jquery.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<body>
  <form>
    <div class="container">
      <label>Sign up</label>
      <div class="fill"><p>Please fill in this form to create an account.</p></div>
      <hr>


      <input type="text" placeholder="Enter Username..." name="username" id="username" maxlength="50" autocomplete="name" required>
      <div class="alert_name"></div>


      <input type="text" placeholder="Enter Email..." name="email" id="email" maxlength="64" autocomplete="email" required>
      <div class="alert_email"></div>


      <input type="password" placeholder="Enter Password..." name="pswd" id="pswd" maxlength="1024" autocomplete="off" required>
      <div class="alert_pswd"></div>


      <input type="password" placeholder="Reapeat Password..." name="pswd_repeat" id="pswd_repeat" maxlength="1024" autocomplete="off" required>
      <div class="alert_pswd_repeat"></div>

      <hr>
      <p>By creating an account you automaticaly agree to our <a href='Terms.php'>Terms & Privacy</a>.</p>

      <button type="button" class="registerbtn" onclick="Registration()">Register</button>

      <p>Already have an account? <a href="Login_form.php">Sign in</a>.</p>

      </div>

  </form>

</body>
<script type="text/javascript">
//regex taken from https://stackoverflow.com/a/21456918/14749665


function Registration(){

  var container = document.getElementsByClassName('container');

  //RegExp
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,1024}$/;


  //dom of the inputs
  const input_username = document.querySelector("#username");
  const input_email = document.querySelector('#email');
  const input_pswd = document.querySelector('#pswd');
  const input_pswd_repeat = document.querySelector('#pswd_repeat');

  //dom of div below the inputs
  var div_below_username = document.getElementsByClassName('alert_name');
  var div_below_email = document.getElementsByClassName('alert_email');
  var div_below_pswd = document.getElementsByClassName('alert_pswd');
  var div_below_pswd_repeat = document.getElementsByClassName('alert_pswd_repeat');

  //empty the mistakes after each click
  $('.alert_name').empty();
  $('.alert_email').empty();
  $('.alert_pswd').empty();
  $('.alert_pswd_repeat').empty();



  //check username value
  if(input_username.value === "" && div_below_username[0].children.length === 0){
    var user_fault_username = document.createElement("div");
    var node_username = document.createTextNode("Enter your name");
    user_fault_username.className = "a_alert_content";
    user_fault_username.appendChild(node_username);
    div_below_username[0].appendChild(user_fault_username);
  }

  //check email value
  if(input_email.value === "" && div_below_email[0].children.length === 0){
    var user_fault_email = document.createElement("div");
    var node_email = document.createTextNode("Enter your email");
    user_fault_email.className = "a_alert_content";
    user_fault_email.appendChild(node_email);
    div_below_email[0].appendChild(user_fault_email);
  }

  //check password value
  if(input_pswd.value === "" && div_below_pswd[0].children.length === 0){
    var user_fault_pswd = document.createElement("div");
    var node_pswd = document.createTextNode("Enter your password");
    user_fault_pswd.className = "a_alert_content";
    user_fault_pswd.appendChild(node_pswd);
    div_below_pswd[0].appendChild(user_fault_pswd);
  }else if(input_pswd_repeat.value === "" && div_below_pswd_repeat[0].children.length === 0){//check password repeat value
    var user_fault_pswd_repeat = document.createElement("div");
    var node_pswd_repeat = document.createTextNode("Type your password again");
    user_fault_pswd_repeat.className = "a_alert_content";
    user_fault_pswd_repeat.appendChild(node_pswd_repeat);
    div_below_pswd_repeat[0].appendChild(user_fault_pswd_repeat);
  }else if(input_pswd.value!==input_pswd_repeat.value){
    var user_fault_wrong_pswd = document.createElement("div");
    var node_wrong_pswd = document.createTextNode("Passwords must match");
    user_fault_wrong_pswd.className = "a_alert_content";
    user_fault_wrong_pswd.appendChild(node_wrong_pswd);
    div_below_pswd_repeat[0].appendChild(user_fault_wrong_pswd);
  }else if(regex.test(input_pswd.value) === false){//regex demands one upper letter, one lower letter, one special character, one number and at string length between 8 and 1024
    var user_fault_check_failed = document.createElement("div");
    var node_check_failed = document.createTextNode("Passwords must be at least 8 characters and contain 1 capital letter, 1 minor letter, 1 number and 1 special character");
    user_fault_check_failed.className = "a_alert_content";
    user_fault_check_failed.appendChild(node_check_failed);
    div_below_pswd[0].appendChild(user_fault_check_failed);
  }else if(regex.test(input_pswd.value) === true){
    let username = input_username.value;
    let email = input_email.value;
    let password = input_pswd.value;

    const ajax_query = $.ajax({
      url:"Register_backend.php",
      type:"POST",
      dataType:"text",
      data:{username:username, password:password, email:email},
      success:function(response){
        console.log(response);
        if(response == 0){
          Swal.fire({
            text:"You have just registered to our app. Welcome!",
            allowEscapeKey:false,
            allowEnterKey:false,
            confirmButtonColor:"#000000"//"#4267B2"
          }).then(function(){
            window.location.assign("Login_form.php");
          });
        }else if(response == 1){
          Swal.fire({
            text:"There is already a user with that email or username!",
            allowEscapeKey:false,
            allowEnterKey:false,
            confirmButtonText:"OK,got it",
            confirmButtonColor:"#000000"//"#4267B2"
          }).then(function(){
            window.location.reload();
          });
        }
      }
    })

  }

  //remove user fault in username
  input_username.addEventListener('input',function(e){
    if(e.target.value!=="" && div_below_username[0].children.length>0){
      $('.alert_name').empty();
    }
  });

  //remove user fault in email
  input_email.addEventListener('input', function(e){
    if(e.target.value!=="" && div_below_email[0].children.length>0){
      $('.alert_email').empty();
    }
  });

  //remove user fault in password
  input_pswd.addEventListener('input', function(e){
    if(e.target.value!=="" && div_below_pswd[0].children.length>0){
      $('.alert_pswd').empty();
    }
  });

  //remove user fault in password repeat
  input_pswd_repeat.addEventListener('input', function(e){
    if(e.target.value!=="" && div_below_pswd_repeat[0].children.length>0){
      $('.alert_pswd_repeat').empty()
      //document.getElementsByClassName('alert_pswd_repeat')[0].removeChild(user_fault_pswd_repeat); Giati otan ebaza auto ebgaze error?
    }
  });


}

</script>
</html>
