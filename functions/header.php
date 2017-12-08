<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alumni Portal</title>
<style>
	.dropbtn {
	    background-color: #fff;
	    color: #333;
	    padding:26px 15px;
	    border: none;
	    cursor: pointer;
	}

	/* Dropdown button on hover & focus */
	.dropbtn:focus {
	    background-color: #d1d1d1;
	}

	/* The container <div> - needed to position the dropdown content */
	.dropdown {
	    position: relative;
	    display: inline-block;
	}

	/* Dropdown Content (Hidden by Default) */
	.dropdown-content {
		overflow-y:scroll;
		height:300px;
		width:290px;
	    display: none;
	    position: absolute;
	    background-color: #f9f9f9;
	    min-width: 160px;
	    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
	    z-index: 1;
	}

	/* Links inside the dropdown */
	.dropdown-content a {
	    color: black;
	    padding: 12px 16px;
	    text-decoration: none;
	    display: block;
	}

	/* Change color of dropdown links on hover */
	.dropdown-content a:hover {background-color: #f1f1f1}

	/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
	.show {display:block;}
</style>
<!-- css here -->
<script src="../layouts/js/jquery-3.2.1.min.js"></script>
<link rel="shortcut icon" type="image/png" href="../layouts/images/logo.png" />
<script src="../ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
<link rel="stylesheet" type="text/css" href="../layouts/css/layout.css">
<link rel="stylesheet" type="text/css" href="../layouts/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="../layouts/css/font-awesome.min.css">
<script src="../layouts/js/sweetalert.min.js"></script>
<script type="text/javascript">
	function myFunction() {
	    document.getElementById("myDropdown").classList.toggle("show");
	}
	// Close the dropdown menu if the user clicks outside of it
	window.onclick = function(event) {
	  if (!event.target.matches('.dropbtn')) {

	    var dropdowns = document.getElementsByClassName("dropdown-content");
	    var i;
	    for (i = 0; i < dropdowns.length; i++) {
	      var openDropdown = dropdowns[i];
	      if (openDropdown.classList.contains('show')) {
	        openDropdown.classList.remove('show');
	      }
	    }
	  }
	}
</script>


