// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// import './styles/app.css';
import './styles/proj.scss';

let img = document.getElementById('level-img');

img.addEventListener("click", (e) => {

    let form = document.getElementById("coordForm");
    let xCoord = document.getElementById("xCoord");
    let yCoord = document.getElementById("yCoord");

    xCoord.value = parseFloat(e.offsetX/e.target.offsetWidth);
    yCoord.value = parseFloat(e.offsetY/e.target.offsetHeight)

    form.submit();
    // console.log(`${e.offsetX/e.target.offsetWidth} ${e.offsetY/e.target.offsetHeight}`);

    });