var my_skins = ["skin-blue", "skin-black", "skin-red", "skin-yellow", "skin-purple", "skin-green"];
$(function () {
  /* For demo purposes */
  var demo = $("<div />").css({
    position: "fixed",
    top: "70px",
    right: "0",
    background: "#fff",
    "border-radius": "5px 0px 0px 5px",
    padding: "10px 15px",
    "font-size": "16px",
    "z-index": "99999",
    cursor: "pointer",
    color: "#3c8dbc",
    "box-shadow": "0 1px 3px rgba(0,0,0,0.1)"
  }).html("<i class='fa fa-link'></i>").addClass("no-print");

  var demo_settings = $("<div />").css({
    "padding": "10px",
    position: "fixed",
    top: "70px",
    right: "-250px",
    background: "#fff",
    border: "0px solid #ddd",
    "width": "250px",
    "z-index": "99999",
    "box-shadow": "0 1px 3px rgba(0,0,0,0.1)"
  }).addClass("no-print");
  demo_settings.append(
          "<h4 class='text-light-blue' style='margin: 0 0 5px 0; border-bottom: 1px solid #ddd; padding-bottom: 15px;'>Quick links</h4>"
          //Fixed layout
          + "<div class='form-group'>"
          + "<div class='checkbox' id='pagelinks2'>None"
          + "</div>"
          + "</div>"
          );
  
 

  demo.click(function () {
    if (!$(this).hasClass("open")) {
      $(this).animate({"right": "250px"});
      demo_settings.animate({"right": "0"});
      $(this).addClass("open");
    } else {
      $(this).animate({"right": "0"});
      demo_settings.animate({"right": "-250px"});
      $(this).removeClass("open");
    }
  });

  $("body").append(demo);
  $("body").append(demo_settings);
	
  setup();
checkHistory("pagelinks2");

});
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + '=' + cvalue + ';path="/";' + expires;
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for ( var i = 0; i < ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name) == 0)
			return c.substring(name.length, c.length);
	}
	return "";
}

function checkHistory(targetId) {
	var history = getCookie("history");
	var htmlContent = '';

	if (history != "") {
		var insert = true;
		var sp = history.toString().split(",");
		for ( var i = sp.length - 1; i >= 0; i--) {
			htmlContent += '<a class="btn-block btn bg-purple"  href="'
					+ sp[i]
					+ '">'
					//+ sp[i].substring(sp[i].lastIndexOf('/') + 1) + '</a><br>';
					+ sp[i].replace( path,"") + '</a><br>';
			if (sp[i] == document.URL) {
				insert = false;
			}
			document.getElementById(targetId).innerHTML = htmlContent;
		}
		if (insert) {
			sp.push(document.URL);
		}
		setCookie("history", sp.toString(), 30);
	} else {
		var stack = new Array();
		stack.push(document.URL);
		setCookie("history", stack.toString(), 30);
	}
}


function clearHistory(targetId) {
	setCookie("history", "", -1);
	document.getElementById(targetId).innerHTML = "";
	alert("Visited page links were cleared");
}
function change_layout(cls) {
  $("body").toggleClass(cls);
  $.AdminLTE.layout.fixSidebar();  
}
function change_skin(cls) {  
  $.each(my_skins, function (i) {
    //$("body").removeClass(my_skins[i]);
  });

 // $("body").addClass(cls);
  //store('skin', cls);
  return false;
}
function store(name, val) {
  if (typeof (Storage) !== "undefined") {
    localStorage.setItem(name, val);
  } else {
    alert('Please use a modern browser to properly view this template!');
  }
}
function get(name) {
  if (typeof (Storage) !== "undefined") {
    return localStorage.getItem(name);
  } else {
    alert('Please use a modern browser to properly view this template!');
  }
}

function setup() {
  var tmp = get('skin');
  if (tmp && $.inArray(tmp, my_skins))
    change_skin(tmp);
}
