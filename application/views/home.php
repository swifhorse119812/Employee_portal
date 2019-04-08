<?php 
    $this->load->view("header");
?>        
  <link rel="stylesheet" href="<?php echo base_url("assets/css/vendor.css?v=2.1.1"); ?>">

<style type="text/css">
    .fr-view{
        min-height: 150px !important;
    }
     .class1 {
        border-radius: 10%;
        border: 2px solid #efefef;
      }

      .class2 {
        opacity: 0.5;
      }
      #faq_table tbody tr{
        cursor: pointer;
      }
      .bootstrap-select .dropdown-menu{
        background: white;
      }
      .bootstrap-select{
        width: 100% !important;
      }
</style>

        <!-- 
        ================================================== 
            Global Page Section Start
        ================================================== -->
        <section class="global-page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <h2>virsympay reports</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url("home"); ?>">
                                        Reports
                                    </a>
                                </li>
                                 
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<!-- 
================================================== 
    Company Description Section Start
================================================== -->
<!-- <section class="company-description">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="pip_chart" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
                </div>
            </div>
            <div class="col-md-6">
                <div id="pip_chart_product" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 50px; margin-bottom: 20px;">
            <div style="height: 500px; border: 1px solid rgb(230, 230, 230);" id="chart_div">
            </div>
        </div>
    </div>
</section> -->

 
            <!--
            ==================================================
            Call To Action Section Start
            ================================================== -->
            <section id="call-to-action">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">SO WHAT YOU THINK ?</h1>
                                <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">All purchases with Virsympay are purchases of the Virsymcoin Cryptocurrency,<br/> we convert all purchases to the currency of your choice.</p>
                                <!-- <a href="<?php echo site_url("contact"); ?>" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a> -->
                                <a class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
<?php 
    $this->load->view("footer");
?> 

<script src="<?php echo base_url("assets/code/highstock.js"); ?>"></script>
<script src="<?php echo base_url("assets/code/modules/exporting.js"); ?>"></script>
<script src="<?php echo base_url("assets/code/modules/export-data.js"); ?>"></script>
<script type="text/javascript">
    $(function(){

$.getJSON('<?php echo base_url("home/get_chart_data"); ?>', function (data) {

// $.getJSON('https://www.highcharts.com/samples/data/aapl-c.json', function (data) {
    // Create the chart
    Highcharts.stockChart('chart_div', {


        rangeSelector: {
            buttons: [{
                type: 'day',
                count: 1,
                text: '1D'
            }, {
                type: 'week',
                count: 1,
                text: '1W'
            }, 
      {
                type: 'month',
                count: 1,
                text: '1M'
            }, 
      {
                type: 'all',
                count: 1,
                text: 'All'
            }],
            selected: 1,
            inputEnabled: true
        },

        title: {
            text: 'Trasactions on Virsympay'
        },
    
      series: [{
            name: 'Gross Price',
            data: data,
            type: 'areaspline',
            threshold: null,
            tooltip: {
                valueDecimals: 2
            },
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            }
        }]
    });
});
 
$.getJSON('<?php echo base_url("home/get_pipe_transction_data"); ?>', function (data) {

  // Build the chart
  Highcharts.chart('pip_chart', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Trasactions Status on Virsympay'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  },
                  connectorColor: 'silver'
              }
          }
      },
      series: [{
          name: 'Share',
          data:  data
      }]
  });


});


$.getJSON('<?php echo base_url("home/get_product_transction"); ?>', function (data) {

  // Build the chart
  Highcharts.chart('pip_chart_product', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Product Sold Status'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                  },
                  connectorColor: 'silver'
              }
          }
      },
      series: [{
          name: 'Share',
          data:  data
      }]
  });

  
});



    })
</script>
 