/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/

function CallData(){
    // constructor
}

CallData.prototype.login = function(){
	document.location = 'admin/';
	/*
    console.log($("#usuario").val());
    $.ajax({
        url : 'business/controller/class.login.php',
        data : {usuario: $("#usuario").val(), password: $("#password").val() },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            console.log('->>>>');
            console.log(json, json.ok, json.tipo_usuario);
            if(json.ok === 1 && json.tipo_usuario === "5"){
                window.location = 'admin/';
            }

        }
    });
	*/
};

var CD = new CallData();
