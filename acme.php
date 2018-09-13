<?php
/**
 * Created by PhpStorm.
 * User: Clay Turner
 * Date: 9/13/2018
 * Time: 3:11 AM
 */



?>


<HTML>

<script>
    littleavg = [1];
    bigavg = [5];
    function request() {
        days = document.getElementById("reqd").value;
        let temp = 0;
        for (let x = 0; x < bigavg.length; x++) {
            temp += +bigavg[x];
        }
        temp = +temp / +bigavg.length;
        if (days <= temp) {
            alert("Order successful, processing order")
        }
        else {
            alert("Order not in the average range, can't be fulfilled.")
        }
    }
    function update(box) {
        let items = document.getElementsByName("item");
        let temp = 0;
        if (box === 3) {
            for (let x = 0; x < littleavg.length; x++) {
                temp += +littleavg[x];
            }
            temp = +temp / +littleavg.length;
            document.getElementById("toyeaster").value = temp + " days";
        }
        if (box === 1) {
            for (let x = 0; x < bigavg.length; x++) {
                temp += +bigavg[x];
            }
            temp = +temp / +bigavg.length;
            document.getElementById("bigeaster").value = temp + " minutes";
        }
        if (box === 2) {
            for (let x = 0; x < bigavg.length; x++) {
                temp += +bigavg[x];
            }
            temp = +temp / +bigavg.length;
            document.getElementById("smalleaster").value = temp + " minutes";
        }
    }
function test() {
    let minutes = 0;
    let days = 0;
    let groupminutes = 0;
    let groupdays = 0;
    let items = document.getElementsByName("item");
    let groups = document.getElementsByName("grouped");
    if(items[0].checked === true) {
        document.getElementById("stuffed").value = 0 + " minutes";
    }
    if(items[1].checked === true) {
        let temp = sync("actbig");
        bigavg.push(temp);
        if(groups[1].checked === true) {
            if(+temp > +groupdays) {
                groupminutes= temp;
            }
        }
        document.getElementById("actbig").value = temp + " minutes";
    }

    if(items[2].checked===true) {
        let temp = sync("actsmall");
        bigavg.push(temp);
        if(groups[2].checked === true) {
            if(+temp > +groupdays) {
                groupminutes = temp;
            }
        }
        document.getElementById("actsmall").value = temp + " minutes";
    }

    if(items[3].checked === true) {
        let temp = async("acttoy");
        littleavg.push(temp);
        if (groups[3].checked === true) {
            if (+groupdays < +temp) {
                groupdays = temp;
            }
        }
    }

    document.getElementById("status").value = groupdays + " days " + groupminutes + " minutes ";
}

//Little Stuff responds in days
function async(foo) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "./littlestuff.php", true);
    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById(foo).value = +xhr.responseText + " days";
                document.getElementById("status").value = +xhr.responseText + " days";
                return +xhr.responseText;
            }
        }
    };
    xhr.send(null);
}
//Big stuff responds in minutes
function sync() {
    var request = new XMLHttpRequest();
    request.open('GET', './bigstuff.php', false);  // `false` makes the request synchronous
    request.send(null);
    if (request.status === 200) {
        return +request.responseText;
    }
}

</script>
<table>
    <th>Ordered?</th>
    <th>Item to Order:</th>
    <th>Grouped Together</th>
</table>
<form>

    <input type="checkbox" name="item" value="warehouse" onclick="update(0)"> Stuffed Bunny Rabit Toy <input type="checkbox" name="grouped"/>
    <b> Est Delivery Time: </b><input type="text" id="stuffed" value="0">
    <b> Actual Delivery Time: </b><input type="text" id="actstuffed" value="0">
    <br>

    <input type="checkbox" name="item" value="bigstuff" onclick="update(1)"> Big Easter Basket <input type="checkbox" name="grouped"/>
    <b> Est Delivery Time: </b><input type="text" id="bigeaster" value="0">
    <b> Actual Delivery Time: </b><input type="text" id="actbig" value="0">
    <br>

    <input type="checkbox" name="item" value="bigstuff" onclick="update(2)"> Small Easter Basket <input type="checkbox" name="grouped"/>
    <b> Est Delivery Time: </b><input type="text" id="smalleaster" value="0">
    <b> Actual Delivery Time: </b><input type="text" id="actsmall" value="0">
    <br>

    <input type="checkbox" name="item" value="littlestuff" onclick="update(3)"> Toy Easter Basket <input type="checkbox" name="grouped"/>
    <b> Est Delivery Time: </b><input type="text" id="toyeaster" value="0">
    <b> Actual Delivery Time: </b><input type="text" id="acttoy" value="0">
    <br>
    <input type="button" value="Submit" onclick="test()">
</form>
    <b>Grouped Order Time: </b><input type="text" id="status" value="">

    <br>
    <b>How many days ahead would you like to request? </b>  <input type="text" id="reqd"> <input type="button"
                                                                                                 value="Request!"
                                                                                                 onclick="request()">


</HTML>
