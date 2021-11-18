const select = document.querySelector('#marca')
const insertModelo = document.querySelector('#modelo')
const inputModelo = document.querySelector('#input-modelo')
const criaInputMarca = document.querySelector('#input-marca')
const idmodel = document.querySelector('#idmodel')
const idmarca = document.querySelector('#idmarca')
const nameModelo = document.querySelector('#name-modelo')
const nameMarca = document.querySelector('#name-marca')
const cad = document.querySelector('#cad')

var valueSelect = ''
select.addEventListener('click', (e)=>{

    if(select.selectedIndex != 0 && select.selectedIndex != valueSelect)
    {
        if(select.value !== 'outros')
        {
            const url = "//fipe.parallelum.com.br/api/v1/carros/marcas/"+select.value+"/modelos";
            idmarca.style.display = 'none'
            idmarca.innerHTML = ''
            insertModelo.innerHTML = ''
            inputModelo.innerHTML = ''
            insertModelo.style.display = 'inline'

            function popularDados(result){
                var modelo = ''
                valueSelect = select.selectedIndex
                var selecteCriated = document.createElement('option')
                selecteCriated = new Option('Selecione', '')
                insertModelo.appendChild(selecteCriated) 
             
                for(const campo in result.modelos)
                {
                    var model = result.modelos[campo].nome.split(' ')
                    var str = result.modelos[campo].nome.substring(0, 10)
                    
                    if(model[0].toUpperCase() !== modelo)
                    {
                        insertModelo.addEventListener('click', ()=>{
                            
                            nameModelo.value = insertModelo.value;
                            
                        })

                        modelo = model[0].toUpperCase() 
                        selecteCriated = new Option(modelo, modelo)
                        insertModelo.appendChild(selecteCriated)  
                    }            
                }
            }
            const headersOption = {
                mode: 'no-cors',
                cache: 'default'
            }   
            fetch(url)
            .then(response => response.json())
            .then(response => popularDados(response))
            .catch(error => {
                alert("Erro ao cosultar! se o problema persistir selecione uma das 4 ultimas opções e digite o modelo"+error);
                select.value = ''
            })
        }else{
            idmarca.style.display = 'flex'

            this.createInputMarca();
            this.createInput()
        }
    } 
})

cad.addEventListener('click', (e) => {
    const inputMarca = document.querySelector('#inputMarca')

    if (!inputMarca){        
        nameMarca.value = select.value
    } else {
        console.log(inputMarca.value, 'existe sim')
        if (inputMarca.value === '') {
            alert("Campo MARCA não preenchido!")
            e.preventDefault()
        } else {
            nameMarca.value = inputMarca.value
        }
    }
    console.log(nameMarca.value, nameMarca);
    var modeloCarro = document.querySelector('#inputModel')
    if(insertModelo.value == ''){
        if(!modeloCarro) {
            alert("Campo MODELO não selecionado!")
            e.preventDefault() 
        } else {
            if(modeloCarro.value == ''){
                alert("Campo MODELO não selecionado!")
                e.preventDefault() 
            } else {
                nameModelo.value = modeloCarro.value;
            }
        }
    } else {
        nameModelo.value = insertModelo.value;
    }
    console.log(nameModelo, inputModelo, modeloCarro, insertModelo.value)
    // e.preventDefault() 
});

function createInputMarca() {
    idmarca.innerHTML = ''
    var input = document.createElement('input')
    input.name = 'marca'
    input.type = 'text'
    input.id = 'inputMarca'
    input.required
    input.placeholder = 'Outros'
    idmarca.appendChild(input)
}

function createInput()
{
    insertModelo.style.display = 'none'
    inputModelo.innerHTML = ''
    var input = document.createElement('input')    
    input.name = 'modelo'
    input.type = 'text'
    input.id = 'inputModel'
    input.required
    input.placeholder = 'Titan, JET 50, SUN 150'
    inputModelo.appendChild(input)
}