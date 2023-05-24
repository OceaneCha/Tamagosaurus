let saurus;

window.onload = function () {
    updateHunger(0, true);
}

async function fetchSaurus() {
    return await getRequest('/tamagosauruses/1');
}

async function updateHunger(newHunger = 0, force = false) {
    if (force) {
        saurus = await fetchSaurus();
        console.log(saurus);
        newHunger = saurus.hunger;
    }
    document.getElementById('dino-hunger').innerHTML = newHunger;
}

async function feed(quantity, reset = false) {
    let hunger = quantity + saurus.hunger;
    let json = reset ? {hunger: 0} : {hunger};

    saurus = await putRequest(saurus['@id'], json);
    updateHunger(saurus.hunger);
}