if(typeof errors != 'undefined'){
for (key in errors) {
    let errordiv = document.createElement('div');
    errordiv.classList.add('danger')
    errordiv.innerHTML = errors[`${key}`];

   console.log(errors[`${key}`]);
   let elm = document.querySelector(`input[name=${key}]`).parentElement;
   elm.appendChild(errordiv)
   setTimeout(() => {
    errordiv.setHTML("");
   }, 3000);
}

}

if(typeof message != 'undefined'){
  let msgDiv = document.querySelector('.message').innerHTML= message['message'];
  console.log(message)
  setTimeout(() => {
msgDiv.setHTML('') ;
   }, 3000);
 
}