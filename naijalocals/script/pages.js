function hideAll() {
  for(var i = 0; i < list.length; i++) {
    list[i].style.display = "none";
  }
}

function printArray(startIndex)  {
  for(var x = startIndex; x < startIndex+10; x++) {
    list[x].style.display = "block";
  }
}


function changePage (num) {
  hideAll();
  var arrayStartIndex = (num * 10) - 10;
  printArray(arrayStartIndex);
} 

var items = document.getElementById("items");
var list = items.getElementsByTagName("div");
var pages = Math.ceil(list.length / 10);
changePage(1);




for(var i = 1; i <= pages; i++) {
 
  document.write("<button onclick = 'changePage("+i+")'>"+i+"</button>");
}


