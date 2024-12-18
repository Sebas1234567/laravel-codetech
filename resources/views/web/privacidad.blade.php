@extends('layout.web')

@section('title')Política de Privacidad @stop

@section('styles')
@stop

@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- latest news -->
<div class="terms mt-5 mb-150">
    <div class="container">
        <div class="row">
            <h1>Política de Privacidad</h1><br>

            <p>CodeTech te informa sobre su Política de Privacidad respecto del tratamiento y protección de los datos de carácter personal de los usuarios y clientes que puedan ser recabados por la navegación o contratación de servicios a través del sitio Web <a href="{{ route('index') }}">https://codetech.com</a>.</p>

            <p>En este sentido, el Titular garantiza el cumplimiento de la normativa vigente en materia de protección de datos personales, reflejada en la Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y de Garantía de Derechos Digitales (LOPD GDD). Cumple también con el Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo de 27 de abril de 2016 relativo a la protección de las personas físicas (RGPD).</p>

            <p>El uso de sitio Web implica la aceptación de esta Política de Privacidad así como las condiciones incluidas en el <a href="{{ route('terms') }}">Aviso Legal</a>.</p>

            <h3>Qué datos personales recopilamos y por qué los recopilamos.</h3>
            <h4>Comentarios</h4>
            <p>Cuando los visitantes dejan comentarios en el sitio, recopilamos los datos que se muestran en el formulario de comentarios, y también la dirección IP del visitante y la cadena del agente del usuario del navegador para ayudar a la detección de spam.</p>
            <p>Se puede proporcionar una cadena anónima creada a partir de su dirección de correo electrónico (también llamada hash) al servicio Gravatar para ver si la está utilizando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de su comentario, su imagen de perfil es visible al público en el contexto de su comentario.</p>
            <p>Con fines de evitar spam, para comentar, es necesario registrarse mediante un correo electrónico, también puedes iniciar sesión directamente con tu cuenta de Facebook, Google Github o Gitlab, todo bajo reglamento. Ojo, solamente recopilamos tu dirección correo electrónico.</p>
            <h4>Media</h4>
            <p>Si carga imágenes en el sitio web, debe evitar subir imágenes con datos de ubicación incorporados (GPS EXIF) incluidos. Los visitantes del sitio web pueden descargar y extraer los datos de ubicación de las imágenes en el sitio web.</p>
            <h4>Formularios de contacto</h4>
            <p>El Titular solicita datos personales entre los que pueden estar: Nombre y apellidos, dirección de correo electrónico, número de teléfono y dirección de tu sitio Web con la finalidad de responder a tus consultas.<br>Por ejemplo, el Titular utiliza esos datos para dar respuesta a tus mensajes, dudas, quejas, comentarios o inquietudes que puedas tener relativas a la información incluida en el sitio Web, los servicios que se prestan a través del sitio Web, el tratamiento de tus datos personales, cuestiones referentes a los textos legales incluidos en el sitio Web, así como cualquier otra consulta que puedas tener y que no esté sujeta a las condiciones del sitio Web o de la contratación.</p>
            <h4>Cookies</h4>
            <p>Para que este sitio Web funcione correctamente necesita utilizar cookies, que es una información que se almacena en tu navegador web.</p>
            <p>En la página <a href="{{ route('cook') }}">Política de Cookies</a> puedes consultar toda la información relativa a la política de recogida, la finalidad y el tratamiento de las cookies.</p>
            <h4>Contenido incrustado de otros sitios web</h4>
            <p>Los artículos en este sitio pueden incluir contenido incrustado (por ejemplo, videos, imágenes, artículos, etc.). El contenido incorporado de otros sitios web se comporta de la misma manera que si el visitante hubiera visitado el otro sitio web.</p>
            <p>Es posible que estos sitios web recopilen información sobre usted, utilicen cookies, incorporen un seguimiento de terceros adicional y monitoreen su interacción con ese contenido integrado, incluido el seguimiento de su interacción con el contenido incorporado si tiene una cuenta y está registrado en ese sitio web.</p>

            <h3>Con quién compartimos sus datos</h3>
            <h3>Cuánto tiempo conservamos sus datos</h3>
            <p>Si deja un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar cualquier comentario de seguimiento automáticamente en lugar de mantenerlos en una cola de moderación.</p>
            <p>Para los usuarios que se registran en nuestro sitio web (si corresponde), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores del sitio web también pueden ver y editar esa información.</p>
            <h3>Qué derechos tienes sobre tus datos</h3>
            <p>Si tiene una cuenta en este sitio o ha dejado comentarios, puede solicitar recibir un archivo exportado de los datos personales que tenemos sobre usted, incluidos los datos que nos haya proporcionado. También puede solicitar que borremos cualquier información personal que tengamos sobre usted. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.</p>
            <h3>Donde enviamos tus datos</h3>
            <p>Los comentarios de los visitantes pueden verificarse a través de un servicio automatizado de detección de spam.</p>
            <h3>Destinatarios de datos personales</h3>
            <ul>
                <li>
                    <p><b>Mailrelay</b> CPC Servicios Informáticos Aplicados a Nuevas Tecnologías S.L. (en adelante “CPC”) , con domicilio social en C/ Nardo, 12 28250 – Torrelodones – Madrid. <br>Encontrarás más información en: <a href="https://mailrelay.com" target="_blank" rel="noopener noreferrer">https://mailrelay.com</a><br>CPC trata los datos con la finalidad de prestar sus servicios de email el Titulareting al Titular.</p>
                </li>
                <li><p><b>Mailchimp</b> The Rocket Science Group LLC d/b/a , con domicilio en EEUU. <br>Encontrarás más información en: <a href="https://mailchimp.com" target="_blank" rel="noopener noreferrer">https://mailchimp.com</a><br>The Rocket Science Group LLC d/b/a trata los datos con la finalidad de prestar sus servicios de email el Titulareting al Titular.</p></li>
                <li><p><b>SendinBlue</b> SendinBlue, sociedad por acciones simplificada (société par actions simplifiée) inscrita en el Registro Mercantil de París con el número 498 019 298, con domicilio social situado en 55 rue d’Amsterdam, 75008, París (Francia). <br>Encontrarás más información en: <a href="https://es.sendinblue.com" target="_blank" rel="noopener noreferrer">https://es.sendinblue.com</a><br>SendinBlue trata los datos con la finalidad de ofrecer soluciones para el envío de correos electrónicos, SMS transaccionales y de el Titulareting al Titular.</p></li>
                <li><p><b>Google Analytics</b> es un servicio de analítica web prestado por Google, Inc., una compañía de Delaware cuya oficina principal está en 1600 Amphitheatre Parkway, Mountain View (California), CA 94043, Estados Unidos (“Google”). <br>Encontrarás más información en: <a href="https://analytics.google.com" target="_blank" rel="noopener noreferrer">https://analytics.google.com</a><br>Google Analytics utiliza “cookies”, que son archivos de texto ubicados en tu ordenador, para ayudar al Titular a analizar el uso que hacen los usuarios del sitio Web. La información que genera la cookie acerca del uso del sitio Web (incluyendo tu dirección IP) será directamente transmitida y archivada por Google en los servidores de Estados Unidos.</p></li>
                <li><p><b>DoubleClick by Google</b> es un conjunto de servicios publicitarios proporcionado por Google, Inc., una compañía de Delaware cuya oficina principal está en 1600 Amphitheatre Parkway, Mountain View (California), CA 94043, Estados Unidos (“Google”). <br>Encontrarás más información en: <a href="https://www.doubleclickbygoogle.com" target="_blank" rel="noopener noreferrer">https://www.doubleclickbygoogle.com</a><br>DoubleClick utiliza “cookies”, que son archivos de texto ubicados en tu ordenador y que sirven para aumentar la relevancia de los anuncios relacionados con tus búsquedas recientes. En la Política de privacidad de Google se explica cómo Google gestiona tu privacidad en lo que respecta al uso de las cookies y otra información.</p></li>
            </ul>
            <p>También puedes ver una lista de los tipos de cookies que utiliza Google y sus colaboradores y toda la información relativa al uso que hacen de cookies publicitarias.</p>
            <h4>Navegación Web</h4>
            <p>Al navegar por <a href="{{ route('index') }}">https://codetech.com</a> se pueden recoger datos no identificativos, que pueden incluir, la dirección IP, geolocalización, un registro de cómo se utilizan los servicios y sitios, hábitos de navegación y otros datos que no pueden ser utilizados para identificarte.</p>
            <p>El sitio Web utiliza los siguientes servicios de análisis de terceros:</p>
            <ul>
                <li><p>Google Analytics</p></li>
                <li><p>DoubleClick por Google</p></li>
            </ul>
            <p>El Titular utiliza la información obtenida para obtener datos estadísticos, analizar tendencias, administrar el sitio, estudiar patrones de navegación y para recopilar información demográfica.</p>
            <h4>Exactitud y veracidad de los datos personales</h4>
            <p>Te comprometes a que los datos facilitados al Titular sean correctos, completos, exactos y vigentes, así como a mantenerlos debidamente actualizados.</p>
            <p>Como Usuario del sitio Web eres el único responsable de la veracidad y corrección de los datos que remitas al sitio exonerando a el Titular de cualquier responsabilidad al respecto.</p>
            <h4>Aceptación y consentimiento</h4>
            <p>Como Usuario del sitio Web declaras haber sido informado de las condiciones sobre protección de datos de carácter personal, aceptas y consientes el tratamiento de los mismos por parte de el Titular en la forma y para las finalidades indicadas en esta Política de Privacidad.</p>
            <h4>Revocabilidad</h4>
            <p>Para ejercitar tus derechos de acceso, rectificación, cancelación, portabilidad y oposición tienes que enviar un correo electrónico a code.tech.evolution@gmail.com junto con la prueba válida en derecho como una fotocopia del D.N.I. o equivalente.</p>
            <p>El ejercicio de tus derechos no incluye ningún dato que el Titular esté obligado a conservar con fines administrativos, legales o de seguridad.</p>
            <h4>Cambios en la Política de Privacidad</h4>
            <p>El Titular se reserva el derecho a modificar la presente Política de Privacidad para adaptarla a novedades legislativas o jurisprudenciales, así como a prácticas de la industria.</p>
            <p>Estas políticas estarán vigentes hasta que sean modificadas por otras debidamente publicadas.</p>
        </div>
    </div>
</div>
<!-- end latest news -->
@stop

@section('scripts')
@stop