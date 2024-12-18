@extends('layout.web')

@section('title')Términos y Condiciones @stop

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
            <h1>Términos y condiciones</h1><br>

            <h4>Finalidad</h4>
            <p>La finalidad del sitio Web <a href="{{ route('index') }}">https://codetech.com</a> es La temática principal de CodeTech es el asesoramiento en programación o desarrollo de software, mediante tutoriales, artículos, videos, cursos o un servicio privado.</p>

            <h4>Condiciones de Uso</h4>
            <p>La utilización del sitio Web te otorga la condición de Usuario, e implica la aceptación completa de todas las cláusulas y condiciones de uso incluidas en las páginas:</p>
            <ul>
                <li><a href="{{ route('terms') }}">Aviso Legal</a></li>
                <li><a href="{{ route('priv') }}">Política de Privacidad</a></li>
                <li><a href="{{ route('cook') }}">Política de Cookies</a></li>
            </ul>
            <p>Si no estás conforme con todas y cada una de estas cláusulas y condiciones te abstendrás de utilizar este sitio Web.</p>
            <p>El acceso a este sitio Web no supone, en modo alguno, el inicio de una relación comercial con CodeTech.</p>
            <p>A través de este sitio Web, el Titular te facilita el acceso y la utilización de diversos contenidos que el Titular o sus colaboradores han publicadon por medio de Internet.</p>
            <p>A tal efecto, te obligas y comprometes a NO utilizar cualquiera de los contenidos del sitio Web con fines o efectos ilícitos, prohibidos en este Aviso Legal o por la legislación vigente, lesivos de los derechos e intereses de terceros, o que de cualquier forma puedan dañar, inutilizar, sobrecargar, deteriorar o impedir la normal utilización de los contenidos, los equipos informáticos o los documentos, archivos y toda clase de contenidos almacenados en cualquier equipo informático propios o contratados por CodeTech, de otros usuarios o de cualquier usuario de Internet.</p>
            <p>El Titular se reserva el derecho de retirar todos aquellos comentarios que vulneren la legislación vigente, lesivos de los derechos o intereses de terceros, o que, a su juicio, no resulten adecuados para su publicación.</p>
            <p>CodeTech no será responsable de las opiniones vertidas por los usuarios a través del sistema de comentarios, redes sociales u otras herramientas de participación, conforme a lo previsto en la normativa de aplicación.</p>
            <h4>Medidas de seguridad</h4>
            <p>Los datos personales que facilites al Titular pueden ser almacenados en bases de datos automatizadas o no, cuya titularidad corresponde en exclusiva a CodeTech, que asume todas las medidas de índole técnica, organizativa y de seguridad que garantizan la confidencialidad, integridad y calidad de la información contenida en las mismas de acuerdo con lo establecido en la normativa vigente en protección de datos.</p>
            <p>No obstante, debes ser consciente de que las medidas de seguridad de los sistemas informáticos en Internet no son enteramente fiables y que, por tanto el Titular no puede garantizar la inexistencia de virus u otros elementos que puedan producir alteraciones en los sistemas informáticos (software y hardware) del Usuario o en sus documentos electrónicos y ficheros contenidos en los mismos aunque el Titular pone todos los medios necesarios y toma las medidas de seguridad oportunas para evitar la presencia de estos elementos dañinos.</p>
            <h4>Datos personales</h4>
            <p>Puedes consultar toda la información relativa al tratamiento de datos personales que recoge el Titular en la página de <a href="{{ route('priv') }}">Política de Privacidad</a></p> 
            <h4>Devolución o reembolso de compras</h4>
            <p>Dado que los productos que se vende son <strong>productos digitales descargables</strong>, no es posible obtener una devolución o reembolso del dinero realizado en las compras, a menos que se presente el siguiente caso:</p>
            <ul>
                <li><p>Si compró el <strong>mismo producto 2 o más veces</strong> por error, se puede realizar el reembolso correspondiente.</p></li>
                <li><p>Si compró un producto y <b>no se descargó</b>, usted tiene derecho a un reembolso.</p></li>
            </ul>
            <h4>Contenidos</h4>
            <p>El Titular ha obtenido la información, el contenido multimedia y los materiales incluidos en el sitio Web de fuentes que considera fiables, pero, si bien ha tomado todas las medidas razonables para asegurar que la información contenida es correcta, el Titular no garantiza que sea exacta, completa o actualizada. CodeTech declina expresamente cualquier responsabilidad por error u omisión en la información contenida en las páginas de este sitio Web.</p>
            <p>Queda prohibido transmitir o enviar a través del sitio Web cualquier contenido ilegal o ilícito, virus informáticos, o mensajes que, en general, afecten o violen derechos de el Titular o de terceros.</p>
            <p>Los contenidos de <a href="{{ route('index') }}">https://codetech.com</a> tienen únicamente una finalidad informativa y bajo ninguna circunstancia deben usarse ni considerarse como oferta de venta, solicitud de una oferta de compra ni recomendación para realizar cualquier otra operación, salvo que así se indique expresamente.</p>
            <p>CodeTech se reserva el derecho a modificar, suspender, cancelar o restringir el contenido de <a href="{{ route('index') }}">https://codetech.com</a>, los vínculos o la información obtenida a través del sitio Web, sin necesidad de previo aviso.</p>
            <p>CodeTech no es responsable de los daños y perjuicios que pudieran derivarse de la utilización de la información del sitio Web o de la contenida en las redes sociales del Titular.</p>
            <h4>Política de cookies</h4>
            <p>En la página <a href="{{ route('cook') }}">Política de Cookies</a> puedes consultar toda la información relativa a la política de recogida y tratamiento de las cookies.</p>
            <h4>Enlaces a otros sitios Web</h4>
            <p>El Titular puede proporcionarte acceso a sitios Web de terceros mediante enlaces con la finalidad exclusiva de informarte sobre la existencia de otras fuentes de información en Internet en las que podrás ampliar los datos ofrecidos en el sitio Web.</p>
            <p>Estos enlaces a otros sitios Web no suponen en ningún caso una sugerencia o recomendación para que visites las páginas web de destino, que están fuera del control del Titular, por lo que CodeTech no es responsable del contenido de los sitios web vinculados ni del resultado que obtengas al seguir los enlaces.</p>
            <p>Asimismo, CodeTech no responde de los links o enlaces ubicados en los sitios web vinculados a los que te proporciona acceso.</p>
            <p>El establecimiento del enlace no implica en ningún caso la existencia de relaciones entre CodeTech y el propietario del sitio en el que se establezca el enlace, ni la aceptación o aprobación por parte del Titular de sus contenidos o servicios.</p>
            <p>Si accedes a un sitio Web externo desde un enlace que encuentres en <a href="{{ route('index') }}">https://codetech.com</a> deberás leer la propia política de privacidad del otro sitio web que puede ser diferente de la de este sitio Web.</p>
            <h4>Enlaces de Afiliados y anuncios patrocinados</h4>
            <p>El sitio Web <a href="{{ route('index') }}">https://codetech.com</a> ofrece contenidos patrocinados, anuncios y/o enlaces de afiliados.</p>
            <p>La información que aparece en estos enlaces de afiliados o los anuncios insertados, son facilitados por los propios anunciantes, por lo que CodeTech no se hace responsable de posibles inexactitudes o errores que pudieran contener los anuncios, ni garantiza en modo alguno la experiencia, integridad o responsabilidad de los anunciantes o la calidad de sus productos y/o servicios.</p>
            <h4>Propiedad intelectual e industrial</h4>
            <p>Todos los derechos están reservados.</p>
            <p>Todo acceso a este sitio Web está sujeto a las siguientes condiciones: la reproducción, almacenaje permanente y la difusión de los contenidos o cualquier otro uso que tenga finalidad pública o comercial queda expresamente prohibida sin el consentimiento previo expreso y por escrito de CodeTech.</p>
            <h4>Limitación de responsabilidad</h4>
            <p>La información y servicios incluidos o disponibles a través de este sitio Web pueden incluir incorrecciones o errores tipográficos. De forma periódica el Titular incorpora mejoras y/o cambios a la información contenida y/o los Servicios que puede introducir en cualquier momento.</p>
            <p>El Titular no declara ni garantiza que los servicios o contenidos sean interrumpidos o que estén libres de errores, que los defectos sean corregidos, o que el servicio o el servidor que lo pone a disposición estén libres de virus u otros componentes nocivos sin perjuicio de que el Titular realiza todos los esfuerzos en evitar este tipo de incidentes.</p>
            <p>CodeTech declina cualquier responsabilidad en caso de que existan interrupciones o un mal funcionamiento de los Servicios o contenidos ofrecidos en Internet, cualquiera que sea su causa. Asimismo, el Titular no se hace responsable por caídas de la red, pérdidas de negocio a consecuencia de dichas caídas, suspensiones temporales de fluido eléctrico o cualquier otro tipo de daño indirecto que te pueda ser causado por causas ajenas a el Titular.</p>
            <p>Antes de tomar decisiones y/o acciones con base a la información incluida en el sitio Web, el Titular te recomienda comprobar y contrastar la información recibida con otras fuentes.</p>
            <h4>Derecho de exclusión</h4>
            <p>CodeTech se reserva el derecho a denegar o retirar el acceso al sitio Web y los servicios ofrecidos sin necesidad de preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan cualquiera de las condiciones de este Aviso Legal.</p>
            <h4>Jurisdicción</h4>
            <p>Siempre que no haya una norma que obligue a otra cosa, para cuantas cuestiones se susciten sobre la interpretación, aplicación y cumplimiento de este Aviso Legal, así como de las reclamaciones que puedan derivarse de su uso, las partes acuerdan someterse a los Jueces y Tribunales de la provincia de Lima, con renuncia expresa de cualquier otra jurisdicción que pudiera corresponderles.</p>
            <h4>Contacto</h4>
            <p>En caso de que tengas cualquier duda acerca de estas Condiciones legales o quieras realizar cualquier comentario sobre este sitio Web, puedes enviar un mensaje de correo electrónico a la dirección code.tech.evolution@gmail.com.</p>
        </div>
    </div>
</div>
<!-- end latest news -->
@stop

@section('scripts')
@stop