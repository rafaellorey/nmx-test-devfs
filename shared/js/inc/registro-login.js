$(function () {
    //LOGIN
    $("#form-login").validate({
        submitHandler: function (form) {
            var frm = $(form);
            var $btn = frm.find('button').button('loading');            
            var mail = frm.find('#email').val();
            var pass = frm.find('#pass').val();
            $.post('wApi.php', { oper: 'login', mail: mail, pass: pass })
                .done(function( data ) {                    
                    if(data.success){
                        location.reload(true);
                    }
                    else { 
                        swal("ERROR: "+data.error, "Corrija el error e intente nuevamente.", "error");
                    }
                }).fail(function(){
                    swal("ERROR al iniciar sesión", "Ocurrio un problema, intente nuevamente.", "error");
                }).always(function(){
                    frm.resetFields();
                    $btn.button('reset');
                });             
        }
    });
    //SIGNIN
    $("#form-signin").validate({
        submitHandler: function (form) {
            var frm = $(form);
            var $btn = frm.find('button').button('loading');            
            var name = frm.find('#name').val();
            var mail = frm.find('#mail').val();
            var pass = frm.find('#pass').val();
            $.post('wApi.php', { oper: 'signin', mail: mail, pass: pass, name: name })
                .done(function( data ) {                    
                    if(data.success){
                        location.reload(true);
                    }
                    else { 
                        swal("ERROR: "+data.error, "Corrija el error e intente nuevamente.", "error");
                    }
                }).fail(function(){
                    swal("ERROR al crear cuenta", "Ocurrio un problema, intente nuevamente.", "error");                    
                }).always(function(){
                    frm.resetFields();
                    $btn.button('reset');
                });             
        }        
    });
});



