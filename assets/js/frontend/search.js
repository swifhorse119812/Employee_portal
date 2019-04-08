
var i = 0;
var mapajax = 0;
var markers = [];
//<![CDATA[
// this variable will collect the html which will eventually be placed in the side_bar
var side_bar_html = "";
//var img='images/mapIcons/marker_red.png';
var img = '<?php echo base_url(); ?>assets/images/mapIcons/map_car_red.png';
var yimg = '<?php echo base_url(); ?>assets/images/mapIcons/map_car_yellow.png';
// arrays to hold copies of the markers and html used by the side_bar
// because the function closure trick doesnt work there
var gmarkers = [];
var gicons = [];
// global "map" variable
var map = null;
gicons["red"] = new google.maps.MarkerImage(img,
    // This marker is 20 pixels wide by 34 pixels tall.
    new google.maps.Size(50, 50),
    // The origin for this image is 0,0.
    new google.maps.Point(0, 0),
    // The anchor for this image is at 9,34.
    new google.maps.Point(9, 34));

var iconImage = new google.maps.MarkerImage(img,
    // This marker is 20 pixels wide by 34 pixels tall.
    new google.maps.Size(20, 34),
    // The origin for this image is 0,0.
    new google.maps.Point(0, 0),
    // The anchor for this image is at 9,34.
    new google.maps.Point(9, 34));
var iconShadow = new google.maps.MarkerImage('images/mapIcons/shadow50.png',
    // The shadow image is larger in the horizontal dimension
    // while the position and offset are the same as for the main image.
    new google.maps.Size(37, 34),
    new google.maps.Point(0, 0),
    new google.maps.Point(9, 34));
// Shapes define the clickable region of the icon.
// The type defines an HTML &lt;area&gt; element 'poly' which
// traces out a polygon as a series of X,Y points. The final
// coordinate closes the poly by connecting to the first
// coordinate.
var iconShape = {
    coord: [9, 0, 6, 1, 4, 2, 2, 4, 0, 8, 0, 12, 1, 14, 2, 16, 5, 19, 7, 23, 8, 26, 9, 30, 9, 34, 11, 34, 11, 30, 12, 26, 13, 24, 14, 21, 16, 18, 18, 16, 20, 12, 20, 8, 18, 4, 16, 2, 15, 1, 13, 0],
    type: 'poly'
};
function showView(val) {
    $('.showlist' + val).toggle('');
    $('#show_model').hide();
    if (val == '6') {
        if ($("#minus_botton").css('display') == 'none') {
            $("#minus_botton").show();
            $("#plus_botton").hide();
            $("#show_model").hide();
        } else {
            $("#minus_botton").hide();
            $("#plus_botton").show();
        }
    }
}
jQuery(function () {
    var currencyrate = $('#currencyrate').val();
    var GMaxPrice = $('#GMaxPrice').val() * currencyrate;
    var GMinPrice = $('#GMinPrice').val() * currencyrate;
    var SMaxPrice = $('#SMaxPrice').val() * currencyrate;
    var SMinPrice = $('#SMinPrice').val() * currencyrate;
    var currencysym = $('#currencysym').val();

    $("body").on("change", "#category_id", function () {

        $("#main_cat_id option").css("display", "none");
        $("#main_cat_id option[data-cate='-1']").css("display", "");
        $("#main_cat_id option[data-cate='" + $("#category_id").val() + "']").css("display", "");


        $.ajax({
            url: base_url + "site/search/getCarType",
            dataType: "html",
            type: "post",
            data: { "category_id": $("#category_id").val() },
            beforeSend: function () {
                $("#show_loader").show();
            },
            success: function (res) {
                $("#show_car").html(res);
                // $('#show_model').hide();
            }
        })

        $.ajax({
            url: base_url + "site/search/getMoreFilter",
            dataType: "html",
            type: "post",
            data: { "category_id": $("#category_id").val() },
            success: function (res) {
                $("#show_filter").html(res);

                $("#plus_botton").show();
                $("#minus_botton").hide();

                $('.showlist6').hide('');
                // $('#show_model').hide();
                doAjax();
            },
            complete: function () {
                $("#show_loader").hide();

            }
        })
    });

    var infowindow = new google.maps.InfoWindow(
        {
            size: new google.maps.Size(150, 150)
        });

    $('.multi-switch').multiSwitch({
        functionOnChange: function ($element) {
            var name = $element.attr('name');
            if (($element).is(':checked') == true) {
                var value = 'Yes';
                $('.switch-circle').text('On');
            } else {
                var value = 'No';
                $('.switch-circle').text('Off');
            }
            doAjax();
        }
    });
    if ($('.multi-switch').is(':checked') == true) {
        $('.switch-circle').text('On');
    } else {
        $('.switch-circle').text('Off');
    }

    var seleced_date = $('#txtFromDate').val();
    seleced_date = seleced_date.split('/');
    seleced_date[1] = parseInt(seleced_date[1]) + 1;
    var daysToAdd = 0;
    $("#txtFromDate").datepicker({
        minDate: 0,
        onSelect: function (selected) {
            var dtMax = new Date(selected);
            dtMax.setDate(dtMax.getDate() + daysToAdd);
            var dd = dtMax.getDate();
            var mm = dtMax.getMonth() + 1;
            var y = dtMax.getFullYear();
            var dtFormatted = mm + '/' + dd + '/' + y;
            $("#txtToDate").datepicker("option", "minDate", dtFormatted);
            var checkin = $("#txtFromDate").val();

            $.ajax({
                type: 'POST',
                url: 'http://rentals.zoplay.com/renters_car/site/landing/get_checkin_time',
                data: { 'checkin': checkin },
                success: function (data) {
                    $('#pickup_time').html(data);
                }
            });
        }
    });
    if (seleced_date[2] == '' || seleced_date[2] == undefined) {
        $("#txtToDate").datepicker({

            minDate: 0,
            onSelect: function (selected) {
                var dtMax = new Date(selected);
                dtMax.setDate(dtMax.getDate() - daysToAdd);
                var dd = dtMax.getDate();
                var mm = dtMax.getMonth() + 1;
                var y = dtMax.getFullYear();
                var dtFormatted = mm + '/' + dd + '/' + y;
                $("#txtFromDate").datepicker("option", "maxDate", dtFormatted);
                var checkin = $("#txtFromDate").val();
                var checkout = $("#txtToDate").val();
                var pickup_time = $('#pickup_time').val();
                $.ajax({
                    type: 'POST',
                    url: 'http://rentals.zoplay.com/renters_car/site/landing/get_checkout_time',
                    data: { 'checkin': checkin, 'checkout': checkout, 'pickup_time': pickup_time },
                    success: function (data) {
                        $('#return_time').html(data);
                    }
                });
                doAjax();
            }
        });
    } else {
        $("#txtToDate").datepicker({
            minDate: new Date(seleced_date[2], seleced_date[0], seleced_date[1]),
            onSelect: function (selected) {
                var dtMax = new Date(selected);
                dtMax.setDate(dtMax.getDate() - daysToAdd);
                var dd = dtMax.getDate();
                var mm = dtMax.getMonth() + 1;
                var y = dtMax.getFullYear();
                var dtFormatted = mm + '/' + dd + '/' + y;
                $("#txtFromDate").datepicker("option", "maxDate", dtFormatted);
                var checkin = $("#txtFromDate").val();
                var checkout = $("#txtToDate").val();
                var pickup_time = $('#pickup_time').val();
                $.ajax({
                    type: 'POST',
                    url: 'http://rentals.zoplay.com/renters_car/site/landing/get_checkout_time',
                    data: { 'checkin': checkin, 'checkout': checkout, 'pickup_time': pickup_time },
                    success: function (data) {
                        $('#return_time').html(data);
                    }
                });
                doAjax();
            }
        });
    }
    if ($('#txtToDate').val() != '') {
        selectedDate1 = $("#txtFromDate").val();
        $("#txtToDate").datepicker("option", "minDate", selectedDate1);
    }
    w = $("body").width();
    $("#show_loader").css("left", ((w - 100) / 2) + "px");


    $(".filter-primary-item i").click(function () {
        $(this).prev().attr('checked', true);
    });

    $('#rst_btn').click(function () {
        $('.list_value').attr('checked', false);
        $('.room_type').attr('checked', false);
        $('.property_type').attr('checked', false);
        $('#main_cat_id').val('');
        $('#level1_sub_cat').val('');
        doAjax();
    });
    $('.drop4btn').click(function () {
        $(this).next().slideToggle();
    });

    $('.drop4btn').each(function () {
        $(this).next().css('display', 'none');
    });

    var min_price_start = $("#min_price_start").val() * 1;
    var maxprice = $("#maxPrice").val() * 1;
    maxMileage
    var options = {
        range: true,
        min: Math.floor(min_price_start),
        max: Math.ceil(maxprice),

        values: ['0', maxprice],
        change: function (event, ui) { doAjax(); },
        slide: function (event, ui) {
            var min = ui.values[0],
                max = ui.values[1];

            $("#amount_pricefilter1").val("$" + min);
            $("#amount_pricefilter2").val("$" + max);

            showProducts(min, max);
        }
    }, min, max;

    $("#slider-range").slider(options);

    min = $("#slider-range").slider("values", 0);
    max = $("#slider-range").slider("values", 1);


    $('#autocomplete').val('New York, NY, USA');

    var min_mileage_start = $("#min_mileage_start").val() * 1;
    var maxmile = $("#maxMileage").val() * 1;

    var options = {
        range: true,
        min: Math.floor(min_mileage_start),
        max: Math.ceil(maxmile),
        values: [0, maxmile],
        change: function (event, ui) { doAjax(); },
        slide: function (event, ui) {
            var min = ui.values[0],
                max = ui.values[1];

            $("#mileageFilter1").val("km " + min);
            $("#mileageFilter2").val("km " + max);

            showMileagePro(min, max);
        }
    }, min, max;


    $("#slider-range1").slider(options);

    min = $("#slider-range1").slider("values", 0);
    max = $("#slider-range1").slider("values", 1);

    $("#amount").val("km " + min + " - km " + max);

    showMileagePro(min, max);

    $('#autocomplete').val('New York, NY, USA');

    $("#main_cat_id option").css("display", "none");
    $("#main_cat_id option[data-cate='-1']").css("display", "");
    $("#main_cat_id option[data-cate='" + $("#category_id").val() + "']").css("display", "");

    $('.footer-toggle').click(function () {
        $(this).toggleClass('open');
        var className = $(this).attr('class');
        var res = className.split(" ");

        if (res[3] == 'open') {
            $('.map-footer').css('display', 'none');
        } else {
            $('.map-footer').css('display', 'block');
        }
        $('.map-footer').toggleClass('footerup');
    });

});
$(document).ajaxComplete(function () {

    $('.sidebar').scroll(function () {
        var listing_top = $('.filter-list').offset().top;
        var search_top = $('.header').offset().top;

        console.log(search_top);

        if (search_top >= listing_top) {
            $("#ui-datepicker-div").addClass("sample");
        }
        else {
            $("#ui-datepicker-div").removeClass("sample");
        }
    });
});
function doAjax() {
    if (mapajax == 0 || mapajax == 1) {
        city = $('#autocompleteNew').val();
    }
    else {
        city = '';
    }
    mapajax++;

    $(".similar-listing").css("opacity", "0.2");


    var category_id = $("#category_id").val();
    var pricemin = $("#minPrice").val();
    var pricemax = $("#maxPrice").val();
    var minMileage = $("#minMileage").val();
    var maxMileage = $("#maxMileage").val();
    var dateFrom = $("#txtFromDate").val();
    var dateTo = $("#txtToDate").val();
    var pickup_time = $("#pickup_time").val();
    var return_time = $("#return_time").val();
    var gueatsCount = $("#guests").val();
    var main_cat_id = $("#main_cat_id").val();
    var level1_sub_cat = $("#level1_sub_cat").val();
    $("#datefrom").val(dateFrom);
    $("#dateto").val(dateTo);
    $("#pickup_time1").val(pickup_time);
    $("#return_time1").val(return_time);

    var newProperty_type = "";
    $('.property_type:checked').each(function (i) {
        newProperty_type += $(this).val() + ",";
    });

    var newListvalue = "";
    $('.list_value:checked').each(function (i) {
        newListvalue += $(this).val() + ",";
    });

    if ($('.chk').is(':checked') == true) {
        var instantbook = '1';
    } else {
        var instantbook = '0';
    }

    var zoom = map.getZoom();
    var bounds = map.getBounds();
    var minLat = bounds.getSouthWest().lat();
    var minLong = bounds.getSouthWest().lng();
    var maxLat = bounds.getNorthEast().lat();
    var maxLong = bounds.getNorthEast().lng();
    var cLat = bounds.getCenter().lat();
    var cLong = bounds.getCenter().lng();

    // if(zoom != 13)
    // {
    //   $("#zoom").val(zoom);
    //   $("#minLat").val(minLat);
    //   $("#minLong").val(minLong);
    //   $("#maxLat").val(maxLat);
    //   $("#maxLong").val(maxLong);
    //   $("#cLat").val(cLat);
    //   $("#cLong").val(cLong);
    // }
    // else
    // {
    //   zoom = $("#zoom").val();
    //   minLat = $("#minLat").val();
    //   minLong = $("#minLong").val();
    //   maxLat = $("#maxLat").val();
    //   maxLong = $("#maxLong").val();
    //   cLat = $("#cLat").val();
    //   cLong = $("#cLong").val();
    // }

    $.ajax({
        url: base_url + '/site/search/mapViewAjax',
        type: "POST",
        data: {
            "category_id": category_id,
            "city": city,
            "pricemin": pricemin,
            "pricemax": pricemax,
            "minMileage": minMileage,
            "maxMileage": maxMileage,
            "checkin": dateFrom,
            "checkout": dateTo,
            "property_type": newProperty_type,
            'main_cat_id': main_cat_id,
            'level1_sub_cat': level1_sub_cat,
            "listvalue": newListvalue,
            "minLat": minLat,
            "minLong": minLong,
            "maxLat": maxLat,
            "maxLong": maxLong,
            "cLat": cLat,
            "cLong": cLong,
            'zoom': zoom,
            'instantbook': instantbook,
            "pickup_time": pickup_time,
            "return_time": return_time
        },
        beforeSend: function () {
            $("#show_loader").show();
        },
        success: function (data) {
            $("#ajax_map").html(data);
            setAllMap(null);
            markers = [];
            downloadUrl();
            $(".similar-listing").css("opacity", "none !important");
        }
    });
}
function setPagination(id) {
    $('#paginationId').val(id);
    doAjax();
}


function showProducts(minPrice, maxPrice) {
    var currency_r = 1.000;
    var newMin = Math.ceil(minPrice / currency_r);
    var newMax = Math.ceil(maxPrice / currency_r);
    $("#minPrice").val(newMin);
    $("#maxPrice").val(newMax);
    //doAjax();
}

function showMileagePro(minMileage, maxMileage) { //alert(minMileage); alert(maxMileage);

    $(".similar-listing li").hide();
    $('.similar-listing li').each(function () {

        var min_mileage = parseInt($(this).data("min_mileage"), 10);
        var max_mileage = parseInt($(this).data("max_mileage"), 10);

        if (min_mileage >= minMileage && max_mileage <= maxMileage)
            $(this).show();
    });

    var newMin = Math.ceil(minMileage);
    var newMax = Math.ceil(maxMileage);
    $("#minMileage").val(newMin);
    $("#maxMileage").val(newMax);

    /* if( $("#minPrice").val() !=0 && $("#minPrice").val() !='' && $("#maxPrice").val() !=0 && $("#maxPrice").val() !='')
    { */
    //showProducts($("#minPrice").val(), $("#maxPrice").val());
    /* } */
}

function getCarmodels(make_id) {
    if (make_id == '') {
        $('#show_model').hide('slow');
    } else {
        $('#show_model').show('slow');
    }
    $.ajax({
        type: 'POST',
        url: base_url + '/site/product/ajax_getCarmodels',
        data: { make_id: make_id },
        dataType: "html",
        success: function (response) {
            $('#loading_carmodel').css('display', 'none');
            $('#level1_sub_cat').html(response);
        }
    })
}


function getMarkerImage(iconColor) {
    if ((typeof (iconColor) == "undefined") || (iconColor == null)) {
        iconColor = "red";
    }
    if (!gicons[iconColor]) {
        gicons[iconColor] = new google.maps.MarkerImage(base_url + "assets/images/mapIcons/" + iconColor + ".png",
            // This marker is 20 pixels wide by 34 pixels tall.
            new google.maps.Size(50, 50),
            // The origin for this image is 0,0.
            new google.maps.Point(0, 0),
            // The anchor for this image is at 6,20.
            new google.maps.Point(9, 34));
    }
    return gicons[iconColor];
}

gicons["Vehicles"] = getMarkerImage("Vehicles");
gicons["Boats"] = getMarkerImage("Boats");
gicons["Motorcycle"] = getMarkerImage("Motorcycle");
gicons["Water_fun"] = getMarkerImage("Water_fun");

gicons["Vehicles_blue"] = getMarkerImage("Vehicles_blue");
gicons["Boats_blue"] = getMarkerImage("Boats_blue");
gicons["Motorcycle_blue"] = getMarkerImage("Motorcycle_blue");
gicons["Water_fun_blue"] = getMarkerImage("Water_fun_blue");
// A function to create the marker and set up the event window function
function createMarker(latlng, name, html, color, details, rid) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        icon: gicons[color],
        shadow: iconShadow,
        map: map,
        title: name,
        animation: google.maps.Animation.DROP,
        zIndex: 1
    });

    google.maps.event.addListener(map, 'idle', function (event) { });


    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(contentString);
        infowindow.open(map, marker);
    });
    // Switch icon on marker mouseover and mouseout
    google.maps.event.addListener(marker, "mouseover", function () {
        // marker.setIcon(gicons["red"]);
        marker.setZIndex(100);
    });
    google.maps.event.addListener(marker, "mouseout", function () {
        // marker.setIcon(gicons["blue"]);
        marker.setZIndex(1);
    });
    markers.push(marker);
    gmarkers.push(marker);
    // add a line to the side_bar html
    var marker_num = gmarkers.length - 1;
    //side_bar_html='<div class="map-areas"><ul class="similar-listing">'+side_bar_html;
    // side_bar_html=side_bar_html+'</ul></div>';
    side_bar_html += '<div onmouseover="gmarkers[' + marker_num + '].setIcon(gicons.' + color + '_blue' + ');gmarkers[' + marker_num + '].setZIndex(100);" onmouseout="gmarkers[' + marker_num + '].setIcon(gicons.' + color + ');gmarkers[' + marker_num + '].setZIndex(1);">' + details + '</div>';
}
// This function picks up the click and opens the corresponding info window
function myclick(i) {
    google.maps.event.trigger(gmarkers[i], "click");
}