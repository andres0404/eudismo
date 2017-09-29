/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/

function CallData(){
    // constructor
}

CallData.prototype.login = function(){
    console.log($("#usuario").val());
    $.ajax({
        url : 'http://uvd.uniminuto.edu/boletin/eudista/business/controller/class.login.php',
        data : {u_correo: $("#usuario").val(), u_clave: $("#password").val(), funcion:1 },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            console.log('->>>>', json);
            console.log(json, json.ok, json.tipo_usuario);
            if(json.ok === 1){
                //window.location = 'admin/';

            }else{
                alert('Datos incorrectos');

            }

        }
    });
};

var CD = new CallData();
