@extends('layout.web')

@section('title')Contacto @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section contact-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1>Ponerse en contacto</h1>
                    <p>Si tiene preguntas de soporte, desea obtener más información sobre los cursos o desea convertirse en un socio desarrollador / editor, comuníquese conmigo utilizando los métodos a continuación.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- breadcrumb-section -->
<div class="breadcrumb-section contact-breadcrumb bg-gray">
    <div class="container">
        <div class="layout-flex">
            <div class="block-column">
                <div class="breadcrumb-text info-box">
                    <div class="block-image">
                        <figure class="aligncenter size-large">
                            <img decoding="async" width="65" height="65" src="{{ asset('web/assets/img/email-sm.png') }}" alt="" class="wp-image-306">
                        </figure>
                    </div>
                    <h3 class="text-center">Correo electrónico 1</h3>
                    <p class="text-center">contacto.code.tech@gmail.com</p>
                </div>
            </div>
            <div class="block-column">
                <div class="breadcrumb-text info-box">
                    <div class="block-image">
                        <figure class="aligncenter size-large">
                            <img decoding="async" width="65" height="65"
                                src="{{ asset('web/assets/img/email-sm.png') }}" alt="" class="wp-image-306">
                        </figure>
                    </div>
                    <h3 class="text-center">Correo electrónico 2</h3>
                    <p class="text-center">code.tech.evolution@outlook.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- contact form -->
<div class="contact-form-section pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-form-wrap">
                    <h2>Enviame un mensaje</h2>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div id="form_status"></div>
                <div class="contact-form">
                    <div class="form-container">
                        <form type="POST" id="fruitkha-contact">
                            @csrf
                            <label class="label-text" for="name">Informacion personal <span class="required-value-mark"></span></label>
                            <p>
                                <input type="text" placeholder="Nombre" name="nombre" id="nombre" onblur="validarFormulario(this)" onkeyup="validarFormulario(this)">
                                <span class="wrong" id="sp-nombre" style="visibility: hidden;">Este campo es obligatorio.</span>
                                <input type="text" placeholder="Apellidos" name="apellidos" id="apellidos" onblur="validarFormulario(this)" onkeyup="validarFormulario(this)">
                                <span class="wrong" id="sp-apellidos" style="visibility: hidden;">Este campo es obligatorio.</span>
                            </p>
                            <label class="label-text" for="name">Email <span class="required-value-mark"></span></label>
                            <p>
                                <input type="email" placeholder="Ingresa tu correo electrónico" name="email" id="email" onblur="validarFormulario(this)" onkeyup="validarFormulario(this)">
                                <span class="wrong" id="sp-email" style="visibility: hidden;">Este campo es obligatorio.</span>
                            </p>
                            <label class="label-text" for="name">Asunto <span class="required-value-mark"></span></label>
                            <p>
                                <input type="text" placeholder="Asunto" name="asunto" id="asunto" onblur="validarFormulario(this)" onkeyup="validarFormulario(this)">
                                <span class="wrong" id="sp-asunto" style="visibility: hidden;">Este campo es obligatorio.</span>
                            </p>
                            <label class="label-text" for="name">Mensaje <span class="required-value-mark"></span></label>
                            <p id="textarea">
                                <textarea name="mensaje" id="mensaje" cols="30" rows="10" placeholder="Ingresa tu mensaje" onblur="validarFormulario(this)" onkeyup="validarFormulario(this)"></textarea>
                                <span class="wrong" id="sp-mensaje" style="visibility: hidden;">Este campo es obligatorio.</span>
                            </p>
                            <p>
                                <button type="button" class="submit-btn" id="submit-btn">Enviar</button>
                                <input type="submit" value="Submit" id="submit" style="visibility: hidden;">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end contact form -->
@stop

@section('scripts')
<!-- magnific popup -->
<script src="{{ asset('web/assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- form validation js -->
<script src="{{ asset('web/assets/js/form-validate.js') }}"></script>

<script>
    const campos = {
        nombre: false,
        apellidos: false,
        email: false,
        asunto: false,
        mensaje: false
    };
    const inputs = document.querySelectorAll('#fruitkha-contact input');
    const textareas = document.querySelectorAll('#fruitkha-contact textarea');
    var activeval = true;

    function valid_datas(f) {
        if (f.value == ''){
            f.style.border = '1px solid red';

            var nm = 'sp-' + f.name;
            document.getElementById(nm).style.visibility = 'visible';

            campos[f.name] = false;
        }
    }

    function validarFormulario(e){
        if (activeval){
            if (e.value == '') {
                e.style.border = '1px solid red';

                var nm = 'sp-' + e.name;
                document.getElementById(nm).style.visibility = 'visible';

                campos[e.name] = false;
            }
            else {
                e.style.border = '1px solid #ddd';

                var nm = 'sp-' + e.name;
                document.getElementById(nm).style.visibility = 'hidden';

                campos[e.name] = true;
            }
        }
    }

    $("#submit-btn").on("click", function () {
        inputs.forEach((input) => {
            valid_datas(input);
        });
        textareas.forEach((textarea) => {
            if (textarea.value == '') {
                textarea.style.border = '1px solid red';

                document.getElementById('sp-mensaje').style.visibility = 'visible';

                campos[textarea.name] = false;
            };
        });
        if (!campos.nombre && !campos.apellidos && !campos.email && !campos.asunto && !campos.mensaje) {
            $('#form_status').html('<span>Completa todos los campos obligatorios</span>');
        }
        if (campos.nombre && campos.apellidos && campos.email && campos.asunto && campos.mensaje) {
            $.ajax({
                url: "{{ route('contact.mail') }}",
                type: 'post',
                data: jQuery('form#fruitkha-contact').serialize(),
                success: function (data) {
                    $('#form_status').html('<div class="success"><i class="fas fa-check-circle"></i><h3>¡Gracias!</h3>Tu mensaje ha sido enviado exitosamente.</div>');
                    $('#fruitkha-contact').find('input,textarea').attr({ value: '' });
                    $('#fruitkha-contact').css({ opacity: 1 });
                    $('#fruitkha-contact').remove();
                },
                error: function (data) {
                    console.log(data);
                }
            });
            $('#form_status').html('<span class="loading">Enviando tu mensaje...</span>');
            $('#fruitkha-contact').animate({ opacity: 0.3 });
            $('#fruitkha-contact').find('input,textarea,button').css('border', 'none').attr({ 'disabled': '' });
        }
        activeval = true;
    });
</script>
@stop