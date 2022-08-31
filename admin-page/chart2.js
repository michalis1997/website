window.onload=function(){

  var barChartData;
  var barChartDataGlobal =[];


  fetch("a.php?chart2a=1", {
    method: 'GET',
    headers: new Headers ({
        'Content-Type': 'application/x-www-from-urlencoded'
    })
  })
  .then( response => response.json())
  .then( data => {
  
    console.log(data);

    re =  /\d+(?=:)/;

    /*
    data.forEach(element => {

      console.log(element['hour'].match(re)[0]);
      //console.log(element['response_time']);
      barChartDataGlobal.push(element['hour'].match(re)[0])
    });
    console.log(barChartDataGlobal);
    */
    

    data.forEach(element => {

      barChartData = {
        

        labels: [00, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
        datasets: [
          {
            label: 'Application',
            backgroundColor: 'rgba(206, 0, 23, 1)',
            data: [ element['response_time'],  element['response_time']  ] 
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

    })

  }).then( datas => {

    console.log(barChartData);
    
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
