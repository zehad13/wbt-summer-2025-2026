document.addEventListener("DOMContentLoaded", function () {

const form=document.getElementById("clubForm");

let attempts=0;

form.addEventListener("submit",function(e){

e.preventDefault();

document.querySelectorAll(".error").forEach(function(item){
item.innerHTML="";
});

document.getElementById("success").innerHTML="";

let valid=true;

let nameRegex=/^[A-Za-z]+$/;
let emailRegex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

let fname=document.getElementById("fname").value.trim();
let lname=document.getElementById("lname").value.trim();
let email=document.getElementById("email").value.trim();
let password=document.getElementById("password").value;
let reason=document.getElementById("reason").value.trim();
let category=document.getElementById("category").value;

let errors=document.querySelectorAll(".error");



if(fname==""){
errors[0].innerHTML="First Name Required";
valid=false;
}
else if(!nameRegex.test(fname)){
errors[0].innerHTML="Only alphabets allowed";
valid=false;
}



if(lname==""){
errors[1].innerHTML="Last Name Required";
valid=false;
}
else if(!nameRegex.test(lname)){
errors[1].innerHTML="Only alphabets allowed";
valid=false;
}



if(email==""){
errors[2].innerHTML="Email Required";
valid=false;
}
else if(!emailRegex.test(email)){
errors[2].innerHTML="Invalid Email";
valid=false;
}



if(password==""){
errors[3].innerHTML="Password Required";
valid=false;
}
else if(password.length<8){
errors[3].innerHTML="Minimum 8 characters";
valid=false;
}



if(!valid){
attempts++;

if(attempts>=3){
document.getElementById("password").disabled=true;
errors[3].innerHTML="Password Locked after 3 attempts";
}

}



let gender=document.querySelector('input[name="gender"]:checked');

if(gender==null){
errors[4].innerHTML="Select Gender";
valid=false;
}



let clubs=document.querySelectorAll('input[name="club"]:checked');

if(clubs.length!=1){
errors[5].innerHTML="Select exactly one club";
valid=false;
}



if(category==""){
errors[6].innerHTML="Choose a Category";
valid=false;
}



if(reason==""){
errors[7].innerHTML="Reason Required";
valid=false;
}
else if(reason.length<20){
errors[7].innerHTML="Minimum 20 characters";
valid=false;
}



if(valid){
document.getElementById("success").innerHTML="Registration Successful!";
form.reset();
}

});

});