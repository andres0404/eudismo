/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/


// Objetos de los datos consultados
var arrStudBooks = []; // objeto JSON de los libros a entregar
var resStudBooks = []; // resultado del JSON cargado
var idstudGenesi = null;
var selPeridodo = null;
function Consultas(){
    
}

Consultas.prototype.getStudentBooks = function(per){  
    console.log(per);
    if(per === undefined){
        selPeridodo = periodo;
    }else{
        selPeridodo = per;
    }
    console.log(selPeridodo);
    idstudGenesi = $("#idGenSearch").val();
    $("#result_search").html('');
    $.ajax({
        url : '../business/controller/class.controladorLibros.php',
        data : { 
            funcion: 1, 
            id_genesis: idstudGenesi,
            periodo: selPeridodo
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            //console.log(json);
            resStudBooks = json;
            if(json.ok === 1){
                //console.log(json.datos[0]['u_nombres'])
                $("#studentNames").html(json.datos[0]['u_nombres']+' '+json.datos[0]['u_apellidos']);
                $("#result_search").html('');
                var entr;
                var chk;
                var ben = null;
                $.each(json.datos, function(k,v){
                    
                    if(v['libro_asignado'] === null){
                        if(v['id_libro'] !== null){ ben = 1;}                 
                        entr = '<small class="label label-danger">Sin entregar</small>';
                        chk = '<td><input type="checkbox" id="'+v['id_libro']+'"></td>';
                    }else{            
                        entr = '<small class="label label-success">Entregado</small>';
                        chk = '<td></td>';
                    }
                    if(v['lib_autor'] === null){
                        v['lib_autor'] = '';
                        v['lib_titulo'] = '';
                        entr = '<small class="label label-info">No tiene libro</small>';
                        chk = '<td></td>';                        
                    }                      
                    $("#result_search").append('<tr>'+
                        chk+
                        '<td class="mailbox-name"><a href="#">'+v['lib_autor']+'</a></td>'+
                        '<td class="mailbox-subject"><b>'+v['lib_titulo']+'</td>'+
                        '<td class="mailbox-date">'+v['nrc_nombre']+'</td>'+
                        '<td class="mailbox-date">'+entr+'</td>'+
                    '</tr>');
                    //console.log(v['libro_asignado'], ben);
                    if(ben === 1){$("#control-buttons-bks").css({ display: "block" });}
                    
                }); 
            }else if(json.ok === 0){
                $("#studentNames").html("Para el peridodo "+selPeridodo+" no hay NRC's asigandos para el ID");
            }

        },
        failure: function (response) {
            alert(response.responseText);
        },
        error: function (response) {
            alert(response.responseText);
        }
    });  
    
};

var cns = new Consultas();

/*
 * funcion para llenar el objeto a enviar de libros entregados
 * params{int} fn
 * indice de la función a ejecutar
 */

var AppBooks = {
    init:function(fn){
        // Constructor
        switch (fn) {
            case 1:
                //console.log(fn);  
                if($('#result_search input:checked').length > 0){
                    $("#alert-bks").css({ display: "none" });
                    AppBooks.createObjBooks();
                }else{
                    $("#alert-bks").css({ display: "block" });
                    $('#modal-default').modal('toggle');
                }
            break;
        }
        
    },
    createObjBooks:function(){
        $('#result_search input:checked').each(function() {
            
            for (var i = 0; i < resStudBooks.datos.length; i++){
                if (resStudBooks.datos[i].id_libro === $(this).attr('id')){
                    itemsBooks = {};
                    itemsBooks['id_libro'] = resStudBooks.datos[i].id_libro;
                    itemsBooks['nrc'] = resStudBooks.datos[i].nrc_nrc;
                    itemsBooks['id_genesis'] = resStudBooks.datos[i].id_genesis;                   
                    arrStudBooks.push(itemsBooks);
                }
            }
      
        });   
        //console.log(arrStudBooks);
        AppBooks.sendBooks();
    },
    sendBooks:function(){
        $.ajax({
            url : '../business/controller/class.controladorLibros.php',
            data : { 
                funcion: 2, 
                arrStudBooks: JSON.stringify(arrStudBooks)            
            },
            type : 'POST',
            dataType : 'json',
            success : function(json) {
                //console.log(json);
                arrStudBooks = [];
                $('#modal-default').modal('toggle');
                if(json.ok === 1){
                    //console.log(json.ok);
                    cns.getStudentBooks();
                }
            },
            failure: function (response) {
                //alert(response.responseText);
                arrStudBooks = [];
                
            },
            error: function (response) {
                //alert(response.responseText);
                arrStudBooks = [];
            }
        });        
 
    },
    /*
     * Controlador de las estadísticas
     */
    statisticsBooks:function(){
        
    }
};


