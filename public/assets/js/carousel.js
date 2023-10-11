let items = {  
    'person1':` <p>salman</p>
    <p>January/12/2022</p>
    <img src="assets/hareesh.png" alt="" width="10%" class="img-fluid rounded">` ,
    'person2': `   <p>Hareesh</p>
    <p>January/12/2022</p>
    <img src="assets/hareesh.png" alt="" width="10%" class="img-fluid rounded">` ,
    'person3':`      <p>naveen</p>
    <p>January/12/2022</p>
    <img src="assets/hareesh.png" alt="" width="10%" class="img-fluid rounded">`

    
}



let persons = document.querySelectorAll('.person');
let people = document.querySelector('.people')

persons.forEach(element => {
    setInterval(() => {
        let person1C = persons[0].children
        let person2C = persons[1].children      
        let person3C =persons[2].children


persons[0].innerHTML =  items.person1
persons[1].innerHTML =items.person2
persons[2].innerHTML =items.person3


    }, 1000);
    
});