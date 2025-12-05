window.onload = function () {

  const lookupBtn = document.getElementById("lookup");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  lookupBtn.addEventListener("click", function () {
    const country = countryInput.value.trim();

    // Prevent empty search
    if (country === "") {
      resultDiv.innerHTML = "<p>Please enter a country name.</p>";
      return;
    }

    // Build request URL
    const url = "world.php?country=" + encodeURIComponent(country);

    // Send AJAX request
    fetch(url)
      .then(response => response.text())
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        resultDiv.innerHTML = "<p>Error connecting to server.</p>";
        console.error("Fetch error:", error);
      });
  });

};
