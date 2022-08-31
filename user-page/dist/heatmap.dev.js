"use strict";

function showHeatMap() {
  var mymap = L.map("map");
  var osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
  var osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
  var osm = new L.TileLayer(osmUrl, {
    attribution: osmAttrib
  });
  mymap.addLayer(osm);
  mymap.setView([38.246242, 21.7350847], 8);
  var testData = {
    max: 8,
    //gia to count = SELECT count(contentype) FROM header WHERE contentType= "htpp,php,asp,jsp"
    data: [{
      lat: 38.246242,
      lng: 21.735085,
      count: 3
    }, {
      lat: 38.323343,
      lng: 21.865082,
      count: 2
    }, {
      lat: 38.34381,
      lng: 21.57074,
      count: 8
    }, {
      lat: 38.108628,
      lng: 21.502075,
      count: 7
    }, {
      lat: 38.123034,
      lng: 21.917725,
      count: 4
    }, {
      lat: 38.246242,
      lng: 21.735085,
      count: 3
    }, {
      lat: 38.323343,
      lng: 21.865082,
      count: 2
    }, {
      lat: 38.34381,
      lng: 21.57074,
      count: 8
    }, {
      lat: 38.108628,
      lng: 21.502075,
      count: 7
    }, {
      lat: 38.123034,
      lng: 21.917725,
      count: 4
    }]
  };
  var cfg = {
    "radius": 40,
    "maxOpacity": 0.8,
    "scaleRadius": false,
    "useLocalExtrema": false,
    // which field name in your data represents the latitude - default "lat"
    latField: 'lat',
    // which field name in your data represents the longitude - default "lng"
    lngField: 'lng',
    // which field name in your data represents the data value - default "value"
    valueField: 'count'
  };
  var heatmapLayer = new HeatmapOverlay(cfg);
  mymap.addLayer(heatmapLayer);
  heatmapLayer.setData(testData);
}