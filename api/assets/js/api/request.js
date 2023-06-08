const putRequest = async (resource, json) => {
  const response = await fetch(`https://localhost${resource}`, {
    method: "PATCH",
    headers: {
      Accept: "application/ld+json",
      "Content-Type": "application/merge-patch+json",
    },
    body: JSON.stringify(json),
  });

  return await response.json();
};

const getRequest = async (resource) => {
  try {
    const response = await fetch(`https://localhost${resource}`);
    return await response.json();
  } catch (error) {
    console.error(error);
  }

};
