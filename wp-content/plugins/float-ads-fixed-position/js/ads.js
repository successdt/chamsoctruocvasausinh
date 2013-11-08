/*
<div id="fl813691" style="height: 120px; display: block;">
  <div id="eb951855">
    <div id="cob263512">
      <div id="coh963846">
        <ul id="coc67178">
          <li id="pf204652hide" style="display: inline;"><a title="Ẩn đi" href="javascript:pf204652clickhide();" class="min"> Ẩn</a></li>
          <li id="pf204652show" style="display: none;"><a title="Hiện lại" href="javascript:pf204652clickshow();" class="max">Xem </a></li>
          <li style="display: none;" id="pf204652close"><a title="Đóng lại" href="javascript:pf204652clickclose();" class="close"> Đóng</a></li>
        </ul>
        <a title="Ngoại Ngữ Tin Học Phương Đông" target="javascript:void(0);" href="#">Chăm sóc khách hàng</a> </div>
      <div id="co453569"> <a href="#"><img src="http://www.pico.vn/Images/Banner/920_banhangdienthoai.gif" width=290 height=80/></a>
        <div class="clr"></div>
        <div class="clr"></div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email đặt hàng: <a href="mailto:contact@ngoainguphuongdong.com" style="text-align:center">contact@ngoainguphuongdong.com</a> </div>
    </div>
  </div>
</div>
*/
pf204652bottomLayer = document.getElementById('fl813691');
var pf204652IntervalId = 0;
var pf204652maxHeight = 130;
var pf204652minHeight = 20;
var pf204652curHeight = 0;

function getCookieState() {
	var isMinimized = null;
	var isClosed = null;
	if (parseInt(isMinimized) == 1) {
		pf204652bottomLayer.style.height=pf204652minHeight+'px';
		document.getElementById('pf204652hide').style.display='none';
		document.getElementById('pf204652show').style.display='inline';
	}
	else {
		pf204652bottomLayer.style.height = pf204652maxHeight+'px';
		document.getElementById('pf204652hide').style.display='inline';
		document.getElementById('pf204652show').style.display='none';
	}
}

function pf204652show(){
	if (pf204652IntervalId != null) {
		pf204652curHeight += 2;
		if(pf204652curHeight > pf204652maxHeight){
			clearInterval(pf204652IntervalId);
			pf204652IntervalId = null;
		}
		pf204652bottomLayer.style.height = pf204652curHeight+'px';
	}
}
function pf204652hide(){
	if (pf204652IntervalId != null) {
		pf204652curHeight -= 3;

		if(pf204652curHeight < pf204652minHeight){
			clearInterval(pf204652IntervalId);
			pf204652IntervalId = null;
		}
		pf204652bottomLayer.style.height=pf204652curHeight+'px';
	}
}

function pf204652clickhide(){
	document.getElementById('pf204652hide').style.display='none';
	document.getElementById('pf204652show').style.display='inline';
	pf204652bottomLayer.style.height=pf204652minHeight+'px';
}

function pf204652clickshow(){
	document.getElementById('pf204652hide').style.display='inline';
	document.getElementById('pf204652show').style.display='none';
	pf204652bottomLayer.style.height = pf204652maxHeight+'px';
}

function pf204652clickclose(){
	document.body.style.marginBottom = '0px';
	pf204652bottomLayer.style.display = 'none';
}

//getCookieState();