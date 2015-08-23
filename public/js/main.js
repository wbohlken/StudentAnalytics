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


    $(function () {

        var gaugeOptions = {

            chart: {
                type: 'solidgauge'
            },

            title: 'Je verwachte cijfer',

            pane: {
                center: ['50%', '50%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#DF5353'], // red
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#55BF3B'] // green
                ],
                lineWidth: 0,
                minorTickInterval: null,
                tickPixelInterval: 400,
                tickWidth: 0,
                title: {
                    y: -70
                },
                labels: {
                    y: 16
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };
        var data = $('#graph-grade').attr('data-attr');

        // The speed gauge
        $('#graph-grade').highcharts(Highcharts.merge(gaugeOptions, {
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
                data: JSON.parse("[" + data + "]"), //data
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

        var data2 = $('#graph-risk').attr('data-attr');
        $('#graph-risk').highcharts(Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
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
                    '<span style="font-size:12px;color:silver">%</span></div>'
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

