
function changeTime() {
    let time_start_h = document.getElementById("time_start_h");
    let time_start_m = document.getElementById("time_start_m");
    
    let bus = document.getElementById("bus");

    let start_h = time_start_h.value
    let start_m = time_start_m.value
    
    var xhr = new XMLHttpRequest ();
    xhr.open ( "POST", "server/server_id_bus_to_form.php");
    xhr.onreadystatechange = responseXHR;
    xhr.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );

    xhr.send (`time_start_h=${start_h}&time_start_m=${start_m}&pass=hsr224`);

    function responseXHR() {
        if ( xhr.readyState == 4 )
        {
            console.log(xhr.responseText);
            let dateTag = JSON.parse(xhr.responseText);
            str = `<select class="form-control" name="bus" id="bus">`;
                                
            str += dateTag.map(n => `<option value="${n.b_id}">${n.b_name} - ${n.b_id}</option>`)             
                                
            str += `</select>`

            console.log(str)

            bus.innerHTML = str;
        }
    }

}

function changeTime2() {
    let time_start_h = document.getElementById("time_start_h2");
    let time_start_m = document.getElementById("time_start_m2");
    let e_ro_id = document.getElementById("e_ro_id").value;
    
    let bus = document.getElementById("bus2");

    let start_h = time_start_h.value
    let start_m = time_start_m.value
    
    var xhr = new XMLHttpRequest ();
    xhr.open ( "POST", "server/server_id_bus_to_form.php");
    xhr.onreadystatechange = responseXHR;
    xhr.setRequestHeader ( "Content-type", "application/x-www-form-urlencoded" );

    xhr.send (`time_start_h=${start_h}&time_start_m=${start_m}&id=${e_ro_id}&pass=hsr224`);

    function responseXHR() {
        if ( xhr.readyState == 4 )
        {
            console.log(xhr.responseText);
            let dateTag = JSON.parse(xhr.responseText);
            str = `<select class="form-control" name="bus" id="bus">`;
                                
            str += dateTag.map(n => `<option value="${n.b_id}">${n.b_name} - ${n.b_id}</option>`)             
                                
            str += `</select>`

            console.log(str)

            bus.innerHTML = str;
        }
    }

}