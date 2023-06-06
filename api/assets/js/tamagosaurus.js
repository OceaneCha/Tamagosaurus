let saurus;
let tamagosaurusId;

window.onload = function () {
  var tamagosaurus = document.querySelector('#tamagosaurus');
  tamagosaurusId = tamagosaurus.dataset.tamagosaurusId;
  updateHunger(0, true);
};

let interval = 45000; // TODO: Set the interval based on the saurus's species
setInterval(function() {
  if (saurus.hunger > 0) {
    updateHunger(0, true);
    console.log(saurus.hunger);
  }
}, interval);

async function fetchSaurus() {
  return await getRequest(`/tamagosauruses/${tamagosaurusId}/status`);
}

async function updateHunger(newHunger = 0, force = false) {
  if (force) {
    saurus = await fetchSaurus();
    newHunger = saurus.hunger;
  }
  document.getElementById("dino-hunger").innerHTML = newHunger;
}

async function feed(quantity) {
  let hunger = quantity + saurus.hunger;
  let json = { hunger };

  saurus = await putRequest(`/tamagosauruses/${tamagosaurusId}/feed`, json);
  if (saurus) {
    updateHunger(saurus.hunger);
  }
}

async function resetFood() {
  let json = { hunger: 0 };

  saurus = await putRequest(`/tamagosauruses/${tamagosaurusId}/feed`, json);
  updateHunger();
}

let lastToggle = null;

function toggleOptions(elementId, targetElementId) {
  let element = document.getElementById(elementId);
  let elementContent = element.innerHTML;
  let targetElement = document.getElementById(targetElementId);
  let hidden = "element-hidden";
  let visible = "element-visible";

  if (lastToggle !== null && lastToggle === element) {
    if (targetElement.classList.contains(hidden)) {
      targetElement.classList.replace(hidden, visible);
    } else {
      targetElement.classList.replace(visible, hidden);
    }
  } else {
    targetElement.classList.replace(hidden, visible);
  }

  lastToggle = element;

  targetElement.innerHTML = elementContent;
}

const evtSource = new EventSource(`https://localhost/.well-known/mercure?topic=https://localhost/tamagosauruses/${tamagosaurusId}`);
evtSource.onmessage = function(event) {
  const data = JSON.parse(event.data);
  console.log(data);
}