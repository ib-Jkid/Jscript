//////////////////////////////////////////////////////////
//checking to see if the browser supports XMLHTTPREQUEST
if(window.XMLHttpRequest) {

    xml = new XMLHttpRequest();
    xml2 = new XMLHttpRequest();
    xml3 = new XMLHttpRequest();
    
  }else {
    xml = new ActiveXObject("Microsoft.XMLHTTP");
    xml2 = new ActiveXObject("Microsoft.XMLHTTP");
    xml3 = new ActiveXObject("Microsoft.XMLHTTP");
  }

  username = "";
  commentText = "";
  /***********************************
  *creating a function that executes when readyState changes 
  *using the onreadystateevent
  ********************************/
  xml.onreadystatechange = function () {
    if(xml.readyState == 4 && xml.status == 200) {
      if(xml.responseText == "1") {
        /*******************
         * the following codes writes the comment to the page after it has been uploaded to the 
         * database
         */
        var commentItems = document.getElementById("commentItems");
        var commentItemsFirst = commentItems.getElementsByTagName("div")[0];
        var h6_tag = document.createElement("h6");
        var p_tag = document.createElement("p");
        var div_tag = document.createElement("div_tag");
        div_tag.setAttribute("class","comments");
        div_tag.appendChild(h6_tag);
        div_tag.appendChild(p_tag);
        
        commentItems.insertBefore(div_tag, commentItemsFirst);
        h6_tag.innerHTML = username;
        p_tag.innerHTML = commentText;

      }
    }
  }
  /***********************************
  *creating a function that executes when readyState changes 
  *using the onreadystateevent
  ********************************/
  xml2.onreadystatechange = function () {
    if(xml2.readyState == 4 && xml2.status == 200) {
     /********************************
      * 
      * i have to put some lines of codes here
      * to delete the comment from the screen but it can wait thou
      */
      /*var delC = document.getElementById("com"+xml2.responseText);
      delC.style.display = "none";*/
      
    }
  }
  function commentSubmit  () {
    /****************************
     * using Ajax to upload comments without reloading 
     * the page
     */
    form = document.getElementById("commentForm");

    username = form.getElementsByTagName("input")[0].value;
    songId = form.getElementsByTagName("input")[1].value;
    id_name = form.getElementsByTagName("input")[1].name;
    commentText = form.getElementsByTagName("textarea")[0].value;
    //sending a post request to commment.php on the server
    xml.open("POST","comment.php",true);
    xml.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xml.send("username="+username+"&"+id_name+"="+songId+"&comment="+commentText);
    

    return false;
  }
  function deleteComment(id) {
    xml2.open("GET","qwertyuiop/manage_comment.php?id="+id,true);
    xml2.send();
  }

  ///////////////////////////////////////////////////

  function liked(type,id) {
   /* var alreadyLiked = false;
    var cookee = document.cookie;
    var cookieArray = cookee.split(";");
    for(i = 0; i < cookieArray.length; i++) {
      var insArray = cookieArray[i].split(",");
      for(x = 0; x < insArray.length; x++) {
        if (insArray[x].split("=")[0]== "type" && insArray[x].split("=")[1]== "type") {
            alreadyLiked = true;
        }
      }
    }
    document.cookie ="type="+type+",id="+id+",action=liked;";
    alert(alreadyLiked);*/
  }
