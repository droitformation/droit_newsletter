var url  = location.protocol + "//" + location.host+"/";

$(function() {

    $( "#sortable" ).sortable({
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: url+ 'admin/campagne/sorting'
            });
        }
    });

});