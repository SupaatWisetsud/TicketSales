
var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function () {
  modal.style.display = "block";
};

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};


function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  
  document.body.innerHTML = printContents;

  window.print();
  document.body.innerHTML = originalContents;

      
  var xhr = new XMLHttpRequest ();
  xhr.open ( "POST", "server/server_add_sales.php");
  xhr.onreadystatechange = responseXHR;
  xhr.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );

  let obj = {
      // id_round: <?php echo $_GET['ro_id'] ?>,
      // id_emp: <?php echo $_SESSION["user_id"] ?>,
      // id_seat: <?php echo $_GET["select_seat"] ?>,
      // price: <?php echo $_GET["price"] ?>,
      // time: <?php echo time() ?>
  }
  // let message = "id_round=" + <?= $_GET['ro_id'] ?>
  console.log(message)
  // xhr.send (`id_round=${obj.id_round}&id_emp=${obj.id_emp}&id_seat=${obj.id_seat}&price=${obj.price}&time=${obj.time}&pass=hsr224`);

  function responseXHR() {
      if ( xhr.readyState == 4 )
      {
          console.log(xhr.responseText);
          // location.replace(`index.php?ro_id=${obj.id_round}&bus_id=${<?= $_GET["bus_id"] ?>}&price=${obj.price}`)
      }
  }

}