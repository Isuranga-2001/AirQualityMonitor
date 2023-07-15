<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link href="../css/bootstrap.css" rel="stylesheet" />
  <!-- <link href="../css/background.css" rel="stylesheet" /> -->
  <link href="../css/login.css" rel="stylesheet" />
  <link href="../images/icon2.png" rel="icon" />
  <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
      import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
      import { getDatabase, ref, child, get } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-database.js";

      console.log('running');
        
      const firebaseConfig = {
        apiKey: "AIzaSyCZV35Sd2Qo14fz3XORPncs7TudDTVRFLk",
        authDomain: "airqualitymonitoringsyst-87ae7.firebaseapp.com",
        databaseURL: "https://airqualitymonitoringsyst-87ae7-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "airqualitymonitoringsyst-87ae7",
        storageBucket: "airqualitymonitoringsyst-87ae7.appspot.com",
        messagingSenderId: "451013569860",
        appId: "1:451013569860:web:bf8e9bc4946c3b13f3bb11",
        measurementId: "G-NBW598T1DB"
      };

      const app = initializeApp(firebaseConfig);
      const analytics = getAnalytics(app);

      const dbRef = ref(getDatabase());

      btnlogin.addEventListener('click', (e) => {
        var uname = document.getElementById("uname").value;
        var pwd = document.getElementById("password").value;

        get(child(dbRef, uname + "/Password")).then((snapshot) => {
          if (snapshot.exists()) {
            if (snapshot.val() == pwd){
              localStorage.setItem("username", uname);
              localStorage.setItem("password", pwd);
              window.location.href = "home.php";
            }
            else{
              alert("Invalid Password");
            }
          } else {
            alert("Invalid Username");
          }
        }).catch((error) => {
          alert(error);
        });
      });
  </script>
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
              <button class="formBtn loginBtn" style="width:180px;height:50px;" onclick="login();" id="btnlogin">LOGIN</button>
              <button class="formBtn adminBtn" style="width:180px;height:50px;">SIGN UP</button>
            </div>
          </div>
          <!-- form -->
        </div>
      </div>
    </div>
    <script src="../main/script.js"></script>
</body>

</html>