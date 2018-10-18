/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
 var $ = require('jquery');
 var imagesLoaded = require('imagesloaded');
imagesLoaded.makeJQueryPlugin( $ );

$(document).ready(function(){

  /*$(window).scroll(function(){
    $('.header').
    css("background-size",(100 + 10 * $(window).scrollTop()/250 + "%"));
  });*/

  flatpickr("#res_date", {
    "locale": "es",
    enableTime: true,
    minDate : Date.now()
  });

  /*UIkit.slideshow('#hab-slideshow','itemshow', function(){

  });*/

  /* Image Fog */
function activateFogAnimation(){
  if($('#canvas-fog').length){

    const front = $('.header-image'),
        canv = document.getElementById("canvas-fog"),
        ctx = canv.getContext("2d"),
        img = new Image(),
        imgMask = new Image();

  img.src = $('.header-image').attr('src');
  //imgMask.src = "http://res.cloudinary.com/dkcygpizo/image/upload/v1505176018/codepen/watercolor-effect-2.png";
  imgMask.src = "../assets/components/fog.png";

  let i = 0;

  function draw() {
    i += 10;

    let maskX = (canv.width - (70 + i)) / 2,
        maskY = (canv.height - (40 + i)) / 2;

    ctx.clearRect(0, 0, canv.width, canv.height);
    ctx.globalCompositeOperation = "source-over";

    ctx.drawImage(imgMask, maskX, maskY, 70 + i, 40 + i);

    ctx.globalCompositeOperation = "source-in";
    ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);

    window.requestAnimationFrame(draw);
  }

  img.onload = function() {
    canv.width = img.naturalWidth;
    canv.height = img.naturalHeight;
  }

  front.onclick = function() {
    front.style.display = "none";
    canv.style.display = "block";

    draw();
  }


    i = 0;
    draw();
  }
}

/* Fog Modal */

function activateFogAnimationonModal(){
    const front = $('.header-image'),
        canv = document.getElementById("fog-modal"),
        ctx = canv.getContext("2d"),
        img = new Image(),
        imgMask = new Image();

  img.src = $('.modal-reserve-cover').attr('src');
  //imgMask.src = "http://res.cloudinary.com/dkcygpizo/image/upload/v1505176018/codepen/watercolor-effect-2.png";
  imgMask.src = "../assets/components/fog.png";

  let i = 0;

  function draw() {
    i += 10;

    let maskX = (canv.width - (70 + i)) / 2,
        maskY = (canv.height - (40 + i)) / 2;

    ctx.clearRect(0, 0, canv.width, canv.height);
    ctx.globalCompositeOperation = "source-over";

    ctx.drawImage(imgMask, maskX, maskY, 70 + i, 40 + i);

    ctx.globalCompositeOperation = "source-in";
    ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);

    window.requestAnimationFrame(draw);
  }

  img.onload = function() {
    canv.width = img.naturalWidth;
    canv.height = img.naturalHeight;
  }

  front.onclick = function() {
    front.style.display = "none";
    canv.style.display = "block";

    draw();
  }


    i = 0;
    draw();

}

  $(document).on('itemshow', '#hab-slideshow', function(){
      $('#hab-slideshow-progressbar').addClass('fill-progressbar');
  });

  $(document).on('beforeitemshow', '#hab-slideshow', function(){
      $('#hab-slideshow-progressbar').removeClass('fill-progressbar');
  });

    $('#main-container').imagesLoaded( function(){
      $('#loader-container').fadeOut('slow', function(){
        $('#loader-container').remove();
        $('#main-container').css('opacity','1');
            activateFogAnimation();
      });
  });

  $(document).on('show', '#reserve-modal', function(){
       activateFogAnimationonModal();
  });

  var removeImageLoaer = {
    opacity: 0,
    duration: 1000
  };

  var slideUp = {
      distance: '120%',
      origin: 'bottom',
      opacity: 0,
      interval: 500,
      duration: 1000
  };

  ScrollReveal().reveal('.inview-animation', slideUp);
  ScrollReveal().reveal('.image-loader', slideUp);


        //Trigger Events

        $('.editable-content').change(function(){

           var id = $(this).data('id');
           var content = $(this).val();

           UIkit.notification({
             message: 'Procesando Cambios',
             status: 'warning',
             pos: 'bottom-left',
             timeout: 2000
          });

           $.ajax({
             type: 'post',
             url: '/request/updatecontent',
             dataType: "json",
             data: {
            "id": id,
            "value": content,
             },
             async: true,
             success: function(data) {

               UIkit.notification({
                 message: 'Cambios Aplicados',
                 status: 'success',
                 pos: 'bottom-left',
                 timeout: 2000
              });

             }


        });

        });



});
