$(function () {
    //RECOV PASS
    $("#form-recovpass").validate({
        submitHandler: function (form) {
            var frm = $(form);
            var $btn = frm.find('button').button('loading');
            var mail = frm.find('#email').val();
            $.post('wApi.php', {oper: 'passrecov', mail: mail})
            .done(function (data) {
                if (data.success) {
                    swal({
                        title: "Contraseña Enviada",
                        text: 'Se envió un correo electrónico con tu nuevo password.',
                        type: "success"},
                            function () {
                                window.location = 'registro-login.php';
                            });
                } else {
                    swal("ERROR: " + data.error, "Corrija el error e intente nuevamente.", "error");
                }
            }).fail(function () {
                swal("ERROR al iniciar sesión", "Ocurrio un problema, intente nuevamente.", "error");
            }).always(function () {
                frm.resetFields();
                $btn.button('reset');
            });
        }
    });
});
