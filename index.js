var leftside_el = document.getElementsByClassName('leftside_fixed');
var rightside_el = document.getElementsByClassName('rightside_fixed');
var one = document.getElementById('one');
var two = document.getElementById('two');
var three = document.getElementById('three');
var four = document.getElementById('four');
var five = document.getElementById('five');
var six = document.getElementById('six');
var seven = document.getElementById('seven');
var eight = document.getElementById('eight');
var els = document.querySelectorAll('.leftside_fixed>a');
leftside_el[0].setAttribute('style', 'width: 227px;');
rightside_el[0].setAttribute('style', 'width: 227px;');
var logo = document.getElementById('logo');
var one1 = document.getElementById('one1');
var two2 = document.getElementById('two2');
var three3 = document.getElementById('three3');
logo.setAttribute('style', 'margin-left: 5px; margin-right: 16px;');
for (var i = 0; i < els.length; i++){
	els[i].setAttribute('style', 'margin-left: 5px; margin-right: 16px;');
}
var els2 = document.querySelectorAll('.rightside_fixed>a');
for (var i = 0; i < els2.length; i++){
	els2[i].setAttribute('style', 'margin-right: 5px; margin-left: 16px;');
}
function checked() {
var prevEl = this.previousSibling;
	var nextEl = this.nextSibling;
	prevEl.setAttribute('style', 'border-bottom: none; margin-left: 5px; margin-right: 16px;');
	nextEl.setAttribute('style', 'border-top: none; margin-left: 5px; margin-right: 16px;');
	this.setAttribute('style', 'background-color: rgba(225, 225, 225, 0.4); margin-left: 0; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; border: none; border-radius: 5px; margin-right: 11px;');
}
		function checked1() {
			var nextEl = this.nextSibling;
			nextEl.setAttribute('style', 'border-top: none; margin-right: 5px; margin-left: 16px;');
			this.setAttribute('style', 'background-color: rgba(225, 225, 225, 0.4); margin-right: 0; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; border: none; border-radius: 5px; margin-left: 11px;');
		}
		function unchecked1(){
			this.setAttribute('style', 'background-color: none; margin-right: 5px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; border-top: 2px solid rgba(225, 225, 225, 0.3); border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-left: 16px;');
			var nextEl = this.nextSibling;
			nextEl.setAttribute('style', 'border-top: 1px solid rgba(225, 225, 225, 0.3); margin-right: 5px; margin-left: 16px;');
		}
		function checked2() {
			var prevEl = this.previousSibling;
			var nextEl = this.nextSibling;
			prevEl.setAttribute('style', 'border-bottom: none; margin-left: 16px; margin-right: 5px;');
			nextEl.setAttribute('style', 'border-top: none; margin-left: 16px; margin-right: 5px;');
			this.setAttribute('style', 'background-color: rgba(225, 225, 225, 0.4); margin-right: 0; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; border: none; border-radius: 5px; margin-left: 11px;');
			//leftside_el[0].setAttribute('style', 'margin-right: ')
		}
		function unchecked2(){
			this.setAttribute('style', 'background-color: none; margin-left: 16px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; border-top: 1px solid rgba(225, 225, 225, 0.3); border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-right: 5px;');
			var nextEl = this.nextSibling;
			var prevEl = this.previousSibling;
			nextEl.setAttribute('style', 'border-top: 1px solid rgba(225, 225, 225, 0.3); margin-left: 16px; margin-right: 5px;');
			prevEl.setAttribute('style', 'border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-left: 16px; margin-right: 5px;');
		}
		function checked3() {
			var previousEl = this.previousSibling;
			previousEl.setAttribute('style', 'border-bottom: none; margin-left: 16px; margin-right: 5px;');
			this.setAttribute('style', 'background-color: rgba(225, 225, 225, 0.4); margin-right: 0; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; border: none; border-radius: 5px; margin-left: 11px;');
			//leftside_el[0].setAttribute('style', 'margin-right: ')
		}
		function unchecked3(){
			this.setAttribute('style', 'background-color: none; margin-left: 16px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; border-bottom: 2px solid rgba(225, 225, 225, 0.3); border-top: 1px solid rgba(225, 225, 225, 0.3); margin-right: 5px;');
			var prevEl = this.previousSibling;
			prevEl.setAttribute('style', 'border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-right: 5px; margin-left: 16px;');
		}
		function unchecked(){
			this.setAttribute('style', 'background-color: none; margin-left: 5px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; border-top: 1px solid rgba(225, 225, 225, 0.3); border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-right: 16px;');
			var nextEl = this.nextSibling;
			var prevEl = this.previousSibling;
			nextEl.setAttribute('style', 'border-top: 1px solid rgba(225, 225, 225, 0.3); margin-left: 5px; margin-right: 16px;');
			prevEl.setAttribute('style', 'border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-left: 5px; margin-right: 16px;');
		}
		function checkedForLast() {
			var prevEl = this.previousSibling;
			prevEl.setAttribute('style', 'border-bottom: none; margin-left: 5px; margin-right: 16px;');
			this.setAttribute('style', 'background-color: rgba(225, 225, 225, 0.4); margin-left: 0; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; border: none; border-radius: 5px; margin-right: 11px;');
			//leftside_el[0].setAttribute('style', 'margin-right: ')
		}
		function uncheckedForLast(){
			this.setAttribute('style', 'background-color: none; margin-left: 5px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; border-top: 1px solid rgba(225, 225, 225, 0.3); border-bottom: 2px solid rgba(225, 225, 225, 0.3); margin-right: 16px;');
			var prevEl = this.previousSibling;
			prevEl.setAttribute('style', 'border-bottom: 1px solid rgba(225, 225, 225, 0.3); margin-left: 5px; margin-right: 16px;');
		}
		one.onmouseover = checked;
		one.onmouseout = unchecked;
		two.onmouseover = checked;
		two.onmouseout = unchecked;
		three.onmouseover = checked;
		three.onmouseout = unchecked;
		four.onmouseover = checked;
		four.onmouseout = unchecked;
		five.onmouseover = checked;
		five.onmouseout = unchecked;
		six.onmouseover = checked;
		six.onmouseout = unchecked;
		seven.onmouseover = checked;
		seven.onmouseout = unchecked;
		eight.onmouseover = checkedForLast;
		eight.onmouseout = uncheckedForLast;
		one1.onmouseover = checked1;
		one1.onmouseout = unchecked1;
		two2.onmouseover = checked2;
		two2.onmouseout = unchecked2;
		three3.onmouseover = checked3;
		three3.onmouseout = unchecked3;
var download_img = document.querySelectorAll('input[type="file"]');
var download_img_bttn = document.querySelectorAll('input[type="submit"]');
function onelement(){
	download_img_bttn.setAttribute('style', 'background-color: #6eb9ff;');
}
function notonelement(){
	download_img_bttn.setAttribute('style', 'background-color: #57A7FF;');
}
download_img.onmouseover = onelement;
download_img.onmouseout = notonelement;