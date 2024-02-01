<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="functions.js"></script>
	<title><?php echo $title = 'Vero Task'; ?></title>
</head>

<body>

<h1><?php echo $title; ?></h1>

<div id="modal_background" style="display:none;"></div>
<div id="modal_center" style="display:none">
	<div id="modal_container">
		<div id="modal_close_button"><a class="close_icon" href="javascript:close_modal();">&#x2715;</a></div>
		<div id="modal">
			<h2>Select Image</h2>
			<input type="file" name="image_select" id="image_select" accept="image/*" onChange="select_image();" />
			<label id="image_select_lebel" for="image_select">+</label>
		</div>
	</div>
</div>

<div id="search_input">
	<input type="text" name="search" id="search" value="" placeholder="Search" onFocus="this.placeholder='';"  onBlur="this.placeholder='Search';" /><!--onKeyUp="search_data();"-->
	<div class="search_icon" onClick="close_modal();">&#9740;</div>
	<button onClick="search_data();">Search</button>
</div>

<button class="open_modal" onClick="open_modal();">Select Image</button>

<div id="data"><?php include("data.idiv.php"); ?></div>

</body>

</html>
