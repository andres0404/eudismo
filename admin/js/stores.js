/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/
var arrLng = [0,0,0,0,0,0,0,0];
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
            console.log()
            if(arrLng[this.ps] === 0){
                console.log('->  csl.getCJM');
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
        case 4: 
            if(arrLng[this.ps] === 0){
                csl.getOraciones(this.fn , this.le);   
            }   
            break;         
        case 5: 
            if(arrLng[this.ps] === 0){
                //csl.getOraciones(this.fn , this.le);   
            }   
            break;         
        case 6: 
            if(arrLng[this.ps] === 0){
                csl.getFamilia(this.fn , this.le);   
            }   
            break;         
        case 7: 
            if(arrLng[this.ps] === 0){
                csl.getNovedades(this.fn , this.le);   
            }   
            break;    
        case 8:
            csl.getCantosCategorias();
            break;
        case 9:
            csl.getCantosEudistas(fn);
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
                //console.log('lang', lg);
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
                            '<h3 class="box-title">'+v.fj_tematica+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+
                                '<dt>Referencia Bíblica</dt>'+
                                '<dd>'+v.fj_ref_biblia+'</dd>'+                                
                                '<dt>Objetivo</dt>'+
                                '<dd>'+v.fj_objetivo+'</dd>'+
                                '<dt>Lectura Eudista</dt>'+
                                '<dd>'+v.fj_lec_eudista+'</dd>'+    
                                '<dt>Oración Final</dt>'+
                                '<dd>'+v.fj_oracion_final+'</dd>'+       
                                '<dt>Fecha de publicación</dt>'+
                                '<dd>'+v.fecha_publica+'</dd>'+                              
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
 * Consulta para las Oraciones
 */
Consultas.prototype.getOraciones = function(){  
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
                            '<h3 class="box-title">'+v.ora_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+                               
                                '<dd>'+v.ora_oracion+'</dd>'+                              
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.oracionesFull('+v.id_articulo+')">Actualizar</button>'+
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
 * Consulta para las Oraciones
 */
Consultas.prototype.getFamilia = function(){  
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
                            '<h3 class="box-title">'+v.fame_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+                               
                                '<dd>'+v.fame_id_padre+'</dd>'+                              
                                '<dd>'+v.fame_desc+'</dd>'+                              
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.oracionesFull('+v.id_articulo+')">Actualizar</button>'+
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
 * Consulta para las Npvedades
 */
Consultas.prototype.getNovedades = function(){  
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
                            '<h3 class="box-title">'+v.novt_titulo+'</h3>'+
                            '<div class="bg-aqua-active color-palette" id="txt-publicacion"><span>Id publicación: '+v.id_articulo+'</span></div>'+
                        '</div>'+
                        '<div class="box-body">'+
                            '<dl>'+                               
                                '<dd>'+v.novt_desc+'</dd>'+                              
                            '</dl>'+
                        '</div>'+
                    '</div>'+
                    // Botones de configuración
                    '<div class="box-footer ui-sortable-handle" style="cursor: move;">'+
                        '<div class="pull-right box-tools">'+
                            '<button type="button" class="btn btn-success btn-sm" id="btn-upd" data-toggle="modal" data-target="#modal-default" onclick="csl.oracionesFull('+v.id_articulo+')">Actualizar</button>'+
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
 * Set form update Fromar a Jesús (Itinerario)
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
            document.getElementById('fj_tematica').value = arrStr[i].fj_tematica;
            document.getElementById('fj_ref_biblia').value = arrStr[i].fj_ref_biblia;
            document.getElementById('fj_objetivo').value = arrStr[i].fj_objetivo;
            document.getElementById('fj_lec_eudista').value = arrStr[i].fj_lec_eudista;
            document.getElementById('fj_oracion_final').value = arrStr[i].fj_oracion_final;
            document.getElementById('fj_fecha').value = arrStr[i].fecha_publica;        
        }
    }
    arrCfg = [3, 6, document.getElementById('idTraducir').value, csl.sePosLang(this.le)];
};


/*
 * Set form update Oraciones
 */
Consultas.prototype.oracionesFull = function(ip){
    //console.log(ip, this.le);
    document.getElementById('idTraducir').value = this.le;
    document.getElementById('idOrigen').value = this.le;
    document.getElementById('id_articulo').value = ip;
    //console.log(arrStr.length);
    for(var i = 0; i < arrStr.length; i++){
        var iAr = parseInt(arrStr[i].id_articulo);
        if(ip === iAr){
            console.log(arrStr[i].id_articulo, arrStr[i].cjm_desc);
            document.getElementById('ora_categoria').value = arrStr[i].ora_categoria;
            document.getElementById('ora_titulo').value = arrStr[i].ora_titulo;
            document.getElementById('ora_oracion').value = arrStr[i].ora_oracion;   
        }
    }
    arrCfg = [3, 6, document.getElementById('idTraducir').value, csl.sePosLang(this.le)];
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



/*
 * Consulta para las categorias de los cantos
 */

Consultas.prototype.getCantosCategorias = function(){  
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { 
            funcion: 18,
            lang: ''
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            console.log(json);
            if(json.cod_respuesta === 1){
                
                arrStr = json.data;
                $('#list-cantos').html('');
                $.each(json.data, function(k,v){  
                    //console.log(k, '->> ', json.data[k]);
                    var tit = "'La Categoría: "+json.data[k]+"'";
                    console.log(tit);
                    if(k === 1){
                        $('#ceu_categoria').append('<option value="'+k+'" selected = "selected">'+json.data[k]+'</option>');
                    }
                    else{
                        $('#ceu_categoria').append('<option value="'+k+'">'+json.data[k]+'</option>');
                    }
                    
                    $('#list-cantos').append('<li onclick="csl.init(9, '+k+'); csl.setTitle('+tit+');">'+
			'<span class="handle ui-sortable-handle">'+
                            '<i class="fa fa-ellipsis-v"></i>'+
                            '<i class="fa fa-ellipsis-v"></i>'+
			'</span>'+
			'<span class="text" id="text-initial">'+json.data[k]+'</span>'+
                    '</li>');
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
 * Consulta para los cantos eudistas
 * @param {type} fn
 * @returns {undefined}
 */
Consultas.prototype.getCantosEudistas = function(fn){  
    console.log(fn);
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { 
            funcion: 10,
            ceu_categoria: fn,
            lang: ''
        },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            console.log(json);
            if(json.cod_respuesta === 1){
                $('#list-cantos-categorias').html('');
                $.each(json.data, function(k,v){  
      
                    $('#list-cantos-categorias').append('<div class="box box-solid">'+
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
Consultas.prototype.setTitle = function(tit){ 
    console.log(tit);
    document.getElementById('tit-categorias').innerHTML = tit;
}



var csl = new Consultas();

