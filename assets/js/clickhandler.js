const checkClick = function(clickX, clickY, targetX, targetY, elementWidth, elementHeight, tolerance = 0.05) {

    const lowerY = targetY * (1 - tolerance);
    const higherY = targetY * (1 + tolerance);
    const lowerX = targetX * (1 - tolerance);
    const higherX = targetX * (1 + tolerance)

    if ( (clickY/elementHeight <= higherY && clickY/elementHeight >= lowerY) &&
    (clickX/elementWidth <= higherX && clickX/elementWidth >= lowerX) ) 
    {
        return true;
    }
    return false;
}


export { checkClick };
