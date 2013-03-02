function isNumber(id){
	var regexp = /^[0-9]+$/;
	input=document.getElementById(id).value;
	if(!regexp.test(input)) showNoticeToast("Input should be numeric.");
}

function isLetter(id){
	var regexp = /^[A-z ]+$/;
	input=document.getElementById(id).value;
	if(!regexp.test(input)) showNoticeToast("Input should be in alphabet.");
}

function setPostValue(id){
	document.getElementById("postID").value = id;
	alert(document.getElementById("postID").value);
	return true;
}

flag=0;
function imgError(source){
	if(flag==0){ document.getElementById(source).src="../../products/"+source+".png"; flag++;}
	else {showErrorToast(source+" image is not found."); flag=0;}
}

/*Toast Messages*/
function showSuccessToast(message) {
    $().toastmessage('showSuccessToast', message);
}
function showNoticeToast(message) {
	$().toastmessage('showNoticeToast', message);
}
function showWarningToast(message) {
	$().toastmessage('showWarningToast', message);
}
function showErrorToast(message) {
	$().toastmessage('showErrorToast', message);
}
/*End of Toast*/

/*script for Add Product*/
function ValidateAddProduct(){
	var regexp = /^[0-9]+$/;
	var form=document.addProduct;
	alertmess="";

	if (form.id.value==""||form.id.value==null||(!regexp.test(form.id.value))) alertmess+="Please enter a valid product ID.<br>";
	if (form.name.value==""||form.name.value==null) alertmess+="Please enter name of product.<br>";
	if (form.price.value==""||form.price.value==null||(!regexp.test(form.price.value))) alertmess+="Please enter a valid product price.<br>";
	if (form.desc.value==""||form.desc.value==null) alertmess+="Please enter product description.<br>";

	if (alertmess==""){}
	else{
		showWarningToast(alertmess);
		return false;
	}
}
/*End of Add Product*/

/*script for Sign Up*/
function pwordMatch(){
	var form=document.signup;
	if (form.newpwd.value!=form.newpwd2.value) showErrorToast("Passwords do not match.");
	else showSuccessToast("Passwords match.");
}
function ValidateSignup(){
	var regexp = /^[0-9]+$/;
	var regexp1 = /^[A-z ]+$/;
	var form=document.signup;
	alertmess="";

	if (form.role[0].checked==false&&form.role[1].checked==false) alertmess+="Please choose role.";
	else{
		if (form.fname.value==""||form.fname.value==null||(!regexp1.test(form.id.value))) alertmess+="Please enter a valid first name.<br>";
		if (form.lname.value==""||form.lname.value==null||(!regexp1.test(form.id.value))) alertmess+="Please enter a valid last name.<br>";
		if (form.uname.value==""||form.uname.value==null) alertmess+="Please enter username.<br>";
		if (form.newpwd.value.length<6) alertmess+="Please enter valid password (at least 6 chars).<br>";
		if ((form.empno.value==""||form.empno.value==null||(!regexp.test(form.id.value)))&& form.role[0].checked==true) alertmess+="Please enter valid employee number.<br>";
		if ((form.address.value==""||form.address.value==null)&& form.role[0].checked==true) alertmess+="Please enter address.<br>";
		if (form.sex.selectedIndex==0 && form.role[0].checked==true) alertmess+="Please choose sex.<br>";
		if((form.month.selectedIndex==0||form.day.selectedIndex==0||form.year.selectedIndex==0)&& form.role[0].checked==true) alertmess+="Please enter hire date.<br>";
	}	

	if (alertmess==""){}
	else{
		showWarningToast(alertmess);
		return false;
	}
}
function Disable(){
	var form=document.signup;
	if (form.role[0].checked == true){
		form.empno.disabled=false;
		form.address.disabled=false;
		form.sex.disabled=false;
		form.month.disabled=false;
		form.day.disabled=false;
		form.year.disabled=false;
	}
	if (form.role[1].checked == true){
		form.empno.value='';
		form.empno.disabled=true;
		form.address.value='';
		form.address.disabled=true;
		form.sex.selectedIndex=0;
		form.sex.disabled=true;
		form.month.selectedIndex=0;
		form.month.disabled=true;
		form.day.selectedIndex=0;
		form.day.disabled=true;
		form.year.selectedIndex=0;
		form.year.disabled=true;
	}
}
/*End of Sign Up*/

/*script for Login*/
function ValidateLogin(){
	var form=document.login;
	alertmess="";
	
	if (form.uname.value==""||form.uname.value==null) alertmess+="Please enter username<br>";
	if (form.pword.value==""||form.pword.value==null)alertmess+="Please enter password";
	if (alertmess==""){}
	else{
		showWarningToast(alertmess);
		return false;
	}
}
/*End of Login*/

function addProd(prodId,prodName,quantity,prodPrice){
		
		if(quantity.value == 0) alert("Cannot add 0 "+prodName);
		else{
			var a = confirm("Add "+quantity.value+" piece(s) of "+prodName+"?");
			if(a == true){
				var tr = document.createElement("tr");
				
				for(var i=0; i<5; i++){
					var input = document.createElement("input");
					var td = document.createElement("td");
					
					input.type = "text";
					input.className = "center";
					input.readOnly = true;
					
					if(i==0){
						input.type = "hidden";
						input.name = "prodPrice[]";
						input.value = prodPrice;
						document.getElementById("cashierForm").appendChild(input);
					}
					
					else{
					
						if(i==1){
							input.name = "prodId[]";
							input.value = prodId;
							td.appendChild(input);
						}
						
						else if(i==2){
							input.name = "prodName[]";
							input.className = "centerBorder0";
							input.value = prodName;
							td.appendChild(input);
						}
						
						else if(i==3){
							input.name = "quantity[]";
							input.value = quantity.value;
							quantity.max = parseInt(quantity.max)-parseInt(quantity.value);
							td.appendChild(input);
						}
						
						else if(i==4){
							input.value = parseInt(prodPrice)*parseInt(quantity.value);
							document.getElementById("totalPayment").value = parseInt(document.getElementById("totalPayment").value)+parseInt(input.value);
							td.appendChild(input);
						}
					
						tr.appendChild(td);
					}
				}
				
				document.getElementById("toBuy").appendChild(tr);
			}
		}
}

/*script for drawing charts of Income Graphs*/
function initiateGoogle(){
	google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
}
function drawChart() {
	var data = google.visualization.arrayToDataTable([
		['Month', 'Sales'],
		['November',  1000],
		['December',  1170],
		['January',  660],
		['February',  1030]
	]) 	;

	var options = {
		title: 'Company Performance'
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}
/*End of Income Graphs*/