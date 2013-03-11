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

function redirect(){
	window.location = '../payment_system';
}

/*Image Processing*/
flag=0;
function imgError(source){
	if(flag==0){ document.getElementById(source).src="../../products/"+source+".png"; flag++;}
	else {showErrorToast(source+" image is not found."); flag=0;};
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

/*script for Bulk Order and Online Payment*/
function myFunction(price,quan,total){
	var discount;
	if(quan > 20 && quan < 50) discount = 0.95;
	if(quan >= 50 && quan < 100) discount = 0.94;
	if(quan >= 100 && quan < 150) discount = 0.93;
	if(quan >= 150 && quan < 200) discount = 0.92;
	if(quan >= 200 && quan < 250) discount = 0.91;
	if(quan >= 250 && quan < 300) discount = 0.90;
	if(quan > 400) discount = 0.85;


	total.value = (parseInt(price)*parseInt(quan)*discount).toFixed(2);
}
function bulkorder(prodlist){
	var hidden = document.getElementById(prodlist).value;
	var tr = document.createElement("tr");
	var counter = document.getElementById("hiddenCounter");
	for(var i=0; i<3; i++){
		var input = document.createElement("input");
		var td = document.createElement("td");
			if(i==0){
				input.name = "bulkProdName[]";
				input.value = prodlist;
				input.type = "text";
				input.readOnly = true;
				td.appendChild(input);
			}
			
			else if(i==1){
				var input2 = document.createElement("input");
				
				input2.value = (20*parseInt(hidden)*0.95).toFixed(2);
				input2.name = "bulkProdAmount[]";
				input2.readOnly = true;
				input.name = "bulkProdQuan[]";
				input.type = "number";
				input.min = input.value = "20";
				input.max = "9999";
				input.onblur = function(){myFunction(hidden,this.value,input2);};
				td.appendChild(input);
			}
			
			else{
				td.appendChild(input2);
			}
			
		tr.appendChild(td);
	}
	document.getElementById("order").appendChild(tr);
	counter.value = parseInt(counter.value)+1;
}
function dateCheck(today){
  expiryDate = document.getElementById('expiryDate').value;
  
  if(expiryDate < today) showErrorToast("Card is already expired");
}
function testCreditCard () {
  myCardNo = document.getElementById('CardNumber').value;
  myCardType = document.getElementById('CardType').value;
  
  if (checkCreditCard (myCardNo,myCardType)) {
   showErrorToast("Credit card has a valid format")
  } 
  else {showErrorToast(ccErrors[ccErrorNo])};
}

var ccErrorNo = 0;
var ccErrors = new Array ()

ccErrors [0] = "Unknown card type";
ccErrors [1] = "No card number provided";
ccErrors [2] = "Credit card number is in invalid format";
ccErrors [3] = "Credit card number is invalid";
ccErrors [4] = "Credit card number has an inappropriate number of digits";
ccErrors [5] = "Warning! This credit card number is associated with a scam attempt";

function checkCreditCard (cardnumber, cardname) {     
  // Array to hold the permitted card characteristics
  var cards = new Array();
  // Define the cards we support. You may add addtional card types as follows.
  //  Name:         As in the selection box of the form - must be same as user's
  //  Length:       List of possible valid lengths of the card number for the card
  //  prefixes:     List of possible prefixes for the card
  //  checkdigit:   Boolean to say whether there is a check digit
  
  cards [0] = {name: "Visa", 
               length: "13,16", 
               prefixes: "4",
               checkdigit: true};
  cards [1] = {name: "MasterCard", 
               length: "16", 
               prefixes: "51,52,53,54,55",
               checkdigit: true};
  cards [2] = {name: "DinersClub", 
               length: "14,16", 
               prefixes: "36,38,54,55",
               checkdigit: true};
  cards [3] = {name: "CarteBlanche", 
               length: "14", 
               prefixes: "300,301,302,303,304,305",
               checkdigit: true};
  cards [4] = {name: "AmEx", 
               length: "15", 
               prefixes: "34,37",
               checkdigit: true};
  cards [5] = {name: "Discover", 
               length: "16", 
               prefixes: "6011,622,64,65",
               checkdigit: true};
  cards [6] = {name: "JCB", 
               length: "16", 
               prefixes: "35",
               checkdigit: true};
  cards [7] = {name: "enRoute", 
               length: "15", 
               prefixes: "2014,2149",
               checkdigit: true};
  cards [8] = {name: "Solo", 
               length: "16,18,19", 
               prefixes: "6334,6767",
               checkdigit: true};
  cards [9] = {name: "Switch", 
               length: "16,18,19", 
               prefixes: "4903,4905,4911,4936,564182,633110,6333,6759",
               checkdigit: true};
  cards [10] = {name: "Maestro", 
               length: "12,13,14,15,16,18,19", 
               prefixes: "5018,5020,5038,6304,6759,6761,6762,6763",
               checkdigit: true};
  cards [11] = {name: "VisaElectron", 
               length: "16", 
               prefixes: "4026,417500,4508,4844,4913,4917",
               checkdigit: true};
  cards [12] = {name: "LaserCard", 
               length: "16,17,18,19", 
               prefixes: "6304,6706,6771,6709",
               checkdigit: true};
               
  // Establish card type
  var cardType = -1;
  for (var i=0; i<cards.length; i++) {

    // See if it is this card (ignoring the case of the string)
    if (cardname.toLowerCase () == cards[i].name.toLowerCase()) {
      cardType = i;
      break;
    }
  }
  
  // If card type not found, report an error
  if (cardType == -1) {
     ccErrorNo = 0;
     return false; 
  }
   
  // Ensure that the user has provided a credit card number
  if (cardnumber.length == 0)  {
     ccErrorNo = 1;
     return false; 
  }
    
  // Now remove any spaces from the credit card number
  cardnumber = cardnumber.replace (/\s/g, "");
  
  // Check that the number is numeric
  var cardNo = cardnumber
  var cardexp = /^[0-9]{13,19}$/;
  if (!cardexp.exec(cardNo))  {
     ccErrorNo = 2;
     return false; 
  }
       
  // Now check the modulus 10 check digit - if required
 if (cards[cardType].checkdigit) {
    var checksum = 0;                                  // running checksum total
	var mychar = "";                                   // next char to process
    var j = 1;                                         // takes value of 1 or 2
  
    // Process each digit one by one starting at the right
    var calc;
    for (i = cardNo.length - 1; i >= 0; i--) {
    
      // Extract the next digit and multiply by 1 or 2 on alternative digits.
      calc = Number(cardNo.charAt(i)) * j;
    
      // If the result is in two digits add 1 to the checksum total
      if (calc > 9) {
        checksum = checksum + 1;
        calc = calc - 10;
      }
    
      // Add the units element to the checksum total
      checksum = checksum + calc;
    
      // Switch the value of j
      if (j ==1) {j = 2} else {j = 1};
    } 
  
    // All done - if checksum is divisible by 10, it is a valid modulus 10.
    // If not, report an error.
    if (checksum % 10 != 0)  {
     ccErrorNo = 3;
     return false; 
    }
  }  
  
  // Check it's not a spam number
  if (cardNo == '5490997771092064') { 
	ccErrorNo = 5;
    return false; 
  }
  // The following are the card-specific checks we undertake.
  var LengthValid = false;
  var PrefixValid = false; 
  var undefined; 

  // We use these for holding the valid lengths and prefixes of a card type
  var prefix = new Array ();
  var lengths = new Array ();
    
  // Load an array with the valid prefixes for this card
  prefix = cards[cardType].prefixes.split(",");
      
  // Now see if any of them match what we have in the card number
  for (i=0; i<prefix.length; i++) {
    var exp = new RegExp ("^" + prefix[i]);
    if (exp.test (cardNo)) PrefixValid = true;
  }
      
  // If it isn't a valid prefix there's no point at looking at the length
  if (!PrefixValid) {
     ccErrorNo = 3;
     return false; 
  }
    
  // See if the length is valid for this card
  lengths = cards[cardType].length.split(",");
  for (j=0; j<lengths.length; j++) {
    if (cardNo.length == lengths[j]) LengthValid = true;
  }
  
  // See if all is OK by seeing if the length was valid. We only check the length if all else was 
  // hunky dory.
  if (!LengthValid) {
     ccErrorNo = 4;
     return false; 
  };   
  
  // The credit card is in the required format.
  return true;
}
/*End of Bulk Order and Online Payment*/