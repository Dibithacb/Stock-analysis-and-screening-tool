<?php
session_start();
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_PARSE);
$Hostname = "localhost";
$UserName = "root";
$Password = "";

$DatabaseName="Riafy";
mysql_connect($Hostname ,$UserName,$Password);
mysql_select_db($DatabaseName);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 70%;
}

td, th {
  border: 1px solid #EOF2FF;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: 	#ECF8E8;
}

</style>
</head>     
<body>

<h2>Stocks</h2>
<h1 style="text-align:center">The easiest way to buy and sell stocks</h1>


<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" >
  <div style="width:800px; margin:0 auto;" class="autocomplete" style="width:300px;">
    <input id="myInput" type="text" name="myCountry" placeholder="Company">
  </div>
  <input type="submit">
</form>
<?php 
if($_REQUEST['myCountry']!=""){
  //echo 'inside';  
   $Get_Sql=mysql_query("SELECT * FROM `company` where Name='".$_REQUEST['myCountry']."'");
   $Res_Sql=mysql_fetch_array($Get_Sql); 
       $Market=$Res_Sql['Market Cap'];
       $Divident=$Res_Sql['Dividend_Yield'];
       $Debt=$Res_Sql['Stock'];
       $Current=$Res_Sql['Current_Market_Price'];
       $ROCE=$Res_Sql['ROCE'];
       $Eps=$Res_Sql['EPS'];
       $Stock=$Res_Sql['Stock	'];
       $ROE=$Res_Sql['ROE_Previous_Annum'];
       $Reserves=$Res_Sql['Reserves'];
       $Debit=$Res_Sql['Debt'];
 ?>
<table>
    <div class="container">
        <h1><?=$_REQUEST['myCountry'];?>
            <tr>
                <td>Market Cap &#x20b9; <?=$Market?></td>
                <td>Divident Yield <?=$Divident?>%</td>
                <td>Debt Equality <?=$Debt?>%</td>
            </tr>
             <tr>
                <td>Current Price &#x20b9;<?=$Current?></td>
                <td>ROCE <?=$ROCE?>%</td>
                <td>Eps &#x20b9;<?=$Eps?></td>
            </tr>
             <tr>
                <td>Stock P/E <?=$Stock?>%</td>
                <td>ROE <?=$ROE?>%</td>
                <td>Reserves &#x20b9;<?=$Reserves?></td>
            </tr>
             <tr>
                <td>Debit &#x20b9;<?=$Debit?></td>
                
            </tr>
    </div>
</table>
<?php
}
//echo $_REQUEST['myCountry'];
?>
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Bhansali Engg.","Coal India","IOL Chemicals","Dolat Investment","NDTV","Balmer Law. Inv.","Ebixcash World","Mangalam Organic","INEOS Styrolut.","Expleo Solutions","Sh. Jagdamba Pol","Godawari Power","Cigniti Tech.","Kirl. Ferrous","Rites","Guj.St.Petronet","Ester Industries","Anjani Portland","Venky","Heritage Foods","SIS","GTPL Hathway","Welspun Corp","I G Petrochems","Geojit Fin. Ser.","Sasken Technol.","Engineers India","Petronet LNG","Saksoft","Polyplex Corpn"]
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), countries);
</script>

</body>
</html>
