<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="El buscador más privado y rápido de toda la web. Busca sin preocuparte de que las grandes empresas te estén vigilando. Más de 100 páginas en las que puedes buscar directamente.">
    <title>SearchOut - Busca rápido y seguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="./img/icon.png">
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="main">
        <div class="header d-flex">
            <p class="col-4"></p>
            <h1 class="header-title col-4">SearchOut</h1>
            <div class="col-4 d-flex">
            <a class="header-download" href="https://searchout.es/install">Descargar ahora</a>
            </div>
        </div>
        <div class="content">
            <div class="content-1" id="rain-container">
                <h1 class="content-1-title">Navega directo al grano</h1>
                <h3 class="content-1-subtitle">Disfruta navegando con privacidad y velocidad.</h3>
                <button class="content-1-link" onclick="window.open('https://searchout.es/install')">Añadir a tu navegador ahora</button>
            </div>
            <div class="content-2">
                <div id="trigger1"></div>
                <h1 class="content-2-title animation-show-1">Con SearchOut, se abren millones de posibilidades.</h1>
                <div id="trigger2"></div>
                <div class="form animation-show-2" id="searchform">
                    <input id="searcherbox" type="text" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" aria-label="Buscador" title="Buscador" aria-autocomplete="both" aria-haspopup="false" maxlength="2048" autofocus="" placeholder="Buscador" disabled>
                    <input id="searchbox" type="text" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" aria-label="Buscar" title="Buscar" aria-autocomplete="both" aria-haspopup="false" maxlength="2048" autofocus="" placeholder="¿Qué te apetece buscar?" disabled>
                    <button id="submit-button" title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    </button>
                </div>
                <div id="trigger3"></div>
                <h3 class="content-2-text animation-show-3">Explora entre las cientos de páginas web disponibles en SearchOut y realiza búsquedas en cada una de ellas directamente, sin intermediarios. ¡Añadimos nuevas páginas web cada día!</h3>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#000000" fill-opacity="1" d="M0,192L48,208C96,224,192,256,288,256C384,256,480,224,576,224C672,224,768,256,864,250.7C960,245,1056,203,1152,197.3C1248,192,1344,224,1392,240L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
            <div class="trigger-sticky" id="trigger-img"></div>
            <div class="content-sequence">
                <div class="content-sequence-image">
                    <img alt="Imagen de un ordenador abriéndose con SearchOut." src="./img/sequence_mini/0025.jpg" id="sequence-image">
                </div>
                <h1 class="poppins content-sequence-title">Un diseño <span class="sequence-image-adjective"></span></h1>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg) translate(0, 10px);margin-bottom:5rem;" viewBox="0 0 1440 320">
                <path fill="#000000" fill-opacity="1" d="M0,192L8.3,160C16.6,128,33,64,50,64C66.2,64,83,128,99,128C115.9,128,132,64,149,69.3C165.5,75,182,149,199,170.7C215.2,192,232,160,248,165.3C264.8,171,281,213,298,229.3C314.5,245,331,235,348,234.7C364.1,235,381,245,397,261.3C413.8,277,430,299,447,288C463.4,277,480,235,497,229.3C513.1,224,530,256,546,240C562.8,224,579,160,596,160C612.4,160,629,224,646,240C662.1,256,679,224,695,186.7C711.7,149,728,107,745,101.3C761.4,96,778,128,794,160C811,192,828,224,844,213.3C860.7,203,877,149,894,133.3C910.3,117,927,139,943,154.7C960,171,977,181,993,192C1009.7,203,1026,213,1043,229.3C1059.3,245,1076,267,1092,234.7C1109,203,1126,117,1142,96C1158.6,75,1175,117,1192,144C1208.3,171,1225,181,1241,192C1257.9,203,1274,213,1291,229.3C1307.6,245,1324,267,1341,266.7C1357.2,267,1374,245,1390,224C1406.9,203,1423,181,1432,170.7L1440,160L1440,320L1431.7,320C1423.4,320,1407,320,1390,320C1373.8,320,1357,320,1341,320C1324.1,320,1308,320,1291,320C1274.5,320,1258,320,1241,320C1224.8,320,1208,320,1192,320C1175.2,320,1159,320,1142,320C1125.5,320,1109,320,1092,320C1075.9,320,1059,320,1043,320C1026.2,320,1010,320,993,320C976.6,320,960,320,943,320C926.9,320,910,320,894,320C877.2,320,861,320,844,320C827.6,320,811,320,794,320C777.9,320,761,320,745,320C728.3,320,712,320,695,320C678.6,320,662,320,646,320C629,320,612,320,596,320C579.3,320,563,320,546,320C529.7,320,513,320,497,320C480,320,463,320,447,320C430.3,320,414,320,397,320C380.7,320,364,320,348,320C331,320,314,320,298,320C281.4,320,265,320,248,320C231.7,320,215,320,199,320C182.1,320,166,320,149,320C132.4,320,116,320,99,320C82.8,320,66,320,50,320C33.1,320,17,320,8,320L0,320Z"></path>
            </svg>
            <div class="text-center content-targets">
                <div class="row">
                    <div class="col-md content-targets-target mx-3 px-0 mb-5">
                        <h2 class="poppins p-3 mt-1">¿Tienes que recordar algo importante?</h2>
                        <img src="https://searchout.es/views/pages/src/img/reminders.gif" alt="La funcióin Reminders de SearchOut, te permite recordar tus tareas más importantes y te irá avisando antes de que se aproxime la fecha límite." class="reminders-gif">
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">Con los recordatorios, nunca más olvidarás nada. Añade tus tareas pendientes o simplemente algo de lo que quieras acordarte, y nosotros te avisaremos antes de que llegue la fecha límite.</p>
                    </div>
                    <div class="col-md content-targets-target mx-3 px-0 mb-5">
                        <h2 class="poppins p-3 mt-1">Diseña la página de inicio a tu manera.</h2>
                        <img src="./img/theme.png" alt="Imagen que hace referencia a la gran personalización que tiene SearchOut, alterna entre los temas claros y oscuros, o añade una imagen de fondo de pantalla." class="reminders-gif">
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">Cambia totalmente la estética de SearchOut y adáptala a tu estilo. Añade alguna imagen de fondo que te guste, incorpora la hora y alterna entre temas claros y oscuros.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col content-targets-target mx-3 px-0 mb-5">
                        <img src="./img/bookmarks.png" alt="Añade las páginas que más utilizas al inicio para poder acceder a ellas con un solo clic." class="reminders-gif-mini">
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">Agrega tus páginas favoritas para tenerlas al alcance de un solo clic.</p>
                    </div>
                    <div class="col content-targets-target mx-3 px-0 mb-5">
                        <img src="./img/data.png" alt="Codifica todos los datos relacionados con tu página de inicio para migrarlos a otro dispositivo." class="reminders-gif-mini">
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">Codifica tus datos para poder transferirlos a otro dispositivo de manera segura.</p>
                    </div>
                    <div class="col content-targets-target mx-3 px-0 mb-5">
                        <img src="./img/ai.png" alt="SearchOut Chat utiliza un sistema de IA para proporcionar descripciones a los términos que le preguntes." class="reminders-gif-mini" id="copy-height">
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">¿Has escuchado algo o quieres saber más sobre un término concreto? SearchOut Chat puede ayudarte.</p>
                    </div>
                    <div class="col content-targets-target mx-3 px-0 mb-5">
                    <iframe class="reminders-gif-mini reminders-gif-mini-video" src="https://www.youtube.com/embed/hhbIrjNzjjU?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                        <p class="poppins mt-4 px-3" style="font-size:1.2rem;">En definitiva, SearchOut tiene todo lo necesario para ahorrarte tiempo, brindarte seguridad y ayudarte a ser más productivo.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col content-targets-target mx-3 py-5 mb-5">
                        <a target="_blank" href="https://searchout.es/install" class="text-black h3 fw-normal">Obtener SearchOut gratis ahora</a>
                    </div>
                </div>
            </div>
            <div class="content-4">
                <div class="content-4-div-text">
                    <div id="trigger5"></div>
                    <h1 class="content-4-title animation-show-5">El tiempo es <span class="content-4-title-gold">oro</span></h1>
                    <div id="trigger6"></div>
                    <h3 class="content-4-text animation-show-6 w-75 w-xxl-50">Cada búsqueda con SearchOut te brinda un valioso ahorro de tiempo, evitando la navegación innecesaria en motores de búsqueda convencionales. Imagina cuánto tiempo podrías recuperar para actividades que realmente disfrutas. <br><br>No pierdas más tiempo, descarga SearchOut y mejora tu experiencia de búsqueda hoy mismo.</h3>
                </div>
            </div>
            <footer class="py-5 mt-5">
                <div class="row me-0">
                    <div class="col-3 col-sm ms-5">
                    <h5>Recursos</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="link-secondary text-decoration-none" href="https://searchout.es/install">Descagar extensión</a></li>
                        <li><a class="link-secondary text-decoration-none" href="https://searchout.es/legal.php">Aviso legal</a></li>
                        <li><a class="link-secondary text-decoration-none" href="https://searchout.es/team">Nuestro equipo</a></li>
                    </ul>
                </div>
                <div class="col-3 col-sm">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="link-secondary text-decoration-none" href="https://instagram.com/searchout.project">Instagram</a></li>
                        <li><a class="link-secondary text-decoration-none" href="https://discord.gg/RyC4yvRSE6">Discord</a></li>
                    </ul>
                </div>
            </footer>
            
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/jquery.gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.velocity.min.js"></script>
<script src="./index.js"></script>
</body>
</html>