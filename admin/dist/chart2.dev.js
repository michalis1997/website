"use strict";

/*
window.onload=function(){


  fetch("chart2.php?chart2a=1", {
    method: 'GET',
    headers: new Headers ({
        'Content-Type': 'application/x-www-from-urlencoded'
    })
  })
  .then( response => response.json())
  .then( data => {
  
    re =  /\d+(?=:)/;
    data.forEach(element => {
      //get the hour of the day
      
      console.log(element['startedDateTime'].match(re)[0]);
  
    })  
  
    var barChartData = {
      labels: [data[0]['startedDateTime'].match(re)[0], 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12, 13, 14, 15, 16, 17, 18 ,19 ,20, 21, 22, 23],
      datasets: [
        {
          label: 'Application',
          backgroundColor: 'rgba(206, 0, 23, 1)',
          data: [0, 1, 3, 0, 2, 0, 0, 2, 0, 1, 0, 1, 1, 0, 0, 1, 0, 0, 2, 1, 0, 1, 2, 1, 1, 0, 0, 0, 2, 2, 0, 3]
        }, 

        {
          label: 'Text',
          backgroundColor: 'rgba(206, 0, 23, 0.75)',
          data: [0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1]
        },

        {
          label: 'Image',
          backgroundColor: 'rgba(206, 0, 23, 0.5)',
          data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
        },

        {
          label: 'Audio',
          backgroundColor: 'rgba(206, 0, 23, 0.2)',
          data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
        }, 

        {
          label: 'Html',
          backgroundColor: 'rgba(206, 0, 23, 0.6)',
          data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
        }, 

        {
          label: 'Video',
          backgroundColor: 'rgba(206, 0, 23, 0.95)',
          data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
        }, 

        {
          label: 'Font',
          backgroundColor: 'rgba(206, 0, 24, 0.5)',
          data: [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1]
        }]
    };





    var ctx = document.getElementById('sub2sub1chart').getContext('2d');
    var chartInstance = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        title: {
          display: false,
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

    $("#toggle21").click(function() {
        chartInstance.data.datasets.forEach(function(ds) {
        ds.hidden = !ds.hidden;
      });
      chartInstance.update();
    });
  
  

  })


}
 */
window.onload = function () {
  $.ajax({
    type: 'GET',
    url: 'chart2.php?chart2a =1',
    dataType: 'json',
    success: function success(response) {
      console.log(response);
      var chartData = JSON.parse(response);
      console.log(chartData);
      var chartOptions = {
        'height': 350,
        'title': 'List of continents by population (%)',
        'width': 1000,
        'fixPadding': 18,
        'barFont': [0, 12, "bold"],
        'labelFont': [0, 13, 0]
      };
      graphite(chartData, chartOptions, barChart);
    }
  });
};