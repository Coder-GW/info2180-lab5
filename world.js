window.onload = function () {
  console.log("world.js loaded");

  const lookupBtn = document.getElementById("lookup");
  const lookupCitiesBtn = document.getElementById("lookup-cities");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  console.log("lookup button:", lookupBtn);
  console.log("lookup-cities button:", lookupCitiesBtn);

  lookupBtn.addEventListener("click", function () {
    const country = countryInput.value.trim();
    const url = "world.php?country=" + encodeURIComponent(country);
    console.log("Fetching COUNTRY:", url);
    fetch(url).then(r => r.text()).then(t => resultDiv.innerHTML = t);
  });

  lookupCitiesBtn.addEventListener("click", function () {
    const country = countryInput.value.trim();
    const url = "world.php?country=" + encodeURIComponent(country) + "&lookup=cities";
    console.log("Fetching CITIES:", url);
    fetch(url).then(r => r.text()).then(t => {
      console.log("Cities response:", t);
      resultDiv.innerHTML = t;
    }).catch(e => console.error("Error fetching cities:", e));
  });
};
