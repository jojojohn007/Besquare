$(document).ready(function() {
    $('video').attr('onplay', 'vidcheck(this)')
});
let currentVideoId;
let course;
let vidId;

let everyVideoRenderedFromBackend = document.querySelectorAll('[course]');
everyVideoRenderedFromBackend.forEach(element => {
    if (element.currentTime >= 0) {
        element.currentTime = element.getAttribute('currentTime');
    }

});

