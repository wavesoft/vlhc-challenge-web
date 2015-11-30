
var end = new Date('11/30/2015 23:59 PM');

var _second = 1000;
var _minute = _second * 60;
var _hour = _minute * 60;
var _day = _hour * 24;
var timer;

function showRemaining() {
    var now = new Date();
    var distance = end - now;
    if (distance < 0) {

        clearInterval(timer);
        document.getElementById('countdown').innerHTML = 'Completed! Thank you for your participation!';

        return;
    }
    var days = Math.floor(distance / _day);
    var hours = Math.floor((distance % _day) / _hour);
    var minutes = Math.floor((distance % _hour) / _minute);
    var seconds = Math.floor((distance % _minute) / _second);

    document.getElementById('countdown').innerHTML = days + 'd ';
    document.getElementById('countdown').innerHTML += hours + 'h ';
    document.getElementById('countdown').innerHTML += minutes + 'm ';
    document.getElementById('countdown').innerHTML += seconds + 's';
}

timer = setInterval(showRemaining, 1000);



$(document).ready(function(){
    
    showRemaining();
})