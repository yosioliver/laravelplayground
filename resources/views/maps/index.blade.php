<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        .dropdown {
            position: absolute;
            z-index: 99999;
            list-style-type: none;
            width: 360px;
            border: rgb(15, 22, 33);
            list-style: none;
            top: 135px;
        }

        input {
            z-index: 9999;
            font-size: 18px;
            font-family: "Allerta", Helvetica, Arial, sans-serif;
            color: #495057;
            position: absolute;
            top: 100px;
            left: 20px;
            width: 65%;
            height: 35px;
            padding: 5px;
            margin-left: 17px;
            margin-top: 7px;
            border: none;
        }

        ul {
            list-style: none;
            background-color: white;
            padding: 0px;
            margin-left: 29px;
            width: 360px;
        }

        li {
            list-style-type: none;
            height: 12px;
            padding: 12px;
            box-shadow: rgb(158, 202, 237) 0px 0px 4px;
            display: list-item;
            text-align: -webkit-match-parent;
            font-family: "Allerta", Helvetica, Arial, sans-serif;
            color: #495057;
        }

        li:hover {
            background-color: yellowgreen;
        }

        #list {
            cursor: pointer;
        }

        .fa-search-custom {
            position: absolute;
            left: 65%;
            top: 123px;
            z-index: 99999;
        }
    </style>
    <title>Geocoding Demo</title>
</head>

<body>
    <div style="height: 100vh; width: 100vw" id="mapContainer" class="container-1">
        <input placeholder="Search for a Place or an Address." type="text" name="search" id="search"
            value="Berlin, Germany" autocomplete="off" onkeyup="autosuggest(this)" autofocus />
        <i class="fa fa-search fa-search-custom" aria-hidden="true"></i>
        <div class="dropdown">
            <ul id="list"></ul>
        </div>
    </div>
</body>
<script>
    const personalApiKey = `N3N8X01cQGP_lvkAzczCMTo3-RqU6aMv_iC8bRq1IPk`; // Your personal API key
    function moveMapToBerlin(map) {
      map.setCenter({ lat: 52.5159, lng: 13.3777 });
      map.setZoom(10);
    }
    var platform = new H.service.Platform({
      apikey: personalApiKey,
    });
    var defaultLayers = platform.createDefaultLayers();

    //Step 2: initialize a map - this map is centered over Europe
    var map = new H.Map(
      document.getElementById("mapContainer"),
      defaultLayers.vector.normal.map,
      {
        center: { lat: 50, lng: 5 },
        zoom: 4,
        pixelRatio: window.devicePixelRatio || 1,
      }
    );
    // add a resize listener to make sure that the map occupies the whole container
    window.addEventListener("resize", () => map.getViewPort().resize());

    //Step 3: make the map interactive
    // MapEvents enables the event system
    // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    // Create the default UI components
    var ui = H.ui.UI.createDefault(map, defaultLayers);
    // Now use the map as required...
    window.onload = function () {
      moveMapToBerlin(map);
      getDefaultLocation();
    };
    const autosuggest = (e) => {
      if (event.metaKey) {
        return;
      }

      let searchString = e.value;
      if (searchString != "") {
        fetch(
          `https://autosuggest.search.hereapi.com/v1/autosuggest?apiKey=${personalApiKey}&at=33.738045,73.084488&limit=5&resultType=city&q=${searchString}&lang=en-US`
        )
          .then((res) => res.json())
          .then((json) => {
            if (json.length != 0) {
              document.getElementById("list").innerHTML = ``;
              let dropData = json.items.map((item) => {
                if ((item.position != undefined) & (item.position != ""))
                  document.getElementById(
                    "list"
                  ).innerHTML += `<li onClick="addMarkerToMap(${item.position.lat},${item.position.lng},'${item.title}')">${item.title}</li>`;
              });
            }
          });
      }
    };
    // to get default location after loading the page
    function getDefaultLocation() {
      var lat = 52.5159;
      var lng = 13.3777;
      var title = "Berlin, Germany";
      addMarkerToMap(lat, lng, title);
    }
    // adding marker to map
    const addMarkerToMap = (lat, lng, title) => {
      map.removeObjects(map.getObjects());
      document.getElementById("search").value = title;
      var selectedLocationMarker = new H.map.Marker({ lat, lng });
      map.addObject(selectedLocationMarker);
      document.getElementById("list").innerHTML = ``;
      map.setCenter({ lat, lng }, true);
    };
</script>

</html>