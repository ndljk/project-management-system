//Daje funkcionalnost btnu iz sidebara
function btnDodajClick() {
  window.location = "kreirajProjekat.php";
}


function ucitavanjeKartica(status, projekatID) {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let cards = document.getElementById("cards");
      cards.innerHTML = this.responseText;
    }

  }
  xhr.open("GET", "/kartice.php?status=" + status + "&projekatID=" + projekatID);
  xhr.send();
}

function btnDeleteProject(naziv) {
  var nazivPr = naziv;
  window.location = "/deleteProject.php?projekat=" + nazivPr;
}

function prikaziLozinke() {
  var x = document.getElementById("rePass");
  var y = document.getElementById("rePassConf");

  if (x.type === "password") {
    x.type = "text";
    y.type = "text";
  }
  else {
    x.type = "password";
    y.type = "password";
  }
}

function prikaziLozinku() {
  var element = document.getElementById("chPassword");
  var icon = document.getElementById("btnIcon");

  if (element.type === "password") {
    element.type = "text";
    icon.className = "fa fa-eye-slash";
  }
  else {
    element.type = "password";
    icon.className = "fa fa-eye";
  }
}
