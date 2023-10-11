let realJsonPath = 'http://localhost/besquare/public/assets/json/backendData.json';
let adminDataPath = 'http://localhost/besquare/public/assets/json/adminCourseData.json';
let nav = 0;
let clicked = null;
let userCourses = [];
/*

*/

//~render
//!trigger
//*dynamic
//^
//&

//for storing clicked title
let notified = [];
let id
var h
let Clicktype
let selectedMonthIndex
let clickedDate
let clickedDayOnly
let clickedMonthOnly
let clickedYearOnly
let clickedDayNameOnly
let switch_Type = 'Events'
let yearShift = 0;
// constants
const newEventModal = $('#newEventModal');
const deleteEventModal = $('#deleteEventModal');
const eventTitleInput = $('#eventTitleInput')[0]
const eventWrap = $('.eventWrap');
const reminderWrap = $('.reminderWrap');
const updateEventModel = $('#deleteEventModal');
const upcomingEventWrap = $('.upcomingEventWrap')
const currentDateEvents = $('#commonTables tbody')
const dataListOptionElement = $('#datavalue');
const dt = new Date();
const day = dt.getDate();
const month = dt.getMonth();
const year = dt.getFullYear();
const today = `${year}-${month + 1}-${day}`;
const monthString = dt.toLocaleDateString('en-IN', { month: "long" })
const currentYear = year
let startyear = currentYear - 11
let yearNav = 132;


const everyMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

//fetch event from local storage or fetch empty array

let events = localStorage.getItem('events') ? JSON.parse(localStorage.getItem('events')) : [];

let reminders = localStorage.getItem('reminders') ? JSON.parse(localStorage.getItem('reminders')) : [];

let eventIncrement = 3

const last10Years = []

for (let i = currentYear - 10; i <= currentYear; i++) {
    last10Years.push(i)
}
//shows events or task on table while clicking a date
//~render 
function showClickedEvents(daystring, json) {


    currentDateEvents.html(` 
    <tr>
     
      <th width="xxs">No</th>
      <th width="xs">Date</th>
      <th width="xs">Class</th>
      <th width="md">Unit</th>
      <th width="md">Lesson</th>
      <th width="lg">Topic</th>
      <th width="sm">Category  - Exercise</th>
    </tr>`)

    $('.todaysWork').html(`<h2>${daystring}</h2>`)
    //fetch data to currentDateEvents 
    const eventForDay = json.find(e => e.date === daystring);
    if (switch_Type == 'Events') {


        if (eventForDay) {
            Object.keys(eventForDay).forEach(function (key) {

                const entries = Object.entries(eventForDay);

                const index = entries.findIndex(entry => entry[0] === key);


                if ((key != 'Tasks') && (key != 'date') && (key != 'course')) {

                    for (let i = 0; i < eventForDay[key].length; i++) {
                        let object = eventForDay[key];



                        currentDateEvents.append(`
               <tr status='${key}'>
             
                <td>   ${index}</td>
                <td>
                  <p>${eventForDay['date']}</p>
                </td>
                <td>
                ${object[i]['class']}
                </td>
                <td>
                ${object[i]['unit']}
                </td>
                <td>
${object[i]['lesson-name']}
               
               
                </td>
                <td>
                <a class="bi bi-box-arrow-up-right" href='${object[i]['url']}'> ${object[i]['topic']}
                </a>
                </td>
            
                <td>
                ${key}
                </td>
           
                
                </tr> `)
                    }
                }

            });


        } else {

            let testOBj = eventForDay;
            currentDateEvents.append(`<tr>
            <td colspan="6" style='text-align:center'>There are no activities  on ${daystring}</td>
          </tr>`)
        }
    } else {
        if (eventForDay) {
            for (let i = 0; i < eventForDay[switch_Type].length; i++) {
                let object = eventForDay[switch_Type];
                currentDateEvents.append(`

                <tr>
            
                <td>   ${i + 1}</td>
                <td>
                  <p>${eventForDay['date']}</p>
                </td>
                <td>
                ${object[i]['class']}
                </td>
                <td>
                ${object[i]['unit']}
                </td>
                <td>
                ${object[i]['lesson-name']}
                               
                               
                                </td>
                <td>
                <a class="bi bi-box-arrow-up-right" href='${object[i]['url']}'> ${object[i]['topic']}</a>
               
                </td>
              
                <td>
                ${'Task assigned'}
                </td>
                
                </tr>
`)
            }

        } else {
            let testOBj = eventForDay;
            cl(testOBj);
            currentDateEvents.append(`<tr>
            <td colspan="6" style='text-align:center'>There are no activities on ${daystring}</td>
          </tr>`)
        }
    }

    //shows works of the current day
    // if (typeof eventForDay !== 'undefined') {

    //     for (let j = 0; j < eventForDay['Tasks'].length; j++) {
    //         $('.todaysWork').append(`

    //     <div class='workcard' >

    //     <p>Time spend : </p>
    //    <p> ${eventForDay['Tasks'][j]}</p>

    //    <p>Status</p>
    //     <p>${eventForDay['Tasks'][j]}</p>

    //     </div>

    //     `)
    //     }
    // } else {
    //     $('.todaysWork').append(`<p>There is no worklist to show</p>`)
    // }

    rename()

}


// re render calendar after selecting a month or year
function fetchCalendar(e, type) {
    Clicktype = type
    if (nav >= yearNav) {
        return false;
    }
    if (Clicktype == 'month') {
        let selectedMonth = e.value
        selectedMonthIndex = everyMonths.indexOf(selectedMonth);
        if (yearShift) {
            nav += yearShift
        }
        nav += selectedMonthIndex - month

    } else {
        //some complicated calculation to render month and year according to user's selection
        yearShift = -(JSON.parse(e.value))
        if (selectedMonthIndex) {
            nav += selectedMonthIndex - month

        }
        nav += yearShift
    }
    load()
}

//show models like add event , delete event ,update event , event list etc..
function openmodal(date, json) {
    $('.currentDateEvents').html('')

    clicked = date
    if (clicked) {
        clicked.replace(" ", '')
    }

    let path = window.location.pathname;
    if (!(path.includes("calendarDetailedView"))) {
        $(".contentwrap").addClass("contentwrapIntro")
    }

}

//mostly for padding days
const weekdays = ['Sunday', "Monday", 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

//function to run after document is loaded /render calendar


function load() {


    //fetching todays work
    //Current Full date
    const dt = new Date()

    dt.setMonth(new Date().getMonth() + nav)
    $('.timeDiv').text('')
    $('#calendar').text('');
    //Current day,month,year given
    var currentDMY = today

    const day = dt.getDate();
    const month = dt.getMonth();
    const year = dt.getFullYear();
    const fetchedDate = `${year}-${month + 1}-${day}`;
    //getting first day of current  month and day in current given month starts (like "wednesday or thusrday")
    const firstDayOfMonth = new Date(year, month, 1);
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const dateString = firstDayOfMonth.toLocaleDateString('en-IN', {
        weekday: 'long',
        year: 'numeric',
        month: "numeric",
        day: 'numeric',
    });
    const weekday = new Date().toLocaleDateString('en-IN', {
        weekday: 'long'
    });



    $('.timeDiv').html(`<span>${day}</span><span> ${everyMonths[month]}</span>`)
    //getting actual padding days (if current month start on wednesday ,the number of padding days will be 3)
    const paddingDays = weekdays.indexOf(dateString.split(', ')[0]);
    //displayin month text
    cl('hii');

    $('#monthDisplay').html('')
    $('#yearDisplay').html()

    for (let i = 0; i < everyMonths.length; i++) {
        if (everyMonths[i] == dt.toLocaleDateString('en-IN', { month: "long" })) {
            $('#monthDisplay').append(`<option value=${everyMonths[i]} selected>${dt.toLocaleDateString('en-IN', { month: "long" })}</option>`);
        } else {
            $('#monthDisplay').append(`<option value=${everyMonths[i]} >${everyMonths[i]}</option>`);
        }
    }

    for (let j = 0; j < last10Years.length; j++) {
        if (last10Years[j] == dt.toLocaleDateString('en-IN', { year: "numeric" })) {
            $('#yearDisplay').append(`<option selected  value="${yearNav -= 12}"> ${startyear += 1} </option>`)

        } else {
            $('#yearDisplay').append(`<option  value="${yearNav -= 12}"> ${startyear += 1} </option>`)

        }


    }
    yearNav = 132;
    startyear = currentYear - 11
    // cl($.getJSON(jsonPath))
    //rendering the claender 
    $.getJSON(realJsonPath, function (json) {

        showClickedEvents(currentDMY, json);
        if (clicked) {
            openmodal(currentDMY, json)
        }
        // openmodal(clicked, json)
        for (let i = 1; i <= paddingDays + daysInMonth; i++) {
            const daysSquare = document.createElement('div');
            daysSquare.classList.add('day');
            if (i > paddingDays) {
                //rendering dates of current month
                daysSquare.innerHTML = `<div class="dayDiv"> ${i - paddingDays}</div>`;
                const daystring = `${year}-${month + 1}-${i - paddingDays}`
                const eventForDay = json.find(e => e.date === daystring);

                if (i - paddingDays === day && nav === 0 && today == fetchedDate) {

                    daysSquare.id = 'currentDay';
                }
                if (eventForDay) {
                    const eventDiv = document.createElement('div');
                    eventDiv.classList.add('event');
                    eventDiv.id = daystring;

                    let eventcount = 0;
                    if (eventForDay['problem']) {
                        if (eventForDay['problem']) {
                            eventcount += eventForDay['problem'].length
                        }
                    } else if (eventForDay['video']) {
                        eventcount += eventForDay['video'].length


                    } else {
                        eventcount = '';

                    }



                    eventDiv.innerHTML = `${eventcount}`;
                    daysSquare.children[0].append(eventDiv)



                }

                daysSquare.addEventListener('click', () => {

                    clickedDate = daystring

                    if (daystring) {

                        showClickedEvents(daystring, json)
                    } else {
                        showClickedEvents(today, json)

                    }

                    $('.timeDiv span:nth-child(1)').text(`${i - paddingDays}`)
                    clickedDayOnly = i - paddingDays
                    clickedMonthOnly = everyMonths[month]

                });
            } else {

                daysSquare.classList.add('padding');
            }
            $('#calendar').append(daysSquare);
        }
    });
    //Resetin nav to render calender properly according  to user
    if (Clicktype) {
        nav = 0
        Clicktype = ''
        // yearShift = 0;
        // monthShift = 0;
    }

}

// adding event listner to   previous and next button

$('button').click(function () {

    switch (this.id) {
        case 'nextButton':
            nav++;
            load();
            break;
        case 'backButton':
            nav--;
            load();
            break;
        case 'saveButton':
            saveModal();
            break;
        case 'deleteButton':
            deleteEvent();
            break;
        case 'editButton':
            closeModal();
            break;
        case 'cancelButton':
            closeModal();
            break;
        case 'closeButton':
            $(".addEventForm ").toggle(700);
            $(".addReminderForm ").hide(700);
            $('.reminderWrap').text('')
            closeModal();
            break;
        // default:
        //     closeModal();
        //     break;
    }
})



$('.addNewEvent').click(function () {
    $('#showEventModal').css('display', 'none');
    $('#newEventModal').css('display', 'block');
})



function viewEventDetails(newtitle, newdate, eventId, disc, e) {
    load()
    $(e.nextElementSibling).toggle(700)
}



$(".showEventForm , #cancelButton ,.showReminderForm").click(function () {
    if ($(this)[0].classList == 'showEventForm')
        $(".addEventForm ").toggle(700);

    else if ($(this)[0].classList == 'showReminderForm')
        $(".addReminderForm ").toggle(700);


});


$('.cancelButton  , #cancelButton').click(function () {
    closeModal()
    $(".addEventForm ").toggle(700);
    $(".addReminderForm ").hide(700);
    $('.reminderWrap').text('')
})

//show hidden reminders / events
$('.showReminders').click(function () {
    $('.reminderWrap').toggle(600)
})
$('.showEvents').click(function () {
    $('.eventWrap').toggle(600)
})


//swap data show on click  eg:  1wed 2thurday 

$('.upcomingDates p ').click(function (json) {
    let index = $(this).index()
    $.getJSON(realJsonPath, function (json) {
        if (index > 1) {
            let nextday = `${year}-${month + 1}-${day + index - 1}`
            $('.timeDiv span:nth-child(1)').text(`${day + index - 1}`)

            showClickedEvents(nextday, json)

        } else {
            $('.timeDiv span:nth-child(1)').text(`${day + index - 1}`)
            showClickedEvents(today, json)
        }

    });


})
function rename() {
    setTimeout(() => {
        $('[status*="1"]').text('Completed')
        $('[status*="0"]').text('Pending')
    }, 100);
}
//FILTERS
//STATUS FILTER
$('#StatusFilter').change(function (e) {

    // getting value to filter  //status filter
    let switchable = e.target.value
    let defaultKey = ['problem', 'video', 'All'];
    defaultKey.forEach(element => {
        //Just for hiding element
        if (element != 'All' && element != switchable) {
            cl($(`#commonTables [status*=${element}] `).hide(500));
        } else {
            cl($(`#commonTables [status*=${element}] `).show(500));
        }
        //For showing All elelments
        if (switchable == 'All') {
            cl($(`#commonTables [status*=${element}] `).show(500));
        }
    });

    if (switchable == 'Pending') {
        cl($('#commonTables [status*="${}"] ').parent().parent().hide(500))
        cl($('#commonTables [status*="0"] ').parent().parent().show(500))


    } else if ((switchable == 'Completed')) {
        cl($('#commonTables [status*="1"] ').parent().parent().show(500))
        cl($('#commonTables [status*="0"] ').parent().parent().hide(500))

    } else {
        cl($('#commonTables [status*="1"] ').parent().parent().show(500))
        cl($('#commonTables [status*="0"] ').parent().parent().show(500))
    }



})


load()



// $('select').css('color', 'transparent')
$(document).ready(function () {

    const myElements = $('input[type],textarea,select');

    myElements.closest('.inputDiv').find('label').addClass('movingLabel')

    myElements.focus(function () {
        $('select').css('color', 'inherit')
        let inputType = $(this).attr('type');
        if (!(inputType == 'radio' || inputType == 'checkbox')) {
            let inputDiv = $(this)

            let inputval = $(this).val();
            $(this).closest('.inputDiv').find('label').addClass("movingLabelIntro")

        }
    });

    $('input[type],textarea,select').blur(function () {
        let inputval = $(this).val();
        if (!inputval) {
            $('select').css('color', 'transparent')
        } else {
            $('select').removeClass('movingLabel')

        }
    })
});

$('textarea').on('input', function () {
    const elem = $(this);
    elem.css('height', "5px");
    elem.css("height", elem.css("scrollHeight") + "px");
});




//odd variables 

$('#applyFilterBtn').click(function () {
    currentDateEvents.html(``)
    let fromdate = $('input[dateFilter="from"]').val().replace("-0", "-");
    let toDate = $('input[dateFilter="to"]').val().replace("-0", "-");

    // fromdate = '2023-03-13';
    // toDate = '2023-03-16';

    // if filter range is set in input

    if (fromdate && toDate) {
        $.getJSON(realJsonPath, function (json) {
            let sortedEvents = json.filter(element => element.date >= fromdate && element.date <= toDate)
            let sortedEvents2 = json.filter(element => (element.date >= fromdate && element.date <= toDate))

            if (switch_Type == 'Events') {

                const date1 = new Date(fromdate);
                const date2 = new Date(toDate);
                if (sortedEvents.length >= 1) {
                    for (let i = 0; i < sortedEvents.length; i++) {
                        let object = sortedEvents[i]['video'];
                        if(sortedEvents[i].hasOwnProperty('video')){

                            renderStuff(sortedEvents[i],'video');

                        }else if(sortedEvents[i].hasOwnProperty('problem')){
                            renderStuff(sortedEvents,'problem');

                        }

                       
                    }

                } else if (date1 < date2 && sortedEvents.length <= 0) {
                    currentDateEvents.html(`<tr>
                    <td colspan="6" style='text-align:center'>There are no activities between ${fromdate} and ${toDate}</td>
                  </tr>`)
                    return false;

                } else if (date1 > date2) {
                    currentDateEvents.html(`<tr>
                    <td colspan="6" style='text-align:center'>Please set your date range properly 1</td>
                  </tr>`)

                }
            } else {

                if (sortedEvents.length >= 1) {
                    cl(sortedEvents)
                    for (let i = 0; i < sortedEvents.length; i++) {
                        let object = sortedEvents[i]['Tasks'];
                        cl(object)


                        for (let i = 0; i < object.length; i++) {

                            currentDateEvents.append(`
            
                            <tr>
                            <td class="checkBoxTD tableMenu">
                              <input id="" type="checkbox" class="selectProject rowCheckBox">
                              
                            </td>
                            <td>1</td>
                            
                            <td>
                              <p>${sortedEvents[i]['date']}</p>
                            </td>
                            <td>
                            ${object[i]['title']}
                            </td>
                            <td>
                            ${object[i]['time']['start']}
                            </td>
                            <td>
                            ${object[i]['time']['end']}
                            </td>
                            <td>
                              <a class="changeStatusBtn" prority='${object[i]['priority']}' status='${object[i]['status']}'>events</a>
                            </td>
                            
                            </tr>
            `)
                        }

                    }

                } else if (fromdate < toDate && sortedEvents.length <= 0) {
                    currentDateEvents.html(`<tr>
                    <td colspan="6" style='text-align:center'>There are no activities between ${fromdate} and ${toDate}</td>
                  </tr>`)
                    return false;

                } else if (fromdate > toDate) {
                    currentDateEvents.html(`<tr>
                    <td colspan="6" style='text-align:center'>Please set your date range properly</td>
                  </tr>`)

                }
            }



        })
    } else {
        cl('hii')
        cl(currentDateEvents)
        currentDateEvents.append(`<tr>
        <td colspan="6" style='text-align:center'>Please activate any filter before applying</td>
      </tr>`)
    }
    rename()
})


function renderStuff(sortedEvents,type){
    let object = sortedEvents[type];
    for (let j = 0; j < object.length; j++) {

        currentDateEvents.append(`
   <tr>
    <td class="checkBoxTD tableMenu">
      <input id="" type="checkbox" class="selectProject rowCheckBox">
  
    </td>
    <td>1</td>
    
    <td>
      <p>${sortedEvents['date']}</p>
    </td>
    <td>
    ${object[j]['class']}
    </td>
    <td>
    ${object[j]['unit']}
    </td>
    <td>
    ${object[j]['lesson-name']}
    </td>
    
    <td>
    ${object[j]['topic']}
    </td>
    
    <td>
    ${object[j]['type']}
    </td>
    </tr> `)

    }
}

// function showMoreUpcomingEvents() {

//     if (eventIncrement < 7) {
//         upcomingEventWrap.text('')
//         $.getJSON(realJsonPath, function (json) {
//             for (let i = 0; i <= eventIncrement; i++) {
//                 if (json[i]) {
//                     if (json[i]['date'] >= today) {
//                         let object = json[i]['Events'];
//                         upcomingEventWrap.append(`
//                         <div class='upcomingEvents' onclick='showClicked("${json[i]['date']}")'>
//                         <p>${json[i]['date']}</p>
//                         <h1>${json[i]['Events'][0]['title']}</h1>
//                         <p>${object[0]['time']['start']} : ${object[0]['time']['end']}</p>
//                         </div>`)
//                     }
//                 }

//             }
//             eventIncrement += 2;
//         });
//     }

// }


$('.eventIncrementBtn').click(function () {
    $(this).hide(600);
})

// showMoreUpcomingEvents();



//show clicked upcoming on calendar map

function showClicked(newclicked) {
    let clickedYear = newclicked.slice(0, 4)
    let clickedMonth = newclicked.split('-')[1];

    let value = year - clickedYear
    if (value) {
        let monthIndex = everyMonths.indexOf(monthString)
        let newMonthNav = clickedMonth - (monthIndex + 1) ? clickedMonth - (monthIndex + 1) : 0;
        nav = value * -12 + (newMonthNav)

    } else {
        nav = 0
    }

    load()
    // openmodal(newclicked)
}


//shows clicked events on  big tab
function switchTo(e, switchType) {

    $('.activeView').text(switchType)
    $.getJSON(realJsonPath, function (json) {
        cl(json)
        switch_Type = switchType
        if (clickedDate) {
            showClickedEvents(clickedDate, json)
        } else {
            showClickedEvents(today, json)
        }

    });
    rename()

}

$('select').change(function () {
    let interactedElement = $(this)


    // if (interactedElement.val()) {
    //     $('select').css('color', 'inherit')
    //     interactedElement.closest('.inputDiv').find('label').removeClass('movingLabelIntro')

    // } else {
    //     interactedElement.css('color', 'transparent')
    // }
});

//!RENDER DATALIST  TRIGGER ;
$('#searchKey').change(function (e) {

    renderDataList($(this).val())
})
//~ SEARCH FUNCTIONALITY
function searchFunctionality(json, jsonKey, searchVal) {
    let rendarable = ['problem', 'video']
    currentDateEvents.html(` 
    <tr>
     
      <th width="xxs">No</th>
      <th width="xs">Date</th>
      <th width="xs">Class</th>
      <th width="md">Unit</th>
      <th width="md">Lesson</th>
      <th width="lg">Topic</th>
      <th width="sm">Type</th>
    </tr>`)


    const JsonData = json.filter(e => e.date)
    json.forEach(element => {
        eventForDay = element;
        rendarable.forEach(element => {

            if (eventForDay[element][0][jsonKey] == searchVal) {
                if (switch_Type == 'Events') {
                    // console.log(eventForDay[element])
                    console.log(eventForDay['date'])
                    Object.values(eventForDay[element]).forEach(element => {
                        object = element
                        console.log(object)
                        currentDateEvents.append(`
                    <tr status='
                    ${object['type']}'>
                  
                     <td>   ${object['id']}</td>
                     <td>
                       <p>${eventForDay['date']}</p>
                     </td>
                     <td>
                     ${object['class']}
                     </td>
                     <td>
                     ${object['unit']}
                     </td>
                     <td>
     ${object['lesson-name']}
                    
                    
                     </td>
                     <td>
                     <a class="bi bi-box-arrow-up-right" href='${object['url']}'> ${object['topic']}
                     </a>
                     </td>
                 
                     <td>
                     ${object['type']}
                     </td>
                
                     
                     </tr> `)
                    });

                    //                 currentDateEvents.append(`
                    //                 <tr status='${element}'>

                    //                  <td>   ${eventForDay[element]['id']}</td>
                    //                  <td>
                    //                    <p>${eventForDay['date']}</p>
                    //                  </td>
                    //                  <td>
                    //                  ${object[i]['class']}
                    //                  </td>
                    //                  <td>
                    //                  ${object[i]['unit']}
                    //                  </td>
                    //                  <td>
                    //  ${object[i]['lesson-name']}


                    //                  </td>
                    //                  <td>
                    //                  <a class="bi bi-box-arrow-up-right" href='${object[i]['url']}'> ${object[i]['topic']}
                    //                  </a>
                    //                  </td>

                    //                  <td>
                    //                  ${key}
                    //                  </td>


                    //                  </tr> `)
                }
            }
        });



    });


}

//     if (eventForDay) {
//         Object.keys(eventForDay).forEach(function (key) {

//             const entries = Object.entries(eventForDay);
//             const index = entries.findIndex(entry => entry[0] === key);
// console.log(eventForDay);
//             if ((key != 'Tasks') && (key != 'date' && (key != 'course'))) {

//                 for (let i = 0; i < eventForDay[key].length; i++) {
//                     let object = eventForDay[key];



//                     currentDateEvents.append(`
//            <tr status='${key}'>

//             <td>   ${index}</td>
//             <td>
//               <p>${eventForDay['date']}</p>
//             </td>
//             <td>
//             ${object[i]['class']}
//             </td>
//             <td>
//             ${object[i]['unit']}
//             </td>
//             <td>
// ${object[i]['lesson-name']}


//             </td>
//             <td>
//             <a class="bi bi-box-arrow-up-right" href='${object[i]['url']}'> ${object[i]['topic']}
//             </a>
//             </td>

//             <td>
//             ${key}
//             </td>


//             </tr> `)
//                 }
//             }

//         });


//     } else {

//         let testOBj = eventForDay;
//         cl(testOBj);
//         currentDateEvents.append(`<tr>
//         <td colspan="6" style='text-align:center'>Not found</td>
//       </tr>`)
//     }
// } else {
//     if (eventForDay) {
//         for (let i = 0; i < eventForDay[switch_Type].length; i++) {
//             let object = eventForDay[switch_Type];
//             currentDateEvents.append(`

//             <tr>

//             <td>   ${i + 1}</td>
//             <td>
//               <p>${eventForDay['date']}</p>
//             </td>
//             <td>
//             ${object[i]['class']}
//             </td>
//             <td>
//             ${object[i]['unit']}
//             </td>
//             <td>
//             ${object[i]['lesson-name']}


//                             </td>
//             <td>
//             <a class="bi bi-box-arrow-up-right" href='${object[i]['url']}'> ${object[i]['topic']}</a>

//             </td>

//             <td>
//             ${'Task assigned'}
//             </td>

//             </tr>
// `)
//         }

//     } else {
//         let testOBj = eventForDay;
//         cl(testOBj);
//         currentDateEvents.append(`<tr>
//         <td colspan="6" style='text-align:center'>There are no activities on ${daystring}</td>
//       </tr>`)
//     }
// }
//*APPEND DATA TO DATA LIST 
function appendTOdataList(data) {
    dataListOptionElement.append(
        ` <option value="${data}">`
    )
}





//*get JSON data dynamically by specifying path ;
function getJsonData(path = realJsonPath) {

    return new Promise(function (resolve, reject) {
        $.getJSON(path, function (json) {
            resolve(json);
        }).fail(function (error) {
            reject(error);
        });
    });
}
getJsonData().then(function (jsonData) {
    Object.keys(jsonData).forEach(function (key) {

        const entries = Object.entries(jsonData);

        const index = entries.findIndex(entry => entry[0] === key);
        let courseName = (jsonData[key]['course'])
        userCourses.push(courseName)
        cl(userCourses)
        // if((key ='course')){
        //     userCourses.push(jsonData[key].course)

        // }

    });

})
//! FILL DATALIST TO DEFAULT (DEFAULT = 'UNIT');
function renderDataList(filterKey = 'unit') {
    dataListOptionElement.html("");
    getJsonData(adminDataPath).then(function (jsonData) {

        jsonData.forEach(element => {
            let filteredData = (element[filterKey])
            if (userCourses.includes(element['course'])) {
                filteredData.forEach(element => {
                    dataListOptionElement.append(
                        ` <option value="${element}">`
                    )
                });




            }
        });




    }).catch(function (error) {
        //   console.error("Error fetching JSON data:", error);
    });


}
renderDataList()

//! SEARCH BUTTON TRIGGER 
$('#searchButton').click(function (e) {
    let fromdate = $('input[dateFilter="from"]').val().replace("-0", "-");
    let toDate = $('input[dateFilter="to"]').val().replace("-0", "-");
    if (fromdate && toDate) {

    } else {
        let searchVal = ($('#searchValue').val());
        let jsonKey = ($('#searchKey').val());
        if (searchVal) {
            getJsonData(realJsonPath).then(function (jsonData) {
                searchFunctionality(jsonData, jsonKey, searchVal);
            });
        }
        ;
    }
})





//  const json = {
//   "data": [
//     {
//       "name": "John Doe",
//       "age": 30,
//       "email": "johndoe@example.com"
//     },
//     {
//       "name": "Jane Doe",
//       "age": 25,
//       "email": "janedoe@example.com"
//     }
//   ]
// };

// const jsonKey = "name";

// const filteredJson = test(jsonKey);

// cl(filteredJson);

function cl(dt) {
    // console.log(dt)

    // console.log("Caller function line number: " + this.caller.lineNumber);
}

// $('tr:first-child').css('display','none');


