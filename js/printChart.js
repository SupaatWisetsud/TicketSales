   
var dataList = Array(31).fill(0)

var objRespones = [];

var xhr = new XMLHttpRequest();
xhr.open("GET", "server/server_list_sale_chart.php?pass=hsr224");
xhr.onreadystatechange = responseXHR;
xhr.send(null);

function responseXHR() {
    if (xhr.readyState == 4) {
        console.log(JSON.parse(xhr.responseText));
        objRespones = JSON.parse(xhr.responseText);
        
        for(let n = 0; n < objRespones.length; n++) {
            var d = new Date(objRespones[n].sale_time_sale);
            
            for (let i = 0; i < 31; i++) {
                if (d.getDay() + 13 == i + 1) {
                    dataList[i] = parseInt(objRespones[n].sale_count);
                }
            }
        }
        generateChart(dataList);
    }
}

function generateChart(dataList) {
    var day = []
    for (let i = 1; i <= 31; i++) {
        day = [...day, i];
    }
    const month = [
        "มกราคม (January)",
        "กุมภาพันธ์ (February)",
        "มีนาคม (March)",
        "เมษายน (April)",
        "พฤษภาคม (May)",
        "มิถุนายน (June)",
        "กรกฎาคม (July)",
        "สิงหาคม (August)",
        "กันยายน (September)",
        "ตุลาคม (October)",
        "พฤศจิกายน (November)",
        "ธันวาคม (December)"
    ]
    var ctxLine = document.getElementById('myChartLine').getContext('2d');

    const d = new Date();

    var data = {
        labels: day,
        datasets: [{
            label: 'ยอดขายในเดือน ' + month[d.getMonth()],
            data: dataList,
            backgroundColor: ['#966B9D'],
            borderColor: ['#7E8987'],
            borderWidth: 1
        }]
    }

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }

    var myLineChart = new Chart(ctxLine, {
        type: 'line',
        data: data,
        options: options
    });
}


function printReport() {

    var list_sale = document.getElementById("list_sale_table");
    var originList = list_sale.innerHTML;

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "server/server_list_sale_all.php?pass=hsr224");
    xhr.onreadystatechange = responseXHR;
    xhr.send(null);

    function responseXHR() {
        if (xhr.readyState == 4) {
            console.log(JSON.parse(xhr.responseText));
            let list_sale_data = JSON.parse(xhr.responseText);

            let generateTableListSale = `
                <thead style="background-color: #5DADE2; color:white">
                    <tr>
                        <th>No.</th>
                        <th>ไอดี</th>
                        <th>รอบออก</th>
                        <th>เวลาออก</th>
                        <th>รอบถึง</th>
                        <th>ที่นั้ง</th>
                        <th>รถ</th>
                        <th>ผู้ขายตั๋ว</th>
                        <th>ราคา</th>
                        <th>วันที่/เดือน/ปี</th>
                    </tr>
                </thead>
                <tbody>
            `;
            
            for(let i = 0; i < list_sale_data.length; i++) {
                generateTableListSale += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${list_sale_data[i].sale_id}</td>
                            <td>${list_sale_data[i].ps_name}</td>
                            <td>${list_sale_data[i].ro_time_start}</td>
                            <td>${list_sale_data[i].pe_name}</td>
                            <td>${list_sale_data[i].seat_name}</td>
                            <td>${list_sale_data[i].b_name} - ${list_sale_data[i].b_id}</td>
                            <td>${list_sale_data[i].sale_emp_name}</td>
                            <td>${list_sale_data[i].sale_price}</td>
                            <td>${list_sale_data[i].sale_time_sale}</td>
                        </tr>
                `
            }

            generateTableListSale += `
                </tbody>
            `;
            list_sale.innerHTML = generateTableListSale; 
            window.print();

            list_sale.innerHTML = originList;
        }
    }
}