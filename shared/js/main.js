$(function () {
    //image colorbox
    if ($('.cbox_single').length) {
        $('.cbox_single').colorbox({
            maxWidth: '80%',
            maxHeight: '80%',
            opacity: '0.2',
            fixed: true
        });
    }     
    //SETUP VALIDACIÓN
    jQuery.validator.setDefaults({
        rules: {
            vali: "required",
            pass: {
                minlength: 5
            },
            repeat_password: {
                equalTo: "form#form-signin #pass"
            },
            repeat_pass: {
                equalTo: "form#form-resetpass #pass"
            },            
            email: {
                email: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (label, element) {
            if (element.is(':radio')) {
                element.closest('table').closest('td').append(label);
            } else {
                label.insertAfter(element);
            }
            if (element.parent('.input-group').length) {
                label.insertAfter(element.parent());
            } else {
                label.insertAfter(element);
            }
        }
    });
    $.fn.resetFields = function () {
        $(this).find("input[type=hidden][name=id]").val("");
        $(this).find("input[type=email],input[type=text], input[type=password], textarea, select").val("");
        $(this).find('input[type=checkbox], input[type=radio]').prop('checked', false);
        $(this).find('.form-group').removeClass('has-error');
    };     
    //CERRAR SESSION DE USUARIO
    $(".logOff").click(function(){                        
        $.post('wApi.php', { oper: 'logout' })
            .done(function( data ) {                    
                if(data.success){
                    location.reload(true);
                }
                else { 
                    swal("ERROR: "+data.error, "Corrija el error e intente nuevamente.", "error"); 
                }
            }).fail(function(){
                swal("ERROR al cerrar sesión", "Ocurrio un problema, intente nuevamente.", "error");
            });                         
    });    
});