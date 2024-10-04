<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Flight Search</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="./style.css" />
    <style>
        .flex-1 {
  flex: 1;
}
</style>
  </head>
  <body>
    <div class="container-sm">
      <div class="my-2 card">
        <div class="card-body">
          <h5 class="card-title">Locations</h5>
          <div class="row">
            <div class="col-sm">
              <div class="mb-2">
                <label id="origin-label" for="origin-input" class="form-label"
                  >Origin</label
                >
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="bi-pin-map"></i>
                  </span>
                  <input
                    type="text"
                    class="form-control"
                    list="origin-options"
                    id="origin-input"
                    placeholder="Location"
                    aria-describedby="origin-label"
                  />
                  <datalist id="origin-options"></datalist>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="mb-2">
                <label
                  id="destination-label"
                  for="destination-input"
                  class="form-label"
                  >Destination</label
                >
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="bi-pin-map-fill"></i>
                  </span>
                  <input
                    type="text"
                    class="form-control"
                    list="destination-options"
                    id="destination-input"
                    placeholder="Location"
                    aria-describedby="destination-label"
                  />
                  <datalist id="destination-options"></datalist>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mb-2 col">
          <div class="h-100 card">
            <div class="card-body">
              <h5 class="card-title">Dates</h5>
              <div class="mb-2">
                <label
                  id="flight-type-label"
                  for="flight-type-select"
                  class="form-label"
                  >Flight</label
                >
                <select
                  id="flight-type-select"
                  class="form-select"
                  aria-describedby="flight-type-label"
                >
                  <option value="one-way">One-way</option>
                  <option value="round-trip">Round-trip</option>
                </select>
              </div>
              <div id="departure-date" class="mb-2">
                <label
                  id="departure-date-label"
                  for="departure-date-input"
                  class="form-label"
                  >Departure date</label
                >
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="bi-calendar"></i>
                  </span>
                  <input
                    type="date"
                    class="form-control"
                    id="departure-date-input"
                    aria-describedby="departure-date-label"
                  />
                </div>
              </div>
              <div id="return-date" class="mb-2">
                <label
                  id="return-date-label"
                  for="return-date-input"
                  class="form-label"
                  >Return date</label
                >
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="bi-calendar-fill"></i>
                  </span>
                  <input
                    type="date"
                    class="form-control"
                    id="return-date-input"
                    aria-describedby="return-date-label"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-2 col">
          <div class="h-100 card">
            <div class="card-body">
              <h5 class="card-title">Details</h5>
              <div class="mb-2">
                <label
                  id="travel-class-label"
                  for="travel-class-select"
                  class="form-label"
                  >Travel class</label
                >
                <select
                  class="form-select"
                  id="travel-class-select"
                  aria-describedby="travel-class-label"
                >
                  <option value="ECONOMY">Economy</option>
                  <option value="PREMIUM_ECONOMY">Premium Economy</option>
                  <option value="BUSINESS">Business</option>
                  <option value="FIRST">First</option>
                </select>
              </div>
              <label class="form-label">Passengers</label>
              <div class="mb-2">
                <div class="input-group">
                  <label for="adults-input" class="input-group-text"
                    >Adults</label
                  >
                  <input
                    type="number"
                    min="0"
                    class="form-control"
                    id="adults-input"
                    aria-describedby="adults-label"
                  />
                </div>
                <span id="adults-label" class="form-text"
                  >12 years old and older</span
                >
              </div>
              <div class="mb-2">
                <div class="input-group">
                  <label for="children-input" class="input-group-text"
                    >Children</label
                  >
                  <input
                    type="number"
                    min="0"
                    class="form-control"
                    id="children-input"
                    aria-describedby="children-label"
                  />
                </div>
                <span id="children-label" class="form-text"
                  >2 to 12 years old</span
                >
              </div>
              <div class="mb-2">
                <div class="input-group">
                  <label for="infants-input" class="input-group-text"
                    >Infants</label
                  >
                  <input
                    type="number"
                    min="0"
                    class="form-control"
                    id="infants-input"
                    aria-describedby="infants-label"
                  />
                </div>
                <span id="infants-label" class="form-text"
                  >Up to 2 years old</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <button id="search-button" class="w-100 btn btn-primary">Search</button>
      <div class="border-bottom mb-4 pt-4" id="search-results-separator"></div>
      <div class="d-flex justify-content-center" id="search-results-loader">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <ul class="list-group mb-4" id="search-results"></ul>
    </div>
    <script>
      const originInput = document.getElementById("origin-input");
const originOptions = document.getElementById("origin-options");
const destinationInput = document.getElementById("destination-input");
const destinationOptions = document.getElementById("destination-options");
const flightTypeSelect = document.getElementById("flight-type-select");
const departureDateInput = document.getElementById("departure-date-input");
const returnDate = document.getElementById("return-date");
const returnDateInput = document.getElementById("return-date-input");
const travelClassSelect = document.getElementById("travel-class-select");
const adultsInput = document.getElementById("adults-input");
const childrenInput = document.getElementById("children-input");
const infantsInput = document.getElementById("infants-input");
const searchButton = document.getElementById("search-button");
const searchResultsSeparator = document.getElementById(
  "search-results-separator"
);
const searchResultsLoader = document.getElementById("search-results-loader");
const searchResults = document.getElementById("search-results");
const autocompleteTimeout = 300;

let autocompleteTimeoutHandle = 0;
let destinationCityCodes = {};
let originCityCodes = {};

const reset = () => {
  originInput.value = "";
  destinationInput.value = "";
  flightTypeSelect.value = "one-way";
  departureDateInput.valueAsDate = new Date();
  returnDateInput.valueAsDate = new Date();
  returnDate.classList.add("d-none");
  travelClassSelect.value = "ECONOMY";
  adultsInput.value = 1;
  childrenInput.value = 0;
  infantsInput.value = 0;
  searchButton.disabled = true;
  searchResultsSeparator.classList.add("d-none");
  searchResultsLoader.classList.add("d-none");
};
const formatDate = (date) => {
  const [formattedDate] = date.toISOString().split("T");

  return formattedDate;
};
const formatNumber = (number) => {
  return `${Math.abs(parseInt(number))}`;
};
const autocomplete = (input, datalist, cityCodes) => {
  clearTimeout(autocompleteTimeoutHandle);
  autocompleteTimeoutHandle = setTimeout(async () => {
    try {
      const params = new URLSearchParams({ keyword: input.value });
      const response = await fetch(`/api/autocomplete?${params}`);
      const data = await response.json();

      datalist.textContent = "";
      data.forEach((entry) => {
        cityCodes[entry.name.toLowerCase()] = entry.iataCode;
        datalist.insertAdjacentHTML(
          "beforeend",
          `<option value="${entry.name}"></option>`
        );
      });
    } catch (error) {
      console.error(error);
    }
  }, autocompleteTimeout);
};
const search = async () => {
  try {
    const returns = flightTypeSelect.value === "round-trip";
    const params = new URLSearchParams({
      origin: originCityCodes[originInput.value.toLowerCase()],
      destination: destinationCityCodes[destinationInput.value.toLowerCase()],
      departureDate: formatDate(departureDateInput.valueAsDate),
      adults: formatNumber(adultsInput.value),
      children: formatNumber(childrenInput.value),
      infants: formatNumber(infantsInput.value),
      travelClass: travelClassSelect.value,
      ...(returns
        ? { returnDate: formatDate(returnDateInput.valueAsDate) }
        : {}),
    });
    const response = await fetch(`/api/search?${params}`);
    const data = await response.json();

    return data;
  } catch (error) {
    console.error(error);
  }
};
const showResults = (results) => {
  if (results.length === 0) {
    searchResults.insertAdjacentHTML(
      "beforeend",
      `<li class="list-group-item d-flex justify-content-center align-items-center" id="search-no-results">
        No results
      </li>`
    );
  }
  results.forEach(({ itineraries, price }) => {
    const priceLabel = `${price.total} ${price.currency}`;

    searchResults.insertAdjacentHTML(
      "beforeend",
      `<li class="flex-column flex-sm-row list-group-item d-flex justify-content-between align-items-sm-center">
        ${itineraries
          .map((itinerary, index) => {
            const [, hours, minutes] = itinerary.duration.match(/(\d+)H(\d+)?/);
            const travelPath = itinerary.segments
              .flatMap(({ arrival, departure }, index, segments) => {
                if (index === segments.length - 1) {
                  return [departure.iataCode, arrival.iataCode];
                }
                return [departure.iataCode];
              })
              .join(" → ");

            return `
            <div class="flex-column flex-1 m-2 d-flex">
              <small class="text-muted">${
                index === 0 ? "Outbound" : "Return"
              }</small>
              <span class="fw-bold">${travelPath}</span>
              <div>${hours || 0}h ${minutes || 0}m</div>
            </div>
          `;
          })
          .join("")}
        <span class="bg-primary rounded-pill m-2 badge fs-6">${priceLabel}</span>
      </li>`
    );
  });
};

document.body.addEventListener("change", () => {
  clearTimeout(autocompleteTimeoutHandle);
  searchButton.disabled = !originInput.value || !destinationInput.value;
});
originInput.addEventListener("input", () => {
  autocomplete(originInput, originOptions, originCityCodes);
});
destinationInput.addEventListener("input", () => {
  autocomplete(destinationInput, destinationOptions, destinationCityCodes);
});
flightTypeSelect.addEventListener("change", () => {
  if (flightTypeSelect.value === "one-way") {
    returnDate.classList.add("d-none");
  } else {
    returnDate.classList.remove("d-none");
  }
});
searchButton.addEventListener("click", async () => {
  searchResultsSeparator.classList.remove("d-none");
  searchResultsLoader.classList.remove("d-none");
  searchResults.textContent = "";

  const results = await search();

  searchResultsLoader.classList.add("d-none");
  showResults(results);
});

reset();
</script>
    <script src="./script.js"></script>
  </body>

</html>