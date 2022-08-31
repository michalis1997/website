"use strict";

document.getElementById('chart4').addEventListener('click', mapInitialize);
document.getElementById('map').addEventListener('mouseover', waitMapLoad);

function waitMapLoad() {
  $("#wait").hide("slow");
}

function mapInitialize() {
  var table = [];
  fetch("mapChart.php?mapChart=1", {
    method: 'GET',
    headers: new Headers({
      'Content-Type': 'application/x-www-from-urlencoded'
    })
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    table.push(data);
    table = table[0]; // for map contaier is already intialized error

    var container = L.DomUtil.get('map');

    if (container != null) {
      container._leaflet_id = null;
    }

    mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
    var grayscale = L.tileLayer(mbUrl, {
      id: 'mapbox/light-v9'
    });
    var streets = L.tileLayer(mbUrl, {
      id: 'mapbox/streets-v11'
    });
    var baseLayers = {
      "Grayscale": grayscale,
      "Streets": streets
    };
    var map = new L.Map('map', {
      center: [37.983810, 23.727539],
      zoom: 2,
      layers: [grayscale]
    });
    L.control.layers(baseLayers).addTo(map);
    var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
    var osm = new L.TileLayer(osmUrl, {
      minZoom: 8,
      maxZoom: 20,
      attribution: osmAttrib
    });
    map.setView(new L.LatLng(37.983810, 23.727539), 2);
    map.addLayer(osm);
    fetch("mapChart.php?mapChart=2", {
      method: 'GET',
      headers: new Headers({
        'Content-Type': 'application/x-www-from-urlencoded'
      })
    }).then(function (response) {
      return response.json();
    }).then(function (datas) {
      table.forEach(function (element) {
        userMarker = L.marker([element['latitude'], element['longitude']]).bindPopup('User ID: ' + element['userID']);
        resMarker = L.marker([element['resLatitude'], element['resLongitude']]).bindPopup(element['responseIP']);
        userMarker.addTo(map);
        resMarker.addTo(map); //count normalization, beetween 0-1

        countIP = element['countResIP'] / datas[0]['res_ip_count'];
        var latlngs = [[element['latitude'], element['longitude']], [element['resLatitude'], element['resLongitude']]];
        var polyline = L.polyline(latlngs, {
          color: 'red',
          weight: countIP
        });
        polyline.bindPopup(element['res_ip_count']).addTo(map); // zoom the map to the polyline

        map.fitBounds(polyline.getBounds());
      });
    });
  });
}