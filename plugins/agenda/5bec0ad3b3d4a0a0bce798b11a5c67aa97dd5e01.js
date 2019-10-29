
$(function(){
    $.contextMenu({selector:".theagendatablebody",callback:function(a,b){$("#NuevoContacto").modal("show")},items:{edit:{name:"Nuevo Contacto",icon:"edit"}}})
});
function editarContacto(a,b){
    $.ajax({url:a[0],type:"POST",data:"process=2&tabla="+a[1]+"&contacto="+b,beforeSend:function(){},success:function(a){$("#agenda-append").html(a);$("#agenda-model").modal("show")},error:function(){}})
}
function eliminarContacto(a,b){
    $.ajax({url:a[0],type:"POST",data:"process=4&tabla="+a[1]+"&contacto="+b,beforeSend:function(){},success:function(a){$("#contacto"+a).addClass("animated bounceOut").fadeOut(1E3)},error:function(){}})
}
function nuevoContactoCrear(a){
    var b=a[0],c=a[1];jQuery.validator.setDefaults({debug:!0,success:"valid",ignore:[]});var d=$("#NuevoContactoFRM");d.validate({rules:{nombre:"required",apellido:"required",telefono:"required",email:"required",comentarios:"required"},messages:{nombre:"Campo obligatorio.",apellido:"Campo obligatorio.",telefono:"Campo obligatorio.",email:"Campo obligatorio.",comentarios:"Campo obligatorio."}});1==d.valid()&&(a=d.serialize(),$.ajax({type:"POST",url:b,data:"process=3&tabla="+c+"&"+a,beforeSend:function(){},success:function(a){$("#NuevoContacto").modal("toggle");$("tbody."+c).append(a);d[0].reset()},error:function(){}}))
}
function guardarCambiosContacto(a){
    var b=a[0];a=a[1];jQuery.validator.setDefaults({debug:!0,success:"valid",ignore:[]});var c=$("#editarContactoFRM");c.validate({rules:{nombre:"required",apellido:"required",telefono:"required",email:"required",comentarios:"required"},messages:{nombre:"Campo obligatorio.",apellido:"Campo obligatorio.",telefono:"Campo obligatorio.",email:"Campo obligatorio.",comentarios:"Campo obligatorio."}});1==c.valid()&&(c=c.serialize(),$.ajax({type:"POST",dataType:"json",url:b,data:"process=5&tabla="+a+"&"+c,beforeSend:function(){},success:function(a){$("#agenda-model").modal("toggle");$(".tdnombre"+a.id).text(a.nombre);$(".tdapellido"+a.id).text(a.apellido);$(".tdtelefono"+a.id).text(a.telefono);$(".tdemail"+a.id).text(a.email);$(".tdcoment"+a.id).text(a.comentarios)},error:function(){}}))
};