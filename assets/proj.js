// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// import './styles/app.css';
import './styles/proj.scss';
// const getNiceMessage = require('./js/clickhandler.js');
import { checkClick } from  './js/clickhandler.js';


let img = document.getElementById('level-img');
let targetX = 549/679;
let targetY = 550/679;
img.addEventListener("click", (e) => {
        console.log(checkClick(e.offsetX, e.offsetY, targetX, targetY, e.target.offsetWidth, e.target.offsetHeight));
    });
    // if ( (e.offsetY/e.target.offsetHeight <= targetY*1.05 && e.offsetY/e.target.offsetHeight >= targetY*0.95) &&
    //      (e.offsetX/e.target.offsetWidth <= targetX*1.05 && e.offsetX/e.target.offsetWidth >= targetX*0.95) ) 
    // {
    //     console.log(`X: ${e.offsetX} Width: ${e.target.offsetWidth}`);
    //     console.log(`Y: ${e.offsetY} Height: ${e.target.offsetHeight}`);
    // }

// body.style.backgroundImage = 'url(./images/Medieval-City-DALL-E.webp)';

