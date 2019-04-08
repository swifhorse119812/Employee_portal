var editor_category; // use a global for the submit and return data rendering in the examples
var editor_degree;
var editor_language;
var editor_typewriting;
var editor_experience;
 
$(document).ready(function() {

    $('body').on("change",".setup-input",function(){
        field = $(this).attr('name');
        value = $(this).val();

        if(field!="currency"&&!/^[+-]?(?=.)(?:\d+,)*\d*(?:\.\d+)?$/.test(value)){
            $(this).css('color','red');
        } else {
            $(this).css('color','inherit');
        }
        $.ajax({
            url:BASE_URL + "setting/changeSetting",
            data:{"field": field, "value":value},
            dataType: "json",
            type: "post",
            success: function(){

            }
        })
    })

     // if($settingType == "category") $setting_title = "Category";
     //                if($settingType == "degree") $setting_title = "Education and degrees";
     //                if($settingType == "language") $setting_title = "Lanuages";
     //                if($settingType == "typewriting") $setting_title = "Type of writing";

// ------------- category --------------------------------------------
    
    editor_category = new $.fn.dataTable.Editor( {
            ajax: BASE_URL+"Setting/getSettingList/category",
            table: "#category_list",
            fields: [ {
                    label: "Category:",
                    name:  "name"
                }, {
                    label: "Status:",
                    name:  "status",
                    type:  "radio",
                    options: [
                        { label: "Unactivate", value: 0 },
                        { label: "Activate",  value: 1 }
                    ],
                    def: 1
                },
                {
                    label: "No:",
                    name:  "no",
                    type:"hidden"
                }
            ]
        } );
         
        $('#category_list').DataTable( {
            dom: "Bfrtip",
            ajax: BASE_URL+"Setting/getSettingList/category",
            columns: [
                { data: "no" },
                { data: "name" },
                {
                    "data": "status",
                    "render": function (val, type, row) {
                        return val == 0 ? "Unactivate" : "Activate";
                    }
                }
            ],
            select: true,
            buttons: [
                { extend: "create", editor: editor_category },
                { extend: "edit",   editor: editor_category },
                { extend: "remove", editor: editor_category }
            ]
        } );

    $('body').on('click','.click-tab',function(){
        for(i=1; i<=5; i++){
            $('#tab_content'+i).html("");
        }
        idElement = $(this).find('a').attr('href');
        var th_title = "";
        var settingType = "";
        switch(idElement){
            case "#tab_content1": th_title = th_title_1; settingType = "category"; break;
            case "#tab_content2": th_title = th_title_2; settingType = "degree"; break;
            case "#tab_content3": th_title = th_title_3; settingType = "language"; break;
            case "#tab_content4": th_title = th_title_4; settingType = "typewriting"; break;
            case "#tab_content5": th_title = th_title_5; settingType = "experience"; break;
            break;

        }
        var ele = "";
        ele += '<table id="category_list" class="display table table-striped table-bordered bulk_action" style="width:100%">';
        ele += "<thead><tr><th style='width:200px; !important'>"+str_1+"</th><th>"+th_title+"</th><th>"+str_2+"</th></tr></thead>";
        ele += "</table>";
        $(idElement).html(ele);

        editor_category = new $.fn.dataTable.Editor( {
            ajax: BASE_URL+"Setting/getSettingList/"+settingType,
            table: "#category_list",
            fields: [ {
                    label: th_title + ":",
                    name:  "name"
                }, {
                    label: "Status:",
                    name:  "status",
                    type:  "radio",
                    options: [
                        { label: "Unactivate", value: 0 },
                        { label: "Activate",  value: 1 }
                    ],
                    def: 1
                },
                {
                    label: "No:",
                    name:  "no",
                    type:"hidden"
                }
            ]
        } );
         
        $('#category_list').DataTable( {
            dom: "Bfrtip",
            ajax: BASE_URL+"Setting/getSettingList/"+settingType,
            columns: [
                { data: "no" },
                { data: "name" },
                {
                    "data": "status",
                    "render": function (val, type, row) {
                        return val == 0 ? "Unactivate" : "Activate";
                    }
                }
            ],
            select: true,
            buttons: [
                { extend: "create", editor: editor_category },
                { extend: "edit",   editor: editor_category },
                { extend: "remove", editor: editor_category }
            ]
        } );

    })


    $('body').on("click",".action_btn",function(){
        flg = $(this).data('flg');
        id = $(this).closest('.row').data('api_id');
        obj = $(this).closest(".row");

        if(flg == "create") action_title = action_title_1+"?";
        if(flg == "edit") action_title = action_title_2+"?";
        if(flg == "remove") action_title = action_title_3+"?";
        $('#sure_btn').html(flg);
        $("#api_id").val(id);
        $("#flg").val(flg);

        api_key = "";
        api_secret = "";
        if(flg!="create"){
            api_key = obj.find(".api_key").val();
            api_secret = obj.find(".api_secret").val();
        }
        $('#api_key').val(api_key);
        $('#api_secret').val(api_secret);
        $('#action_title').html(action_title);
        
        $('#error').closest('.row').hide();
        $('#action_modal').modal();

    })

    $('body').on('click','#sure_btn',function(){

        api_key = $("#api_key").val();
        api_secret = $("#api_secret").val();
        var error = "";
        if(api_key=="") error += "API key have to entry correct value!<br/>";
        if(api_secret=="") error += "API secret have to entry correct value!<br/>";
        if(error!=""){
            $('#error').html(error);
            $('#error').closest('.row').fadeIn();
            return;
        }
        $.ajax({
            url: BASE_URL +"setting/actionGetway",
            dataType:"json",
            type:"post",
            data:{"api_key":api_key, "api_secret":api_secret, "api_id":$("#api_id").val(), "flg":$('#flg').val() },
            success:function(res){
                flg = $("#flg").val();
                obj = $('div[data-api_id="'+$("#api_id").val()+'"]');
                if(flg == "create"){
                    ele = "";
                    ele += '<div class="row" data-api_id="'+res.data['id']+'" style="margin-bottom: 20px;">';
                    ele += '    <div class="col-md-1" style="padding: 0px;">';
                    ele += '        <div style="margin-top:40px;" class="col-md-6">';
                    ele += '          <input type="radio" name="pay_gateway" class="with-gap setup-input" value="'+res.data['id']+'"> ';
                    ele += '        </div>';
                    ele += '        <div style="margin-top:40px;padding: 0px; text-align: right;" class="col-md-6">';
                    ele += '          <i class="fa fa-caret-left" style="color:#ccc"></i>';
                    ele += '        </div>';
                    ele += '    </div>  ';
                    ele += '    <div class="col-md-10" style="border-left: 1px solid #ccc; border-right: 1px solid #ccc">';
                    ele += '      <label>'+str_3+'</label>';
                    ele += '      <input type="text" class="api_key" title="'+res.data.api_key+'" value="'+res.data.api_key+'" style="width: 100%; cursor: pointer;" readonly="" > ';

                    ele += '      <label style="margin-top:10px;">'+str_4+'</label>';
                    ele += '      <input type="text" class="api_secret" title="'+res.data.api_secret+'" value="'+res.data.api_secret+'" style="width: 100%; cursor: pointer;" readonly="false" > ';
                    ele += '    </div>  ';
                    ele += '    <div class="col-md-1" style="padding-top: 20px; padding-left: 5px;">';
                    ele += '        <button class="btn btn-xs btn-info action_btn" style="width: 25px;" data-flg="edit" title="edit"><i class="fa fa-edit"></i></button>';
                    ele += '        <br/><br/>';
                    ele += '        <button class="btn btn-xs btn-warning action_btn" style="width: 25px;" data-flg="remove" title="remove"><i class="fa fa-trash"></i></button>';
                    ele += '    </div>';
                    ele += '  </div>';

                    $('#api_show').append(ele);
                }

                if(flg == "edit"){
                    obj.find(".api_key").val(api_key);
                    obj.find(".api_secret").val(api_secret);
                }
                if(flg == "remove"){
                    obj.remove();
                }

                $('button[data-dismiss="modal"]').click();
            }
        })
    })
} );