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

function changeTime() {
  let time_start_h = document.getElementById("time_start_h");
  let time_start_m = document.getElementById("time_start_m");

  let time_end_h = document.getElementById("time_end_h");
  let time_end_m = document.getElementById("time_end_m");
  let bus = document.getElementById("bus");

  let start_h = time_start_h.value;
  let start_m = time_start_m.value;
  let end_h = time_end_h.value;
  let end_m = time_end_m.value;

  console.log(start_h, start_m, end_h, end_m);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "server/server_id_bus_to_form.php");
  xhr.onreadystatechange = responseXHR;
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.send(
    `time_start_h=${start_h}&time_start_m=${start_m}&time_end_h=${end_h}&time_end_m=${end_m}&pass=hsr224`
  );

  function responseXHR() {
    if (xhr.readyState == 4) {
      console.log(xhr.responseText);
      let dateTag = JSON.parse(xhr.responseText);
      str = `<select class="form-control" name="bus" id="bus">`;

      str += dateTag.map(
        (n) => `<option value="${n.b_id}">${n.b_name}</option>`
      );

      str += `</select>`;

      console.log(str);

      bus.innerHTML = str;
    }
  }
}

function changeTime2() {
  let time_start_h = document.getElementById("time_start_h2");
  let time_start_m = document.getElementById("time_start_m2");

  let time_end_h = document.getElementById("time_end_h2");
  let time_end_m = document.getElementById("time_end_m2");
  let bus = document.getElementById("bus2");

  let start_h = time_start_h.value;
  let start_m = time_start_m.value;
  let end_h = time_end_h.value;
  let end_m = time_end_m.value;

  console.log(start_h, start_m, end_h, end_m);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "server/server_id_bus_to_form.php");
  xhr.onreadystatechange = responseXHR;
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhr.send(
    `time_start_h=${start_h}&time_start_m=${start_m}&time_end_h=${end_h}&time_end_m=${end_m}&pass=hsr224`
  );

  function responseXHR() {
    if (xhr.readyState == 4) {
      console.log(xhr.responseText);
      let dateTag = JSON.parse(xhr.responseText);
      str = `<select class="form-control" name="bus" id="bus">`;

      str += dateTag.map(
        (n) => `<option value="${n.b_id}">${n.b_name}</option>`
      );

      str += `</select>`;

      console.log(str);

      bus.innerHTML = str;
    }
  }
}

function listRound() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "server/server_list_round_out.php?pass=hsr224");
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      console.log(JSON.parse(xhr.responseText));
      print(JSON.parse(xhr.responseText));
    }
  }
}

function print(list) {
  var mywindow = window.open("", "", "height=600,width=900");
  var d = new Date();
  var genarataPrint = `
        <html>
            <head>
                <style>
                </style>
            </head>
            <body style="padding:0px;margin:0px">
                <div style="margin-top:10px; width: 100%">
                    <div style="margin-top:10px; width: 100%">
                        <div style="display:flex;justify-content: space-between;">
                            <p style="font-weight: bold;font-size:34px">Ticket Sales</p>
                            <p>${
                              d.getDate() +
                              "/" +
                              d.getMonth() +
                              "/" +
                              d.getFullYear()
                            }</p>
                        </div>
                        <p style="font-weight: bold;font-size:24px;">รายการรอบรถ</p>
                    </div>
                </div>
    `;

  for (let n = 0; n < list.length; n++) {
    genarataPrint += `
                <div style=" margin-top:5%;border:2px solid #333; padding: 5px">
                    <h3 style="margin:0px;padding:0px">${list[n].round}</h3>
                </div>
                <table style="width:100%;text-align:center;" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ไอดี</th>
                            <th>ต้นทาง</th>
                            <th>ปลายทาง</th>
                            <th>เวลาเดินทาง</th>
                            <th>เวลาถึง</th>
                            <th>รถ</th>
                            <th>หมายเลขรถ</th>
                            <th>ราคา</th>
                        </tr>
                    </thead>
                    <tbody>  
        `;

    for (let x = 0; x < list[n].list.length; x++) {
      genarataPrint += `
                <tr>
                    <td>${x + 1}</td>
                    <td>${list[n].list[x].ro_id}</td>
                    <td>${list[n].list[x].ps_name}</td>
                    <td>${list[n].list[x].pe_name}</td>
                    <td>${list[n].list[x].ro_time_start}</td>
                    <td>${list[n].list[x].ro_time_end}</td>
                    <td>${list[n].list[x].b_name}</td>
                    <td>${list[n].list[x].b_id}</td>
                    <td>${list[n].list[x].ro_price}</td>
                </tr>
            `;
    }

    genarataPrint += `
                    </tbody>
                </table>
        `;
  }

  genarataPrint += `
            </body>
        </html>
    `;

  mywindow.document.write(genarataPrint);
  mywindow.document.close();
  mywindow.focus();
  mywindow.print();

  var mediaQueryList = mywindow.matchMedia("print");

  mediaQueryList.addEventListener("change", function (mql) {
    if (!mql.matches) {
      mywindow.close();
    }
  });
}
