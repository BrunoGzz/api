//INPUT 1

var input = document.getElementById('searcherbox');
var words = ['Google', 'Amazon', 'Bing', 'Twitch', 'Twitter', 'Youtube', 'Nike', 'Wikipedia', 'Play Store', 'Instagram', 'Facebook'];
var index = 0;

function typeWord() {
  var word = words[index];
  var letterIndex = 0;

  var interval = setInterval(function() {
    var substring = word.substring(0, letterIndex + 1);
    input.value = substring;
    letterIndex++;

    if (letterIndex === word.length) {
      setTimeout(function() {
        deleteWord();
      }, 1000);
      clearInterval(interval);
    }
  }, 100);
}

function deleteWord() {
  var interval = setInterval(function() {
    var word = input.value;
    var substring = word.substring(0, word.length - 1);
    input.value = substring;

    if (substring === '') {
      setTimeout(function() {
        index++;
        if (index === words.length) {
          index = 0;
        }
        typeWord();
      }, 500);
      clearInterval(interval);
    }
  }, 50);
}

typeWord();

//INPUT 2

var input2 = document.getElementById('searchbox');
var words2 = [
    'Zapatos rojos para hombre',
    'Recetas de cocina saludables',
    'Mejores destinos de viaje en verano',
    'Consejos para bajar de peso rápidamente',
    'Cómo hacer crecer plantas en interiores',
    'Rutina de ejercicios para fortalecer los abdominales',
    'Ideas de regalos para el Día de la Madre',
    'Tutoriales de maquillaje para principiantes',
    'Trucos para mantener el hogar limpio y ordenado',
    'Reseñas de los mejores teléfonos inteligentes del mercado',
    'Consejos para ahorrar dinero en compras en línea',
    'Información sobre el cambio climático y sus efectos',
    'Guía para aprender a tocar la guitarra acústica',
    'Preguntas frecuentes sobre el funcionamiento de un ordenador',
    'Cómo iniciar un negocio propio con poco capital',
    'Beneficios y contraindicaciones de la meditación diaria'
    ];
var index2 = 0;

function typeWord2() {
  var word2 = words2[index2];
  var letterIndex2 = 0;

  var interval2 = setInterval(function() {
    var substring2 = word2.substring(0, letterIndex2 + 1);
    input2.value = substring2;
    letterIndex2++;

    if (letterIndex2 === word2.length) {
      setTimeout(function() {
        deleteWord2();
      }, 1000);
      clearInterval(interval2);
    }
  }, 100);
}

function deleteWord2() {
  var interval2 = setInterval(function() {
    var word2 = input2.value;
    var substring2 = word2.substring(0, word2.length - 1);
    input2.value = substring2;

    if (substring2 === '') {
      setTimeout(function() {
        index2++;
        if (index2 === words2.length) {
          index2 = 0;
        }
        typeWord2();
      }, 500);
      clearInterval(interval2);
    }
  }, 50);
}

typeWord2();

//SCROLL

var controller = new ScrollMagic.Controller();

new ScrollMagic.Scene({
  triggerElement: "#trigger1",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-1", "visible")
.addTo(controller);

new ScrollMagic.Scene({
  triggerElement: "#trigger2",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-2", "visible")
.addTo(controller);

new ScrollMagic.Scene({
  triggerElement: "#trigger3",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-3", "visible")
.addTo(controller);

new ScrollMagic.Scene({
  triggerElement: "#trigger4",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-4", "visible")
.addTo(controller);

new ScrollMagic.Scene({
  triggerElement: "#trigger5",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-5", "visible")
.addTo(controller);


new ScrollMagic.Scene({
  triggerElement: "#trigger6",
  triggerHook: 0.9,
  offset: 50
})
.setClassToggle(".animation-show-6", "visible")
.addTo(controller);

var images = [];

for (var i = 0; i <= 25; i++) {
  var paddedNumber = i.toString().padStart(0, '0');
  var imagePath = "./img/sequence_mini/"+ addZeros(paddedNumber) + ".jpg";
  images.push(imagePath);
}

function addZeros(number) {
  var str = String(number);
  while (str.length < 4) {
    str = '0' + str;
  }
  return str;
}

var obj = {curImg: 0};

/*var tween = TweenMax.to(obj, 0.5,
  {
    curImg: images.length - 1,	// animate propery curImg to number of images
    roundProps: "curImg",				// only integers so it can be used as an array index									// repeat 3 times
    immediateRender: true,			// load first image automatically
    ease: Linear.easeNone,			// show every image the same ammount of time
    onUpdate: function () {
      $("#sequence-image").attr("src", images[obj.curImg]); // set the image source
    }
  }
);

var scene = new ScrollMagic.Scene({triggerElement: "#trigger-img", duration: 300})
					.setTween(tween)
					.duration(350)
          .addTo(controller);*/

var scene1 = new ScrollMagic.Scene({triggerElement: ".trigger-sticky", duration: 600})
        .setPin(".content-sequence")
        .addTo(controller);

var adjetivos = ["que enamora", "elegante", "innovador", "minimalista", "productivo", "inspirador"];
var index3 = 0;

function cambiarAdjetivo() {
  $(".sequence-image-adjective").text(adjetivos[index3]);
  $(".sequence-image-adjective").animate({ top: "-50px", opacity: 1 }, 500, function() {
    $(".sequence-image-adjective").delay(1500).animate({ top: "0", opacity: 0 }, 500, function() {
      index3 = (index3 + 1) % adjetivos.length;
      cambiarAdjetivo();
    });
  });
}

cambiarAdjetivo();

window.addEventListener('DOMContentLoaded', function() {
  var sourceElement = document.querySelector('#copy-height');
  var targetElement = document.querySelector('.reminders-gif-mini-video');
  var height = window.getComputedStyle(sourceElement).getPropertyValue('height');
  targetElement.style.height = height;
});