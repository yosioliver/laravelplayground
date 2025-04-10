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
            width: 80%;
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
            height: auto;
            width: auto;
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

        .container {
            height: 100px;
            position: relative;
            border: 3px solid green;
        }

        .vertical-center {
            margin: 0;
            position: absolute;
            top: 50%;
            width: 96%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
        }
    </style>
    <title>Geocoding Demo</title>
</head>

<body>
    <div style="height: 60vh; width: 100vw" id="mapContainer" class="container-1">
        <input placeholder="Search for a Place or an Address." type="text" name="search" id="search"
            value="Jakarta, Indonesia" autocomplete="off" onkeyup="autosuggest(this)" autofocus />
        <div class="dropdown">
            <ul id="list"></ul>
        </div>
    </div>
    <div class="container">
        <div>
            <input type="text" id="address" name="address" class="vertical-center">
        </div>
    </div>
</body>
<script>
    const personalApiKey = {{ env('HERE_MAP_API') }};
    function moveToJakarta(map) {
      map.setCenter({ lat: -6.200000, lng: 106.816666 });
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
      moveToJakarta(map);
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
      var lat = -6.200000;
      var lng = 106.816666;
      var title = "Jakarta, Indonesia";
      addMarkerToMap(lat, lng, title);
    }
    // adding marker to map
    const addMarkerToMap = (lat, lng, title) => {
      map.removeObjects(map.getObjects());
      document.getElementById("search").value = title;
      document.getElementById("list").innerHTML = ``;
      // Add the click event listener.
      addDraggableMarker(map, behavior, lat, lng);
    };

    /**
     * Adds a  draggable marker to the map..
     *
     * @param {H.Map} map                      A HERE Map instance within the
     *                                         application
     * @param {H.mapevents.Behavior} behavior  Behavior implements
     *                                         default interactions for pan/zoom
     */
    function addDraggableMarker(map, behavior, lat, lng) {
        var marker = new H.map.Marker(
            { lat: lat, lng: lng },
            {
                // mark the object as volatile for the smooth dragging
                volatility: true,
            }
        );
        // Ensure that the marker can receive drag events
        marker.draggable = true;
        map.addObject(marker);
        map.setCenter({ lat, lng }, true);

        // disable the default draggability of the underlying map
        // and calculate the offset between mouse and target's position
        // when starting to drag a marker object:
        map.addEventListener(
            "dragstart",
            function (ev) {
            var target = ev.target,
                pointer = ev.currentPointer;
            if (target instanceof H.map.Marker) {
                var targetPosition = map.geoToScreen(target.getGeometry());
                target["offset"] = new H.math.Point(
                pointer.viewportX - targetPosition.x,
                pointer.viewportY - targetPosition.y
                );
                behavior.disable();
            }
        },
        false
    );

    // re-enable the default draggability of the underlying map
    // when dragging has completed
    map.addEventListener(
        "dragend",
        function (ev) {
        var target = ev.target;
            if (target instanceof H.map.Marker) {
                behavior.enable();
                localStorage.setItem('longLat', Object.values(target.im))
                getAddressData(localStorage.getItem("longLat"));
                localStorage.clear();
            }
        },
        false
    );

    // Listen to the drag event and move the position of the marker
    // as necessary
    map.addEventListener(
        "drag",
        function (ev) {
        var target = ev.target,
            pointer = ev.currentPointer;
        if (target instanceof H.map.Marker) {
            target.setGeometry(
            map.screenToGeo(
                pointer.viewportX - target["offset"].x,
                pointer.viewportY - target["offset"].y
            )
            );
        }
        },
        false
    );}

    function getAddressData(longLat) {
        // Specify the API endpoint for user data
        const apiUrl = 'https://revgeocode.search.hereapi.com/v1/revgeocode?at=' + longLat + '&lang=en-US&apiKey=nLuTuw0wCNuYmF1hTkf_guE8qp91EU7Xo95nUy3QM8I';

        // Make a GET request using the Fetch API
        fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
            })
            .then(addressData => {
                // Process the retrieved user data
                document.getElementById("address").value = addressData.items[0].title;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

</html>