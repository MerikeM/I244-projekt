function validateUsername() {
    var name = document.forms["register"]["user"].value;
    if (name == ""){
                document.getElementById("register").user.style.color="black";
        document.getElementById("wronguser").innerHTML = "";
        document.getElementById("reg").disabled = true;
    } else if (name.length<4){
        document.getElementById("register").user.style.color = "red";
        document.getElementById("wronguser").innerHTML = "Kasutajanimi on liiga lühike";
        document.getElementById("reg").disabled=true;
    } else {
        document.getElementById("register").user.style.color = "black";
        document.getElementById("wronguser").innerHTML = "";
    }
}

function validatePass() {
    var first = document.forms["register"]["pass"].value;
    var second = document.forms["register"]["pass2"].value;
    if (first == "" || second == "" ){
        document.getElementById("reg").disabled = true;
        document.getElementById("register").pass.style.color = "black";
        document.getElementById("register").pass2.style.color = "black";
        document.getElementById("wrongpass").innerHTML = "";
    } else if (first != second){
        document.getElementById("register").pass.style.color = "red";
        document.getElementById("register").pass2.style.color = "red";
        document.getElementById("wrongpass").innerHTML = "Sisestatud paroolid on erinevad";
        document.getElementById("reg").disabled = true;
    } else {
        document.getElementById("register").pass.style.color = "black";
        document.getElementById("register").pass2.style.color = "black";
        document.getElementById("wrongpass").innerHTML = "";
    }
}

function validateEmail() {
    var email = document.forms["register"]["email"].value;
    var at = email.indexOf("@");
    var dot = email.lastIndexOf(".");
    if (email == ""){
        document.getElementById("register").email.style.color = "black";
        document.getElementById("wrongemail").innerHTML = "";
        document.getElementById("reg").disabled = true;
    } else if (at < 1 || dot == -1 || at > dot){
        document.getElementById("register").email.style.color = "red";
        document.getElementById("wrongemail").innerHTML = "Sisestatud e-mailiaadress ei ole korrektne";
        document.getElementById("reg").disabled = true;
    } else {
        document.getElementById("register").email.style.color = "black";
        document.getElementById("wrongemail").innerHTML = "";
    }
}

function validateAge() {
    var age = document.forms["register"]["age"].value;
    if (age == ""){
        document.getElementById("register").age.style.color = "black";
        document.getElementById("wrongage").innerHTML = "";
    } else if (age<0 || age > 150 || isNaN(age)){
        document.getElementById("register").age.style.color = "red";
        document.getElementById("wrongage").innerHTML = "Sisestatud vanus ei ole korrektne";
        document.getElementById("reg").disabled = true;
    } else {
        document.getElementById("register").age.style.color = "black";
        document.getElementById("wrongage").innerHTML = "";
    }
}

function validateRegistration() {
    document.getElementById("reg").disabled = false;
    validateUsername();
    validatePass();
    validateEmail();
    validateAge();
}

function showPoem(poem) {
    var current = document.getElementById("open");
    if (current != null){
        current.getElementsByClassName("end").item(0).style.display = "none";
        current.getElementsByClassName("rating").item(0).style.display = "none";
        current.id="";
    }
    poem.getElementsByClassName("end").item(0).style.display = "block";
    poem.getElementsByClassName("rating").item(0).style.display = "block";
    poem.id = "open";
}

function rate(button) {
    var form = button.parentNode;
    form.submit();
}