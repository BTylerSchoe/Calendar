
// JavaScript for calendar created with php

// on load, add visual functions to calendar - click- hover - modal/pop-up
window.onload = function() {

    // initialize variable to store the tableData Elements of the calendar
    let elements = document.getElementsByTagName("td")

    // loop through all tableData elements to create browser functionalities
    for(let i = 1; i < elements.length; i++) {

        // adds opacity affect when mouse is over a day of the month
        elements[i].addEventListener('mouseover', function(e) {
        e.target.style.opacity = "0.5";

        });

        // removes opacity affect when mouse leaves
        elements[i].addEventListener('mouseleave', function(e) {
            e.target.style.opacity = "1";
        });

        // function to do something when day is clicked
        elements[i].addEventListener('click', function(e) {
        console.log(e.target.classList.value)
        e.preventDefault();   
        // do something


        // hides and displays the pop up
        $('#modal-custom').toggleClass('out-of-view', 'in-view');
        console.log(e.target);
        });     
    }

    // function to close/ hide the modal when visible
    $('#close-button').on('click', function() {
        $('#modal-custom').toggleClass('out-of-view', 'in-view');

        // do something else..
    });

}