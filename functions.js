function ajax_request_object() {
	let xmlhttp = '';
	if(window.XMLHttpRequest) xmlhttp = new XMLHttpRequest();
	else xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	return xmlhttp;
}

function ajax_get(url,target) {
	let xmlhttp = ajax_request_object();
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange = function() {
		if((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) document.getElementById(target).innerHTML = xmlhttp.responseText;
	};
	xmlhttp.send(null);
}

function search_data() {
	let query = document.getElementById("search").value;
	ajax_get("data.idiv.php?query="+query,"data");
}

setInterval(function() {
	document.getElementById("search").value = '';
	ajax_get("data.idiv.php?token="+Math.random().toString(36).substr(2),"data");
}, 3600*1000);

function open_modal() {
	document.getElementById("modal_background").style.display = 'block';
	document.getElementById("modal_center").style.display = 'flex';
}

function close_modal() {
	document.getElementById("modal_background").style.display = 'none';
	document.getElementById("modal_center").style.display = 'none';
	document.getElementById("modal").style.backgroundImage  = 'none';
	document.getElementById("image_select_lebel").style.display = 'block';
}

function select_image() {
	document.getElementById("image_select_lebel").style.display = 'none';
	let files = document.getElementById("image_select").files;
	document.getElementById("modal").style.backgroundImage  = 'url('+URL.createObjectURL(files[0])+')';
}
