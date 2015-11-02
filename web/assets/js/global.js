
function previewImage(input) {
    var url = input.val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    files = input.get(0).files;
    if (files && files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.img-preview img').attr('src', e.target.result);
        }

        reader.readAsDataURL(files[0]);
    }else{
         $('.img-preview img').attr('src', '/assets/img/avatar.png');
    }
}

$(document).ready( function() {
    
    $('.btn-confirm').click(function() {
    	$('#confirmModal .modal-body').html($(this).attr('title'));
    	$('#confirmModal .btn-danger').attr('href',$(this).attr('href'));
    	$('#confirmModal').modal('show');
    	return false;
    });
    
    $('.goto').click(function() {
    	window.location.href = $(this).attr('data-goto');
    });


    // Configuração de botões que utilizam POST
    var postHandler = function (event) {
        event.preventDefault();

        if ($(this).data('confirm')) {
            confirmModal.find('.modal-body').text($(this).data('confirm'));
            confirmModal.find('.modal-footer a.confirm').attr('href', $(this).attr('href'));
            confirmModal.modal();
            return;
        }

        var form = $('<form>');
        form.attr('action', $(this).attr('href'));
        form.attr('method', 'post');

        $("body").append(form);
        form.submit();
    }

    var confirmModal = $('<div class="modal "> \
                    <div class="modal-dialog"> \
                      <div class="modal-content">\
                        <div class="modal-header">\
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
                          <h4 class="modal-title">Confirmação</h4>\
                        </div>\
                        <div class="modal-body">\
                        </div>\
                        <div class="modal-footer">\
                          <a class="btn btn-default" data-dismiss="modal">Não</a>\
                          <a href="#" class="btn btn-primary confirm post-link">Sim</a>\
                        </div>\
                      </div>\
                    </div>\
                  </div>');

    $('body').on('click', '.post-link', postHandler);
    confirmModal.on('click', '.post-link', postHandler);
});