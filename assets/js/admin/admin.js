$('document').ready(function(){

 if( typeof ($.fn.DataTable) === 'undefined'){ return; }
	 
	editor = new $.fn.dataTable.Editor( {
        ajax: BASE_URL+"user/get_admin",
        table: "#admin_table",
        fields: [ 
        	{
                label: "Name:",
                name:  "name"
            }, 
            {
                label: "Email:",
                name:  "email",

            }, 
	        {
	            label: "Password:",
	            name:  "password",
	            type:  "password"

	        }, 
	        {
	            label: "Confirm Password:",
	            name:  "con_password",
	            type:  "password"

	        }, 
            {
                label: "Birth Day:",
                name:  "birthday"
                
            } ,
            {
                label: "Gender:",
                name:  "gender",
                type:  "radio",
                options: [
                    { label: "Male", value: 1 },
                    { label: "Female",  value: 2 }
                ],
                def: 1
            },
          
            {
                label: "Roll:",
                name:  "roll",
                type:"radio",
                options: [
                	{ label: "Suspend",  value: 0 },
                    { label: "Super Admin", value: 1 },
                    { label: "Admin",  value: 2 }
                    
                ],
                def: 1
            } 
        ] 
    } );


    editor1 = new $.fn.dataTable.Editor( {
        ajax: BASE_URL+"user/get_admin",
        table: "#admin_table",
        fields: [ 
        	{
                label: "Name:",
                name:  "name"
            }, 
            {
                label: "Email:",
                name:  "email",

            }, 
	       
            {
                label: "Birth Day:",
                name:  "birthday"
                
            } ,
            {
                label: "Gender:",
                name:  "gender",
                type:  "radio",
                options: [
                    { label: "Male", value: 1 },
                    { label: "Female",  value: 2 }
                ],
                def: 1
            },
            {
                label: "Creation date:",
                name:  "date",
                type:"hidden"
            } ,
            {
                label: "Roll:",
                name:  "roll",
                type:"radio",
                options: [
                	{ label: "Suspend",  value: 0 },
                    { label: "Super Admin", value: 1 },
                    { label: "Admin",  value: 2 }
                    
                ],
                def: 1
            } 
        ] 
    } );

         

     editor.on( 'preSubmit', function ( e, o, action ) {
        if ( action !== 'remove' ) {
            var name = this.field( 'name' );
            var email = this.field( 'email' );
            var password = this.field( 'password' );
            var con_password = this.field( 'con_password' );
            var birthday = this.field( 'birthday' );
 
           if ( ! name.isMultiValue() ) {
                if ( ! name.val() ) {
                    name.error( 'A name must be given' );
                }
                 
                if ( name.val().length >= 20 ) {
                    name.error( 'The name length must be less that 20 characters' );
                }
            }

            if ( ! email.isMultiValue() ) {
            	ok = 0;
            	$('.email').each(function(){
            		if($(this).text() == email.val()) ok = 1;
            	})
            	if(ok == 1) email.error("Thie email is exists already.");

                if ( ! email.val() ) {
                    email.error( 'A email must be given' );
                }
    			if(!/\S+@\S+\.\S+/.test(email.val()))email.error("Please enter a valid email address.");

            }
 

 			if ( ! password.isMultiValue() ) {
				
				// if(!/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/.test(password.val()))
				// 	password.error("'<li><span >Your password must be a minimum of eight characters, no email address and must include charcacters from at least three of the following categories: <ul> <li>Uppercase letters</li>  <li>Lowercase letters</li><li>Numbers (0 to 9)</li><li>Special characters (@, !, #, $, %, &amp;, *, ?, _, -, .)</li></ul></span></li>'");
				if ( ! password.val() ) {
                    password.error( 'A email must be given' );
                }
                if ( password.val().length < 6 ) {
                    password.error( 'Your password must be a minimum of six characters' );
                }
            }

            if ( ! con_password.isMultiValue() ) {
				
				// if(!/^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/.test(password.val()))
				// 	password.error("'<li><span >Your password must be a minimum of eight characters, no email address and must include charcacters from at least three of the following categories: <ul> <li>Uppercase letters</li>  <li>Lowercase letters</li><li>Numbers (0 to 9)</li><li>Special characters (@, !, #, $, %, &amp;, *, ?, _, -, .)</li></ul></span></li>'");
				if ( ! con_password.val() ) {
                    con_password.error( 'A email must be given' );
                }
                if ( con_password.val()!=password.val() ) {
                    con_password.error( 'The passwords you entered do not match' );
                }
            }
            if ( ! birthday.isMultiValue() ) {
                if ( ! birthday.val() ) {
                    birthday.error( 'A birthday must be given' );
                }
                 
                 // if(!/^\d\d[./-]\d\d[./-]\d\d\d\d$/.test(birthday.val())){
                 // 	birthday.error("You must enter correct date");
                 // }
            }

            // ... additional validation rules
 
            // If any error was reported, cancel the submission so it can be corrected
            if ( this.inError() ) {
                return false;
            }
        }
    } );

    $('#admin_table').DataTable( {
        ajax: BASE_URL+"user/get_admin",
        columns: [
            { data: "name" , class: "editable"},
            { data: "email" , class: "email"},
            { data: "birthday", class: "editable" },
            {
                data: "gender",
                "render": function (val, type, row) {
                    return val == 1 ? "Male" : "Female";
                }, class: "editable"
            },
            { data: "date", class: "editable" },
            {
                data: "roll",
                "render": function (val, type, row) {
                    if(val ==1) return "Super Admin";
                    if(val==2) return "Admin";
                    if(val==0) return "Suspend";
                }
            },
            {
                data: null,
                defaultContent: '<a href="#" class="btn btn-danger btn-xs edit"><i class="fa fa-edit"></i> Edit</a> <a href="#" class="remove btn btn-primary btn-xs"><i class="fa fa-trash"></i> Remove</a>',
                orderable: false, class: "right"
            },
        ] 
    } );

 	$('#admin_table').on( 'click', 'a.remove', function (e) {
        editor
            .title( 'Remove Admin' )
            .message( 'Are you sure you wish to remove this admin?' )
            .buttons( { "label": "Delete", "fn": function () { editor.submit() } } )
            .remove( $(this).closest('tr') );
    } );

    $('#admin_table').on('click', 'a.edit', function (e) {
        e.preventDefault();
        editor1.edit( $(this).closest('tr'), {
            title: 'Edit Admin',
            buttons: 'Update'
        } );
    } );

       
    $('#createNew').on( 'click', function () {
        editor
            .title( 'Create new Admin' )
            .buttons( { "label": "Add", "fn": function () { editor.submit() } } )
            .create();
    } );
	
	// $("body").on("change","input[type='radio']",function(){
	// 	id = $(this).closest("tr").data("id");
	// 	roll = $(this).val();
	// 	$.ajax({
	// 		url:BASE_URL+"user/changeRoll",
	// 		data:{"idUser":id,"roll":roll},
	// 		dataType:'json',
	// 		type:"post",
	// 		success:function(res){
	// 		 	if(res.result == "ok"){
	// 		 		 $('body').append('<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-success animated fadeInDown" role="alert" data-notify-position="top-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 2000; top: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 2002;" data-dismiss="alert">×</button><span data-notify="icon"></span> <span data-notify="title"><strong></strong></span> <span data-notify="message">Successly Process !</span><a href="#" target="_blank" data-notify="url"></a></div>');
 //                     setTimeout(function(){
 //                        $('.alert-success').fadeOut(500);
 //                        $('.alert-success').remove();

 //                     },5000)
	// 		 	}
	// 		}
	// 	})

	// })
})