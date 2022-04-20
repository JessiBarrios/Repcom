<?php

    // Mostrar errores PHP (Desactivar en producción)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Incluir la libreria PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // Inicio
    $mail = new PHPMailer(true);
    // Contenido del correo
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    
    if(isset($_POST['inputNombre'])){
        
        if(!empty($_POST['inputNombre']) && !empty($_POST['inputPuesto']) && !empty($_POST['inputTel']) && !empty($_POST['inputCorreo']) && !empty($_POST['inputHotel']) && !empty($_POST['areaMessage']) && !empty($_POST['g-recaptcha-response'])){

            $nombre = $_POST['inputNombre'];
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);

            $puesto = $_POST['inputPuesto'];
            $puesto = filter_var($puesto, FILTER_SANITIZE_STRING);

            $telefono = $_POST['inputTel'];

            $correo = $_POST['inputCorreo'];
            $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);

            $hotel = $_POST['inputHotel'];
            $hotel = filter_var($hotel, FILTER_SANITIZE_STRING);

            $habitaciones = $_POST['inputHabitacion'];

            $mensaje = $_POST['areaMessage'];
            $mensaje = filter_var($mensaje, FILTER_SANITIZE_STRING);
            
            $secret_key = "6LdizV0eAAAAAIAj9gbSX09TqHhik4OH-au8Fy6k";
            
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

            $response_data = json_decode($response);
            
            $data = array(
               'success'  => true
             );


            try {
                // Configuracion SMTP
    
                // Mostrar salida (Desactivar en producción)
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
                // Activar envio SMTP
                $mail->isSMTP();
                // Identificacion SMTP
                $mail->SMTPAuth  = true;
    
                // PHPMailer accede a esta cuenta y desde ella envía los correos
                // Servidor SMTP
                $mail->Host  = 'mail.repcom.com.mx';
                // Usuario SMTP
                $mail->Username  = 'leads@repcom.com.mx';
                // Contraseña SMTP
                $mail->Password  = 'Repcom2022';
    
                //Indicamos cual es nuestra dirección de correo y el nombre que queremos que vea el usuario que lee nuestro correo
                $mail->From = "md@repcom.com.mx";
                $mail->FromName = "REPCOM";
    
                // tls ir for Gmail and ssl is for hosting
                $mail->SMTPSecure = 'ssl';
    
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
                // 465 is for hosting and 587 is for Gmail
                $mail->Port  = 465;
    
                // Destinatarios
                // Destinatario directo
                $mail->addAddress('md@repcom.com.mx', 'Victor Avendaño');
                $mail->addAddress('alejandrac@repcom.com.mx', 'Alejandra Carretero');
                $mail->addAddress('mkt@repcom.com.mx', 'Marketing Digital');
                $mail->addAddress('ventas@repcomhs.mx', 'Tanairy Fernandez');
                // Destinatario copia
                //$mail->addCC('copiado@hotmail.com', '');
    
                $mail->Subject = 'Prospecto de Google Ads - REPCOM';
                $mail->Body  = '
                                <!DOCTYPE html>
                                <html lang="es">
                                    <head>
                                        <meta https-equiv="Content-Type" content="text/html; charset=utf-8"/>
                                        <meta https-equiv="X-UA-Compatible" content="IE=edge">
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    </head>
                                    <body style="width: 545px; margin: 0 auto; background-color #323232">
                                        <div style="font-family: "Montserrat", sans-serif; color: #323232; background-color: white;">
                                            <div>
                                                <div style="background-color: #8b162b; text-align: center; padding-top: 5px; padding-bottom: 1px;">
                                                    <div style="background-color: #8b162b; text-align: center; color: #8b162b;">
                                                        <h1>REPCOM</h1>
                                                    </div>
                                                </div>
                                                <h1 style="font-size: 24px; text-align: center; margin-top: 40px; margin-bottom: 40px;">Prospecto de Google Ads</h1>
                                                <div style="padding-left: 20px; padding-right: 20px;">
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Nombre: </strong> '.$nombre.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Puesto Laboral: </strong> '.$puesto.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Teléfono: </strong> '.$telefono.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Correo: </strong> '.$correo.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Hotel: </strong> '.$hotel.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Habitaciones: </strong> '.$habitaciones.'</p>
                                                    <p style="margin-top: 10px; margin-bottom: 10px;"><strong>Mensaje: </strong> '.$mensaje.'</p>
                                                </div>
                                                <div style="height: 150px;"></div>
                                                <div style="text-align: center;">
                                                    <p style="margin-bottom: 0; font-weight: 600;">REPCOM</p>
                                                    <p style="font-size: 14px; margin-top: 0; padding-bottom: 30px">Todos los derechos reservados 2022</p>
                                                </div>
                                            </div>
                                        </div>
                                    </body>
                                </html>
                                ';
                $mail->send();
    
                echo json_encode($data);
    
            }catch (Exception $e) {
                
                $data = array(
                   'false'  => true
                 );
                
                echo json_encode($data);

            }

        }else{
            
            $data = array(
                   'vacio'  => true
                 );
                
                echo json_encode($data);
                
        }
        
    }
    

?>