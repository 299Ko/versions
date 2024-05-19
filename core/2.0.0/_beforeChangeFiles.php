<?php

logg("Began of _beforeChangeFiles", "INFO");

logg("End of _beforeChangeFiles", "INFO");

$version = "2.0.0";

$url = util::urlBuild("", true);

echo <<<EOF
<div class="container">
    <div class="area">
        <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
        </ul>
    </div>
    <div class="center">
        <div class="circle">
            <svg width="300" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(110,110)">
                <circle r="100" class="e-c-base" />
                <g transform="rotate(-90)">
                    <circle r="100" class="e-c-progress" />
                    <g id="e-pointer">
                    <circle cx="100" cy="0" r="8" class="e-c-pointer" />
                    </g>
                </g>
                </g>
            </svg>
        </div>
    <div class="controlls">
        <div class="display-remain-time">10:00</div>
    </div>
    <div class="upd">
        <h1>Version $version</h1>
        <p>
        The update is in progress. Once the countdown reaches 0, a link will appear to redirect you to your site administration.
        </p>
        <p id="upd-p-hidden"><a href="{$url}">Click here to join your site administration</a></p>
    </div>
    </div>
</div>
<style>
#upd-p-hidden {display:none;}
.container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    --font-family: system-ui, -apple-system, "Segoe UI", "Roboto", "Ubuntu",
      "Cantarell", "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
      "Segoe UI Symbol", "Noto Color Emoji";
  }
  .display-remain-time {
    font-weight: 600;
    font-size: 65px;
    color: #fff;
  }
  
  .e-c-progress {
    fill: none;
    stroke: #de2d4a;
    stroke-width: 4px;
    transition: stroke-dashoffset 0.7s;
  }
  .e-c-pointer {
    fill: #fff;
    stroke: #de2d4a;
    stroke-width: 2px;
  }
  #e-pointer {
    transition: transform 0.7s;
  }
  .e-c-base {
    fill: none;
    stroke: #b6b6b6;
    stroke-width: 4px;
  }
  .controlls {
    position: absolute;
    left: 50%;
    top: 155px;
    text-align: center;
    margin-left: -75px;
  }
  .center {
    position: absolute;
    text-align: center;
    left: 50%;
    top: 50%;
    transform: translateY(-50%) translateX(-50%);
    max-width: 1024px;
    padding: 40px;
    border-radius: 15px;
  }
  .upd {
    font-size: 22px;
    color: #fff;
  }

  .area{
    background: #457b9d;  
    width: 100%;
    height:100vh;
}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    margin: 0;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
    
}

.circles li:nth-child(1){
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}


.circles li:nth-child(2){
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3){
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4){
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5){
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6){
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7){
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8){
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9){
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10){
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}



@keyframes animate {

    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100%{
        transform: translateY(-1100px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }

}
</style>
<script>
//circle start
let progressBar = document.querySelector(".e-c-progress");
let indicator = document.getElementById("e-indicator");
let pointer = document.getElementById("e-pointer");
let length = Math.PI * 2 * 100;
progressBar.style.strokeDasharray = length;
EOF;
echo '
function update(value, timePercent) {
  var offset = -length - (length * value) / timePercent;
  progressBar.style.strokeDashoffset = offset;
  pointer.style.transform = `rotate(${(360 * value) / timePercent}deg)`;
}
//circle ends
const displayOutput = document.querySelector(".display-remain-time");
let intervalTimer;
let timeLeft;
let wholeTime = 10 * 60; // manage this to set the whole time

update(wholeTime, wholeTime); //refreshes progress bar
displayTimeLeft(wholeTime);
function changeWholeTime(seconds) {
  if (wholeTime + seconds > 0) {
    wholeTime += seconds;
    update(wholeTime, wholeTime);
  }
}

function timer(seconds) {
  //counts time, takes seconds
  let remainTime = Date.now() + seconds * 1000;
  displayTimeLeft(seconds);

  intervalTimer = setInterval(function () {
    timeLeft = Math.round((remainTime - Date.now()) / 1000);
    if (timeLeft < 0) {
      document.getElementById("upd-p-hidden").style.display = "block";
      return;
    }
    displayTimeLeft(timeLeft);
  }, 1000);
}

function displayTimeLeft(timeLeft) {
  //displays time on the input
  let minutes = Math.floor(timeLeft / 60);
  let seconds = timeLeft % 60;
  let displayString = `${minutes < 10 ? "0" : ""}${minutes}:${
    seconds < 10 ? "0" : ""
  }${seconds}`;
  displayOutput.textContent = displayString;
  update(timeLeft, wholeTime);
}
timer(wholeTime);

</script>
';
ob_flush();
flush();
return true;