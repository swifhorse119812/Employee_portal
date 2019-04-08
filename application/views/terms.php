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
                            <h2>PAYMENT PROCESSING SERVICE AGREEMENT </h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url("home"); ?>">
                                       VIRSYMPAY.COM
                                    </a>
                                </li>
                                 
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="company-description" style="margin-top: 20px;">
            
            <div class="container">
                <div style="margin-bottom: 20px; text-align: right;">
                    <a class="btn btn-success" style="width: 150px;" href="<?php echo base_url("AcceptTerms/accept") ?>">Accept</a>
                </div>
                <iframe src="<?php echo base_url("terms.pdf") ?>" style="width: 100%; height: 800px;"></iframe>
            </div>
        </section>


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
                                <a href="<?php echo site_url("contact"); ?>" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s" data-wow-duration="500ms">Contact With Me</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
<?php 
    $this->load->view("footer");
?>  