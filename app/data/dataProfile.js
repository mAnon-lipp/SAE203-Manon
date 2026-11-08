let HOST_URL = "https://portfolio-manonlippler.alwaysdata.net/server";

let DataProfile = {};

DataProfile.read = async function () {
  let answer = await fetch(HOST_URL + "/script.php?todo=readProfiles");
  let profile = await answer.json();
  return profile;
};

export { DataProfile };