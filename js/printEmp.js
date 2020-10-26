function listUser() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "server/server_list_emp.php?pass=hsr224");
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      console.log(JSON.parse(xhr.responseText));
      print(JSON.parse(xhr.responseText));
    }
  }
}

function print(listUser) {
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
                        <div style="display:flex;justify-content: space-between;">
                            <p style="font-weight: bold;font-size:34px">บริษัทแสงสมชัย</p>
                            <p>${
                              d.getDate() +
                              "/" +
                              d.getMonth() +
                              "/" +
                              d.getFullYear()
                            }</p>
                        </div>
                        <div style="border:2px solid #333; padding: 5px;margin-bottom:5px">
                            <p style="font-weight: bold;font-size:24px;padding:0px;margin:0px">รายชื่อพนักงาน</p>
                        </div>
                    </div>
                    <table style="width:100%;text-align:center">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ไอดี</th>
                                <th>อีเมลล์</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>สถานะ</th>
                                <th>เบอร์โทรติดต่อ</th>
                            </tr>
                        </thead>
                        <tbody>  
        `;

  for (let i = 0; i < listUser.length; i++) {
    genarataPrint += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${listUser[i].u_id}</td>
                                <td>${listUser[i].u_email}</td>
                                <td>${listUser[i].u_first_name}</td>
                                <td>${listUser[i].u_last_name}</td>
                                <td>${
                                  listUser[i].u_role === 0
                                    ? "ลูกจ้าง"
                                    : "ผู้ดูแล"
                                }</td>
                                <td>${listUser[i].u_tel}</td>
                            </tr>
            `;
  }

  genarataPrint += `
                        </tbody>
                    </table>
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
