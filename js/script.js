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

/*Image Processing*/
flag=0;
function imgError(source){
	if(flag==0){ document.getElementById(source).src="../../products/"+source+".png"; flag++;}
	else {showErrorToast(source+" image is not found."); flag=0;}
}
function empImgError(source){
	if(flag==0){ document.getElementById(source).src="../../employees/"+source+".png"; flag++;}
	else {showErrorToast(source+" image is not found."); flag=0;}
}
/*End of Image Processing*/

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

/*script for Add Employee*/
function empNoValidate(id){
	var regexp = /^\d{6}$/;
	input=document.getElementById(id).value;
	if(!regexp.test(input)) showNoticeToast("Input should be 6 numerical digits.");
}
function ValidateAddEmployee(){
	var regexp = /^\d{6}$/;
	var form=document.addEmployee;
	alertmess="";
	
	if (form.empno.value==""||form.empno.value==null||(!regexp.test(form.empno.value))) alertmess+="Please enter a valid employee number.<br>";
	if (form.ename.value==""||form.ename.value==null) alertmess+="Please enter name of employee.<br>";
	if (form.eaddress.value==""||form.eaddress.value==null) alertmess+="Please enter address of employee.<br>";
	if (form.hiredate.value==""||form.hiredate.value==null) alertmess+="Please enter hire date of employee.<br>";
	if (!form.esex[0].checked && !form.esex[1].checked) alertmess+="Please select sex.";
	
	if (alertmess==""){}
	else{
		showWarningToast(alertmess);
		return false;
	}
}
/*End of Add Employee*/

/*script for Sign Up*/
function pwordMatch(){
	var form=document.signup;
	if (form.newpwd.value!=form.newpwd2.value) showErrorToast("Passwords do not match.");
	else showSuccessToast("Passwords match.");
}
function ValidateSignup(){
	var regexp = /^\d{6}$/;
	var regexp1 = /^[A-z ]+$/;
	var form=document.signup;
	alertmess="";

	if (form.role[0].checked==false&&form.role[1].checked==false) alertmess+="Please choose role.";
	else{
		if ((form.fname.value==""||form.fname.value==null||(!regexp1.test(form.fname.value)))&&form.role[1].checked==true) alertmess+="Please enter a valid first name.<br>";
		if ((form.lname.value==""||form.lname.value==null||(!regexp1.test(form.lname.value)))&&form.role[1].checked==true) alertmess+="Please enter a valid last name.<br>";
		if (form.uname.value==""||form.uname.value==null) alertmess+="Please enter username.<br>";
		if (form.newpwd.value.length<6) alertmess+="Please enter valid password (at least 6 chars).<br>";
		if ((form.empno.value==""||form.empno.value==null||(!regexp.test(form.empno.value)))&& form.role[0].checked==true) alertmess+="Please enter valid employee number.<br>";
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
		form.fname.value='';
		form.lname.value='';
		form.empno.disabled=false;
		document.getElementById('fname').disabled=true;
		document.getElementById('lname').disabled=true;
		document.getElementById('fnameHidden').disabled=false;
		document.getElementById('lnameHidden').disabled=false;
	}
	if (form.role[1].checked == true){
		form.empno.value='';
		form.empno.disabled=true;
		document.getElementById('fname').disabled=false;
		document.getElementById('lname').disabled=false;
		document.getElementById('fnameHidden').disabled=true;
		document.getElementById('lnameHidden').disabled=true;
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

/*script for Comment*/
function ValidateAddComment(){
	var form=document.addComment;
	alertmess="";
	
	if (form.comment_name.value==""||form.comment_name.value==null) alertmess+="Please enter name<br>";
	if (form.comment_text.value==""||form.comment_text.value==null) alertmess+="Please put in some comment";
	if (alertmess==""){}
	else{
		showWarningToast(alertmess);
		return false;
	}
}
/*End of Comment*/

/*script for Adding Item in Cashier System*/
var checkout=0;
function addProd(prodId,prodName,quantity,prodPrice){
	if(quantity.value == 0) showErrorToast("Cannot add 0 "+prodName);
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
			checkout++;
		}
	}
}
function ValidateCheckout(){
	if (checkout!=0) return true;
	else{
		showWarningToast('Must add a product to checkout.');
		return false;
	}
}
/*End of Cashier System*/