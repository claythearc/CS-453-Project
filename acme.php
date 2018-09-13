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
        let temp = async("bigeaster");
        if(groups[1].checked === true) {
            if(+temp > +groupdays) {
                groupdays = temp;
            }
        }
//        document.getElementById("bigeaster").value = temp;
    }

    if(items[2].checked===true) {
        let temp = async("smalleaster");
        if(groups[2].checked === true) {
            if(+temp > +groupdays) {
                groupdays = temp;
            }
        }
//        document.getElementById("smalleaster").value = temp;
    }

    if(items[3].checked === true) {
        let temp = sync();
        if(groups[3].checked === true) {
            if(+temp > +groupminutes) {
                if(+groupdays === 0) {
                    groupminutes = temp;
                }
            }
        }
        document.getElementById("toyeaster").value = temp + " minutes";
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

    <input type="checkbox" name="item" value="warehouse"> Stuffed Bunny Rabit Toy <input type="checkbox" name="grouped"/>
    <b> Delivery Time: </b><input type="text" id="stuffed" value="0"><br>

    <input type="checkbox" name="item" value="bigstuff"> Big Easter Basket <input type="checkbox" name="grouped"/>
    <b> Delivery Time: </b><input type="text" id="bigeaster" value="0"><br>

    <input type="checkbox" name="item" value="bigstuff"> Small Easter Basket <input type="checkbox" name="grouped"/>
    <b> Delivery Time: </b><input type="text" id="smalleaster" value="0"><br>

    <input type="checkbox" name="item" value="littlestuff"> Toy Easter Basket <input type="checkbox" name="grouped"/>
    <b> Delivery Time: </b><input type="text" id="toyeaster" value="0"><br>
    <input type="button" value="Submit" onclick="test()">
</form>
    <b>Grouped Order Time: </b><input type="text" id="status" value="">


</HTML>
