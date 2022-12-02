<?php include 'header.php'?>

<title>Profile Management</title>

<body>
  <form>
    <label>Profile Management</label>
      <div class="profile_form">

        <hr>

         <input type="text" placeholder="Enter Username..." name="username" id="username" maxlength="50" autocomplete="name" required>
         <div class="alert_name_fault"></div>


         <input type="password" placeholder="Enter Old password..." name="old_pswd" id="old_pswd" maxlength="1024" autocomplete="off" required>
         <div class="alert_old_pswd_fault"></div>


         <input type="password" placeholder="Enter Password..." name="pswd" id="pswd" maxlength="1024" autocomplete="off" required>
         <div class="alert_pswd_fault"></div>


         <input type="password" placeholder="Reapeat Password..." name="pswd_repeat" id="pswd_repeat" maxlength="1024" autocomplete="off" required>
         <div class="alert_repeat_pswd_fault"></div>

         <hr>

         <button type="button" onclick = "change()">Submit</button>
      </div>
  </form>
</body>

<script>

  function change(){

    //RegExp
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,1024}$/;

    //dom of the inputs
    const input_username = document.querySelector('#username');
    const input_old_pswd = document.querySelector('#old_pswd');
    const input_pswd = document.querySelector('#pswd');
    const input_pswd_repeat = document.querySelector('#pswd_repeat');

    //dom of div below the inputs
    var div_below_username = document.getElementsByClassName('alert_name_fault');
    var div_below_old_pswd = document.getElementsByClassName('alert_old_pswd_fault');
    var div_below_pswd = document.getElementsByClassName('alert_pswd_fault');
    var div_below_repeat_pswd = document.getElementsByClassName('alert_repeat_pswd_fault');

    console.log(div_below_repeat_pswd);

    //empty the mistakes after each click
    $('.alert_name_fault').empty();
    $('.alert_old_pswd_fault').empty();
    $('.alert_pswd_fault').empty();
    $('.alert_pswd_repeat_fault').empty();

    if(input_username.value === "" && div_below_username[0].children.length === 0){
      var user_fault_username = document.createElement("div");
      var node_username = document.createTextNode("Enter your new username!");
      user_fault_username.className = "a_alert_content_pm";
      user_fault_username.appendChild(node_username);
      div_below_username[0].appendChild(user_fault_username);
    }

    if(input_old_pswd.value === "" && div_below_old_pswd[0].children.length === 0){

      var user_fault_old_pswd = document.createElement("div");
      var node_old_pswd = document.createTextNode("Enter your old password!");
      user_fault_old_pswd.className = "a_alert_content_pm";
      user_fault_old_pswd.appendChild(node_old_pswd);
      div_below_old_pswd[0].appendChild(user_fault_old_pswd);

    }else if(input_pswd.value === "" && div_below_pswd[0].children.length === 0){

      var user_fault_pswd = document.createElement("div");
      var node_pswd = document.createTextNode("Enter your password");
      user_fault_pswd.className = "a_alert_content_pm";
      user_fault_pswd.appendChild(node_pswd);
      div_below_pswd[0].appendChild(user_fault_pswd);

    }else if(input_pswd_repeat.value === "" && div_below_repeat_pswd[0].children.length === 0){

      var user_fault_pswd_repeat = document.createElement("div");
      var node_pswd_repeat = document.createTextNode("Type your password again");
      user_fault_pswd_repeat.className = "a_alert_content_pm";
      user_fault_pswd_repeat.appendChild(node_pswd_repeat);
      div_below_repeat_pswd[0].appendChild(user_fault_pswd_repeat);

    }else if(input_pswd.value !== input_pswd_repeat.value){

      var user_fault_wrong_pswd = document.createElement("div");
      var node_wrong_pswd = document.createTextNode("Passwords must match");
      user_fault_wrong_pswd.className = "a_alert_content";
      user_fault_wrong_pswd.appendChild(node_wrong_pswd);
      div_below_repeat_pswd[0].appendChild(user_fault_wrong_pswd);

    }else if(regex.test(input_pswd.value) === false){

      var user_fault_check_failed = document.createElement("div");
      var node_check_failed = document.createTextNode("Passwords must be at least 8 characters and contain 1 capital letter, 1 minor letter, 1 number and 1 special character");
      user_fault_check_failed.className = "a_alert_content";
      user_fault_check_failed.appendChild(node_check_failed);
      div_below_pswd[0].appendChild(user_fault_check_failed);

    }else if(regex.test(input_pswd.value) === true){

      let username = input_username.value;
      let old_pass = input_old_pswd.value;
      let pass = input_pswd.value;

      $.ajax({
        url:"Profile_Management_backend.php",
        type:"POST",
        dataType: "text",
        data:{
          username: username,
          password: pass,
          old_password: old_pass
        },
        success: function(responseText){

          console.log(responseText);

          if(responseText == 1){

            Swal.fire({
              titleText:'Congratulations!',
              text:'You have changed your username and password successfully!',
              showConfirmButton:false,
              timer:2000
            }).then(function(){
              window.location.reload();
            });

          }else if(responseText == 2){

            Swal.fire({
              titleText:"Wrong password!",
              text:"The old password you've entered is incorrect.",
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'OK, got it',
              allowEnterKey: false,
              allowEscapeKey: false
            });

          }else if(responseText == 3){

            Swal.fire({
              titleText:"Alert",
              text:"You've typed a username of another user. Please change that!",
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'OK, got it',
              allowEnterKey: false,
              allowEscapeKey: false
            });

          }else if(responseText == 4){

            Swal.fire({
              titleText:'Congratulations!',
              text:'You have changed your password successfully!',
              showConfirmButton:false,
              timer:2000
            }).then(function(){
              window.location.reload();
            });

          }

        }
      });

    }

    input_username.addEventListener('input',function(e){
      if(e.target.value!=="" && div_below_username[0].children.length>0){
        $('.alert_name_fault').empty();
      }
    });

    input_old_pswd.addEventListener('input',function(e){
      if(e.target.value!=="" && div_below_old_pswd[0].children.length>0){
        $('.alert_old_pswd_fault').empty();
      }
    });

    input_pswd.addEventListener('input',function(e){
      if(e.target.value!=="" && div_below_pswd[0].children.length>0){
        $('.alert_pswd_fault').empty();
      }
    });

    input_pswd_repeat.addEventListener('input',function(e){
      if(e.target.value!=="" && div_below_repeat_pswd[0].children.length>0){
        $('.alert_repeat_pswd_fault').empty();
      }
    });
  }
</script>
