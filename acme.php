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
	/* Variables for the average shipping of little stuff and big stuff */
    littleavg = [1];
    bigavg = [5];
	//This function is called whenever you want to verify an order will get there in time
    function request() {
		//get the value from the requested field. (How many days out to order)
        days = document.getElementById("reqd").value;
        let temp = 0;
		//Calculate the average of big and little stuff
        for (let x = 0; x < bigavg.length; x++) {
            temp += +bigavg[x];
        }
        temp = +temp / +bigavg.length;
		//If the days are less than the averages process the order.
        if (days <= temp) {
            alert("Order successful, processing order");
            test();
        }
        else {
            alert("Order not in the average range, can't be fulfilled.");
        }
    }
	//Helper function to update the associated boxes.
    function update(box) {
		//get all the check boxes for each item.
        let items = document.getElementsByName("item");
        if (!items[box].checked) {
            return 0;
        }
		//If the checkbox is checked for the corresponding item, update the value for the passed objects average shipping time.
        let temp = 0;
        if (box === 3) {
            for (let x = 0; x < littleavg.length; x++) {
                temp += +littleavg[x];
            }
            temp = +temp / +littleavg.length;
            document.getElementById("toyeaster").value = Math.floor(temp) + " days";
        }
        if (box === 1) {
            for (let x = 0; x < bigavg.length; x++) {
                temp += +bigavg[x];
            }
            temp = +temp / +bigavg.length;
            document.getElementById("bigeaster").value = Math.floor(temp) + " minutes";
        }
        if (box === 2) {
            for (let x = 0; x < bigavg.length; x++) {
                temp += +bigavg[x];
            }
            temp = +temp / +bigavg.length;
            document.getElementById("smalleaster").value = Math.floor(temp) + " minutes";
        }
    }
	//This function fills the processing window at the bottom.
function test() {
	//It just shows step by step what's happening
    let tbox = document.getElementById("updates");
    tbox.value = "Ordering from warehouses";
	//Initialize placeholder values
    let minutes = 0;
    let days = 0;
    let groupminutes = 0;
    let groupdays = 0;
    let items = document.getElementsByName("item");
    let groups = document.getElementsByName("grouped");
	
	//The following snippets work by -
	//Is the checkbox checked? if it is - call the request (sync vs. async), and push the actual result to the text box.
	//Then update the big order status box at the end
	//Then, update the average time.
    if(items[0].checked === true) {
        document.getElementById("stuffed").value = 0 + " minutes";
        tbox.value += "\n Big Basket ordered from ACME Warehouse";
    }
    if(items[1].checked === true) {
        tbox.value += "\n Ordered from BigStuff";
        let temp = sync("actbig");
        tbox.value += "\n It will arrive in " + temp + " minutes";
        bigavg.push(temp);
        if(groups[1].checked === true) {
            if(+temp > +groupdays) {
                groupminutes= temp;
            }
        }
        document.getElementById("actbig").value = temp + " minutes";
    }

    if(items[2].checked===true) {
        tbox.value += "\n Small Basket Ordered from Big Stuff"
        let temp = sync("actsmall");
        tbox.value += "\n it will arrive in " + temp + " minutes";
        bigavg.push(temp);
        if(groups[2].checked === true) {
            if(+temp > +groupdays) {
                groupminutes = temp;
            }
        }
        document.getElementById("actsmall").value = temp + " minutes";
    }

    if(items[3].checked === true) {
        tbox.value += "\n Ordered Toy Basket from Little Stuff";
        let temp = async("acttoy");
        if (groups[3].checked === true) {
            if (+groupdays < +temp) {
                groupdays = temp;
            }
        }
    }

    document.getElementById("status").value = groupdays + " days " + groupminutes + " minutes ";
}

//Little Stuff responds in days
//Async function to send the request off.
function async(foo) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "./littlestuff.php", true);
    xhr.onload = function (e) {
		//Do the request.
		//See if the status is OK
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
				//If it is, update the text box
				//Then push the value into little stuff & update the grouped value.
                document.getElementById(foo).value = +xhr.responseText + " days";
                if(document.getElementsByName("grouped")[3].checked) {
                    document.getElementById("status").value = +xhr.responseText + " days";
                }
                document.getElementById("updates").value += " it will arrive in " + xhr.responseText + " days";
                littleavg.push(+xhr.responseText);
                return +xhr.responseText;
            }
        }
    };
    xhr.send(null);
}
//Big stuff responds in minutes
//Sync request to send the information off.
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
</form>
    <b>Grouped Order Time: </b><input type="text" id="status" value="">

    <br>
    <b>How many days ahead would you like to request? </b>  <input type="text" id="reqd"> <input type="button"
                                                                                                 value="Request!"
                                                                                                 onclick="request()">
    <b>Order Status</b><br>
    <textarea id="updates" rows="10" cols="180"></textarea>


</HTML>
