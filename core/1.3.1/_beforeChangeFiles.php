<?php

logg("Began of _beforeChangeFiles", "INFO");

logg("End of _beforeChangeFiles", "INFO");

$url = util::urlBuild("", true);

echo <<<EOF
<div class="container">
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
    <h1>1.3.1</h1>
    <p>
      La mise à jour est en cours. Une fois le compte à rebours arrivé à 0, un lien s'affichera pour vous rediriger vers l'administration de votre site.
    </p>
  <p id="upd-p-hidden"><a href="{$url}">Cliquez ici pour rejoindre l'administration de votre site</a></p>
  </div>
</div>
</div>
<style>
#upd-p-hidden {display:none;}
.container {
    background: url("https://picsum.photos/id/327/1920/1080") no-repeat center;
    background-size: cover;
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
    font-weight: 100;
    font-size: 65px;
    color: #de2d4a;
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
    backdrop-filter: blur(5px);
    background-color: rgba(255, 255, 255, 0.5);
    padding: 40px;
    border-radius: 15px;
  }
  .upd {
    font-size: 22px;
    color: #a71b33;
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
