// var promoTexts = [{
//     "caption": "Variety of configurable motion paths for carousel objects.",
//     "description": "Use pre-configured motion paths - parabola, ellipses, spiral, and more. Or define custom ones using cubic Bezier curves."
// }, {
//     "caption": "Responsive layout with auto scaling capability.",
//     "description": "Pixel-perfect look on a screen of any size."
// }, {
//     "caption": "Support for key board, mouse and touch.",
//     "description": "With physical parameters properly adjusted, it looks and feels just perfect on any device."
// }]

function motionStart(e, data) {
    $(".title, .description", this).hide().removeClass('animated fadeInRight fadeInLeft');
}

function motionEnd(e, data) {

    var promo = promoTexts[data.index % promoTexts.length];
    $(".title, .description", this).show();

    $(".title", this).text(promo.caption).addClass('animated fadeInRight');
    $(".description", this).text(promo.description).addClass('animated fadeInLeft');
}

function carouselCreated(e, data) {
    motionEnd.call(this, e, data);

    $('.popup-link').click(function(e) {
        var $this = $(this);
        var html = Mustache.to_html($('#popupLayout').html(), $(this).data("content"));
        $('#popup').html(html);

        $('#popup').popup({
            closeelement: ".fa-close",
            transition: 'all 0.3s'
        }).popup('show');
    });
}

$(document).ready(function() {

    var container = $('#container');

    // fade in effect
    container.css({
        opacity: 0
    });
    container.delay(500).animate({
        opacity: 1
    }, 500);

    container.theta_carousel({
        "filter": ".ex-item",
        "selectedIndex": 15,
        "distance": 90,
        "numberOfElementsToDisplayRight": 6,
        "numberOfElementsToDisplayLeft": 6,
        "designedForWidth": 1920,
        "designedForHeight": 885,
        "distanceInFallbackMode": 820,
        "path": {
            "settings": {
                "shiftZ": -230,
                "width": 2300,
                "depth": 340,
                "xyPathBezierPoints": {
                    "p1": {
                        "x": -100,
                        "y": 0
                    },
                    "p2": {
                        "x": 0,
                        "y": 0
                    },
                    "p3": {
                        "x": 0,
                        "y": 0
                    },
                    "p4": {
                        "x": 100,
                        "y": 0
                    }
                },
                "xyArcLengthBezierPoints": {
                    "p1": {
                        "x": 0,
                        "y": 0
                    },
                    "p2": {
                        "x": 100,
                        "y": 10
                    },
                    "p3": {
                        "x": 0,
                        "y": 90
                    },
                    "p4": {
                        "x": 100,
                        "y": 100
                    }
                },
                "xzPathBezierPoints": {
                    "p1": {
                        "x": -100,
                        "y": 50
                    },
                    "p2": {
                        "x": 0,
                        "y": 0
                    },
                    "p3": {
                        "x": 0,
                        "y": 0
                    },
                    "p4": {
                        "x": 100,
                        "y": 50
                    }
                }
            },
            "type": "cubic_bezier"
        },
        "sensitivity": 0.5,
        "allignElementsWithPath": true,
        "allignElementsWithPathCoefficient": -2,
        "shadow": true,
        "shadowBlurRadius": 165,
        "shadowSpreadRadius": -13,
        "fadeAway": true,
        "fadeAwayBezierPoints": {
            "p1": {
                "x": 0,
                "y": 100
            },
            "p2": {
                "x": 65,
                "y": 100
            },
            "p3": {
                "x": 90,
                "y": 100
            },
            "p4": {
                "x": 100,
                "y": 0
            }
        },
        "rotation": true,
        "rotationBezierPoints": {
            "p1": {
                "x": 0,
                "y": 0
            },
            "p2": {
                "x": 50,
                "y": 0
            },
            "p3": {
                "x": 50,
                "y": 0
            },
            "p4": {
                "x": 100,
                "y": 10
            }
        },
        "rotationVectorY": 0.3,
        "sizeAdjustment": true,
        "sizeAdjustmentBezierPoints": {
            "p1": {
                "x": 0,
                "y": 100
            },
            "p2": {
                "x": 30,
                "y": 70
            },
            "p3": {
                "x": 70,
                "y": 70
            },
            "p4": {
                "x": 100,
                "y": 60
            }
        },
        "popoutSelected": true,
        "popoutSelectedShiftZ": 50
    });
    carouselCreated.call(container, null, {
        index: container.theta_carousel("option", "selectedIndex")
    });
    container.on('motionStart', motionStart);
    container.on('motionEnd', motionEnd);
});