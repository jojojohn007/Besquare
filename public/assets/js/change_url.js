



let cards=document.querySelectorAll('.prg')
let pointmsg =document.querySelector('.totalpoints')

let cardsl =cards.length
//add video  watched to data base 



let totalponts
let totalprogress


// making a table for user for recording progress  
function startcourse(coursename){
  console.log('proceed')
 $.getJSON(getajaxfrom ,   //making a table for user for recording progress
   { proceed:"startcourse" ,coursename: coursename , numberofcards:cardsl},function (data){
    console.log('adfsgSDGsdg');
   } )
}

function skip(){
 document.querySelector(".showup").remove()
}




$(document).ready(function(){
  setTimeout(() => {
    //find completed percentage
   
    if(document.querySelectorAll('.completed') || document.querySelectorAll('.notcomplete') ){
      let totalcards = document.querySelectorAll('.card').length
      let notansweredcards = document.querySelectorAll('.completed').length
         totalprogress = (notansweredcards /totalcards) * (100) ;
         if(totalprogress){
         $.getJSON(pageurl + getajaxfrom , 
          {getcarddata:"yes" ,coursename:'class5' , updateprogress : totalprogress },function(data){


              });
        }
      }
  }, 1000);

  setTimeout(() => {
    check()
  }, 1000);

function check(){
   $.getJSON(pageurl + getajaxfrom , 
     {getcarddata:"yes" ,coursename:'class5'  },function(data){
       if(data.checkifuserexists){ 
         let array = data.completedCards 
               totalponts  = (array.split("20").length - 1) * 20 ;
               if(pointmsg){
                pointmsg.textContent = totalponts ;
               }
                   //4       // show  tick if user already done the exercise
  cards.forEach((cards , i)=> {
if(cards.classList.length>2){
if(array.includes(cards.classList[2])){  //completed cards
  if(cards.classList.contains('notcomplete') && cards.classList.contains('video_card')){
      cards.classList.remove('notcomplete')
      cards.classList.add('completed')
      cards.children[2].innerHTML='Watched'

      cards.children[0].children[1].innerHTML ='  <defs> <filter id="Icon_map-circle" x="0" y="0" width="35.163" height="35.163" filterUnits="userSpaceOnUse">   <feOffset dy="3" input="SourceAlpha"/>   <feGaussianBlur stdDeviation="3" result="blur"/>   <feFlood flood-opacity="0.161"/>   <feComposite operator="in" in2="blur"/>   <feComposite in="SourceGraphic"/>  </filter> </defs> <g id="Group_1484" data-name="Group 1484" transform="translate(-66.656 -496.578)"> <g id="Group_1480" data-name="Group 1480" transform="translate(75.657 502.578)"> <g transform="matrix(1, 0, 0, 1, -9, -6)" filter="url(#Icon_map-circle)">  <path id="Icon_map-circle-2" data-name="Icon map-circle" d="M17.883,9.3A8.581,8.581,0,1,1,9.3.72,8.581,8.581,0,0,1,17.883,9.3Z" transform="translate(8.28 5.28)" fill="#57c8b6"/> </g> <g id="Icon_feather-video" data-name="Icon feather-video" transform="translate(2.644 4.803)"> <path id="Path_3612" data-name="Path 3612" d="M27.778,10.5,24,13.2l3.778,2.7Z" transform="translate(-15.904 -9.42)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/><path id="Path_3613" data-name="Path 3613" d="M2.58,7.5H8.517A1.08,1.08,0,0,1,9.6,8.58v5.4a1.08,1.08,0,0,1-1.08,1.08H2.58a1.08,1.08,0,0,1-1.08-1.08V8.58A1.08,1.08,0,0,1,2.58,7.5Z" transform="translate(-1.5 -7.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/></g></g></g>'
  }else {
      cards.classList.remove('notcomplete')
      cards.classList.add('completed')
      console.log(cards)
    
    // let exDone =  document.createElement('img')
    cards.children[0].removeAttribute('src' , 'dynamichero/assets/navloadicons/exUndone.svg' )
    cards.children[0].setAttribute('src' , 'dynamichero/assets/navloadicons/exDone.svg')
   cards.children[0].classList.remove('exUndone')
   cards.children[0].classList.add('exDone')
   
  }
}
}
  });
       }else{   
        console.log('user dosent exists')
       }
         });

        }

       });
      
//change url

   $(document).on('click' , '.prg' ,  function(event){
var calltype = $(this).attr('call_type')
console.log(calltype)
$.getJSON(pageurl + getajaxfrom , { calltype:calltype },
function(data,textstatus,xhr){
$(document).attr('title',data.title)
window.history.pushState('',"",pageurl+data.url)
window.location.replace(pageurl+data.url)
   }); 
 });
window.addEventListener('popstate',e =>{
 location.reload()
})
