
(function($) {
  Drupal.behaviors.chart = {
    attach : function(context) {
      self = this;
      $('body').once('projectCharts', function(){
        self.buildCharts();
      });
    },

    buildCharts: function(){
      var charts = Drupal.settings.charts;
      _.each(charts, function(item, id){
        if (item.type == 'doughnut'){
          self.buildGraphDoughnut(id, item.data);
        }
        if (item.type == 'line'){
          self.buildGraphLine(id, item.data);
        }

        if (item.type == 'polarArea'){
          self.buildGraphPolarArea(id, item.data);
        }

      });  
    },
    buildGraphDoughnut: function(chartId, data){
      var ctx = document.getElementById("chart-" + chartId);

      Chart.defaults.global.defaultFontFamily = "'Raleway', Helvetica, Arial, sans-serif";

      var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: data.labels,
            datasets: [{
              data: data.data,
              backgroundColor: data.colors,
            }]
          },
          options: {
            legend: {
              position: 'top',
            },
            tooltips: {
            callbacks: {
              label: function(tooltipItem, data) {
                  //get the concerned dataset
                  var dataset = data.datasets[tooltipItem.datasetIndex];
                  //calculate the total of this data set
                  var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                    return Number(previousValue) + Number(currentValue);
                  });

                  //get the current items value
                  var currentValue = dataset.data[tooltipItem.index];
                  var currentLabel = data.labels[tooltipItem.index];
            
                  //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
                  var percentage = Math.floor(((currentValue / total) * 100)+0.5);
            
                  return " " + percentage + "% " + currentLabel;
                }
              }
            } 
          }
      });
    },

    buildGraphPolarArea: function(chartId, data){
      var ctx = document.getElementById("chart-" + chartId);

      Chart.defaults.global.defaultFontFamily = "'Raleway', Helvetica, Arial, sans-serif";

      var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
          labels: data.labels,
          datasets: [{
            data: data.data,
            backgroundColor: data.colors,
          }]
        },
        options: {
          legend: {
            position: 'top',
            padding: 20,
          },
          scale: {
            ticks: {
              suggestedMin: 0,
              suggestedMax: 100,
            }
          },
          layout: {
            padding: {
              bottom: 10,
            }
          },
          tooltips: {
            callbacks: {
              label: function(tooltipItem, data) {
                //get the concerned dataset
                var dataset = data.datasets[tooltipItem.datasetIndex];
                //calculate the total of this data set
                var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                  return Number(previousValue) + Number(currentValue);
                });

                //get the current items value
                var currentValue = dataset.data[tooltipItem.index];
                var currentLabel = data.labels[tooltipItem.index];
          
                //calculate the precentage based on the total and current item, also this does a rough rounding to give a whole number
                var percentage = Math.floor(((currentValue / total) * 100)+0.5);
          
                return " " + percentage + "% " + currentLabel;
              }
            }
          } 
        }
      });
    }
  };
})(jQuery);