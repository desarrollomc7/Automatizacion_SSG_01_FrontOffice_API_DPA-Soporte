// console.log("Cargando reload.js");
//No funciona por el momento
// $(document).ready(function(){
//     $('#table_wrapper').doubleScroll();
//     alert("activado");
// });

//Actualizar tabla con datos del formulario
function jDepartamento(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarDepartamento.php',
        data: {
            // departamento:val
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Ciudad").innerHTML=response; 
        }
    });
    // $.ajax({
        //     type: 'post',
        //     url: 'php/actualizarTabla.php',
        //     data: {
            //         departamento:val,
            //         tipo1:$('#Tipo1').val(),
            //         tipo2:$('#Tipo2').val(),
            //         tipo3:$('#Tipo3').val()
            //     },
            //     success: function (response) {
                //         document.getElementById("Tabla").innerHTML=response; 
                //     }
                // });
}
            
function jCiudad(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            ciudad:val,
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val(),
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

function jAgente(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            agente:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo1(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo1:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo2(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo2:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}
function jTipo3(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            tipo3:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

function jEstado(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            estado:val,
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            tipo1:$('#Tipo1').val(),
            tipo2:$('#Tipo2').val(),
            tipo3:$('#Tipo3').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

//Completo con boton Buscar
var myVar;
function buscar()
{
    // debugger;
    if( $('#fecha1').val() == "" && $('#fecha2').val() == "") {
        var d = new Date();
        var mes = d.getMonth() + 1;
        var dia = ( d.getDate() < 10 ) ? "0" + d.getDate() : d.getDate();
        var n = d.getFullYear() + "-" + mes + "-" + dia;
        document.getElementById("fecha1").value = n;
    }
    document.getElementById("Tabla").click();
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            estado:$('#Estado').val(),
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val(),
            agente:$('#Agente').val(),
            cedula:$('#Cedula').val(),
            tipo1:$('#Tipo1').val(),
            tipo3:$('#Tipo3').val(),
            almacen:$('#Almacen').val(),
            fecha1:$('#fecha1').val(),
            fecha2:$('#fecha2').val(),
            linea:$('input[name=linea]:checked').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
    myVar = setTimeout(buscar,30000);
}
function jNombre(val)
{
    $.ajax({
        type: 'post',
        url: 'php/actualizarTabla.php',
        data: {
            nombre:val,
            cedula:$('#Usuario').val(),
            ciudad:$('#Ciudad').val(),
            departamento:$('#Departamento').val()
        },
        success: function (response) {
            document.getElementById("Tabla").innerHTML=response; 
        }
    });
}

//Exportar tabla a excel
$(document).ready(function() {
    $("#btnExport").click(function(e) {
        e.preventDefault();
        
        //obtener datos de nuestra tabla, para que coja las tildes utf8 + UCI
        var data_type = 'data:text/csv;charset=utf-8,%EF%BB%BF';
        var table_div = document.getElementById('table_wrapper');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        
        var a = document.createElement('a');
        a.click();
        a.href = data_type + ', ' + table_html;
        //   a.download = 'reporte_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
        
        var fecha = new Date();
        a.download = "Reporte_" + new String(fecha.getDate()) + "-" + new String(fecha.getMonth()) + "-" + new String(fecha.getFullYear()) + "/" + new String(fecha.getHours()) + "." + new String(fecha.getMinutes()) + ".xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
});

function pulsar(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13) buscar();
}

//reiniciar busqueda 
function recargar(){
    $("#Agente").val("");
    $("#Cedula").val("");
    $("#Nombre").val("");
    $("#Ciudad").val("");
    $("#Departamento").val("");
    $("#Tipo1").val("");
    $("#Tipo3").val("");
    $("#Almacen").val("");
    location.reload();
}


//Prueba de mensajes de carga de UIPath
function test() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.body.innerHTML = '<div style="font-family: sans-serif; position: fixed; background: red; color: white; width: 300px; height: 100px; text-align: center; top: 80%; left: 80%;" id="DCargando"><p style="line-height: 100px;">Cargando DPA. Por favor espere...</p></div>' + document.body.innerHTML;
        }
    };
    xhttp.open("GET", "js/captura.png", true);
    xhttp.send();
}