let saurus;

window.onload = function () {
    updateHunger(0, true);
}

async function fetchSaurus() {
    return await getRequest('/tamagosauruses/11');
}

async function updateHunger(newHunger = 0, force = false) {
    if (force) {
        saurus = await fetchSaurus();
        console.log(saurus);
        newHunger = saurus.hunger;
    }
    document.getElementById('dino-hunger').innerHTML = newHunger;
}

async function feed(quantity) {
    let hunger = quantity + saurus.hunger;
    let json = {hunger};

    saurus = await putRequest(saurus['@id'], json);
    updateHunger(saurus.hunger);
}

async function resetFood() {
    let json = {hunger: 0};

    saurus = await putRequest(saurus['@id'], json);
    updateHunger();
}