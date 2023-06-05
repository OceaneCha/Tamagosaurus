// this variable contains all of our saurus's info
let saurus;
let tamagosaurusId;
localStorage.setItem("steakEnabled", false);

function loadSteak() {
  const textureSteakLoader = new MTLLoader();
  let steak;

  if (localStorage.getItem('steakEnabled') == true) {

    textureSteakLoader.load(
      textureSteakUrl.href,
      function (materials) {
        materials.preload();

        const steakLoader = new OBJLoader();
        steakLoader.setMaterials(materials);
        steakLoader.load(
          steakUrl.href,
          function (obj) {
            steak = obj;
            console.log(obj.animations);
            scene.add(steak);
            steak.position.set(2, 0, 7);
            steak.scale.set(1, 1, 1);
            console.log('hello');
          },
          undefined,
          function (error) {
            console.error(error);
          }
        );
      }
    )
  }
}

// On load, we update the saurus's hunger
// 'true' forces a fetch request
window.onload = function () {
  var tamagosaurus = document.querySelector('#tamagosaurus');
  tamagosaurusId = tamagosaurus.dataset.tamagosaurusId;
  updateHunger(0, true);
};

async function fetchSaurus() {
  return await getRequest(`/tamagosauruses/${tamagosaurusId}`);
}

// We restrict fetchSaurus() to be used only with force
//   so we limit the number of api requests
//   beyond the onload fetch, data is stored in $saurus
async function updateHunger(newHunger = 0, force = false) {
  if (force) {
    saurus = await fetchSaurus();
    // console.log(saurus);
    newHunger = saurus.hunger;
  }
  document.getElementById("dino-hunger").innerHTML = newHunger;
}

// We affect the result of the put request to $saurus,
//   which allows us to use the data without another GET
async function feed(quantity) {
  let hunger = quantity + saurus.hunger;
  let json = { hunger };

  saurus = await putRequest(saurus["@id"], json);
  updateHunger(saurus.hunger);

  localStorage.setItem("steakEnabled", true);
  loadSteak();
}

// TODO: this could be folded into feed()
async function resetFood() {
  let json = { hunger: 0 };

  saurus = await putRequest(saurus["@id"], json);
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


// URL de souscription Mercure
// const evtSource = new EventSource('https://localhost/.well-known/mercure?topic=https://localhost/<resource>/<id>')
// evtSource.onmessage = function(event) {
//     const data = JSON.parse(event.data);
// }
