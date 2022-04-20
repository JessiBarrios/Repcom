$('#formContactos').on('submit', function(event){
    
    event.preventDefault();

    enviar();

});

function enviar(){

    $.ajax({

        url: "https://contacto.repcom.com.mx/php/formContact.php",
        method: "post",
        data: $("#formContactos").serialize(),
        dataType:"json",
        beforeSend: function() {
            $('#respuesta').html(`
                            <div class="alert alert-primary" role="alert">
                                Enviando...
                            </div>
                        `);
        },
        success:function(data){

            if(data.success){

                correcto();

            }else if(data.false){

                phperror();

            }else if(data.vacio){

                vacio();

            }


        }

    })

}

function correcto(){

    $("#respuesta").html(`
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Su mensaje se ha enviado. En breve nos comunicaremos contigo.
                    </div>
                `);

    $("#formContactos").trigger("reset");
    grecaptcha.reset();

}

function phperror(){

    $("#respuesta").html(`
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Ha ocurrido un error al mandar el mensaje, por favor inténtelo de nuevo, o si lo prefiere, puede contactarnos por <a href="tel:+529987044488" class="alert-link">9987044488</a>.
                    </div>
                `);

}

function vacio(){

    $("#respuesta").html(`
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        Por favor, complete todos los datos.
                    </div>
                `);

}