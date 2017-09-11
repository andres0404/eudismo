/* 
    Created on : 27/05/2017, 10:19:48 AM
    Author     : luis.caceres
*/
$(document).ready(function() {
    var selPeridodo = null;
    function ConsultasEstadisticas(){
    };

    ConsultasEstadisticas.prototype.format = function( d ) {
        //console.log(d);
        return 'Título: '+d[2];
    };

    var booksData = $('#booksData').dataTable({      
        dom: 'Blfrtip',
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            'pdfHtml5'
        ], 
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "datos":           null,
                "defaultContent": "",
                "width": "40px"
            },
            { "datos": 'lib_alfanumerico', "width": "80px" },
            { "datos": 'lib_titulo' },
            { "datos": 'lib_editorial', "width": "300px"  },
            { "datos": 'lib_precio' },
            { "datos": 'total_libros',  "width": "100px" },
            { "datos": 'valor_libros',  "width": "100px" }
        ],
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        // Grupo por columna en la tabla
        "columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[ 3, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(3, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="6">Editorial: '+group+'</td></tr>'
                    );

                    last = group;
                }
            });
        },
        // Sumatoria del valor de los libros
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 6 ).footer() ).html(
                ' $'+ total
            );
        }

    });

    var verDetalles = [];

    $('#booksData tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = booksData.api().row( tr );
        var idx = $.inArray( tr.attr('id'), verDetalles );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
            verDetalles.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( cns.format( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                verDetalles.push( tr.attr('id') );
            }
        }
    });

    $("#est-periodos a").click(function(){
        cns.getBooksDelivered($(this).text());
    });


    // On each draw, loop over the `verDetalles` array and show any child rows
    booksData.on( 'draw', function () {
        $.each( verDetalles, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    });

    ConsultasEstadisticas.prototype.getBooksDelivered = function(per){ 
        if(per === undefined){
            selPeridodo = periodo;
        }else{
            selPeridodo = per;
        }
        document.getElementById('o-books-list').style.display = 'block';
        //console.log('->>>'+per);
        if(per === undefined){
            selPeridodo = periodo;
        }else{
            selPeridodo = per;
        }
        //console.log(selPeridodo);
        $.ajax({
            url : '../../business/controller/class.controladorLibros.php',
            data : { 
                funcion: 3, 
                periodo: selPeridodo
            },
            type : 'POST',
            dataType : 'json',
            success : function(json) {
                //console.log(json);
                booksData.fnClearTable();
                if(json.ok === 1){
                    //console.log(json.datos.length);
                    for(var i = 0; i < json.datos.length; i++) { 
                        booksData.fnAddData([ 
                            null, 
                            json.datos[i]['lib_alfanumerico'], 
                            json.datos[i]['lib_titulo'], 
                            json.datos[i]['lib_editorial'], 
                            json.datos[i]['lib_precio'], 
                            json.datos[i]['total_libros'], 
                            json.datos[i]['valor_libros'] 
                        ]);  
                    }         
                    document.getElementById('o-books-list').style.display = 'none';

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

    var cns = new ConsultasEstadisticas();
    cns.getBooksDelivered();

});