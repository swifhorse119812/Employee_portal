 
$(document).ready(function() {

    

     // if($settingType == "category") $setting_title = "Category";
     //                if($settingType == "degree") $setting_title = "Education and degrees";
     //                if($settingType == "language") $setting_title = "Lanuages";
     //                if($settingType == "typewriting") $setting_title = "Type of writing";

// ------------- category --------------------------------------------
    
    editor_category = new $.fn.dataTable.Editor( {
            ajax: BASE_URL+"translations/getTranslate",
            table: "#category_list",
            fields: [ {
                    label: "Source Text:",
                    name:  "source_text"
                }, 
                {
                    label: "Translation:",
                    name:  "translation"
                }, 
                {
                    label: "No:",
                    name:  "no",
                    type:"hidden"
                }
            ] 
        } );
         
       
 
 
    $('#createNew').on( 'click', function () {
        editor_category
            .title( 'Create new row' )
            .buttons( { "label": "Add", "fn": function () { editor_category.submit() } } )
            .create();
    } );
 
    // $('#category_list').on( 'click', 'tbody td', function (e) {
    //     if ( $(this).index() < 6 ) {
    //         editor_category.bubble( this );
    //     }
    // } );

    //  $('#category_list').on( 'click', 'tbody td:not(.child), tbody span.dtr-data', function (e) {
    //     // Ignore the Responsive control and checkbox columns
    //     if ( $(this).hasClass( 'control' ) || $(this).hasClass('select-checkbox') ) {
    //         return;
    //     }
 
    //     editor_category.inline( this );
    // } );


    $('#category_list').on( 'dblclick', 'tbody td:not(:first-child)', function (e) {
        editor_category.inline( this, {
            onBlur: 'submit',
            submit: 'allIfChanged'
        } );
    } );
 

 
    $('#category_list').on( 'click', 'a.remove', function (e) {
        editor_category
            .title( 'Delete row' )
            .message( 'Are you sure you wish to delete this row?' )
            .buttons( { "label": "Delete", "fn": function () { editor_category.submit() } } )
            .remove( $(this).closest('tr') );
    } );
 

     $('#category_list').DataTable( {
            
            ajax: BASE_URL+"translations/getTranslate",
            columns: [
                { data: "no" },
                { data: "source_text" },
                { data: "translation" },
                 {
                    data: null,
                    defaultContent: '<a href="#" class="remove">Delete</a>',
                    orderable: false
                },
                
            ] 
        } );


} );