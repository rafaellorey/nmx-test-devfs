$(function () {
    //UPLOAD IMGS            
    var settings = {
        url: 'wApi.php',
        formData: {
            "oper": "gifupload"
        },
        dragDrop: true,
        multiple: false,
        showProgress: true,
        showCancel: true,
        showAbort: true,
        fileName: "gifFile",
        maxFileSize: (1048576 * 2), //4MB
        allowedTypes: "gif",
        acceptFiles: "image/gif",
        returnType: "json",
        dragdropWidth: "100%",
        dragDropStr: "<span><b>Arrastre y suelte aquí</b></span>",
        abortStr:"Cancelar",
	cancelStr:"Terminar",
	doneStr:"Listo",
	multiDragErrorStr: "Solo se permite un archivo.",
	extErrorStr:"Sólo se permiten archivos con extensión:",
	sizeErrorStr:"Sólo se permiten archivos de tamaño máximo:",
	uploadErrorStr:"Error al subir el archivo",
	uploadStr:"Subir archivo",        
        
        onSuccess: function (files, data, xhr) {
            if (data.success) {
                swal({
                    title:"GIF RECIBIDO", 
                    text:'El GIF animado ['+data.img+'] fue recibido, gracias.', 
                    type:"success"},
                    function(){
                        window.location = 'index.php';
                    });                
                
            } else {
                swal("ERROR: GIF NO RECIBIDO", "Ocurrio un problema ["+data.error+"].", "error");
            }
        },
        onError: function (files, status, message) {
            swal("ERROR: GIF NO RECIBIDO", "Ocurrio un problema, intente nuevamente.", "error");
        },
        showStatusAfterSuccess: false
    };
    var uploadObj = $("#gifUpload").uploadFile(settings); 
});