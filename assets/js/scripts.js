   $( document ).ready( function () {
     var nav = $(".navbar");
    $(window).scroll(function() {
      // Add class after 50px from the top
      if ($(window).scrollTop() >= 50) {
        nav.addClass("white-navbar");
        

      } else {
        nav.removeClass("white-navbar");
      }
    });
  
        $(":input[type=tel]").mask("+7 (999) 99-99-999");
     
});

window.addEventListener('DOMContentLoaded', function () {
   const gallery_1 = new Viewer(document.getElementById('gallery'));
   const gallery_2 = new Viewer(document.getElementById('excursion'));
  });

$("form").submit(function(e){
  e.preventDefault();
 
  let fd = $(this).serialize();
  $.ajax({
        method: "POST",
        url: 'h.php',
        data: fd,
        complete: function(r){
          console.log(r);
           var goalParams = {
       order_price: 1000.35,
       currency: "RUB"
    };
          ym(56748280, 'reachGoal', 'lead', goalParams);
          alert('Наш менеджер позвонит вам в течение минуты!');


          }
      }); 
});

//E2hQCBiR)yO)p$f1cy5G