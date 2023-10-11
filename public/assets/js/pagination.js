let list_items
let list_item
let list_element
let nodeitems
let currentpage
let rows=2

let prevel=document.createElement('button')
setTimeout(() => {
list_items = document.querySelectorAll('.set')
 list_item = ['item1' ,'item2','item2','item2']
list_element = document.querySelector('.minnavload')
const pagination_element = document.querySelector('.pagination')
 nodeitems=[list_items[0],list_items[1],list_items[2],list_items[3],list_items[4],list_items[5],list_items[6],list_items[7]]
 currentpage = 1 ;
//show list
 rows = 2 
DisplayList(nodeitems , list_element,rows ,currentpage)
}, 500);


function DisplayList(items, wrapper , rows_per_page , page){

    page-- ; 
    let start = rows_per_page * page ;
let end =  start + rows_per_page ;
    let paginated_item = items.slice(start, end) ;
    console.log(paginated_item)

list_items.forEach(list_items => {
    list_items.classList.remove('d-flex')
});




    //displaying items 
    
        console.log(items)
    for(let i = 0 ; i< paginated_item.length ; i++) {
        if(paginated_item[i]){
        if(!document.querySelector('.prev')){

            prevel.classList.add('prev')
            prevel.classList.add('btn')
            prevel.classList.add('btn-tertiary')
            prevel.setAttribute('onclick','prev()')
            console.log(prevel)
            // document.querySelector('.nxt').insertBefore(prev)
        }
        if(!paginated_item[i].classList.contains('d-flex')){
       paginated_item[i].classList.add('d-flex') ;
       paginated_item[i].setAttribute( "data-aos", "zoom-in")
       paginated_item[i].setAttribute( "data-aos-delay", "600")



       AOS.init({
        useClassNames: true,
        initClassName: false,
        animatedClassName: 'animated',
      });
    }else{
        
       this.classList.remove('d-flex')
    }
   }
}
}





function next() {
    currentpage += 1
    console.log(currentpage)
    prevel.textContent=('Prev')
    list_element.appendChild(prevel)
    
    DisplayList(nodeitems , list_element,rows ,currentpage) 
}

if(currentpage==0){
    document.querySelector('.prev').remove();

}

function prev() {
   
    currentpage -= 1

   
    
    DisplayList(nodeitems , list_element,rows ,currentpage) 
}