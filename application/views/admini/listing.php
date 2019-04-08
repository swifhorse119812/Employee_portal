<?php
  $this->load->view("common/header.php");
?>
	<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Listing<small> by Clients </small></h3>
              </div>

             <!--  <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->
            </div>

            <div class="clearfix"></div>

            <div class="row">

			     <div class="col-md-6 col-sm-6 col-xs-6" style="min-height: 800px">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Listing member list</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
               
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                     <thead>
                        <tr>
                           <th>Image</th>
                           <th>Name</th>
                           <th>Birth Day</th>
                           <th>Email</th>
                           <th>Created Date</th>
                        </tr>
                      </thead>
                      <tbody id="order_list">
                      <?php 
                        foreach ($members as $key => $member_id) {
                          $member = $this->common_model->readData("member",array("id"=>$member_id));
                      ?>
                        <tr data-id="<?php echo $member['id']; ?>" style='cursor: pointer'>
                          <td class='click-td user-name'>
                            <?php echo $member['firstname']." ".$member['lastname']; ?>
                          </td>
                          <td class='click-td'>
                            <img style="width: 100px; height: 100px;" src="<?php echo base_url('assets/uploads/'.$member['imagename']); ?>">
                          </td>
                          <td class='click-td'>
                            <?php echo $member['birthday']; ?>
                          </td>
                          <td class='click-td'>
                            <?php echo $member['email']; ?>
                          </td>
                          <td class='click-td'>
                            <?php 
                              $date =  date_create($member['createdate']);
                              echo date_format($date,"M d, Y H:i:s");
                            ?>
                          </td>
                        </tr>
                      <?php
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6" style="min-height: 800px">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 id="client_name">Member's Listing</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="order_list_show">
                    <table id="member-table" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th> Category </th>
                          <th> Type </th>
                          <th> Title </th>
                          <th> Price </th>
                          <th> Location </th>
                          <th> Image </th>
                          <th> Listing Date </th>
                          <th> Status </th>
                        </tr>
                      </thead>
                      <tbody id="member_list">
                        <?php 
                          foreach ($cars as $key => $car) {
                        ?>
                        <tr class='click-tr' data-id="<?php echo $car['id']; ?>" style="cursor: pointer;">
                          <td>
                            <?php 
                              $category = $this->common_model->readData("category",array("id"=>$car['category_id']));
                              echo $category['name'];
                            ?>
                          </td>
                          <td>
                            <?php 
                              $types = explode(",", $car['typeids']);
                              foreach ($types as $key => $type) {
                                $type_data = $this->common_model->readData("cartype",array("id"=>$type));
                                $parent_data = $this->common_model->readData("cartype",array("id"=>$type_data['parent_id']));
                                if($parent_data['name'] == "Type") echo $type_data['name'];
                              }
                            ?>
                          </td>   
                          <td>
                            <?php echo $car['cartitle']; ?>
                          </td>
                          <td> $ 
                            <?php 
                                if($category['name'] == "Boats" || $category['name']=="Water fun"){
                                  echo $car['pricemonth'];
                                } else {
                                  echo $car['priceday'];
                                }
                             ?>
                          </td>
                          <td>
                            <?php echo $car['location']; ?>
                          </td>
                          <td>
                            <?php 
                              $car_imgs = explode("^", $car['carphotourl']);
                            ?>
                            <img src="<?php echo base_url('assets/images/car/'.$car_imgs[0]); ?>" style="width: 100px; height: 100px;">
                          </td>
                          <td>
                            <?php 
                              $date =  date_create($car['createdate']);
                              echo date_format($date,"M d, Y H:i:s");
                            ?>
                          </td>
                          <td>
                            <?php 
                              if($car['status'] == 2) echo "Rentaled";
                              else {
                                if($car['step']!=0) echo $car['step']." Steps to listing";
                                else echo "Pending Pay";
                              }
                            ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
          </div>
      </div>
 <div class="modal fade in" id="order_detail" aria-hidden="false" style="display: none;">
  
 </div>
 
<?php
	$this->load->view("common/footer.php");
?>

<script type="text/javascript">
  $('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
   
   
  var $datatable = $('#datatable-checkbox');

  // $datatable.dataTable({
  //   'order': [[ 1, 'asc' ]],
  // });
  // $datatable.on('draw.dt', function() {
  //   $('input[type="checkbox"]').iCheck({
  //   checkboxClass: 'icheckbox_flat-green'
  //   });
  // });

  $('#member-table').dataTable({
          'order': [[ 1, 'asc' ]],
  });

  // $('#datatable-checkbox_length').closest("div").removeClass("col-sm-6");
  obj = $('#datatable-checkbox_length').closest(".col-sm-6");
  obj.addClass("col-sm-5");

  obj = $('#member-table_length').closest(".col-sm-6");
  obj.addClass("col-sm-5");

  // TableManageButtons.init();
  $('body').on('click','.click-td',function(){
    $('.tr-active').removeClass("tr-active");
    obj = $(this).closest('tr');
    $(this).closest('tr').addClass("tr-active");
    id = $(this).closest('tr').data('id');
    $.ajax({
      url:BASE_URL+"admini/listing/showListing",
      data:{"id":id},
      dataType:'html',
      type:"post",
      success:function(res){
        $('#order_list_show').html(res);
        $('#member-table').dataTable({
          'order': [[ 1, 'asc' ]],
        });
        $('#client_name').html(obj.find(".click-td:first-child").html()+"'s Listing");
        obj = $('#member-table_length').closest(".col-sm-6");
        obj.addClass("col-sm-5");
      }
    })
    
  })

  // $('body').on("click",".click-tr",function(){
  //   id = $(this).data('id');
  //   $.ajax({
  //     url:BASE_URL+"order/orderDetail",
  //     data:{"idOrder":id},
  //     dataType:'html',
  //     type:"post",
  //     success:function(res){
  //        $('#order_detail').html(res);
  //        $('#order_detail').modal();
  //     }
  //   })
  // })
  
})

</script>

