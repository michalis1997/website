"use strict";

//onInput where id = getHar call Proccess_Har_Sensitive_Data function 
document.getElementById('getHar').addEventListener('input', Proccess_Har_Data);
document.getElementById('saveFileLocally').addEventListener('click', Save_Edited_File);
document.getElementById('uploadFile').addEventListener('click', uploadFile);
document.getElementById('ShowMap').addEventListener('click', showHeatMap);
document.getElementById('resetHeatmap').addEventListener('click', ResetHeatMap); //global variables

var proccessData = [];
var uploadDateTime;
var numberOfRecords;
var dataForIPaddress = [];
/**************************************************************************************\
*                                                                                      *
*                            FILTER UPLOADED HAR FILE                                  *
*                                                                                      *
\**************************************************************************************/

function Proccess_Har_Data() {
  /*
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
      if (ajax.readyState == 4 && this.status == 200) {
          usersIpAddress = ajax.responseText;
          //returns ::1 which is my ipv6 local host address
          console.log(usersIpAddress);
      }
  };
  ajax.open("GET", "get_users_ip.php", true);
  ajax.send();
  */
  //if(this.files[0].size > 37000000){
  //   alert("File is too large for the destination file!");
  //    this.value = "";
  //}else {
  var dateObj = new Date();
  var month = dateObj.getUTCMonth() + 1;
  var day = dateObj.getUTCDate();
  var year = dateObj.getUTCFullYear();
  uploadDateTime = year + "/" + month + "/" + day;
  var fileName = document.getElementById('getHar').files[0].name;
  fetch('../har_files/' + fileName).then(function (response) {
    return response.json();
  }).then(function (data) {
    dataForIPaddress.push(data);
    console.log(data);
    data = proccess(data.log.entries);
    console.log(data);
    numberOfRecords = data.length;
    proccessData.push(data);
  });

  function proccess(har) {
    var results = {
      table: []
    };

    for (var i = 0; i < har.length; i++) {
      var requestHeaders = {
        table: []
      };

      for (var j = 0; j < har[i].request.headers.length; j++) {
        var requestHeader = {};
        var _flag = 0;

        if (har[i].request.headers[j].name == "content-type") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "cache-control") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "pragma") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "expires") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "age") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "last-modified") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        } else if (har[i].request.headers[j].name == "host") {
          requestHeader = {
            "name": har[i].request.headers[j].name,
            "value": har[i].request.headers[j].value
          };
          _flag = 1;
        }

        if (_flag) {
          requestHeaders.table.push(requestHeader);
        }
      }

      var responseHeaders = {
        table: []
      };

      for (var _j = 0; _j < har[i].response.headers.length; _j++) {
        var responseHeader = {};
        var _flag2 = 0;

        if (har[i].response.headers[_j].name == "content-type") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "cache-control") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "pragma") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "expires") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "age") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "last-modified") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        } else if (har[i].response.headers[_j].name == "host") {
          responseHeader = {
            "name": har[i].response.headers[_j].name,
            "value": har[i].response.headers[_j].value
          };
          _flag2 = 1;
        }

        if (_flag2) {
          responseHeaders.table.push(responseHeader);
        }
      } //regex to get just the domain of the url


      re = /(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/;
      var result = {
        "entries": {
          "startedDateTime": har[i].startedDateTime,
          "timings": {
            "wait": har[i].timings.wait
          },
          "serverIPAddress": har[i].serverIPAddress
        },
        "request": {
          "method": har[i].request.method,
          "url": har[i].request.url.match(re)[0],
          "headers": requestHeaders.table
        },
        "response": {
          "status": har[i].response.status,
          "statusText": har[i].response.statusText,
          "headers": responseHeaders.table
        }
      };
      results.table.push(result);
    }

    return results.table;
  }

  $("#showButtons").show(1000); //}
}
/**************************************************************************************\
*                                                                                      *
*                        SAVE EDITTED FILE TO LOCAL FOLDER                             *
*                                                                                      *
\**************************************************************************************/


function Save_Edited_File() {
  proccessData = proccessData[0];
  proccessData = JSON.stringify(proccessData);
  var a = document.createElement('a');
  a.setAttribute('href', 'data:application/json;charset=utf-8,' + encodeURIComponent(proccessData));
  a.setAttribute('download', 'name.json');
  a.click();
}
/**************************************************************************************\
*                                                                                      *
*                                   UPLOAD FILE                                        *
*                                                                                      *
\**************************************************************************************/


var serverUser = [];
var historyUser = [];
var proccessDataReq2 = [];
var proccessServerIP = [];
var serverIPsAddresses = [];
var dataServer = [];
var flag = false;

function uploadFile() {
  /* ----------------------------- find users provider's ip address data + uploadData and numberOfRecrods and store to db -------------------------------------- */
  fetch("https://api.ipify.org/?format=json").then(function (response) {
    return response.json();
  }).then(function (data) {
    providerIP = data.ip;
    var IPs = [providerIP];
    fetch('http://ip-api.com/json/' + IPs).then(function (response) {
      return response.json();
    }).then(function (data) {
      serverUser.push({
        "serverIPAddress": data.query,
        "Isp_name": data.isp,
        "Latitude": data.lat,
        "Longitude": data.lon,
        "uploadDateTime": uploadDateTime,
        "numberOfRecords": numberOfRecords
      });
      serverUser = serverUser[0];
      $.ajax({
        url: "processes.php?request=1",
        method: "POST",
        data: serverUser,
        success: function success(res) {
          console.log(res);
        }
      });
    });
  });
  proccessDataReq2.push(proccessData);
  proccessDataReq2 = proccessDataReq2[0][0];
  $.ajax({
    url: "processes.php?request=2",
    method: "POST",
    data: {
      proccessDataReq2: proccessDataReq2
    },
    success: function success(res) {
      console.log(res);
    }
  });
  /* ------------------------------------------------------------------------------------------------------------------ */

  var count = 0;
  proccessServerIP = proccessData;
  proccessServerIP = proccessServerIP[0];
  proccessServerIP.forEach(function (data) {
    serveripaddress = data['entries']['serverIPAddress'];
    fetch('https://freegeoip.app/json/' + serveripaddress).then(function (response) {
      return response.json();
    }).then(function (data) {
      //console.log({"serverIPaddresss": data.ip, "latitude": data.latitude, "longitude": data.longitude });
      dataServer.push({
        "serverIPaddresss": data.ip,
        "latitude": data.latitude,
        "longitude": data.longitude
      });
      count++;

      if (count == proccessServerIP.length) {
        flag = true;

        if (flag == true) {
          $.ajax({
            url: "processes.php?request=3",
            method: "POST",
            data: {
              dataServer: dataServer
            },
            success: function success(res) {
              console.log(res);
            }
          });
        }
      }
    });
  }); // 3: provlima oti den mporis na kanis 2 fores upload xoris na kanis refresh 
}
/**************************************************************************************\
*                                                                                      *
*                                   SHOW HEATMAP                                       *
*                                                                                      *
\**************************************************************************************/


var mapData = [];
var mymap;
var heatmapLayer;

function showHeatMap() {
  $("#showHeatMap").fadeIn("slow");
  fetch("processes.php?request=4", {
    method: 'GET',
    headers: new Headers({
      'Content-Type': 'application/x-www-from-urlencoded'
    })
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    console.log(data);
    var baseLayer = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
      maxZoom: 18
    });
    var cfg = {
      radius: 5,
      minOpacity: 0.1,
      maxOpacity: .8,
      gradient: {
        0.10: 'blue',
        0.40: 'lime',
        1: 'red'
      },
      scaleRadius: true,
      useLocalExtrema: true,
      latField: 'lat',
      lngField: 'lng',
      valueField: 'count'
    }; // for map contaier is already intialized error

    var container = L.DomUtil.get('map');

    if (container != null) {
      container._leaflet_id = null;
    }

    heatmapLayer = new HeatmapOverlay(cfg);
    mymap = new L.Map('map', {
      center: new L.LatLng(25.6586, -80.3568),
      zoom: 4,
      layers: [baseLayer, heatmapLayer]
    });
    mymap.setView([39.074208, 21.824312], 2.5);
    var i = 0;
    data.forEach(function (element) {
      mapData.push({
        lat: element['latitude'],
        lng: element['longitude'],
        count: element['count']
      });
      console.log(mapData[i]);
      i++;
    });
    heatmapLayer.setData({
      data: mapData
    });
  });
}
/**************************************************************************************\
*                                                                                      *
*                           RESET PREVIOUS HEATMAP DATA                                *
*                                                                                      *
\**************************************************************************************/


function ResetHeatMap() {
  $("#resetHeatmap").click(function () {
    mymap.removeLayer(heatmapLayer);
  });
  $.ajax({
    url: "processes.php?request=5",
    method: "POST",
    success: function success(res) {
      console.log(res);
    }
  });
}