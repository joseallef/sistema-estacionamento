$(document).ready(function(e){
    setInterval(Relogio, 1000);
    $("#notFoud").modal('show');
    $("#cadSuccess").modal('show');
    $("#selectSexo").modal('show');

    $(".pesquisar").click(function(){
        var cep = $("#cep").val();
        cep = cep.replace("-", "");
        var urlstr = "https://viacep.com.br/ws/"+cep+"/json/";

        if(cep != ""){
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
                    console.log(result);
                }
            });
        }else{
            $("#cep").css('background', '#EECCCC');
            bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Digite o CEP!</p>');
        }
    });
/*
    $(".pesquisarNovoCep").click(function(){
        var cep_alter = $("#cep_alter").val();
        cep_alter = cep_alter.replace("-", "");
        var urlstr = "https://viacep.com.br/ws/"+cep_alter+"/json/";
        let id = $("#id_cep_alter").val();

        if(cep_alter != ""){
            $.ajax({
                url : urlstr,
                type : "get",
                dataType : "json", 
                success : function(data){
                    if(data.uf != undefined){
                        $("#estado").val(data.uf);
                        $("#cid").val(data.localidade);
                        $("#bairro").val(data.bairro);
                        $("#rua").val(data.logradouro);
                        $("#cep_alter").css('background', '#FFFFFF');
                    }else{
                        bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Cep não localizado!</p>');
                        $("#estado").val("");
                        $("#cid").val("");
                        $("#bairro").val("");
                        $("#rua").val("");
                    }
                }, error : function(erro){
                    bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Cep não localizado!</p>');                   
                }                
            });
        }else{
            $("#cep_alter").css('background', '#EECCCC');
            bootbox.alert('<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i>Digite o CEP!</p>');
        }
    });
*/

    // Mascaras

    
    $("#placa").mask("AAA-0000");
    $("#ano").mask("0000");
    $("#telC").mask("(00) 00000-0000");
    $("#telF").mask("(00) 0000-0000");
    $('#cep').mask("00000-000", {reverse: true});
    $("#valor").mask("000.00", {reverse: true});


    
    $(".especificar").hide();
    $(".todos").hide();

    $("#radioEspe").on('click',function(){
        $(".especificar").show();
        $(".todos").hide();
    }),$("#radioTodos").click(function(){
        $(".especificar").hide();
        $(".todos").show();
    });


    $('.nome').hide();
    $('.cpf').hide();
    $('.Placa').hide();
    $('.data').hide();
  
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
                $('#cpf').focus();
            }else{
                $("#cpf").css('background', '#DDFFDD');
            }
        }else if( cpf.length == 14 )
        {
            var cpf = $('#cpf').val().replace(/[^0-9]/g, '').toString();      
            
            // O valor original
            var cnpj_original = cpf;
        
            // Captura os primeiros 12 números do CNPJ
            var primeiros_numeros_cnpj = cpf.substr( 0, 12 );
        
            // Faz o primeiro cálculo
            var primeiro_calculo = calc_digitos_posicoes(primeiros_numeros_cnpj, 5 );
        
            // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
            var segundo_calculo = calc_digitos_posicoes(primeiro_calculo, 6 );        
            // Concatena o segundo dígito ao CNPJ
            var cnpj = segundo_calculo;
        
            // Verifica se o CNPJ gerado é idêntico ao enviado
            if ( cnpj === cnpj_original ) {
                $("#cpf").css('background', '#DDFFDD');
                return true;                
            }            
            // Retorna falso por padrão
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

        // Garante que o valor é uma string
        digitos = digitos.toString();
    
        // Faz a soma dos dígitos com a posição
        // Ex. para 10 posições:
        //   0    2    5    4    6    2    8    8   4
        // x10   x9   x8   x7   x6   x5   x4   x3  x2
        //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
        for ( var i = 0; i < digitos.length; i++  ) {
            // Preenche a soma com o dígito vezes a posição
            soma_digitos = soma_digitos + ( digitos[i] * posicoes );
    
            // Subtrai 1 da posição
            posicoes--;
    
            // Parte específica para CNPJ
            // Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
            if ( posicoes < 2 ) {
                // Retorno a posição para 9
                posicoes = 9;
            }
        }
    
        // Captura o resto da divisão entre soma_digitos dividido por 11
        // Ex.: 196 % 11 = 9
        soma_digitos = soma_digitos % 11;
    
        // Verifica se soma_digitos é menor que 2
        if ( soma_digitos < 2 ) {
            // soma_digitos agora será zero
            soma_digitos = 0;
        } else {
            // Se for maior que 2, o resultado é 11 menos soma_digitos
            // Ex.: 11 - 9 = 2
            // Nosso dígito procurado é 2
            soma_digitos = 11 - soma_digitos;
        }
    
        // Concatena mais um dígito aos primeiro nove dígitos
        // Ex.: 025462884 + 2 = 0254628842
        var cpf = digitos + soma_digitos;
    
        // Retorna 
        return cpf;
        
    }
  
    $(".excluir-veiculo").on('click', function(){
        var v = $(this).val();
        let conf = confirm('Deseja realmente excluir?');
        if(conf){
            window.location.href = 'update-veiculo?tabela=excluir&v='+v;
        }
    })
});

$(document).ready(function() {
    $(".cpf").keypress(verificacpf);
});