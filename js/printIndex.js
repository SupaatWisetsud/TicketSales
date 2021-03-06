function printDiv(divName) {

    let set_seat = document.getElementsByClassName("set_select_seat_id");
    let set_seat_name = document.getElementsByClassName("set_select_seat_name");
    
    let user = document.getElementById("user").value
    let ro_id = document.getElementById("txt_ro_id").value;
    let user_id = document.getElementById("txt_user_id").value;
    let price = document.getElementById("txt_price").value;
    let bus_id = document.getElementById("txt_bus_id").value;
    let bus_name = document.getElementById("txt_bus_name").value;
    let time_start = document.getElementById("txt_time_start").value;
    let ps_name = document.getElementById("txt_ps_name").value;
    let pe_name = document.getElementById("txt_pe_name").value;
    let sale_id = document.getElementById("txt_sale_id").value;

    let date = new Date();

    var mywindow = window.open('', '', 'height=600,width=900');
        
    var genarataPrint = `
        <html>
            <head>
                <style>
                </style>
            </head>
            <body style="padding:0px;margin:0px">
        `
        for(let i = 0; i < set_seat.length; i++) {
            genarataPrint += 
            `<div style="border-top: 1px dotted #333;border-bottom: 1px dotted #333;margin-bottom:2px; pading-bottom:2px">
                <div style="display:flex;justify-content: space-between;width:100%">
                    <div 
                        style="
                            display: flex;
                            justify-content: end;
                            align-items: flex-end;
                            padding-bottom: 10px;"
                        >
                        <h1 style="margin:0">บริษัทแสงสมชัย</h1>
                    </div>
                </div>
                <div style="display:flex;justify-content: space-between;width:100%; align-items:center">
                    <table style="width:50%;text-align: center;" border="1px">
                        <tr style="background-color: slategrey;">
                            <th>ต้นทาง</th>
                            <th>ปลายทาง</th>
                        </tr>
                        <tr style="margin-top:5px">
                        <td>${ps_name}</td>
                        <td>${pe_name}</td>
                        </tr>
                    </table>
                    <div>
                        <h4>รหัสตั๋ว ${parseInt(sale_id) + 1 + i}</h4>
                        <h4>วันที่ ${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear() + 543 }</h4>
                    </div>
                </div>
                <table style="width:100%;text-align: center;" border="1px">
                    <tr style="background-color: slategrey;">
                        <td>เวลาเดินทาง <br>${time_start}</td>
                        <td>รถ <br>${bus_name} - ${bus_id}</td>
                        <td>หมายเลขที่นั้ง <br>${set_seat_name[i].value}</td>
                        <td>ราคา <br>${price}</td>
                        <td>ผู้ขายตั๋ว <br>${user}</td>
                    </tr>
                </table>
                <br>
            </div>`
        }

        `
            </body>
        </html>
    `
    
    mywindow.document.write(genarataPrint);
    mywindow.document.close();
    mywindow.focus();
    mywindow.print();
    // var mediaQueryList = window.matchMedia('print');
    // mediaQueryList.addEventListener("change", function(mql) {
    //     if (mql.matches) {
    //         console.log('before print dialog open');
    //     } else {
    //         console.log('after print dialog closed');
    //     }
    // });
    
    mywindow.close(); 
    unDataToDB(ro_id, user_id, price, bus_id);
}

function sale(divName){
    if (confirm("ยืนยันการขาย")){
        printDiv(divName);
    }
}

function unDataToDB(ro_id, user_id, price, bus_id) {

    var xhr = new XMLHttpRequest();
    xhr.open ( "POST", "server/server_add_sales.php");
    xhr.onreadystatechange = responseXHR;
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    let messageSend = `id_round=${ro_id}&id_emp=${user_id}&price=${price}&pass=hsr224`;

    xhr.send(messageSend);

    function responseXHR(){
        if ( xhr.readyState == 4 )
        {
            console.log(xhr.responseText);
            location.replace(`index.php?ro_id=${ro_id}&bus_id=${bus_id}&price=${price}`)
        }
    }
}