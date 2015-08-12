$(document).ready(function () {
    $('.password-edit').click(function () {
        $('.password-edit-fields').show();
    });
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

