var req;

function buscar(barras) {

    if (event.keyCode == 13) {
        $("#barras").prop('disabled', true);

        $('#barras').val('');
        $.post('buscar.php', {barras: barras}, function (data) {
           	console.log(data);
		document.getElementById("resultado").innerHTML = data;
		$("#resultado").toggle();
	
            setTimeout(function() {
    			document.getElementById("resultado").innerHTML = '';
    		    $("#resultado").toggle();
                $("input").prop('disabled', false);
                $("input").focus();
            }, 3000);
        });
        
    }


}
