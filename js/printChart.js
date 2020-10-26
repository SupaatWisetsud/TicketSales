let history_car = document.getElementById("history_car");
let saleEachMonth = document.getElementById("sale_each_month");
let saleEachYear = document.getElementById("sale_each_year");

history_car.value = toDay();
saleEachMonth.value = toMonth();

generateOptionYear();

var categoryCarCtx = document
  .getElementById("count_category_car")
  .getContext("2d");
var saleMonthCtx = document.getElementById("sale_month_ctx").getContext("2d");
var saleYearCtx = document.getElementById("sale_year_ctx").getContext("2d");

var myChartCategoryHot, myChartSaleMonth, myChartSaleYear;

loadCategoryHot(toDay());
loadSaleMonth(toMonth());
loadSaleYear(toYear());

function loadCategoryHot(day) {
  if (myChartCategoryHot) myChartCategoryHot.destroy();

  getListDataToDayCategoryCarHot(day, function (data) {
    let labels = data.map((n) => n.b_name);
    let datas = data.map((n) => n.count);
    let backgroundColor = data.map(
      (_, i) => "#" + (((1 << 24) * Math.random()) | 0).toString(16)
    );

    myChartCategoryHot = new Chart(categoryCarCtx, {
      type: "pie",
      data: {
        labels,
        datasets: [
          {
            data: datas,
            backgroundColor,
          },
        ],
      },
    });
  });
}

function loadSaleMonth(month) {
  if (myChartSaleMonth) myChartSaleMonth.destroy();

  const months = [
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
    "ธันวาคม (December)",
  ];

  getListDataToMonthSale(month, function (data) {
    const dateMonth = new Date(month).getMonth();

    let datas = Array(31).fill(0);

    data.forEach((n) => {
      let dateDay = new Date(n.sale_time_sale).getDate();
      datas[dateDay] = n.sale_count;
    });

    let day = [];
    for (let i = 1; i <= 32; i++) {
      day.push(i);
    }
    let backgroundColor = ["rgba(255, 99, 132, 0.2)"];
    let borderColor = ["rgba(255, 99, 132, 1)"];
    let borderWidth = 1;

    myChartSaleMonth = new Chart(saleMonthCtx, {
      type: "line",
      data: {
        labels: day,
        datasets: [
          {
            label: "ยอดขายในเดือน " + months[dateMonth],
            data: datas,
            backgroundColor,
            borderColor,
            borderWidth,
          },
        ],
      },
    });
  });
}

function loadSaleYear(year) {
  if (myChartSaleYear) myChartSaleYear.destroy();

  getListDataToYearSale(year, function (data) {
    let datas = Array(12).fill(0);

    data.forEach((n) => {
      let dateMonth = new Date(n.sale_time_sale).getMonth();
      datas[dateMonth] = n.sale_count;
    });

    let month = [];
    for (let i = 1; i <= 12; i++) {
      month.push(i);
    }

    let backgroundColor = [
      "#EE1591",
      "#C000D9",
      "#A54366",
      "#BD5966",
      "#83B0E1",
      "#D9B85B",
      "#ED1D6B",
      "#9EE1F6",
      "#B1F5A7",
      "#7A17F1",
      "#9C2615",
      "#C86162",
    ];

    myChartSaleYear = new Chart(saleYearCtx, {
      type: "bar",
      data: {
        labels: month,
        datasets: [
          {
            label: "ยอดขายในปี " + year,
            data: datas,
            backgroundColor,
          },
        ],
      },
    });
  });
}

function changeDateCategoryCar() {
  if (history_car.value) {
    loadCategoryHot(history_car.value);
  }
}

function changeSaleMonth() {
  if (saleEachMonth.value) {
    loadSaleMonth(saleEachMonth.value);
  }
}

function changeSaleYear() {
  loadSaleYear(saleEachYear.value);
}

function toDay() {
  let now = new Date();
  let day = ("0" + now.getDate()).slice(-2);
  let month = ("0" + (now.getMonth() + 1)).slice(-2);
  return now.getFullYear() + "-" + month + "-" + day;
}

function toMonth() {
  let toDayArr = toDay().split("-");
  return toDayArr[0] + "-" + toDayArr[1];
}

function toYear() {
  let toMonthArr = toMonth().split("-");
  return toMonthArr[0];
}

function generateOptionYear() {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "server/server_sale_min_max_year.php?pass=hsr224");
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      let minMax = JSON.parse(xhr.responseText)[0];
      let minYear = new Date(minMax.min).getFullYear();
      let maxYear = new Date(minMax.max).getFullYear();

      for (let i = minYear; i <= maxYear; i++) {
        let tagOption = document.createElement("option");
        let textOption = document.createTextNode(i);
        tagOption.value = i;
        if (toYear() == i) {
          tagOption.setAttribute("selected", "");
        }
        tagOption.appendChild(textOption);
        saleEachYear.appendChild(tagOption);
      }
    }
  }
}

function getListDataToDayCategoryCarHot(day, callback) {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "server/server_today_category_car.php?pass=hsr224&" + "day=" + day
  );
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      callback(JSON.parse(xhr.responseText));
    }
  }
}

function getListDataToMonthSale(month, callback) {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "server/server_tomonth_sale.php?pass=hsr224&" + "month=" + month
  );
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      callback(JSON.parse(xhr.responseText));
    }
  }
}

function getListDataToYearSale(year, callback) {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "server/server_toyear_sale.php?pass=hsr224&" + "year=" + year
  );
  xhr.onreadystatechange = responseXHR;
  xhr.send(null);

  function responseXHR() {
    if (xhr.readyState == 4) {
      callback(JSON.parse(xhr.responseText));
    }
  }
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
      // console.log(JSON.parse(xhr.responseText));
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

      for (let i = 0; i < list_sale_data.length; i++) {
        generateTableListSale += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${list_sale_data[i].sale_id}</td>
                        <td>${list_sale_data[i].ps_name}</td>
                        <td>${list_sale_data[i].ro_time_start}</td>
                        <td>${list_sale_data[i].pe_name}</td>
                        <td>${list_sale_data[i].seat_name}</td>
                        <td>${list_sale_data[i].b_name} - ${
          list_sale_data[i].b_id
        }</td>
                        <td>${list_sale_data[i].sale_emp_name}</td>
                        <td>${list_sale_data[i].sale_price}</td>
                        <td>${list_sale_data[i].sale_time_sale}</td>
                    </tr>
            `;
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
