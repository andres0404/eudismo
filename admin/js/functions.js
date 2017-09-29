/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/
/*
funcion: 19,
lang: lang
id_articulo:
DAO: ''
*/

function Eliminar(){
    
}

Eliminar.prototype.deleteAll = function(ia, cm){
    
    console.log(19, lenCat, ia, del.setMod(cm) );

    var mod = del.setMod(cm) ;
    var r = confirm("Desea eliminar la publicación?!");
    if (r == true) {
        $.ajax({
            url : '../../business/controller/class.controlador.php',
            data : { 
                funcion: 19,
                lang: lenCat,
                id_articulo:ia,
                DAO: mod 
            },
            type : 'POST',
            dataType : 'json',
            success : function(json) {
                if(json.cod_respuesta === 1){
                    location.reload();

                }

            },
            failure: function (response) {
                alert(response.responseText);
            },
            error: function (response) {
                alert(response.responseText);
            }
        }); 
    } else {
        return;
    }
    
};

Eliminar.prototype.setMod = function(cm){
    var rtn = null;
    if(cm === 1){
        rtn = 'cjm';
    }else if(cm === 2){
        rtn = 'temas_fundamentales';
    }else if(cm === 3){
        rtn = 'formar_jesus';
    }else if(cm === 4){
        rtn = 'oraciones';
    }else if(cm === 5){
        rtn = 'cantos_eudistas';
    }else if(cm === 6){
        rtn = 'familia_eudista';
    }else if(cm === 7){
        rtn = 'noticias';
    }else if(cm === 8){
        rtn = 'testimonios';
    }
    return rtn;
};


var del = new Eliminar();

