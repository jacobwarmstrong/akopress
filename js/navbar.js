/*
Adds changing color hover
*/

//get color from jumbotron and make it a c hair darker
var jumboColor = jQuery('.jumbotron').css('background-color');
jumboColor = jumboColor.replace('rgb(', '');
jumboColor = jumboColor.replace(')', '');
var colorValues = jumboColor.split(',');
var newValues = [];
colorValues.forEach( color => newValues.push( Math.floor(color * .9) ) );
var newColor = "rgb(" + newValues[0] + "," + newValues[1] + "," + newValues[2] + ")";



jQuery('#site-navigation').hover(function() {
    jQuery(this).css('background-color', newColor);
}, function () {
    jQuery(this).css('background-color', 'rgba(0,0,0,0)');
    jQuery(this).addClass('navbar-dark');
})


