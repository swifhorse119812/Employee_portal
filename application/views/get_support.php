<?php 
    $this->load->view("header");
?>        
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/froala_editor.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/froala_style.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/code_view.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/colors.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/emoticons.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/image_manager.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/image.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/line_breaker.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/table.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/char_counter.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/video.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/fullscreen.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/file.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/editor/css/plugins/quick_insert.css"); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
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
      .bootstrap-select{
        width: 700px !important;
      }
      .bootstrap-select button{
        height: 40px;
      }
      .filter-option{
        line-height: 27px;
      }
      .bootstrap-select .dropdown-menu{
        background: white;
      }
      .panel-body{
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 20px;
      }
      .menu-content li{
        height: 30px;
        line-height: 30px;
        cursor: pointer;
      }
      .nav-li-active{
        background: #e0e0e0;
        padding-left: 10px
      }
      .sub-menu li{
        padding-left: 10px

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
                            <h2>How may we help you?</h2>
                            <div class="col-md-12">
                              <div class="form-group">
                                <select id="question" name="question" class="selectpicker" data-live-search="true" style="width: 100%;">
                                  <option></option>
                                  <?php
                                    $tags = get_rows("help_tag");
                                    foreach ($tags as $key => $tag) {
                                      echo '<optgroup label="'.$tag['title'].'">';
                                      $tickets = get_rows("help_ticket",array("tag_id"=>$tag['id']));
                                      foreach ($tickets as $ticket) {
                                        echo '<option value="'.$ticket['id'].'">'.$ticket['title'].'</option>';
                                      }
                                      echo '</optgroup>';
                                    }
                                  ?>

                                </select>
                              </div>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?php echo base_url("account/dashboard"); ?>">
                                        <i class="ion-ios-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="active">Help</li>
                                <li class="active">Get Support</li>
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
<section class="company-description">
    <div class="container">
        <div class="row">
             <div class="col-md-4"  style="padding: 10px; min-height: 500px;">
               <div class="panel-body">
                 <div class="menu_section">
                  <ul id="menu-content" class="menu-content collapse in">
                    <?php
                      $tags = get_rows("help_tag",array(),"title ASC");
                      $ok = 0;
                      foreach ($tags as $key => $tag) {
                    ?>
                    <li  data-toggle="collapse" data-target="#sub_menu_<?php echo $tag['id']; ?>" class="collapsed">
                      <a href="#"> <?php echo $tag['title'] ?><span class="fa fa-chevron-down pull-right"></span></a>
                    </li>
                    <ul class="sub-menu collapse in <?php if($ok == 0) echo "in"; ?>" id="sub_menu_<?php echo $tag['id']; ?>" style="">
                      <?php
                        $tickets = get_rows("help_ticket",array("tag_id"=>$tag['id']));
                        foreach ($tickets as $ticket) {
                          $ok++;
                          if($ok == 1)
                          echo '<li  class="nav-li-active" data-target="#ticket'.$ticket['id'].'" data-toggle="tab">'.$ticket['title'].'</li>';
                        else 
                          echo '<li data-target="#ticket'.$ticket['id'].'" data-toggle="tab">'.$ticket['title'].'</li>';

                        }
                      ?>
                    </ul>
                    <?php } ?>
                  </ul>


                 </div>
               </div>
             </div>
             <div class="col-md-8" style="padding: 10px;">
               <div class="panel-body">
                 <div class="tab-content">
                    <?php 
                        $tickets = get_rows("help_ticket");
                        foreach ($tickets as $key => $ticket) {
                          $tag = get_row("help_tag",array("id"=>$ticket['tag_id']));
                    ?>
                    <div class="tab-pane" id="ticket<?php echo $ticket['id']; ?>">
                      <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li class="active">Help Desk</li>
                            <li class="active"><?php echo $tag['title']; ?> </li>
                        </ol>

                      </div>
                      <div style="text-align: center;border-bottom: 3px double  #ccc;">
                        <img src="<?php echo base_url("assets/client_assets/images/logo.png"); ?>" alt="" style="height: 100px;">
                      </div>
                      <div class="col-md-12" style="font-size: 24px;margin-bottom: 20px;border-bottom: 1px solid #e2e2e2;margin-top: 22px;">
                        <?php 
                          echo $ticket['title'];
                        ?>
                      </div>
                      <div class="answer-body">
                        <div class="question-body fr-element fr-view">
                          <?php 
                            echo $ticket['content'];
                          ?>
                        </div>
                      </div>
                    </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
        </div>
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

 
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/froala_editor.min.js"); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/align.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/char_counter.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/code_beautifier.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/code_view.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/colors.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/draggable.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/emoticons.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/entities.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/file.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/font_size.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/font_family.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/fullscreen.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/image.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/image_manager.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/line_breaker.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/inline_style.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/link.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/lists.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/paragraph_format.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/paragraph_style.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/quick_insert.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/quote.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/table.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/save.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/url.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/editor/js/plugins/video.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js?v=2.1.1"); ?>"></script>

<script type="text/javascript">

    $(function(){
        
        $("body").on("click",".menu_section .sub-menu li",function(){
          $(".nav-li-active").removeClass("nav-li-active");
          $(this).addClass("nav-li-active");
        })

        var id = $(".nav-li-active").data("target")      
        $(id).addClass("active");
        
        $("body").on("change","#question",function(){
          id = $(this).val();
          $("li[data-target='#ticket"+id+"']").click();
        })

    })

</script>

            