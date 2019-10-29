/*
 _____                                    __  __                                               
/\___ \                                  /\ \/\ \                                              
\/__/\ \     __    ____  __  __  __  _   \ \ \_\ \     __   _ __   _ __    __   _ __    __     
   _\ \ \  /'__`\ /',__\/\ \/\ \/\ \/'\   \ \  _  \  /'__`\/\`'__\/\`'__\/'__`\/\`'__\/'__`\   
  /\ \_\ \/\  __//\__, `\ \ \_\ \/>  </    \ \ \ \ \/\  __/\ \ \/ \ \ \//\  __/\ \ \//\ \L\.\_ 
  \ \____/\ \____\/\____/\ \____//\_/\_\    \ \_\ \_\ \____\\ \_\  \ \_\\ \____\\ \_\\ \__/.\_\
   \/___/  \/____/\/___/  \/___/ \//\/_/     \/_/\/_/\/____/ \/_/   \/_/ \/____/ \/_/ \/__/\/_/

Template:
Mi Pagina: http://www.vivegroup.org/
Twitter: https://twitter.com/katzhate
Facebook: https://www.facebook.com/katzhate/
Email: katzhate@vivegroup.org
*/



$(document).ready(function() {
  $(window).load(function() {



      // Animación de Entrada
      $('#sub-loading h1').addClass('animated infinite flash');

      // Remover el loading
      setTimeout(function(){
        $('#sub-loading').removeClass('animated infinite flash').addClass('animated bounceOut').fadeOut(1000);
      },2000);
      setTimeout(function(){
        $('#sub-loading .progress').addClass('animated flipOutX').fadeOut(1000);
      },2000);
      setTimeout(function(){
        $('#loading').addClass('animated bounceOut').fadeOut(1000);
      },3000);


    });
});



// Function Constructor
function ConstructorScript(data){
      var ruta = data[0];
      var tabla = data[1];
      var parentbody = $('#'+tabla);

    $.ajax({
         type: 'POST',
         url: ruta,
         data: 'process=1&tabla='+tabla,
         beforeSend: function(){
         },
         success: function(datarequest){
             parentbody.html(datarequest);
         },
         error: function(){
         }
    });
}


// Function AJAX Request
function ajaxsenddata(datarequest){
  var desktoprequest = 'process='+datarequest;
  $.ajax({
         url:  'app/desktop.function.php',
         type: 'POST',
         data: desktoprequest,
         beforeSend: function(){

         },
         success: function(datareturn){
         	
         },
         error: function(){
         }
    });	
}


function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


function minusFolder(data){

$('.window'+data).addClass('animated zoomOutDown').fadeOut(1000);
var theattributewindow = $('.window'+data).attr('data-window');
var thetitle = $('.window'+data+' .panel-heading').html();

$('#btn'+theattributewindow).remove();
setTimeout(function(){
   $('#minusapp').append('<button id="btn'+theattributewindow+'" onclick="showFolder('+theattributewindow+');" class="panel-folder-btn-minus btn btn-default animated flipInX">'+thetitle+'</button>');
   $('#btn'+theattributewindow+' a').hide();
},1000);
return;

}


function animatebtnpanel(){


   // Maximizar Folder
   $('.maximus-btn').on('click', function(){
       var parentfolder = $(this).parent().parent();
       var theidappwindow = $(this).parent().parent().attr('id');
       $('#'+theidappwindow+' .minimus-btn').show();
       $(this).hide();
       parentfolder.animate({
           width: "99%",
           top: "35px",
           left: "10px"
       },1000);
   });


   // Maximizar Folder
   $('.minimus-btn').on('click', function(){
       var parentfolder = $(this).parent().parent();
       var theidappwindow = $(this).parent().parent().attr('id');
       $('#'+theidappwindow+' .maximus-btn').show();
       $(this).hide();
       parentfolder.animate({
           width: "800px",
           top: "20%",
           left: "10%"
       },1000);
   });


   // Efecto al Cerrar el  Folder
   $('.close-btn').on('click', function(){
       var parentfolder = $(this).parent().parent();
       parentfolder.removeClass('animated zoomIn zoomOutDown zoomInUp').addClass('animated shake').fadeOut(1000);
       setTimeout(function(){parentfolder.remove();},1200);
   });

   // Efecto del Cursor Cuando se mueve el folder
   $('.panel-default>.panel-heading').mousedown(function() {
      $(this).addClass("cursorpointer")  
      .mouseup(function() {
      $(this).removeClass("cursorpointer");
      })
    });


   // Instalador
   $('.installerbtn').on('click', function(){
     $('#componentinput').click();
   });


   $("#componentinput").change( function(){
      pesoimg = this.files[0].size;
      var sizeInMB = (pesoimg / (1024*1024)).toFixed(2);
     
      if (sizeInMB > 2){
         $('#alertimg').show();
         setTimeout(function(){$('#alertimg').fadeOut(1000);},3000);
         $(this).val('');
         return;
      }

      //información del formulario
      var componentup = new FormData($("#formuploadcomponent")[0]);
      //hacemos la petición ajax  
      $.ajax({
          url: 'app/desktop.function.php',  
          type: 'POST',
          // Form data
          //datos del formulario
          data: componentup,
          //necesario para subir archivos via ajax
          cache: false,
          contentType: false,
          processData: false,
          //mientras enviamos el archivo
          beforeSend: function(){
              $('#first-div-installer').hide();
              $('#second-div-installer').show();
          },
          //una vez finalizado correctamente
          success: function(datareturn){
              
              $('#second-div-installer').hide();
              setTimeout(function(){$('#final-process-installer').show();},500);
              if (datareturn == 1){
                $('#final-process-installer').html('<div class="alert alert-success animated flash" role="alert"><i class="fa fa-check fa-5x" aria-hidden="true"></i><p><h4>El Complemento fue instalado de manera exitosa.</h4></p></div>');
                $('#notifications').addClass('animated fadeInUp').fadeIn(1000);
                setTimeout(function(){location.reload();},5000);
              }else{
                $('#final-process-installer').html('<div class="alert alert-danger animated flash" role="alert"><i class="fa fa-times-circle-o fa-5x" aria-hidden="true"></i><p><h4>Ocurrio un Error al tratar de instalar el complemento.</h4></p></div>');
                $('#notifications').addClass('animated fadeInUp').fadeIn(1000);
                setTimeout(function(){location.reload();},5000);
              }

          },
          //si ha ocurrido un error
          error: function(){
          }
      });

   });






}


function showFolder(thaitem){
	$('#btn'+thaitem).removeClass('animated flipInX').addClass('animated flipOutX');
 	$('.window'+thaitem).removeClass('animated zoomOutDown').addClass('animated zoomInUp').fadeIn(1000);
  setTimeout(function(){$('#btn'+thaitem).remove();},1000);
}




$('.item-option').on('click', function(){
  var dataitem = $(this).attr('data-item');
  $('.item-option').removeAttr("style");
  setTimeout(function(){$('#'+dataitem).addClass("active");},100);
});


$('#desktop').on('click', function(){
  $('.item-option').removeClass("active");
});


$('.item-option').dblclick(function(){
  var datarequest = $(this).attr('data-option');
  var dataitem = $(this).attr('data-item');
  var theitemdom = $(this);
  $('.item-option').removeClass("active");
  $(this).addClass("active");

  var thedataiditem = "#"+datarequest+"app";

  var desktoprequest = 'process='+datarequest;
  $.ajax({
         url:  'app/desktop.function.php',
         type: 'POST',
         data: desktoprequest,
         beforeSend: function(){
            theitemdom.addClass('animated flash');
         },
         success: function(datareturn){
         	$('#data-append').append(datareturn);
         	$(".panel-default>.panel-heading").parent().draggable();
         	animatebtnpanel();
         	setTimeout(function(){$('#'+dataitem).removeClass("active animated flash");},500);
         },
         error: function(){
         }
    });
});





