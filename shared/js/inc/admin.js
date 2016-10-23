$(function () {
    //estatus
    $(document).on('change', '.upStat', function (e) {
        var val = this.value;
        var id = $(this).closest('tr').data("id");
        if(id && val){
            $.post('wApi.php',{oper: 'mediaestatus', pk: id, value: val}, function(data){
                if(!data.success){
                    toastr.error('Error al actualizar GIF #'+ id +' :' + data.error,'ERROR:');
                }else{
                    toastr.success('GIF #'+ id +' :' + (+val === 1 ? 'ACEPTADO':'RECHAZADO') ,'ÉXITO:');
                }
            },'json');                 
        } 
    });     
});