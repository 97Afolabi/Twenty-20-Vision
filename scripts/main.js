/*
*  This is the main JavaScript file
*/

//print the current date in the format YYYY-MM-DD
function fulldate() {
var d = new Date();
var year = d.getFullYear();
var month = d.getMonth();
var day = d.getDate();
if (day < 10) {
day = "0" + day;
}
if (month < 10) {
month = "0" + month;
}
return year + "-" + month + "-" + day;
}

//print the current date and time in the format YYYY-MM-MM HH:MM:SS
function datetime() {
var d = new Date();
var year = d.getFullYear();
var month = d.getMonth();
var day = d.getDate();
var hour = d.getHours();
var minute = d.getMinutes();
var seconds = d.getSeconds();

//append a leading zero to if return value is less than 10
if (day < 10) {
day = "0" + day;
}
if (month < 10) {
month = "0" + month;
}
if (hour < 10) {
hour = "0" + hour;
}
if (minute < 10) {
minute = "0" + minute;
}
if (seconds < 10) {
seconds = "0" + seconds;
}

return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + seconds;
}

//split returned into JavaScript compatible format for beautiful date and time
//$rec_date is imaginary returned variable

var raw_datetime = $rec_date;
var datetime_split = raw_datetime.split(" ");
var date = datetime_split[0];
var time = datetime_split[1];

var new_datetime = date + "T" + time + "+01:00"; //YYYY-MM-MMTHH:MM:SS+01:00

var beaut_date = new Date(new_datetime);

//time
var new_time = beaut_date.toLocaleTimeString();
//date
var new_date = beaut_date.toDateString();

document.write(new_time + " " + new_date);

