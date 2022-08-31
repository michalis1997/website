"use strict";

window.onload = function () {
  var barChartData;
  var barChartDataGlobal = [];
  fetch("chart2.php?chart2a=1", {
    method: 'GET',
    headers: new Headers({
      'Content-Type': 'application/x-www-from-urlencoded'
    })
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    console.log(data);
    re = /\d+(?=:)/;
    data.forEach(function (element) {
      console.log(element['hour'].match(re)[0]); //console.log(element['response_time']);

      barChartDataGlobal.push(element['hour'].match(re)[0]);
    });
    console.log(barChartDataGlobal);
    barChartData = {
      labels: [barChartDataGlobal],
      //labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,00],
      datasets: [{
        label: 'Application',
        backgroundColor: 'rgba(206, 0, 23, 1)',
        data: [0, 1, 3, 0, 2, 0, 0, 2, 0, 1, 0, 1, 1, 0, 0, 1, 0, 0, 2, 1, 0, 1, 2, 1, 1, 0, 0, 0, 2, 2, 0, 3]
      }, {
        label: 'Text',
        backgroundColor: 'rgba(206, 0, 23, 0.75)',
        data: [0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1]
      }, {
        label: 'Image',
        backgroundColor: 'rgba(206, 0, 23, 0.5)',
        data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
      }, {
        label: 'Html',
        backgroundColor: 'rgba(206, 0, 23, 0.6)',
        data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
      }, {
        label: 'Video',
        backgroundColor: 'rgba(206, 0, 23, 0.95)',
        data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
      }, {
        label: 'Font',
        backgroundColor: 'rgba(206, 0, 24, 0.5)',
        data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
      }]
    }; //console.log(barChartData);
  }).then(function (datas) {
    console.log(barChartData);
    var ctx = document.getElementById('sub2sub1chart').getContext('2d');
    var chartInstance = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: false
        },
        responsive: true,
        scales: {
          xAxes: [{
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: 'Hour of the day'
            }
          }],
          yAxes: [{
            stacked: true,
            scaleLabel: {
              display: true,
              labelString: 'Response time'
            }
          }]
        }
      }
    });
    $("#toggle21").click(function () {
      chartInstance.data.datasets.forEach(function (ds) {
        ds.hidden = !ds.hidden;
      });
      chartInstance.update();
    });
  });
};