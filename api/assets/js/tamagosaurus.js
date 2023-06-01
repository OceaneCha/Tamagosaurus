// this variable contains all of our saurus's info
let saurus;

// On load, we update the saurus's hunger
// 'true' forces a fetch request
window.onload = function () {
  updateHunger(0, true);
};

async function fetchSaurus() {
  return await getRequest("/tamagosauruses/11");
}

// We restrict fetchSaurus() to be used only with force
//   so we limit the number of api requests
//   beyond the onload fetch, data is stored in $saurus
async function updateHunger(newHunger = 0, force = false) {
  if (force) {
    saurus = await fetchSaurus();
    console.log(saurus);
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
}

// TODO: this could be folded into feed()
async function resetFood() {
  let json = { hunger: 0 };

  saurus = await putRequest(saurus["@id"], json);
  updateHunger();
}

// this function allows to show/hide a hidden element, and hide
// other visible elements that use the same visibility class
// elementId: enter the ID of the element you want to hide/show
function toggleOptions(elementId) {
  let classes = document.getElementById(elementId).classList;

  // define the classes used for hidden and visible elements
  //   they should only be used for related elements, where only one is shown,
  //   and the others are hidden again
  let hidden = "element-hidden";
  let visible = "element-visible";

  // if the element has visible, it becomes hidden
  // if the element has hidden, it becomes visible, and all other elements
  //   with visible become hidden
  if (classes.contains(visible)) {
    classes.replace(visible, hidden);
  } else if (classes.contains(hidden)) {
    let othersVisible = document.getElementsByClassName(visible);

    for (element of othersVisible) {
      element.classList.replace(visible, hidden);
    }

    classes.replace(hidden, visible);
  }
}

// URL de souscription Mercure
// const evtSource = new EventSource('https://localhost/.well-known/mercure?topic=https://localhost/<resource>/<id>')
// evtSource.onmessage = function(event) {
//     const data = JSON.parse(event.data);
// }
