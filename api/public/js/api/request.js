const putRequest = async (resource, json) => {
    const response = await fetch(`https://localhost${resource}`, {
        method: "PUT",
        headers: {
            Accept: "application/ld+json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify(json)
    });

    return await response.json();
}

const getRequest = async (resource) => {
    const response = await fetch(`https://localhost${resource}`);

    return await response.json();
}