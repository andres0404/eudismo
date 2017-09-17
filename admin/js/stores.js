/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/
var arrLng = [0,0,0,0,0,0];
var arrStr = [];
var arrCfg = [];
function Consultas(){
    
}

Consultas.prototype.init = function(ex, fn, le, ps){
    //console.log(ex, fn, le, ps);
    this.fn = fn;
    this.le = le;
    this.ps = ps;
    switch (ex){
        case 1: 
            if(arrLng[this.ps] === 0){
               csl.getCJM(this.fn , this.le);   
            }   
            break;
        case 2: 
            if(arrLng[this.ps] === 0){
               csl.getTemas(this.fn , this.le);   
            }   
            break;  
        case 3: 
            if(arrLng[this.ps] === 0){
               csl.getFormar(this.fn , this.le);   
            }   
            break;     
        default :
            console.log('Paila');
    }     
};

/*
 * Consulta para La CJM
 */
Consultas.prototype.getCJM = function(){  
    //console.log(this.ps, this.fn, this.le);
    var lg = this.le;
    arrLng[this.ps] = 1;
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { 
            funcion: this.fn,
            lang: this.le
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            //console.log(json.cod_respuesta);
            if(json.cod_respuesta === 1){
                console.log('lang', lg);
                arrStr = json.data;
                $('#lg-'+lg).html('');
                $.each(json.data, function(k,v){                 
                    $('#lg-'+lg).append('<div class="box box-solid">'+
                        '<div class="box-header with-border">'+
                            '<h3 class="box-title">'+v.cjm_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+
                                '<dd>'+v.cjm_desc+'</dd>'+
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.cjmFull('+v.id_articulo+')">Actualizar</button>'+
                            '<button type="button" class="btn btn-danger btn-sm" id="btn-del">Eliminar</button>'+
                        '</div>'+
                    '</div>');
                });
                
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
/*
 * Consulta para Temas Fundamentales
 */
Consultas.prototype.getTemas = function(){  
    //console.log(this.ps, this.fn, this.le);
    var lg = this.le;
    arrLng[this.ps] = 1;
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { 
            funcion: this.fn,
            lang: this.le
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            //console.log(json.cod_respuesta);
            if(json.cod_respuesta === 1){
                //console.log('lang', lg);
                arrStr = json.data;
                $('#lg-'+lg).html('');
                $.each(json.data, function(k,v){                 
                    $('#lg-'+lg).append('<div class="box box-solid">'+
                        '<div class="box-header with-border">'+
                            '<h3 class="box-title">'+v.funda_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+
                                '<dd>'+v.funda_desc+'</dd>'+
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.temasFull('+v.id_articulo+')">Actualizar</button>'+
                            '<button type="button" class="btn btn-danger btn-sm" id="btn-del">Eliminar</button>'+
                        '</div>'+
                    '</div>');
                });
                
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
/*
 * Consulta para Formar a Jésus (Itinerario)
 */
Consultas.prototype.getFormar = function(){  
    //console.log(this.ps, this.fn, this.le);
    var lg = this.le;
    arrLng[this.ps] = 1;
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { 
            funcion: this.fn,
            lang: this.le
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            //console.log(json.cod_respuesta);
            if(json.cod_respuesta === 1){
                //console.log('lang', lg);
                arrStr = json.data;
                $('#lg-'+lg).html('');
                $.each(json.data, function(k,v){                 
                    $('#lg-'+lg).append('<div class="box box-solid">'+
                        '<div class="box-header with-border">'+
                            '<h3 class="box-title">'+v.funda_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+
                                '<dd>'+v.funda_desc+'</dd>'+
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.formarFull('+v.id_articulo+')">Actualizar</button>'+
                            '<button type="button" class="btn btn-danger btn-sm" id="btn-del">Eliminar</button>'+
                        '</div>'+
                    '</div>');
                });
                
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


/*
 * Set form update CJM
 */

Consultas.prototype.cjmFull = function(ip){
    //console.log(ip, this.le);
    document.getElementById('idTraducir').value = this.le;
    document.getElementById('idOrigen').value = this.le;
    document.getElementById('id_articulo').value = ip;
    //console.log(arrStr.length);
    for(var i = 0; i < arrStr.length; i++){
        var iAr = parseInt(arrStr[i].id_articulo);
        if(ip === iAr){
            console.log(arrStr[i].id_articulo, arrStr[i].cjm_desc);
            document.getElementById('cjm_titulo').value = arrStr[i].cjm_titulo;
            document.getElementById('cjm_desc').value = arrStr[i].cjm_desc;
        }
    }
    arrCfg = [1, 2, this.le, csl.sePosLang(this.le)];
};



/*
 * Set form update Temas Fudamentales
 */
Consultas.prototype.temasFull = function(ip){
    //console.log(ip, this.le);
    document.getElementById('idTraducir').value = this.le;
    document.getElementById('idOrigen').value = this.le;
    document.getElementById('id_articulo').value = ip;
    //console.log(arrStr.length);
    for(var i = 0; i < arrStr.length; i++){
        var iAr = parseInt(arrStr[i].id_articulo);
        if(ip === iAr){
            console.log(arrStr[i].id_articulo, arrStr[i].cjm_desc);
            document.getElementById('funda_titulo').value = arrStr[i].funda_titulo;
            document.getElementById('funda_desc').value = arrStr[i].funda_desc;
        }
    }
    arrCfg = [2, 4, document.getElementById('idTraducir').value, csl.sePosLang(this.le)];
};


/*
 * Set form update CJM
 */
Consultas.prototype.formarFull = function(ip){
    //console.log(ip, this.le);
    document.getElementById('idTraducir').value = this.le;
    document.getElementById('idOrigen').value = this.le;
    document.getElementById('id_articulo').value = ip;
    //console.log(arrStr.length);
    for(var i = 0; i < arrStr.length; i++){
        var iAr = parseInt(arrStr[i].id_articulo);
        if(ip === iAr){
            console.log(arrStr[i].id_articulo, arrStr[i].cjm_desc);
            document.getElementById('funda_titulo').value = arrStr[i].funda_titulo;
            document.getElementById('funda_desc').value = arrStr[i].funda_desc;
        }
    }
    arrCfg = [2, 4, document.getElementById('idTraducir').value, csl.sePosLang(this.le)];
};


/*
 * 
 */
Consultas.prototype.sePosLang = function(le){
    var rtn = null;
    if(le === 'es'){
        rtn = 1;
    }else if(le === 'en'){
        rtn = 2;
    }else if(le === 'fr'){
        rtn = 3;
    }else if(le === 'de'){
        rtn = 4;
    }else if(le === 'it'){
        rtn = 5;
    }else if(le === 'pt'){
        rtn = 6;
    }
    return rtn;
};



var csl = new Consultas();

