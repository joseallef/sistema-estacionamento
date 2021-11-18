$(window).on( "load", function(e){
    setInterval(Relogio, 1000);
    $("#notFoud").modal('show');
    $("#cadSuccess").modal('show');
    $("#selectSexo").modal('show');

    $("#cep").on('focusout', function(){
        var cep = $("#cep").val();
        cep = cep.replace("-", "");
        var urlstr = "https://viacep.com.br/ws/"+cep+"/json/";

        if(cep != "")
        {
            $.ajax({
                url : urlstr,
                type : "get",
                dataType : "json",
                beforeSend: function(e){
                    $(".spinner").css("display", "flex");
                }               
            }).done(function(result){
                if(result.erro)
                {
                    $(".spinner").css("display", "none");
                    bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Cep não encontrado!.</p>');
                    $("#estado").val("");
                    $("#cid").val("");
                    $("#bairro").val("");
                    $("#rua").val("");
                    $("#cep").val("");
                    $("#cep").css('background', '#FFFFFF');
                }else {
                    $("#estado").val(result.uf);
                    $("#cid").val(result.localidade);
                    $("#bairro").val(result.bairro);
                    $("#rua").val(result.logradouro);
                    $("#cep").css('background', '#FFFFFF');
                    $(".spinner").css("display", "none");
                }
            });          
        }else {
            $("#cep").css('background', '#EECCCC');
            bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Digite o CEP!</p>');
        }
    });

    // Mascaras

    
    $("#placa").mask("AAA-0A00");
    $("#ano").mask("0000");
    $("#telC").mask("(00) 00000-0000");
    $("#telF").mask("(00) 0000-0000");
    $('#cep').mask("00000-000", {reverse: true});
    $("#valor").mask("000.00", {reverse: true});


    $('#option').change(function(){
        if($(this).val() === "Nome"){
            $('.nome').show();
            $('.cpf').hide();
            $('.Placa').hide();
            $('.data').hide();    
        }else
         if($(this).val() === "CPF"){
            $('.nome').hide();
            $('.cpf').show();
            $('.Placa').hide();
            $('.data').hide();
            $('.nome_celected').hide();            
        }
        if($(this).val() === "Placa"){
            $('.nome').hide();
            $('.cpf').hide();
            $('.Placa').show();
            $('.data').hide();
            $('.nome_celected').hide();    
        }else
         if($(this).val() === "data"){
            $('.nome').hide();
            $('.cpf').hide();
            $('.Placa').hide();
            $('.data').show();
            $('.nome_celected').hide();
        }else
        if($(this).val() === ""){
            $('.nome').hide();
            $('.cpf').hide();
            $('.Placa').hide();
            $('.data').hide();
            $('.nome_celected').hide();    
        }

    });
    $(document).on('keydown', '[cpf-cnpj]', function (e) {

        var digit = e.key.replace(/\D/g, '');
    
        var value = $(this).val().replace(/\D/g, '');
        var size = value.concat(digit).length;
    
        $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');
    });


     //Executa a requisição quando o campo CPF perder o foco
    $('#cpf').on('blur', function(e)
    {
        var cpf = $('#cpf').val().replace(/[^0-9]/g, '').toString();

        if( cpf.length == 11 )
        {
            var v = [];

            //Calcula o primeiro dígito de verificação.
            v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
            v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
            v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
            v[0] = v[0] % 11;
            v[0] = v[0] % 10;

            //Calcula o segundo dígito de verificação.
            v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
            v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
            v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
            v[1] = v[1] % 11;
            v[1] = v[1] % 10;

            //Retorna falso se os dígitos de verificação são os esperados.
            if ((v[0] != cpf[9]) ||
                (v[1] != cpf[10]) ||
                cpf == "00000000000" || 
                cpf == "11111111111" || 
                cpf == "22222222222" || 
                cpf == "33333333333" || 
                cpf == "44444444444" || 
                cpf == "55555555555" || 
                cpf == "66666666666" || 
                cpf == "77777777777" || 
                cpf == "88888888888" || 
                cpf == "99999999999" )
            {
                $("#cpf").css("background", "#EECCCC");
                bootbox.alert("CPF invalido!");

                $('#cpf').val('');
                $('#cpf').triggerHandler('focus');
            }else{
                $("#cpf").css('background', '#DDFFDD');
            }
        }else if( cpf.length == 14 )
        {
            var cpf = $('#cpf').val().replace(/[^0-9]/g, '').toString();      
            
            var cnpj_original = cpf;
        
            var primeiros_numeros_cnpj = cpf.substr( 0, 12 );
        
            var primeiro_calculo = calc_digitos_posicoes(primeiros_numeros_cnpj, 5 );
        
            var segundo_calculo = calc_digitos_posicoes(primeiro_calculo, 6 );
            var cnpj = segundo_calculo;
        
            if ( cnpj === cnpj_original ) {
                $("#cpf").css('background', '#DDFFDD');
                return true;                
            }
            $("#cpf").css("background", "#EECCCC");
            bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>CNPJ Invalido!</p>');
            return false;

      
        }else
        {
            $("#cpf").css('background', '#EECCCC');
            $('#cpf').val('');
        }
    });
    
    function calc_digitos_posicoes(digitos, posicoes = 10, soma_digitos = 0 ) {

        digitos = digitos.toString();

        for ( var i = 0; i < digitos.length; i++  ) {
            soma_digitos = soma_digitos + ( digitos[i] * posicoes );
    
            posicoes--;

            if ( posicoes < 2 ) {
                posicoes = 9;
            }
        }
        soma_digitos = soma_digitos % 11;
    
        if ( soma_digitos < 2 ) {
            soma_digitos = 0;
        } else {
            soma_digitos = 11 - soma_digitos;
        }
        var cpf = digitos + soma_digitos;
    
        return cpf;
        
    }
    $().ready(function() {
        $('#excluir-veiculo-permanentimente').modal('show');
    })
  
    $(".excluir-veiculo").on('click', function(){
        var v = $(this).val();
        let conf = confirm('Deseja realmente excluir?');
        if(conf){
            window.location.href = 'update-veiculo?tabela=excluir&v='+v;
        }
    });
    $(".excluir-veiculo-permanentimente").on('click', function(){
        var v = $(this).val();
        let conf = confirm('Atenção! sera excluido permanentimente deseja realmente continuar?');
        if(conf){
            window.location.href = 'update-veiculo?tabela=excluir-permanentimente&v='+v;
        }
    });
});