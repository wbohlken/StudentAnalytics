$(document).ready(function () {
        $('.password-edit').click(function () {
            $('.password-edit-fields').show();
        });

        $('.counter').counterUp({
        time: 2500
    });
        $('.counter-fast').counterUp({
            time:1000
        });

        var estimated_risk = $('#traffic-light').attr('data-attr');
        if (estimated_risk < 33.33) {
            $('#stopLight').css('background-color', 'red');
            $('.text-trafficlight').text('Helaas, wij verwachten dat je het niet haalt..');
        } else if (estimated_risk > 33.33 && estimated_risk < 66.66) {
            $('#slowLight').css('background-color', 'orange');
            $('.text-trafficlight').text('Matig, doe nog even iets meer je best');
        } else {
            $('#goLight').css('background-color', 'green');
            $('.text-trafficlight').text('Goedzo, wij verwachten dat je het gaat halen');
        }

        // show disclaimer
        $(window).load(function(){
            if(getCookie('disclaimer') !== 'ok') {
                $('.disclaimer').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });

        //
        $('.ok-disclaimer').click(function() {
            $('.disclaimer').modal('hide');
            //set cookie
            createCookie('disclaimer', 'ok', 365);
        });

        function getCookie(name) {
            var value = "; " + document.cookie;
            var parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        function createCookie(name, value, days) {
            var date, expires;
            if (days) {
                date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                expires = "; expires="+date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = name+"="+value+expires+"; path=/";
        }
        $(function () {
            var data = $('#graph-grade').attr('data-attr');
            var datafrom = (parseFloat(data) - 2.7).toFixed(2);
            if (datafrom < 0) {
                datafrom = 0;
            }
            var datato = (parseFloat(data) + 2.7).toFixed(2);
            if (datato > 10) {
                datato = 10;
            }

            var gaugeOptions = {
                chart: {
                    spacing:[0,0,0,0],
                    margin:[0,0,0,0],
                    borderWidth:1,
                    borderColor: '',
                    type: 'gauge',
                    alignTicks: false,
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },

                title: {
                    text: null
                },

                tooltip: {
                    enabled: false
                },

                pane: {
                    startAngle: -90,
                    endAngle: 90,
                    background: null
                },
                plotOptions: {
                    gauge: {
                        dial: {
                            baseWidth: 2,
                            baseLength: '100%',
                            radius: '75%',
                            rearLength: 0
                        },
                        pivot: {
                            radius: 5
                        },
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                yAxis: [{
                    min: 0,
                    max: 10,
                    lineColor: null,
                    tickColor: null,
                    minorTickColor: null,
                    lineWidth: 2,
                    tickPositions: [datafrom, datato],
                    labels: {
                        style: {
                            color: '#3A3A3A',
                            fontWeight: 'normal'
                        }
                    },
                    offset: -40,
                    tickLength: 25,
                    minorTickLength: 15,
                    endOnTick: false,
                    plotBands: {
                        from: datafrom,
                        to: datato,
                        thickness: 50,
                        color: '#FFA500',
                        events: {
                            mouseenter: function(e) {
                                $('#tooltipholder-graph').html('Het cijfer zal tussen een ' + datafrom + ' en een ' + datato + ' liggen.');

                            },
                            mouseleave: function() {
                                $('#tooltipholder-graph').html('');
                            }
                        }
                    }
                }, {
                    min: 0,
                    max: 10,
                    lineColor: '#000',
                    lineColor: '#000',
                    tickColor: '#000',
                    minorTickColor: '#000',
                    lineWidth: 2,
                    minorTickPosition: 'inside',
                    tickLength: 25,
                    minorTickLength: 15,
                    labels: {
                        distance: 12,
                    },
                    offset: 0,
                    plotBands: [{
                        from: 6.6,
                        to: 10,
                        thickness: 25,
                        color: '#55BF3B'
                    }, {
                        from: 5.8,
                        to: 6.7,
                        thickness: 25,
                        color: {
                            linearGradient: {x1: 0, x2: 1, y1: 0, y2: 0},
                            stops: [
                                [0, '#DDDF0D'],
                                [1, '#55BF3B']
                            ]
                        }
                    }, {
                        from: 0,
                        to: 6,
                        thickness: 25,
                        color: {
                            linearGradient: {x1: 0, x2: 1, y1: 0, y2: 0},
                            stops: [
                                [0, '#ff0000'],
                                [1, '#DDDF0D']
                            ]
                        }
                    }]
                }]
            };
            var data2 = $('#graph-averagegrade').attr('data-attr');
            var data2from = (parseFloat(data2) - 2.7).toFixed(2);
            if (data2from < 0) {
                data2from = 0;
            }
            var data2to = (parseFloat(data2) + 2.7).toFixed(2);
            if (data2to > 10) {
                data2to = 10;
            }
            var gaugeOptions2 = {
                chart: {
                    spacing:[0,0,0,0],
                    margin:[0,0,0,0],
                    borderWidth:1,
                    borderColor: '',
                    type: 'gauge',
                    alignTicks: false,
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },

                title: {
                    text: null
                },

                tooltip: {
                    enabled: false
                },

                pane: {
                    startAngle: -90,
                    endAngle: 90,
                    background: null
                },
                plotOptions: {
                    gauge: {
                        dial: {
                            baseWidth: 2,
                            baseLength: '100%',
                            radius: '75%',
                            rearLength: 0
                        },
                        pivot: {
                            radius: 5
                        },
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                yAxis: [{
                    min: 0,
                    max: 10,
                    lineColor: null,
                    tickColor: null,
                    minorTickColor: null,
                    lineWidth: 2,
                    tickPositions: [data2from, data2to],
                    labels: {
                            style: {
                                color: '#3A3A3A',
                                fontWeight: 'normal'
                            }
                    },
                    offset: -40,
                    tickLength: 25,
                    minorTickLength: 15,
                    endOnTick: false,
                    plotBands: {
                        from: data2from,
                        to: data2to,
                        thickness: 50,
                        color: '#FFA500',
                        events: {
                            mouseenter: function(e) {
                                $('#tooltipholder-averagegraph').html('Het cijfer zal tussen een ' + data2from + ' en een ' + data2to + ' liggen.');

                            },
                            mouseleave: function() {
                                $('#tooltipholder-averagegraph').html('');
                            }
                        }
                    }
                }, {
                    min: 0,
                    max: 10,
                    lineColor: '#000',
                    lineColor: '#000',
                    tickColor: '#000',
                    minorTickColor: '#000',
                    lineWidth: 2,
                    minorTickPosition: 'inside',
                    tickLength: 25,
                    minorTickLength: 15,
                    labels: {
                        distance: 12,
                    },
                    offset: 0,
                    plotBands: [{
                        from: 6.6,
                        to: 10,
                        thickness: 25,
                        color: '#55BF3B'
                    }, {
                        from: 5.8,
                        to: 6.7,
                        thickness: 25,
                        color: {
                            linearGradient: {x1: 0, x2: 1, y1: 0, y2: 0},
                            stops: [
                                [0, '#DDDF0D'],
                                [1, '#55BF3B']
                            ]
                        }
                    }, {
                        from: 0,
                        to: 6,
                        thickness: 25,
                        color: {
                            linearGradient: {x1: 0, x2: 1, y1: 0, y2: 0},
                            stops: [
                                [0, '#ff0000'],
                                [1, '#DDDF0D']
                            ]
                        }
                    }]
                }]
            };


            // The speed gauge
            $('#graph-grade').highcharts(Highcharts.merge(gaugeOptions, {

                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Score',
                    data: JSON.parse("[" + data + "]"), //data
                    dataLabels: {
                        format: '<div style="text-align:center"><span style="font-size:25px; margin-top:10px; display:block;color:' +
                        ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                        '<span style="font-size:12px;color:silver"></span></div>'
                    },
                    tooltip: {
                        valueSuffix: ' '
                    }
                }]

            }));

            var data2 = $('#graph-averagegrade').attr('data-attr');
            $('#graph-averagegrade').highcharts(Highcharts.merge(gaugeOptions2, {
                yAxis: {
                    min: 0,
                    max: 10,
                    title: {
                        text: ''
                    }
                },

                credits: {
                    enabled: false
                },

                series: [{
                    name: 'Score',
                    data: JSON.parse("[" + data2 + "]"),
                    dataLabels: {
                        format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                        ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                        '<span style="font-size:12px;color:silver"></span></div>'
                    },
                    tooltip: {
                        valueSuffix: ' km/h'
                    }
                }]

            }));





        });
        $('.studentnumber-search').select2();
        $('.week-search').select2();
        $('.vooropl-search').select2();

    //
    //
    //    $(function () {
    //        var hash = window.location.hash;
    //
    //        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    //
    //        $('.nav-tabs a').click(function (e) {
    //            var hash = window.location.hash;
    //
    //            var weeknumber = hash.substring(5, hash.length);
    //            var studentnumber = getParameterByName('studentnumber');
    //
    //             $.ajax({
    //                type: 'GET',
    //                url: '',
    //                data: {week: weeknumber, studentnumber: studentnumber},
    //                beforeSend: function () {
    //                    // this is where we append a loading image
    //                    $('#ajax-panel').addClass('loading');
    //                },
    //                success: function (data) {
    //                    // successful request; do something with the data
    //                    $('#ajax-panel').empty();
    //                    $(data).find('item').each(function (i) {
    //                        $('#ajax-panel').append('<h4>' + $(this).find('title').text() + '</h4><p>' + $(this).find('link').text() + '</p>');
    //                    });
    //                },
    //                error: function () {
    //                    // failed request; give feedback to user
    //                    $('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
    //                }
    //            });
    //
    //        });
    //    });
    //
    //    function getParameterByName(name) {
    //    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    //    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    //        results = regex.exec(location.search);
    //    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    //}
});

