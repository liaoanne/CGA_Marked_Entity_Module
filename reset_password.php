<?php
include "./includes/config.php";
?>
 

<html>
<head>
<title>Reset Password Interface</title>
</head>
<body bgcolor=#faf0e6>
<br><br>
<center><img src="pics/crsmgr.jpg" border=0>
<script language="JavaScript">
/*
Defines functions for general use
*/
var ADD_OP="add";
var UPDATE_OP="update";
var DELETE_OP="delete";
/*
ensures there are no "|" characters, which can potentially cause
problems with HTML display.  Note that the "|" character is used as a field delimiter
for front-end arrays, therefore there can be erroneous results if the said character is part
of the text.
@param		the text to check
@return		true if the text is valid; false otherwise
*/
function validateText(input){
	for (var i=0;i<input.length;i++){
		if (input.charAt(i)=='|'){
			return false;
		}
		
	}
	return true;
}
/*
 *trims leading and trailing spaces from input
 *@param		input		the text to trim
 *@return		a copy of the input with leading and trailing spaces removed
*/
function trim(input){
	var len=input.length;
	var modinput=input;
	
	//first remove trailing spaces
	while('' + modinput.charAt(modinput.length-1)==' '){
		modinput=modinput.substring(0,modinput.length-1);
	}
	//next remove leading spaces
	while('' + modinput.charAt(0)==' '){
		modinput=modinput.substring(1,modinput.length);
	}
	return modinput;
	
}
/*
	Moves item in source list to destination list, if the item is not already part
	of destination list. 
*/
function transferListItem(sourceList,destList){
	var sourceIndex=sourceList.selectedIndex;
	var id,text,opt;
	if (sourceIndex >=0){
		id=sourceList.options[sourceIndex].value;
		
		if (findListValue(destList,id)==-1){
			//item was not already added, therefore can add to destination list
			text=sourceList.options[sourceIndex].text;
			opt=new Option(text,id,false,false);
			destList.options[destList.length]=opt;
			//remove from source list
			removeListItem(sourceList);
		}
	}
}
/*
	Removes the selected item from the given list.  
*/
function removeListItem(list){
	var ind=list.selectedIndex;
	if (ind >=0){
		list.options[ind]=null;
	}
}
/*
	Removes the all items from the given list.  (Algorythm used is 
	only suitable for Internet Explorer, as Netscape requires refreshing the page
	or reloading the selection list.)
*/
function clearList(list){
	var len=list.length;
/*	while (len>0){
		list.options[0]=null;
		len-=1;
	}*/
list.options.length=0;
}
/*returns index of list item matching the text (after trimming and converting to uppercase),
and -1 if not found
  @param		selectList			the list of items to check
				inputText			item text
			
*/
function findListItem(selectList,text){
	var trimmedInput=trim(text);
        var inputToCompare=trimmedInput.toUpperCase();
	 for (var i=0;i< selectList.length;i++){
                var recordText=selectList.options[i].text;
               
                var recordTextToCompare=trim(recordText.toUpperCase());
                if (inputToCompare==recordTextToCompare){
                        return i;
                }
        }
	return -1;
}
/*returns index of list item matching the value and -1 if not found
  @param                selectList                      the list of items to check
                        val				value to find 
*/
function findListValue(selectList,val){
         for (var i=0;i< selectList.length;i++){
                var listVal=selectList.options[i].value;
                if (listVal==val){
                        return i;
                }
        }
        return -1;
}
/*
	returns true if an item is in an array (case-sensitive, non-trimmed)
*/
function isInArray(array,item){
	var found=false;
	for(var i=0;i< array.length;i++){
		if (array[i]==item){
			found=true;
		}
	}
	return found;
}
/*
	returns index of item if it's in an array (case-sensitive, non-trimmed)
*/
function findArrayItem(array,item){
	for(var i=0;i< array.length;i++){
		if (array[i]==item){
			return i;
		}
	}
	return -1;
}
/*scrolls a given list to a specific selection
  @param	selectList		the selection list to scroll
			defaultNumber	the list item VALUE (not the text)
*/
function scrollList(selectList,defaultNumber){
			
	for (var i=0;i< selectList.length;i++){
		var recordNumber=selectList.options[i].value;
		if (recordNumber==defaultNumber){	
			selectList.options[i].selected=true;	
		}
	}
}
//returns the value of the item selected in a list; null if no item selected
function returnListSelection(list){
	var ind=list.selectedIndex;
	if (ind>=0){
		var val=list.options[ind].value;
		return val;
	}
	return null;
}
//returns the item selected in a list as an Option object; null if no item selected
function returnListOption(list){
	var ind=list.selectedIndex;
	if (ind>=0){
		return list.options[ind];
	}
	return null;
}
/*
returns array index of matching 2-D array element(after trimming and converting to uppercase);
 -1 if not found
*/
function find2DItem(array2D,valToMatch,subIndex){
	var inputToCompare=trim(valToMatch.toUpperCase());
	for(var i=0; i< array2D.length;i++){
		 var recordTextToCompare=trim(array2D[i][subIndex].toUpperCase());
		
		if (recordTextToCompare==inputToCompare){
			return i;
		}
	}
	return -1;
}
/*loads array with records from a specific form
  @param        recordArray             array to be loaded
                        recForm                 form containing records
                        delimiter               field delimiter
*/
function prepArray(recForm,delimiter){
	var recordArray=new Array();
        var numRecords=recForm.elements.length;
        for (var i=0;i< numRecords;i++){
                recordArray[i]=new Array();
                //populate fields of the record
                recordArray[i]=recForm.elements[i].value.split(delimiter);
        }
	return recordArray;
}
/*
returns index of matching person; -1 if not found
*/
function findPerson(array2D,fname,lname){
	var fNameToCompare=trim(fname.toUpperCase());
	var lNameToCompare=trim(lname.toUpperCase());
	for(var i=0; i< array2D.length;i++){
		
		if(fNameToCompare==trim(array2D[i][1].toUpperCase())
			&& lNameToCompare==trim(array2D[i][2].toUpperCase()) ) {
			return i;
		}
	}
	return -1;
}
//no changed
function validateEndTimeAndStartTime(endDateTime,startDateTime,duration){
	var diffInMills = endDateTime - startDateTime;
	if(diffInMills<=0){
		return "diff_error";
	}
	var diffInMins = Math.round(diffInMills /(60*1000));
	if(diffInMins<duration){
		return "duration_error";
	}
	return "ok";
}

function dateTimeWrapper(year,month,day,hour,minute,second){
	
	return new Date(year,month,day,hour,minute,second);
}


function startValidate(duration){
	var year =document.getElementsByName("start_year")[0].value;
	var month =document.getElementsByName("start_month")[0].value;
	var day =document.getElementsByName("start_day")[0].value;
	var hour =document.getElementsByName("start_hour")[0].value;
	var minute =document.getElementsByName("start_minute")[0].value;
	var second =document.getElementsByName("start_second")[0].value;

	var year2 =document.getElementsByName("end_year")[0].value;
	var month2 =document.getElementsByName("end_month")[0].value;
	var day2 =document.getElementsByName("end_day")[0].value;
	var hour2 =document.getElementsByName("end_hour")[0].value;
	var minute2 =document.getElementsByName("end_minute")[0].value;
	var second2 =document.getElementsByName("end_second")[0].value;
	validateEndTimeAndStartTime(dateTimeWrapper(year2,month2,day2,hour2,minute2,second2),dateTimeWrapper(year,month,day,hour,minute,second),duration);
}
function isFilenameIllegal(filename) {
    var pattern =/'|#|&|\\|\/|:|\?|"|<|>|=|\*|\^|\||\$/gi;
    return pattern.test(filename);
}




</script>

<script language="javascript">

function submitInfo(){
	var myform=document.main;
	
	if (myform.identity.value==0){
		alert("Please identify yourself as a student or a professor!");
		myform.identity.focus();
		return;
	}

	if (trim(myform.the_id.value)=="" || isNaN(myform.the_id.value)){
		alert("The ID must not be must be a defined number!");
		myform.the_id.focus();
		return;
	}
	
	
	if (trim(myform.first_name.value)==""){
		alert("First name must not be empty!");
		myform.first_name.focus();
		return;
	}
		
	if (trim(myform.last_name.value)==""){
		alert("Last name must not be empty!");
		myform.last_name.focus();
		return;
	}
	
	//They will be trimmed before submitted
	//trim() is a javascript function defined in "util_js.php"
	//Also, all the answers will be changed to lower case.
	myform.the_id.value=trim(myform.the_id.value);
	myform.first_name.value=trim(myform.first_name.value);
	myform.first_name.value=(myform.first_name.value).toLowerCase();
	myform.last_name.value=trim(myform.last_name.value);
	myform.last_name.value=(myform.last_name.value).toLowerCase();
			
	myform.submit();
}


function submitAnswer(){
	var myform=document.show_questions;
		
	if (trim(myform.a1.value)==""){
		alert("Answer 1 must not be empty!");
		myform.a1.focus();
		return;
	}

	if (trim(myform.a2.value)==""){
		alert("Answer 2 must not be empty!");
		myform.a2.focus();
		return;
	}
	
	if (trim(myform.a3.value)==""){
		alert("Answer 3 must not be empty!");
		myform.a3.focus();
		return;
	}
	
	//They will be trimmed before submitted
	//trim() is a javascript function defined in "util_js.php"
	//Also, all the answers will be changed to lower case.
	myform.a1.value=trim(myform.a1.value);
	myform.a1.value=(myform.a1.value).toLowerCase();
	
	myform.a2.value=trim(myform.a2.value);
	myform.a2.value=(myform.a2.value).toLowerCase();
	
	myform.a3.value=trim(myform.a3.value);
	myform.a3.value=(myform.a3.value).toLowerCase();
			
	myform.submit();
}
</script>



	

<br>
<center><br>
<font size=5><center><b>Reset Your Password for CGA -- The CrsMgr Group-work Assistant</b></font><hr>

<form name=main method=post action=reset_password.php>
<table border=0 align=center>
<!-- Part of the crgmgr code. Don't think we need this
<tr>
<td><b>Please Identify yourself as:</b></td>
<td><select name=identity>
<option value=0 selected>--
<option value=1>Admin
<option value=2>Professor
<option value=3>Teaching Assistant
<option value=4>Student
</select> 
<font color = "red">*</font>
</td>
</tr>
-->

<tr><td><b>Enter Your Id:<br>(Student ID/Professor ID)</b></td><td><input type=text maxlength=20 size=35 name=the_id><font color=red>*</font></td></tr>
<tr><td><b>Enter Your First Name:</b></td><td><input type=text maxlength=30 size=35 name=first_name><font color=red>*</font></td></tr>
<tr><td><b>Enter Your Last Name:</b></td><td><input type=text maxlength=30 size=35 name=last_name><font color=red>*</font></td></tr>
<tr><td colspan=2 align =center><input type=button onclick=submitInfo(); value="Submit">&nbsp;&nbsp;<input type=reset value=Clear></td></tr>
</table>
<br>
<table border=0 align=center>
<tr><td><a href = "index.php">Back To Login Page</a></td></tr>
<tr><td><br></td></tr>
<tr><td><font color=red>* <i>Mandatory</i></td></tr>
</table>

<input type=hidden name=info_submitted value=true>

</form>

<script langauge = "javascript">
  document.main.identity.focus()
</script>

</body>
</html>