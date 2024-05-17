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







img.addEventListener("click", (e) => {

    let form = document.getElementById("coordForm");
    let xCoord = document.getElementById("xCoord");
    let yCoord = document.getElementById("yCoord");

    xCoord.value = parseFloat(e.offsetX/e.target.offsetWidth);
    yCoord.value = parseFloat(e.offsetY/e.target.offsetHeight)

    form.submit();

    // console.log(`${e.offsetX/e.target.offsetWidth} ${e.offsetY/e.target.offsetHeight}`);
    // console.log(checkClick(e.offsetX, e.offsetY, targetX, targetY, e.target.offsetWidth, e.target.offsetHeight));


        // let xCoord = parseFloat(e.offsetX/e.target.offsetWidth);
        // let yCoord = parseFloat(e.offsetY/e.target.offsetHeight);

        // fetch("/proj/check", {
        //     method: "POST",
        //     body: JSON.stringify({
        //       xCoord: xCoord,
        //       yCoord: yCoord
        //     }),
        //     headers: {
        //       "Content-type": "application/x-www-form-urlencoded"
        //     }
        //   });
        
        // fetch("/proj/check", {
        //     method: "POST",
        //     body: JSON.stringify({
        //       xCoord: xCoord,
        //       yCoord: yCoord
        //     })
        //   });



    });