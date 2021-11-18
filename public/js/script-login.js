var form = document.querySelector('form#user')
var formUser = document.querySelector('.usuario')

if(form){
    var buttonUser = document.querySelector('button#user-submt')
    var valueUser = document.querySelector('input.user')
    buttonUser.addEventListener('click', function(){
        sessionStorage.setItem('user', valueUser.value);
    }) 
}

if(formUser){
    window.addEventListener('load', function(){
        user = sessionStorage.getItem('user')
        document.querySelector('.usuario').innerHTML = user.charAt(0).toUpperCase() + user.slice(1)
    })
}