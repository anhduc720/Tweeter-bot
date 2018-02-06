$(document).ready(function() {

    $(".loader").fadeOut("slow");

    $('button#btnSubmit').click(function(e) {
        e.preventDefault();
        var idForm = $(this).attr('aria-form');
        var form = new FormData(document.getElementById(idForm));
        
        var action = $('form#' + idForm).attr('action');
        //console.log(form);
            var local     = window.location.href;
            var pos       = local.indexOf('index.php');
            if(pos == '-1'){
                img = local + 'application/views/img/ajax-loader.gif';
            } else {
            var deleteUrl = local.substr(pos, local.leng);
            var img       = local.replace(deleteUrl, 'application/views/img/ajax-loader.gif');
            }

            $(this).after('<p class="text-center"><img class="img-responsive" id="ajax-loader" src="'+img+'"></p>');
        
        formAjax(action, form, idForm);
    });

    $('a#btn-authorization').click(function(e){
        e.preventDefault();
        var url = $(this).attr('aria-url');
        //alert(url);
        $.ajax({
            url: url,
            type: 'POST',
            data: {accept: true},
            beforeSend: function(){
                $('a#btn-authorization').text('Loading...');
            }
        }).done(function(r){
            window.location = r;
        });
    });

    $('a#btn-update').click(function(e){
        e.preventDefault();
        id = $(this).attr('aria-id');
        url = $(this).attr('aria-url');
                $.ajax({
            url: url,
            type: 'POST',
            data: {id: id},
            beforeSend: function(){
                $(this).text('Loading...');
            }
        }).done(function(r){
            $(this).text('Update');
            if(r){
                alert("Updated succesfully");
            location.reload();
            } else {
                alert("There's been a problem. Try again.");
            }
        });
    });



    $('a#btnDelete').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('aria-id');
        var action = $(this).attr('aria-action');
        //alert(id+action);
        delete_record(id, action);
    });

    });


function delete_record(id, action) {
    var x = confirm('Do you want to delete this record?');
    if (x) {
        $.ajax({
            url: action,
            type: 'POST',
            data: { id: id },
        }).done(function(r) {
            if (!r) {
                alert("There was a problem deleting this record");
            } else {
                location.reload();
            }

        });
    }
}





function formAjax(action, form, idForm) {
    var posicion = $('form#'+ idForm + ' #message').offset().top;
    $.ajax({
        url: action,
        type: 'POST',
        data: form,
        contentType: false,
        processData: false,
        cache: false,
          beforeSend: function(){
            var local     = window.location.href;
            var pos       = local.indexOf('index.php');
            if(pos == '-1'){
                img = local + 'application/views/img/ajax-loader.gif';
            } else {
            var deleteUrl = local.substr(pos, local.leng);
            var img       = local.replace(deleteUrl, 'application/views/img/ajax-loader.gif');
            }

           
        }
    }).done(function(r) {
        $('img#ajax-loader').slideUp('slow');
        $('html, body').animate({
            scrollTop: posicion - 20
        }, 2000);
        $('form#'+idForm+' #message').slideDown('slow');
        $('form#'+idForm+' #message').html(r);
    }); /*END ajax*/
}

