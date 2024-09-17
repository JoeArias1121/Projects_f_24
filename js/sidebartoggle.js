
function sb_open() {
    document.getElementById("main").style.marginLeft = "320px"; //320px
    document.getElementById("mySidebar").style.width = "300px";
    document.getElementById("mySidebar").style.display = "block";
    var open = document.getElementById("openNav");
    open.style.display = "block";
    if(open.style.display == 'block')
    open.style.display = 'none';
    else
     open.style.display = 'block';
}

  
  function sb_close() {
    document.getElementById("main").style.marginLeft = "20px";
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("openNav").style.display = "inline-block";
  }
