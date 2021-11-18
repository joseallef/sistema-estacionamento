var optpes = window.document.querySelector(".option-pesq");
var icon = document.querySelector(".icone-option")

if(icon){
    optpes.style.display = 'none';
    icon.addEventListener('click', (e)=> {
        showMenuRight()
    });
}

function showMenuRight(){
    optpes.style.display == 'none' ? optpes.style.display = 'block' : optpes.style.display = 'none'
}


function verificacpf(cp){
    if (cp.which != 8 && cp.which != 0 && (cp.which < 48 || cp.which > 57)) {
        return false;
    }
}


 function formatcpf (cp){
    vr = (navigator .appName == 'Netcape') ?cp.target.value : cp.srcElement.value;
        if (vr.length == 3) vr = vr + ".";
        if (vr.length == 7) vr = vr + ".";
        if (vr.length == 11) vr = vr + "-";
        
        return vr;

}

function formCep (dat){
    cep = (navigator .appName == 'Netcape') ?dat.target.value : dat.srcElement.value;
        if (cep.length == 5) cep = cep + "-";
        return cep;
}

window.addEventListener('load', logoff)

var seg = 0
var min = 0

function logoff(){
    setTimeout("logoff()", 1000)
    seg += 1
    if(seg >= 60){
        min += seg
        seg = 0
        if(min >= 300){
            //window.location.href = "logout"
        }
    }
}

var menu = document.querySelector('.menu')
var icone = document.querySelector('#menu')
var shadow = document.querySelector('.shadow-right')
var iconn = document.querySelector('.iconn')
var newIcon = document.querySelector('.navbar-toggler-icon')
if(menu){
    shadow.classList.remove('shadow-right')
    iconn.style.display = 'none'
    icone.addEventListener('click', ()=>{
        exibiMenu()
    })
}
function exibiMenu(){

    if(menu.style.display == 'none'){
        menu.style.display = 'block'
        iconn.style.display = 'block'
        shadow.classList.add('shadow-right')
        shadow.style.display = 'block'
        newIcon.style.display = 'none'
    }else{
        menu.style.display = 'none'
        shadow.classList.remove('shadow-right')
        iconn.style.display = 'none'
        newIcon.style.display = 'block'
    }

}

function Relogio(){

    momentoAtual = new Date()
    hora = momentoAtual.getHours()
    minuto = momentoAtual.getMinutes()
    segundo = momentoAtual.getSeconds()
    momentoAtual.getDay()
    
    if(hora<10){hora = "0" + hora;}
    if(minuto<10){minuto = "0" + minuto;}
    if(segundo<10){segundo= "0" + segundo;}
    
    hr= hora + " : " + minuto + " : " + segundo
    
    document.querySelector('#relogio').innerHTML=hr;
    
}

function verificar(){
    var va = window.document.getElementsByName('nome')[0]
    if(va.value !== ''){

    }else{
        alert("Campo vazio, Verifique os dados!")
    }
}
var as = document.querySelector('form')
function verificarCampo(){
    var va = window.document.getElementsByName('placa')[0]
    if(va.value !== ''){
        as.addEventListener('submit', (ex)=>{
           
        })
    }else{
        as.addEventListener('click', (e)=>{
            va.focus()
            va.style.background = '#ffcccc'            
            bootbox.alert("Campo vazio, Verifique os dados!")
            
        })

    }
}

var ex = document.querySelector('.apagar')
if(ex){
    ex.addEventListener('click', ()=>{
        window.location.href = 'update-veiculo?tabela=excluir&v='+ex.value;
    })
}


// Chamado quando tenta gerar um boleto, e já tem um gerado para a 
// mesma data para evitar duplicação
var windowClose = document.querySelector("#windowClose")
if(windowClose)
{
    windowClose.addEventListener('click', ()=>{
        window.close()
    })
}

const idform = document.getElementById('idform')
const btn = document.querySelector('#btn-pesquisa')
const valor = document.querySelector('#nome')
if(idform)
{
    btn.disabled = true
    valor.addEventListener('keyup', function(e){
        if(valor.value){
            btn.disabled = false
        }else{
            btn.disabled = true
        }
    })
}

// Iteração do financeiro
const tagTh = document.getElementById("create-tag-th")
const gerarBovaro = document.getElementById("gerar-bovaro")
const consultarPor = document.getElementById("consultar-por")
const btnPesquisarFinanceiro = document.getElementById("btn-pesquisar")
const formFinanceiro = document.getElementById("search-finance")
const optionSearch = document.querySelector(".options-search")
const vencimento = document.getElementById('vencimento')
const vencimento_selec = document.getElementById('vencimento_selec')
const validaForm = document.getElementById('form')


function validation()
{
    var isValid = 0    
    var itemsForm = validaForm.elements.length;
    
    for(var i = 0; i < itemsForm; i++)
    {
        if(validaForm[i].type !== "submit" && validaForm[i].type !== "file" && i !== 10)
        {
            if(validaForm[i].value !== "")
            {
                
            }else{
                validaForm.elements[i].classList.add('red')
                isValid++;
            }
        }
    }
    if(isValid>0){return false}
    return true;
}

if(btnPesquisarFinanceiro)
{
    btnPesquisarFinanceiro.addEventListener("click", function(e){
        
        var itemsForm = formFinanceiro.elements.length;
        var isValid = true

        var numPagina = document.getElementById("pagina")
        var numPag = document.getElementById("numeroPagina")
        sessionStorage.setItem('numeroPagina', numPagina.value)
        var valorPag = sessionStorage.getItem('numeroPagina')
        numPag.value = valorPag
        
        for(var i = 0; i < itemsForm; i++)
        {
            if(formFinanceiro[i].type !== "submit")
            {
                if(formFinanceiro[i].value !== "")
                {
                    isValid = true;
                }else{
                    isValid = false;
                }
            }
        }
        return isValid;
    })
}

if(consultarPor)
{
    consultarPor.addEventListener("click", function(){
        if(consultarPor.value)
        {
            if(consultarPor.value == "NOME")
            {
                createInputSearch()

            }else if(consultarPor.value == "DATA"){
                createSelectDate();
            }else if(consultarPor.value == "TODOS"){
            }
        }
    })
}


function createSelectDate()
{
    optionSearch.innerHTML = ""
    var selectDate = document.createElement('select')
    selectDate.name = 'selected_date'
    selectDate.id = 'selected_date'
    selectDate.options[0] = new Option('Selecione')
    selectDate.options[1] = new Option('1')
    selectDate.options[2] = new Option('2')
    selectDate.options[3] = new Option('5')
    selectDate.options[4] = new Option('8')
    selectDate.options[5] = new Option('10')
    selectDate.options[6] = new Option('16')
    selectDate.options[7] = new Option('21')
    selectDate.options[8] = new Option('26')
    selectDate.options[9] = new Option('30')
 
    optionSearch.appendChild(selectDate)
}

function createInputSearch()
{
    var inputText = document.createElement("input")
    var inputButton = document.createElement('input')
    inputText.type = "text"
    inputText.name = "nome"
    inputText.placeholder = "Digite o nome"
    inputButton.type = "submit"
    inputButton.value = 'Pesquisar'
    inputButton.classList.add('btn-primary')

    optionSearch.innerHTML = ""
    //tagTh.innerHTML = ""
    optionSearch.appendChild(inputText)
    //optionSearch.appendChild(inputButton)
}
if(vencimento_selec)
{
    vencimento_selec.addEventListener('click', function(e){

        vencimento.value = vencimento_selec.value;
    });
}




// GRAFICO DE VAGAS! API GOOGLE CHARTS
var vagas = document.querySelector('.vagas');
if(vagas){
// Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.

    function drawChart() {
    // Create the data table.
    var data = new google.visualization.DataTable();  
    var vagasOcup = document.querySelector('.vagasOcup')
    var vagasDisp = document.querySelector('.vagasDisp')
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Ocupadas', Number(vagasOcup.value)],
        ['Disponiveis', Number(vagasDisp.value)]
    ]);

    // Set chart options
    var options = {'title':'Taxa de Ocupação',
                    'width':210,
                    'height':230,
                    'padding': 0,
                    colors:['red', 'lightgreen'],
                    is3D: true};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    }
}

// GRAFICO DE VAGAS! API GOOGLE CHARTS
var resulmo_financeiro = document.querySelector('.resulmo_financeiro');
if(resulmo_financeiro){
// Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.

    function drawChart() {
    // Create the data table.
    var data = new google.visualization.DataTable();  
    var recebido = document.querySelector('.recebido')
    var previsto = document.querySelector('.previsto')
    var baixados = document.querySelector('.baixados')
    var expirados = document.querySelector('.expirados')
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    data.addRows([
        ['Expirados', Number(expirados.value)],
        ['Previstos', Number(previsto.value)],
        ['Recebidos', Number(recebido.value)],
        ['Baixados', Number(baixados.value)]
    ]);

    // Set chart options
    var options = {'title':'R$ % Recebidos / Receber / Vecidos',
                    'width':500,
                    'height':400,
                    'padding': 0,
                    'fontSize': 20,
                    colors:['red', 'orange', 'lightgreen', 'purple'],
                    is3D: true};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('resulmo_financeiro'));
    chart.draw(data, options);
    }




    // Grafico do resulmo em R$
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {

    var chartDiv = document.getElementById('grafic_column');

    var data = google.visualization.arrayToDataTable([
        ['Financeiro', 'Pagos', 'Vencidos'],
        ['Valores', 1000, 10000]
    ]);

    var materialOptions = {
        width: 500,
        height: 400,
        chart: {
        title: 'Valor em R$'
        },
        series: {
        0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
        1: { axis: 'brightness' }, // Bind series 1 to an axis named 'brightness'.
        2: { axis: 'brightness' }
        },
        axes: {
        y: {
            distance: {label: 'Recebidos'}, // Left y-axis.
            brightness: {side: 'right', label: 'A receber'} // Right y-axis.
        }
        }
    };
    function drawMaterialChart() {
        var materialChart = new google.charts.Bar(chartDiv);
        materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
    }

    drawMaterialChart();
    };
}