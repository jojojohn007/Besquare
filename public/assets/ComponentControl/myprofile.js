
if(userData){
let TotalXp = 0 ;
 
setTimeout(() => {
    for (const property in userData) {
        console.log(userData[property]);
        TotalXp += (JSON.parse(userData[property]['xp']))

document.querySelector('.xpAndCourse').innerHTML+=(
   `<h3>${userData[property]['xp']}</h3>
    <p>${userData[property]['selected_courses']}</p>`
)

document.querySelector('.xpAndCourse2').innerHTML=(
    `<h3>${userData[property]['xp']}</h3>
     <p>${userData[property]['selected_courses']}</p>`
 )
 
 document.querySelector('.section3').innerHTML+=(
    `   <div class="d-flex flex-column flex-xl-row gap-2">
    <div class=" align-self-center">
        <img src="asset/bookicon.png" class="pt-3 align-items-center" alt="">
    </div>
    <div class="w-100">
        <div class="row align-items-center">
            <div class="col text-center align-items-center bigcard">
                <p class="fs-2 text-secondary">${userData[property]['selected_courses']}</p>
                <button class="btn-home"> <a href="<?php echo $course; ?>.php" class="text-white">
                        Continue Lesson</a></button>
            </div>
            <div class="col-lg-8 fs-4 text-secondary col-sm-12 my-3 contentleft">
                <span class="me-3">Points:${userData[property]['points']}
                </span>
                <span>Badges:${userData[property]['badges']}</span>
                <p class="fs-6 mt-2">Progress <?php echo $progress; ?>%</p>
                <div class="progress w-100">
                    <div class="progress-bar" role="progressbar" style="width:<?php echo $progress; ?>%"
                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="progress progress-indicator mt-lg-3">
            <div class="progress-bar progressbar-indicator" role="progressbar "
                style="width:<?php echo $progress; ?>%" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
        <div class="row progress-title">
            <div class="col">
                <p>Addition and Substraction</p>
            </div>
            <div class="col">
                <p>Multiplication</p>
            </div>
            <div class="col">
                <p>Division</p>
            </div>
            <div class="col">
                <p>see all</p>
            </div>
        </div>
    </div>

</div>`
 )
 
 document.querySelector('.section4').innerHTML+=(`
 
 
 <p>Class 5</p>
 <img src="asset/complete.png" width="40px" alt="">
 <p>Exercise completed:<?php echo $excompleted ?></p>
 <img src="asset/badgeIcon.png" width="40px" alt="">
 <p>Badge :<?php echo $badges ?></p>
 <p>Score's claimed</p>
 <div class="sec2 text-center d-flex flex-column align-items-center">

     <div class="progress mx-auto" id='wheel1' data-value='80'>
         <span class="progress-left">
             <span class="progress-bar border-primary"></span>
         </span>
         <span class="progress-right">
             <span class="progress-bar border-primary"></span>
         </span>
         <div
             class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
             <div class="h2 font-weight-bold"><span class="tier1"> 0 </span> <span class="small">%</span>
             </div>
         </div>
     </div>
 </div>
 

 
 
 
 
 `)


      }

}, 1000);


}


                              

