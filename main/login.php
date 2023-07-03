<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link href="../css/bootstrap.css" rel="stylesheet" />
  <!-- <link href="../css/background.css" rel="stylesheet" /> -->
  <link href="../css/login.css" rel="stylesheet" />
  <link href="../images/icon1.png" rel="icon" />
</head>

<body style="background-color:white;">
  <div class="container-fluid" style="margin-top:-40px;">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <!-- form -->
          <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 bg-white rounded text-center shadow-lg" style="height:auto; margin-top: 10%;padding:40px;">
            <!-- input fields -->
            <div style="margin-top:100px;">
              <img src="../images/icon1.png" style="width:100px;margin-top:-50px;" />
              <h3 class="heading fw-bolder mt-3">LOGIN TO DASHBOARD</h3>
              <label for="inp" class="inp">
                <input type="text" id="uname" placeholder="&nbsp;">
                <span class="label">ENTER USERNAME</span>
                <span class="focus-bg"></span>
              </label>
              <br />
              <label for="inp" class="inp">
                <input type="password" id="password" placeholder="&nbsp;">
                <span class="label">ENTER PASSWORD</span>
                <span class="focus-bg"></span>
              </label>
            </div>
            <!-- input fields -->
            <div class="mt-0">
              <button class="formBtn loginBtn" style="width:180px;height:50px;" onclick="login();">LOGIN</button>
              <button class="formBtn adminBtn" style="width:180px;height:50px;">ADMIN</button>
            </div>
          </div>
          <!-- form -->
        </div>
      </div>
    </div>
    <script src="../main/script.js"></script>
</body>

</html>