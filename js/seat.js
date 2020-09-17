

var modal = document.getElementById("myModal");
var modalCar = document.getElementById("myModalcar");

var btn = document.getElementById("myBtn");
var btnAddCar = document.getElementById("btn-add-car");

var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];

btn.onclick = function () {
  modal.style.display = "block";
};
btnAddCar.onclick = function () {
  modalCar.style.display = "block";
};

span.onclick = function () {
  modal.style.display = "none";
};
span1.onclick = function () {
  modalCar.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

