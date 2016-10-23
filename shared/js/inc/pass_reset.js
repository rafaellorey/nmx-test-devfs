$(function () {
    //RECOV PASS
    $("#form-resetpass").validate({
        submitHandler: function (form) {
            var frm = $(form);
            var $btn = frm.find('button').button('loading');
            var pass = frm.find('#pass').val();
            var token = frm.find('#tk').val();
            $.post('wApi.php', {oper: 'passchange', token: token, pass: pass})
            .done(function (data) {
                if (data.success) {
                    swal({
                        title: "Contraseña Actualizada",
                        text: 'Ya puede utilizar su nueva contraseña para inicar sesión.',
                        type: "success"},
                            function () {
                                window.location = 'registro-login.php';
                            });
                } else {
                    swal("ERROR: " + data.error, "Corrija el error e intente nuevamente.", "error");
                }
            }).fail(function () {
                swal("ERROR al cambiar contraseña", "Ocurrio un problema, intente nuevamente.", "error");
            }).always(function () {
                frm.resetFields();
                $btn.button('reset');
            });
        }
    });
});
