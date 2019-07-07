function update(e, pri){
    var pepe=e.id.substring(1,e.id.length);

    var stock=parseInt(document.getElementById("s"+pepe).innerHTML);
    var sub_quant=document.getElementById("q"+pepe);

    var beforeT=parseInt(document.getElementById("t"+pepe).value);
    document.getElementById("t"+pepe).value=pri*sub_quant.value;
    var total=parseInt(document.getElementById("total").value);
    var cant=document.getElementById("cant");
    var lastT=parseInt(document.getElementById("t"+pepe).value);
    
    
    var i=1;
    var pepe2=1;
    var lucho=beforeT/pri;
    var lucho2=sub_quant.value;
    var lucho3=lucho2-lucho;

    var selling=document.getElementById("selling");
    if(selling.value.indexOf(pepe)==-1 && sub_quant.value!=0){
      selling.value+=pepe+"-";
    }else if(selling.value.indexOf(pepe)!=-1 && sub_quant.value==0){
      console.log(pepe);
      console.log(pepe.length);
      sv=selling.value;
      selling.value=sv.substring(0,sv.indexOf(pepe))+sv.substring(sv.indexOf(pepe)+pepe.length+1,sv.length);
    }

    cant.value=parseInt(cant.value)+parseInt(lucho3);
    updateTotal();
}
function updateTotal(){
  console.log("hola");
  var selling=document.getElementById("selling");
  var sv=selling.value;
  console.log(sv);
  var total_aux=0;
  var total=document.getElementById("total");
  var subtotal_index;
  var ayuda;
  console.log(sv.indexOf("-"));
  while(sv.indexOf("-")!=-1){
    console.log("pepe jejejeje");
    subtotal_index=sv.substring(0, sv.indexOf('-'));
    ayuda=document.getElementById("t"+subtotal_index).value;
    total_aux+=parseInt(ayuda);
    sv=sv.substring(sv.indexOf("-")+1,sv.length);
  }
  document.getElementById("total").value=total_aux;
}
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[document.getElementById("TB").value];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function borrar(){
  document.getElementById("myInput").value="";
  myFunction();

}

var x, i, j, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
