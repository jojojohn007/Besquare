const NAVLINK = Array.from(document.getElementsByClassName('nav-link'));

NAVLINK.forEach(element => {
    let href = (element.getAttribute('href'));
    let newHref = '../' +  href  ;
    element.setAttribute('href',newHref);
 
});