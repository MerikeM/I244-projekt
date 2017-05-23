function validatePass() {
    var first = document.forms["register"]["pass"].value;
    var second = document.forms["register"]["pass2"].value;
    if (first != second){
        document.getElementById("register").pass.style.color = "red";
        document.getElementById("register").pass2.style.color = "red";
        document.getElementById("wrongpass").innerHTML = "Sisestatud paroolid on erinevad";
    } else {
        document.getElementById("register").pass.style.color = "black";
        document.getElementById("register").pass2.style.color = "black";
        document.getElementById("wrongpass").innerHTML = "";
    }
}

function validateEmail(){
    var email = document.forms["register"]["email"].value;
    var at = email.indexOf("@");
    var dot = email.lastIndexOf(".");
    if (at < 1 || dot == -1 || at > dot){
        document.getElementById("register").email.style.color = "red";
        document.getElementById("wrongemail").innerHTML = "Sisestatud e-mailiaadress ei ole korrektne";
    } else {
        document.getElementById("register").email.style.color = "black";
        document.getElementById("wrongemail").innerHTML = "";
    }
}

function validateAge(){
    var age = document.forms["register"]["age"].value;
    if (age == ""){
        document.getElementById("register").age.style.color = "black";
        document.getElementById("wrongage").innerHTML = "";
    } else if (age<0 || age > 150 || isNaN(age)){
        document.getElementById("register").age.style.color = "red";
        document.getElementById("wrongage").innerHTML = "Sisestatud vanus ei ole korrektne";
    } else {
        document.getElementById("register").age.style.color = "black";
        document.getElementById("wrongage").innerHTML = "";
    }
}