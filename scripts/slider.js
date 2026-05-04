var rotate_delay = 5000; // delay in milliseconds (5000 = 5 secs)
var current = 0;
var valor = '';
function next() {
if (document.getElementsByName("slide")[current+1]) {
alert(document.getElementsByName("slide")[current+1].value);
document.getElementsByName("show").src = document.getElementsByName("slide")[current+1].value;
document.getElementsByName("slide").selectedIndex = ++current;
   }
else first();
}
function previous() {
if (current-1 >= 0) {
document.getElementsByName("show").src = document.getElementsByName("slide")[current-1].value;
document.getElementsByName("slide").selectedIndex = --current;
   }
else last();
}
function first() {
current = 0;
alert(document.getElementsByName("slide")[current].value);
document.getElementsByName("show").src = document.getElementsByName("slide")[current].value;
document.getElementsByName("slide").selectedIndex = 0;
}
function last() {
current = document.getElementsByName("slide").length-1;
document.getElementsByName("show").src = document.getElementsByName("slide")[current].value;
document.getElementsByName("slide").selectedIndex = current;
}
function ap(text) {
document.getElementsByName("slidebutton").value = (text == "Stop") ? "Start" : "Stop";
rotate();
}
function change() {
current = document.getElementsByName("slide").selectedIndex;
valor = document.getElementsByName("slide")[current].value;
document.getElementsByName("show").src = valor;
}
function rotate() {
if (document.getElementsByName("slidebutton").value == "Stop") {
current = (current == document.getElementsByName("slide").length-1) ? 0 : current+1;
document.getElementsByName("show").src = document.getElementsByName("slide")[current].value;
document.getElementsByName("slide").selectedIndex = current;
window.setTimeout("rotate()", rotate_delay);
   }
}
/*document.getElementsByName("x")
function next() {
if (document.slideform.slide[current+1]) {
document.images.show.src = document.slideform.slide[current+1].value;
document.slideform.slide.selectedIndex = ++current;
   }
else first();
}
function previous() {
if (current-1 >= 0) {
document.images.show.src = document.slideform.slide[current-1].value;
document.slideform.slide.selectedIndex = --current;
   }
else last();
}
function first() {
current = 0;
document.images.show.src = document.slideform.slide[0].value;
document.slideform.slide.selectedIndex = 0;
}
function last() {
current = document.slideform.slide.length-1;
document.images.show.src = document.slideform.slide[current].value;
document.slideform.slide.selectedIndex = current;
}
function ap(text) {
document.slideform.slidebutton.value = (text == "Stop") ? "Start" : "Stop";
rotate();
}
function change() {
current = document.slideform.slide.selectedIndex;
document.images.show.src = document.slideform.slide[current].value;
}
function rotate() {
if (document.slideform.slidebutton.value == "Stop") {
current = (current == document.slideform.slide.length-1) ? 0 : current+1;
document.images.show.src = document.slideform.slide[current].value;
document.slideform.slide.selectedIndex = current;
window.setTimeout("rotate()", rotate_delay);
   }
}*/