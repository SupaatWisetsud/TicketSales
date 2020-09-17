function printDiv(divName) {

    var mywindow = window.open('', '', 'height=600,width=900');

    var genarataPrint = `
        <html>
            <head>
                <style>
                </style>
            </head>
            <body style="padding:25px">
                <div style="display:flex;justify-content: space-between;width:60%">
                    <div 
                        style="
                            display: flex;
                            justify-content: end;
                            align-items: flex-end;
                            padding-bottom: 10px;"
                        >
                        <h1 style="margin:0">Ticket Sales</h1>
                    </div>
                    <div>
                        <h4>รหัสตั๋ว 0125222</h4>
                        <h4>วันที่ 01/10/2563</h4>
                    </div>
                </div>
                <table style="width:60%;text-align: center;">
                    <tr style="background-color: slategrey;">
                        <th>ต้นทาง</th>
                        <th>เวลาออกเดินทาง</th>
                        <th>ปลายทาง</th>
                        <th>เวลาเดินทางถึง</th>
                    </tr>
                    <tr style="margin-top:5px">
                        <td>บุรีรัมย์</td>
                        <td>08:30</td>
                        <td>ร้อยเอ็ด</td>
                        <td>12:30</td>
                    </tr>
                </table>
                <div style="display:flex;justify-content: space-between;width:60%;padding-left: 15px;padding-right: 15px;box-sizing: border-box;border-top: 1px solid">
                    <p style="font-weight: bold;">หมายเลขที่นั้ง</p>
                    <p>A5</p>
                </div>
                <div style="display:flex;justify-content: space-between;width:60%;padding-left: 15px;padding-right: 15px;box-sizing: border-box;">
                    <p style="margin-top:0px; font-weight: bold;">ราคา</p>
                    <p style="margin-top:0px;">120 ฿</p>
                </div>
            </body>
        </html>
    `
    
    
    mywindow.document.write(genarataPrint);
    mywindow.document.close();
    mywindow.focus();
    mywindow.print();
    
    var mediaQueryList = mywindow.matchMedia('print');
    
    mediaQueryList.addEventListener("change",function(mql) {
        if (!mql.matches) {
            mywindow.close(); 
            unDataToDB();
        }
    });
}

function sale(divName){
    if (confirm("ยืนยันการขาย")){
        printDiv(divName);
    }
}

function unDataToDB() {
    let ro_id = document.getElementById("txt_ro_id").value;
    let user_id = document.getElementById("txt_user_id").value;
    let select_seat = document.getElementById("txt_select_seat").value;
    let price = document.getElementById("txt_price").value;
    let bus_id = document.getElementById("txt_bus_id").value;

    var xhr = new XMLHttpRequest();
    xhr.open ( "POST", "server/server_add_sales.php");
    xhr.onreadystatechange = responseXHR;
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    let messageSend = `id_round=${ro_id}&id_emp=${user_id}&id_seat=${select_seat}&price=${price}&pass=hsr224`;

    xhr.send(messageSend);

    function responseXHR(){
        if ( xhr.readyState == 4 )
        {
            console.log(xhr.responseText);
            location.replace(`index.php?ro_id=${ro_id}&bus_id=${bus_id}&price=${price}`)
        }
    }
}