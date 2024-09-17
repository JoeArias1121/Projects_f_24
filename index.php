<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>FlowWork >> - Log In</title>

  <!-- w3.css framework used for the styling of our application-->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- font used in the template -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <!--font awesome js -->
  <script defer src="../js/solid.js"></script>
  <script defer src="../js/fontawesome.js"></script>
</head>

<style>
  html,
  body,
  h1,
  h2,
  h3,
  h4,
  h5 {
    font-family: "Raleway", sans-serif
  }

  body,
  html {
    height: 100%;
    margin: 0;
  }

  .bgimg-1,
  .bgimg-1small,
  .bgimg-2,
  .bgimg-3 {
    position: relative;
    opacity: 0.65;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;

  }

  .bgimg-1 {
    background-image: url("./client/assets/honeycomb.png");
    min-height: 100%;
  }
/* 
  .bgimg-1small { 
    background-image: url("./client/assets/honeycomb.jpg");
    min-height: 25%;
  } */

  .bgimg-2 {
    background-image: url("./client/assets/analysis1.jpg");
    min-height: 500px;
  }

  .bgimg-3 {
    background-image: url("./client/assets/presentation.jpg");
    min-height: 500px;
  }

  .caption {
    position: absolute;
    left: 0;
    top: 10%;
    width: 100%;
    text-align: center;
    color: #000;
  }

  .caption span.border {
    background-color: #111;
    color: #fff;
    padding: 18px;
    font-size: 25px;
    letter-spacing: 10px;
  }
  h1 {
    font-weight: 900;
  }
  h3 {
    letter-spacing: 5px;
    text-transform: uppercase;
    font: 20px "Lato", sans-serif;
    color: #111;
  }

  .forgot {
    position: absolute;
    margin-left: 250px;
    margin-top: 10px;

  }

  .input {
    width: 100%;
    margin-bottom: 10px;
  }

  /*   .icon {
    text-align: left;
    width: 1em;
    height: 1em;
    position: absolute;
    margin-top: 13px;
    margin-left: 10px;
    opacity: 0.5;
  }
 */
  .input-field {
    width: 100%;
    padding: 10px;
    text-indent: 30px;
  }

  body,
  html {
    height: 100%;
  }

  .parallax {

    background-image: url("./client/assets/honeycomb.png");


    height: 100%;

    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  /* Turn off parallax scrolling for tablets and phones */
  @media only screen and (max-device-width: 1024px) {

    .bgimg-1,
    .bgimg-1small,
    .bgimg-2,
    .bgimg-3 {
      background-attachment: scroll;
    }
  }

  #grad1 {
  height: 5px;
  background-color: #808080; /* For browsers that do not support gradients */
}
#grad2 {
  height: 5px;
  background-color: #808080; /* For browsers that do not support gradients */
}

.herotext {
  font-weight: bold;
  padding-top: 150px;
}

.beeicon {
  display:block;
  margin-left:auto;
  margin-right:auto;
  padding-top: 300px;
}

.extrapadding {
  margin-top: 78px;
}
</style>

<body>
  <div class="w3-bar">
    <div class="w3-container w3-col" style="width:20%"><a href="" style="text-decoration:none">
        <h2 style="margin-left:20px"><strong>FlowWork</strong></h2>
      </a>
    </div>
    <div class="w3-container w3-col" style="width:65%"></div>
    <div class="w3-container w3-col" style="width:15%; margin-top:20px"><button class="w3-btn w3-ripple w3-round-large" onclick="window.location.href='./client/views/login.php'" style="background-color:#00b044; color:white; margin-bottom: 5px; margin-right: 5px">Login</button><button class="w3-btn w3-ripple w3-round-large" onclick="window.location.href='client/views/signup.php'" style="background-color:#2166c5; color:white; margin-bottom: 5px">Sign Up</button>
    </div>
  </div>
  <div class="w3-bar">
  <div id="grad1" class=" w3-col" style="width:50%"></div><div class=" w3-col" id="grad2" style="width:50%"></div>
  </div>

  <div class="parallax">
      <div class="caption extrapadding">
        <span class="border herotext" font-family="Raleway" style="font-size:25px;color: #ffffff;">ALL-PURPOSE WORKFLOW MANAGEMENT SYSTEM</span>
    </div>
    <!-- <img class="beeicon" src=./client/assets/Bee-icon.png /> -->
</div>

    <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
      <h3 style="text-align:center;">Collaborate on the go</h3>
      <p><strong>Keep your team connected from anywhere.</strong> FlowWork is a powerful Collaborative Online System that allows users to create jobs from scratch or templates, track their time and efficiency in given tasks, and reach relevant peers seamlessly from wherever the team members might be. Update your team as new developments occur in real time, add documentation to a task to keep everything in one place, and share metrics that your group can use to increase productivity.<br><br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <h5 style="text-align:center;">Inspire efficiency with FlowWork today.</h5>
    </div>

    <div class="bgimg-2">
      <div class="caption">
        <span class="border" style="font-size:25px;color: #f7f7f7;">TRACK TASK TIME</span>
      </div>
    </div>

    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
        <p>Vestibulum sed arcu non odio euismod lacinia at quis risus. A scelerisque purus semper eget duis at tellus at urna. At tellus at urna condimentum mattis pellentesque id nibh. Euismod elementum nisi quis eleifend quam adipiscing vitae. Urna duis convallis convallis tellus id interdum velit laoreet. Egestas quis ipsum suspendisse ultrices gravida. Interdum posuere lorem ipsum dolor sit amet consectetur. Nunc sed augue lacus viverra vitae congue eu consequat ac. Condimentum lacinia quis vel eros. Fringilla est ullamcorper eget nulla facilisi etiam. Turpis egestas sed tempus urna et pharetra pharetra massa. Suspendisse interdum consectetur libero id faucibus nisl tincidunt eget nullam. Id porta nibh venenatis cras sed felis. Euismod nisi porta lorem mollis aliquam ut porttitor leo a. Nec feugiat nisl pretium fusce id velit ut. Placerat duis ultricies lacus sed turpis. Arcu cursus euismod quis viverra nibh. Sed turpis tincidunt id aliquet. Pretium fusce id velit ut tortor. Fames ac turpis egestas integer eget aliquet nibh praesent tristique.

          Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Sagittis purus sit amet volutpat consequat mauris nunc congue nisi. Diam sit amet nisl suscipit adipiscing bibendum est. Egestas purus viverra accumsan in. Purus in massa tempor nec feugiat nisl pretium fusce id. Faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam. Urna id volutpat lacus laoreet non. Ipsum nunc aliquet bibendum enim facilisis gravida. At augue eget arcu dictum varius duis. Dolor sit amet consectetur adipiscing elit pellentesque habitant. Vitae auctor eu augue ut lectus arcu bibendum at varius. Porttitor lacus luctus accumsan tortor posuere ac ut consequat. Massa massa ultricies mi quis hendrerit dolor magna.</p>
      </div>
    </div>

    <div class="bgimg-3">
      <div class="caption">
        <span class="border" style="font-size:25px;color: #f7f7f7;">MEET FROM ANYWHERE</span>
      </div>
    </div>

    <div style="position:relative;">
      <div style="color:#ddd;background-color:#282E34;text-align:center;padding:50px 80px;text-align: justify;">
        <p>Sit amet volutpat consequat mauris nunc congue. Posuere sollicitudin aliquam ultrices sagittis orci a. Sed sed risus pretium quam. Scelerisque in dictum non consectetur a erat nam at. Mi proin sed libero enim sed faucibus turpis in. Duis ultricies lacus sed turpis tincidunt. Accumsan in nisl nisi scelerisque. Egestas quis ipsum suspendisse ultrices gravida dictum fusce. Quis ipsum suspendisse ultrices gravida dictum fusce ut. Amet luctus venenatis lectus magna fringilla urna porttitor. Ut diam quam nulla porttitor massa id. Quis ipsum suspendisse ultrices gravida dictum fusce ut. Vulputate sapien nec sagittis aliquam malesuada bibendum arcu vitae. Laoreet id donec ultrices tincidunt arcu non sodales neque sodales.</p>
      </div>
    </div>

    <div class="bgimg-1small">
    </div>

  </div>
</body>

</html>