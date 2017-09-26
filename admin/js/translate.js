/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/

function Translate(idf){
}

var ind = null;
Translate.prototype.init = function(idf, mod){
    document.getElementById('al_frm').style.display = 'none';
    this.idf = idf;
    this.mod = mod;
    this.frm = document.getElementById(idf);
    //console.log(this.frm.elements.length);
    for(var i = 0; i < this.frm.elements.length; i++){
        var fv = this.frm.elements[i].value;
        //console.log(fv, i);
        trad.traductor(fv, i);
        
    }
};

Translate.prototype.traductor = function(fv, i){
    var io = document.getElementById('idOrigen').value;
    var it = document.getElementById('idTraducir').value;
    //console.log(io, it);
    $.ajax({
        url : 'https://statickidz.com/scripts/traductor/index.php?source='+io+'&target='+it+'&q='+fv,
        type : 'GET',
        dataType : 'json',
        success : function(json) {
            trad.setValues(i, json.translation);
            //console.log(i, json.translation);
        }
    });
};
Translate.prototype.setValues = function(i, tr){
    this.frm.elements[i].value = tr;
    ind = i;
    trad.setProgressBar();
    
};

Translate.prototype.setProgressBar = function(){
    //console.log('setProgressBar');
    var frm = this.frm.elements.length;
    document.getElementById('pg_bar').style.display = 'block';
    var current_progress = 0;
    var interval = setInterval(function(frm, ind) {
        current_progress += 20;
        $("#dynamic")
        .css("width", current_progress + "%");

    }, 100);  
    //console.log('', ind, this.frm.elements.length-1);
    if(ind === this.frm.elements.length-1){
        document.getElementById('pg_bar').style.display = 'none';
        clearInterval(interval);
        trad.sendData();
    }

};

Translate.prototype.sendData = function(){
    var ser = $( '#frm_standar' ).serializeArray();
    ser[ser.length] = { name: 'lang', value: document.getElementById('idTraducir').value};
    ser[ser.length] = { name: 'funcion', value: this.mod};
    
    var imgGen = document.getElementById('img_cjm');
    var famPad = document.getElementById('fame_id_padre');
    console.log(imgGen);
    if (imgGen !== null) {
        console.log('entra');
        ser[ser.length] = { name: 'cjm_imagen', value: baseImg};
    }
    if (famPad !== null) {
        ser[ser.length] = { name: 'fame_id_padre', value: famPad};
        ser[ser.length] = { name: 'id_articulo', value: ''};
    }else{
        ser[ser.length] = { name: 'id_articulo', value: document.getElementById('id_articulo').value};
    }
    //console.log(ser);
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : ser,
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.cod_respuesta === 1){
                trad.setMensaje(1, json.mensaje);
                document.getElementById('id_articulo').value = json.data.id_articulo;
                arrLng[arrCfg[3]] = 0;
                var ps = csl.sePosLang(document.getElementById('idTraducir').value);
                //console.log('Acá', arrD[0], arrD[1], document.getElementById('idTraducir').value, csl.sePosLang(document.getElementById('idTraducir').value));
                arrLng[ps] = 0;
                csl.init( arrD[0], arrD[1], document.getElementById('idTraducir').value, csl.sePosLang(document.getElementById('idTraducir').value)  );
            }

        },  
        statusCode: {
            404: function() {
                alert( "URL no encontrada" );
            }
        },    
        error : function(xhr, status) {
            trad.setMensaje(2, 'Se presentó un problema');
        },
        complete : function(xhr, status) {
            //alert('Petición realizada');
        }
    }); 
    
};

Translate.prototype.setMensaje = function(tm, msg){
    if(tm === 1){
        document.getElementById('al_frm').className = 'callout callout-success';  
        document.getElementById('al_frm').getElementsByTagName('h4')[0].innerHTML = 'Exito';
    }else{
        document.getElementById('al_frm').className = 'callout callout-danger';  
        document.getElementById('al_frm').getElementsByTagName('h4')[0].innerHTML = 'Error';
    }
    document.getElementById('al_frm').style.display = 'block';  
    document.getElementById('al_frm').getElementsByTagName('p')[0].innerHTML = msg;  
    setTimeout(function(){
        document.getElementById('al_frm').style.display = 'none';
    },3000);
};




Translate.prototype.sendDataCantos = function(){  
    event.preventDefault();
    var form = $('#frm_standar')[0];
    var data = new FormData(form);
    data.append("lang", "es");
    data.append("id_articulo", document.getElementById('id_articulo').value );
    data.append("funcion", "9");
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "../../business/controller/class.controlador.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $("#result").text(data);
            console.log("SUCCESS : ", data);
            $("#btnSubmit").prop("disabled", false);
        },
        error: function (e) {
            $("#result").text(e.responseText);
            console.log("ERROR : ", e);
            $("#btnSubmit").prop("disabled", false);
        }
    });   
};


var trad = new Translate();