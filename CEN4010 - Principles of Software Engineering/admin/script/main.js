/*/errorType = int 0 => fail, 1 => success
function errorMSG(errorString, errorType){
	console.log(errorString);
	$(".mask").css({"display":"block"});
	$( "#errorMSG" ).html( errorString );
}*/

function loading(msg){
	$(".loadingMask").css({"display":"block"});
	$( "#lMSG" ).html( msg );
}

function endLoading(){
	$(".loadingMask").css({"display":"none"});
}

//Filters the drivers list according to if the driver is active.
$(document).ready(function() {
        
    //
    // Search Function
    //
    $("#search").keyup(function() {
        var searchT = $("#search").val();
        var type = $("#type").val();
        var where = $("#searchIN").val();
        $.ajax({
            method: "POST",
            url: "search.php",
            data: { searchFor: searchT , where: where}
        }).done(function( page ) {
            $("#displayData").html(page);
        });
    });
    
    //
    //Close Error Message
    //
    $("#closeError").click(function(e){
        
        if (window.location.pathname == '/admin/index.php'){
            $(".tabWrapper").css('padding-bottom', '85px');
        }else{
            $(".tabWrapper").css('padding-bottom', '130px');
        }
        
        
        $("#errorWrapper").fadeOut();
        return false;
    });
        
    //
    //Filters the list to show only the active elements.
    //
    $("#showInactiveDriver").click(function() {
        if ($("#showInactiveDriver").is(":checked")){
            $('#driverTable > tbody > tr').each(function() {
                $(this).removeClass( "hidden" );
            });  
        }else{
            $('#driverTable > tbody > tr').each(function() {
                if ( $(this).data('status') == "Retired"){
                    $(this).addClass( "hidden" );
                }
            });
        }
    });
    
	//
    //Filters the list to show only the active clients.
    //
    $("#showInactiveClients").click(function() {
        if ($("#showInactiveClients").is(":checked")){
            $('#clientTable > tbody > tr').each(function() {
                $(this).removeClass( "hidden" );
            });  
        }else{
            $('#clientTable > tbody > tr').each(function() {
                if ( $(this).data('status') == "Inactive"){
                    $(this).addClass( "hidden" );
                }
            });
        }
    });
    
	//
	// Dispays a refresh timer so the user knows how old the data is.
	//
	var refreshTimer = window.setInterval(updateRefreshTimer, 1000);
	
    //
    // Runs every 30 seconds to check for and display emergencies.
    //
    checkEmergencies(); //Run as soon as page loads then timer
    var emergencyTimer = window.setInterval(checkEmergencies, 30000);
    
    
}); //End Document ready.

//
// Runs every 30 seconds to check for and display emergencies.
//
var lastDate = 0;
function checkEmergencies(){
    if (window.location.pathname != '/admin/reports.php'){
        
        var unixTimestamp = lastDate;
        lastDate = Date.now();
        
        $.ajax({
            method: "POST",
            url: "getEmergencies.php",
            data: {
                    action:"getNewEmergencies",
                    date: unixTimestamp
                  }
        }).done(function( returnData ) {

            /*var data = JSON.parse(returnData);

            var lat;
            var lng;
            var dName;
            var location;


            //Add markers for each client
            for(var idx in data){
                lat = parseFloat(data[idx].cLat);
                lng = parseFloat(data[idx].cLng);
                dName = data[idx].dLastName + ", " + data[idx].dFirstName;
                location = {lat: lat, lng: lng};

                errorMSG(dName, 0);
            }*/
            console.log(returnData);
            //return;
            if (returnData > 0){
            	var msg = "<h2>ALERT: You have recieved " + returnData + " new emergency request(s)!</h2><br><a href='reports.php' class='button btn btn-danger'>View Emergency List</a>";
            	errorMSG(msg, 0);
            }

        });

    }
}

//
// This function is called every second to update the refresh counter.
//
var counter = 0;
function updateRefreshTimer(){
	counter++;
	if(counter < 120){
		document.getElementById("dataRefresh").innerHTML = "Data is " + counter + "s old.";
	}else{
		document.getElementById("dataRefresh").innerHTML = "Data is " + counter + "s old. <a href='" + window.location.href +"' class='button btn btn-danger'>Refresh Now</a>";
	}
}

//
//This function will be called when the user clicks on the acknowledge button of the emergency table.
//
var lockbutton = 0;
$(document).on('click','.eTableButton',function(){
    var eid = $(this).data('eid');
    if( lockbutton == 1){
        return;
    }
    lockbutton = 1;

    $.ajax({
        method: "POST",
        url: "reportsHelper.php",
        data: {
            action: "resolveEmergency",
            eID: eid
        }
    }).done(function(returnData) {
        
        if(returnData == 1){
            location.reload();
        }else{
            errorMSG(returnData,0);
            //errorMSG("There was a problem acknowledging this message...  Please try again.", 0);
        }
    });
});



/*
#########################################
############ ADMIN FUNCTIONS ############
#########################################
//
//  ERROR HANDLING
//  errorType = int 0 => fail, 1 => success
//*/
function errorMSG(errorString, errorType){
	console.log(errorString);
	//$(".mask").css({"display":"block"});
	//$( "#errorMSG" ).html( errorString );
    
    //Im using this with bootstrap alerts till you work out what you are doing with that ugly popup :P
    $( "#errorWrapper" ).fadeOut(function(){
        $( "#errorMSG" ).html( errorString );
        
        if (window.location.pathname == '/admin/index.php'){
            var height = $("#errorWrapper").height() + 100;
            $(".tabWrapper").css('padding-bottom', height);
        }else{
            var height = $("#errorWrapper").height() + 150;
            $(".tabWrapper").css('padding-bottom', height);
        }

        
        $( "#errorWrapper" ).removeClass("alert-success alert-danger");
        if(errorType == 0){
            $( "#errorWrapper" ).addClass("alert-danger").fadeIn();
        }else{
            $( "#errorWrapper" ).addClass("alert-success").fadeIn();
        }
    });
}

//
// Get client edit Form
//
function editClient(cID){
	if($("#showEdit"+cID).is(':visible')){
		$("#showEditDiv"+cID).animate({height:"0px"},400,function(){
			$("#showEdit"+cID).css({"display":"none"});
		});
	} else {
		$("#showEdit"+cID).css({"display":"block"});
		$("#showEditDiv"+cID).animate({height:"600px"},400);
	}
	
	
	/*$.ajax({
			method: "POST",
			url: "clientHelper.php",
			data: { action:"clientEdit",cID: cID }
		}).done(function( page ) {
			$(".popUp").html(page);
		});*/
}

// Get driver edit Form
function editDriver(cID){
	$(".mask").css({"display":"block"});
	
	$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"driverEdit",cID: cID }
		}).done(function( page ) {
			$(".popUp").html(page);
        alert(page);
		});
}

/*Submit Client Edit*/
$(document).on('click','#editClient',function(){
	var cID = $("#cID").val();
	var fName = $("#fName").val();
	var lName = $("#lName").val();
	var email = $("#email").val();
	var phone = $("#phone").val();
	var addr1 = $("#addr1").val();
	var addr2 = $("#addr2").val();
	var city = $("#city").val();
	var state = $("#state").val();
	var zip = $("#zip").val();
	var delNotes = $("#delNotes").val();
	//var FA = $("#FA").is(':checked');
	//var FR = $("#FR").is(':checked');
    var FAList = $("#FAList").val();
	var FRList = $("#FRList").val();
	var Active = $("#isActive").is(':checked');

    //Set the alergies checkbox data if an alergy is typed into the box.
    if(FAList == ""){
        FA = false;   
    }else{
        FA = true;
    }
    //Set the food restrictions checkbox data if a restriction is typed into the box.
    if(FAList == ""){
        FR = false;   
    }else{
        FR = true;
    }
    
	var MSG = "";
	console.log("Edit - "+ fName);
	if(textValidate(fName) && textValidate(lName) && phoneValidate(phone) && /*emailValidate(email) &&*/ textValidate(addr1) && textValidate(city) && textValidate(state) && textValidate(zip)){
		
		$.ajax({
			method: "POST",
			url: "clientHelper.php",
			data: { action:"submitClientEdit",cID: cID, fName: fName, lName: lName, email: email, phone: phone, addr1: addr1, addr2: addr2, city:  city, state: state, zip: zip, delNotes: delNotes, FA: FA, FR: FR, FAList: FAList, FRList: FRList, Active:Active }
		}).done(function( page ) {
			//$("showEditDiv"+cID).html("Client Info has been updated"+page);
			errorMSG(page, 1);
		});
		
		
	} else {
		MSG += "Please Fill in all required fields.</br>";
		if(!emailValidate(email)){
			MSG += "Please Enter a Valid Email.</br>";
		}
		if(!phoneValidate(phone)){
			MSG += "Please Enter a Valid Phone Number.</br>";
		}

		errorMSG(MSG, 0);
	} 
	
});

/*Submit New Client*/
$(document).on('click','#addClient',function(){
	var cID = $("#cID").val();
	var fName = $("#fName").val();
	var lName = $("#lName").val();
	var email = $("#email").val();
	var phone = $("#phone").val();
	var addr1 = $("#addr1").val();
	var addr2 = $("#addr2").val();
	var city = $("#city").val();
	var state = $("#state").val();
	var zip = $("#zip").val();
	var delNotes = $("#delNotes").val();
	//var FA = $("#FA").is(':checked');
	//var FR = $("#FR").is(':checked');
    var FAList = $("#FAList").val();
	var FRList = $("#FRList").val();
	var Active = 1;
	var MSG = "";
	console.log("Makes it to validate");
	if(textValidate(fName) && textValidate(lName) && phoneValidate(phone) && emailValidate(email) && textValidate(addr1) && textValidate(city) && textValidate(state) && textValidate(zip)){
		console.log("validation passes");
		$.ajax({
			method: "POST",
			url: "clientHelper.php",
			data: { action:"submitNewClient",cID: cID, fName: fName, lName: lName, email: email, phone: phone, addr1: addr1, addr2: addr2, city:  city, state: state, zip: zip, delNotes: delNotes, FAList: FAList, FRList: FRList, Active:Active }
		}).done(function( page ) {
			errorMSG(page, 1);
            $('#editClientForm')[0].reset();
		});
		
	} else {
		MSG += "Please Fill in all required fields.</br>";
		if(!emailValidate(email)){
			MSG += "Please Enter a Valid Email.</br>";
		}
		if(!phoneValidate(phone)){
			MSG += "Please Enter a Valid Phone Number.</br>";
		}
		
		errorMSG(MSG, 0);
	} 
	
});

/*Delete Client*/
function actionClient(cID, step){
	$(".mask").css({"display":"block"});
	
	if(step == 1){
		
		$.ajax({
				method: "POST",
				url: "clientHelper.php",
				data: { action:"clientDeleteConfirm",cID: cID }
			}).done(function( page ) {
				$(".popUp").html(page);
			});
			
	} else if(step == 0){
		$(".mask").css({"display":"none"});
	} else {
			
		$.ajax({
				method: "POST",
				url: "clientHelper.php",
				data: { action:"clientDelete",cID: cID }
			}).done(function( page ) {
				$(".popUp").html(page);
			});
	}
}

/*Submit New Drivers*/
$('#insertDriver').click(function(){
	console.log("Submit New Drivers");
	
	//var str = $("#editDriverForm").serialize();
	var cID = $("#cID").val();
	var fName = $("#fName").val();
	var lName = $("#lName").val();
	var email = $("#email").val();
	var phone = $("#phone").val();
	var license = $("#dLicense").val();
	var make = $("#vehMake").val();
	var model = $("#vehModel").val();
	var year = $("#vehYear").val();
	var tag = $("#vehTag").val();
	var insurance = $("#insCo").val();
	var policyNumber = $("#insPolicy").val();
	var delNotes = $("#delNotes").val();
	var delArea = $("#delArea").val();
	var Active = 1;
	var MSG = "";

	var schedule = [];
	 $.each($("input[name='schedule']:checked"), function(){            
                schedule.push($(this).val());
            });
		//console.log("add to array " + schedule);
	
	if(textValidate(fName) && textValidate(lName) && phoneValidate(phone) && emailValidate(email) && textValidate(schedule)){
		
		$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"submitNewDriver",
					cID: cID, 
					fName: fName, 
					lName: lName, 
					email: email, 
					phone: phone, 
					license: license, 
					make: make, 
					model:  model, 
					year: year, 
					tag: tag,
					insurance: insurance, 
					policyNumber: policyNumber, 
					delNotes: delNotes,
					schedule: schedule,
					Active:Active,
					delArea: delArea}
		}).done(function( page ) {
			errorMSG(page, 0);
			$("#editDriverForm").find("input[type=text], input[type=email], textarea").val("").removeAttr('checked');
			$("#editDriverForm").find("input[name='schedule']").removeAttr("checked");
			
			
		});
		
	} else {
		MSG += "Please Fill in all required (*) fields.</br>";
		errorMSG(MSG, 0);
	}
	
});

/*Submit Driver Edit*/
$(document).on('click','#editDriver',function(){
	var dID = $("#dID").val();
	var fName = $("#fName").val();
	var lName = $("#lName").val();
	var email = $("#email").val();
	var phone = $("#phone").val();
	var license = $("#dLicense").val();
	var make = $("#vehMake").val();
	var model = $("#vehModel").val();
	var year = $("#vehYear").val();
	var tag = $("#vehTag").val();
	var insurance = $("#insCo").val();
	var policyNumber = $("#insPolicy").val();
	var delNotes = $("#delNotes").val();
	var delArea = $("#delArea").val();
	//console.log(delArea);
	var schedule = [];
	 $.each($("input[name='schedule']:checked"), function(){            
                schedule.push($(this).val());
            });
	var MSG = "";

	
	if(textValidate(fName) && textValidate(lName) && phoneValidate(phone) && emailValidate(email)){
		
		$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"submitDriverEdit",
					dID: dID, 
					fName: fName, 
					lName: lName, 
					email: email, 
					phone: phone, 
					license: license, 
					make: make, 
					model:  model, 
					year: year, 
					tag: tag,
					insurance: insurance, 
					policyNumber: policyNumber,
					schedule: schedule,
					delNotes: delNotes,
					delArea: delArea}
		}).done(function( page ) {
			errorMSG(page, 0);
		});
		
		
	} else {
		MSG += "Please Fill in all required fields.</br>";
		if(!emailValidate(email)){
			MSG += "Please Enter a Valid Email.</br>";
		}
		if(!phoneValidate(phone)){
			MSG += "Please Enter a Valid Phone Number.</br>";
		}
		
		errorMSG(MSG, 0);
	} 

});

/*Submit New Administrator Form*/
$(document).on('click','#addAdminButton',function(){
	var sID = $("#sID").val();
	var fName = $("#fName").val();
	var lName = $("#lName").val();
	var email = $("#email").val();
	var pwd = $("#pwd").val();
	var secQuestion = $("#securityQuestion").val();
	var secAnswer = $("#securityAnswer").val();
    var active = $("#activeCheck").is(':checked');
	var sa = $("#superAdminCheck").is(':checked');
	var MSG = "";
	    
	if(textValidate(fName) && textValidate(lName)){
		
		$.ajax({
			method: "POST",
			url: "accountHelper.php",
			data: { action:"submitAdmin",
					sID: sID, 
					fName: fName, 
					lName: lName, 
					email: email, 
					pwd: pwd, 
					secQuestion: secQuestion, 
					secAnswer: secAnswer,
                    type: sa,
                    active: active
                  }
		}).done(function( page ) {
            //If the PHP page returns an error without redirect, display it.
            errorMSG(page, 0);
		});
		
	} else {
		MSG += "Please Fill in all required fields.</br>";
		if(!emailValidate(email)){
			MSG += "Please Enter a Valid Email.</br>";
		}
        
		errorMSG(MSG, 0);
	} 

});

function changePassword(dID){
	$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"driverNewpass", dID: dID }
		}).done(function( page ) {
			errorMSG(page, 0);
		});
}

function unlockDriver(dID){
	$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"unlockDriver", dID: dID }
		}).done(function( page ) {
			errorMSG(page, 0);
		});
}

function retireDriver(dID, step){
	$.ajax({
			method: "POST",
			url: "driverHelper.php",
			data: { action:"retireDriver", dID: dID, step:step }
		}).done(function( page ) {
			errorMSG(page, 0);
		});
}

// Login Forms
$("#driverLog").click(function(){
	$( ".admin_L" ).addClass( "disable" );
	$( ".driver_L" ).removeClass( "disable" );
});

$("#adminLog").click(function(){
	$( ".admin_L" ).removeClass( "disable" );
	$( ".driver_L" ).addClass( "disable" );
});

/*Close POPUP*/
$(".popClose").click(function(){
	$(".mask").css({"display":"none"});
});


/*
##########################################
########## VALIDATION FUNCTIONS ##########
##########################################
*/

/*Validate Text*/
function textValidate(text){
	 if (text.length == 0) {
		return false;
	} else {
		return true;
	}
}
/*Validate Email*/
function emailValidate(email){
	var error="";
    var tfld = trim(email);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    
    if (email == "") {
		return false;
    } else if (!emailFilter.test(tfld)) {
		return false;
    } else if (email.match(illegalChars)) {
		return false;
    } else {
        return true;
    }
}
/*Validate Phone Number*/
function phoneValidate(phone){
	
	var stripped = phone.replace(/[\(\)\.\-\ ]/g, '');     
   if (phone == "") {
		return false;
    } else if (isNaN(parseInt(stripped))) {
		return false;
    } else if (!(stripped.length == 10)) {
		return false;
    } else{
		return true;
	}
	
}
/*Highlight required*/
function highlightRequired(idName){
	$("#"+idName).css({"border":"1px solid red"});
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
} 


/*
################################################
############# DELIVERIES FUNCTIONS #############
################################################
*/

var stopCounter = 0;
var dateControl = "today";

$("#delYesterday").click(function(){
	deliveryDay('yesterday');
	dateControl = "yesterday";
	stopCounter = 1;
});

$("#delToday").click(function(){
	deliveryDay('today');
	dateControl = "today";
	stopCounter = 0;
});


$("#delTomorrow").click(function(){
	deliveryDay('tomorrow');
	dateControl = "tomorrow";
	stopCounter = 1;
});

function deliveryDay(showDay){
	console.log(showDay);
	$.ajax({
			method: "POST",
			url: "deliveriesHelper.php",
			data: { action:"changeDate", showDay:showDay}
		}).done(function( page ) {
			$("#displayData").html(page);
		});
}

function deliveryRefresh(){
	if(stopCounter == 0){
		deliveryDay('today')
		console.log("Reloaded");
	}
}



$("#genCopy").click(function(){
	console.log("init Load");
	loading("This may take a few minutes.</br>Please don't reload the page!");
	$.ajax({
			method: "POST",
			url: "deliveriesHelper.php",
			data: { action:"genCopy"}
		}).done(function( page ) {
			endLoading();
			errorMSG(page, 1);
		});
});

$("#genNew").click(function(){
	console.log("init Load");
	loading("This may take a few minutes.</br>Please don't reload the page!");
	$.ajax({
			method: "POST",
			url: "deliveriesHelper.php",
			data: { action:"genNew"}
		}).done(function( page ) {
			endLoading();
			errorMSG(page, 1);
		});
});


$("#genToday").click(function(){
	console.log("init Load");
	loading("This may take a few minutes.</br>Please don't reload the page!");
	
	var val = [];
        $('.driver_checkbox:checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	
	$.ajax({
			method: "POST",
			url: "deliveriesHelper.php",
			data: { action:"genToday", driverArray: val}
		}).done(function( page ) {
			endLoading();
			errorMSG(page, 1);
		});
});

function changeDriver(rID, dID){

	console.log("rID "+ rID +" dID "+dID);

	$.ajax({
			method: "POST",
			url: "deliveriesHelper.php",
			data: { action:"changeDriver",rID:rID,dID:dID}
		}).done(function( page ) {
			errorMSG(page, 1);
			deliveryDay(dateControl);
		});
}



    