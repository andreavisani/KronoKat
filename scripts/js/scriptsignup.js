function validate() {

    clearErrors();
    var fname = document.getElementById("fname").value.trim();
    var lname = document.getElementById("lname").value.trim();
    var email = document.getElementById("email").value;
    var login = document.getElementById("login").value.trim().toLowerCase();
    var pass = document.getElementById("pass").value;
    var pass2 = document.getElementById("pass2").value;
    var terms = document.getElementById("terms").checked;

    var isValid = true;
    // validate firstname 
    if(fname.length === 0 || fname.length >30){
        errorTime("fname"); 
        isValid = false; 
    }
    // validate lastname
    if(lname.length === 0 || lname.length >30){
        errorTime("lname"); 
        isValid = false; 
    }
    
    // Validate email
    if (!validateEmail(email)) {
        showError("email", "Please enter a valid email address.");
        isValid = false;
    }

    // Validate login
    if (login.length === 0 || login.length > 30) {
        errorTime("login");
        isValid = false;
    }

    // Validate password
    if (pass.length < 8) {
        showError("pass", "Password must be at least 8 characters long.");
        isValid = false;
    }

    // Validate re-typed password
    if (pass !== pass2 || pass2.trim() === "") {
        showError("pass2", "Passwords do not match.");
        isValid = false;
    }

    // Validate terms acceptance
    if (!terms) {
        showError("terms", "Please accept the terms and conditions.");
        isValid = false;
    }

    return isValid;
}

function validateEmail(email) {
    var anugrah = /\S+@\S+\.\S+/;
    return anugrah.test(email);
}

function showError(field, message) {
    var inputField = document.getElementById(field);
    inputField.style.borderColor = "red";

    var errorSpan = document.createElement("span");
    errorSpan.textContent = message;
    errorSpan.style.color = "red";
    errorSpan.classList.add("error-message");

    var parentDiv = inputField.parentNode;
    parentDiv.appendChild(errorSpan);
}

function errorTime(field) {
    var inputField = document.getElementById(field);
    inputField.style.borderColor = "red";
}

function clearErrors() {
    var errorMessages = document.getElementsByClassName("error-message");
    while (errorMessages.length > 0) {
        errorMessages[0].parentNode.removeChild(errorMessages[0]);
    }

    var inputFields = document.querySelectorAll(".textfield input");
    for (var i = 0; i < inputFields.length; i++) {
        inputFields[i].style.borderColor = "";
    }
}

document.getElementById("fname").addEventListener("input", validateField);
document.getElementById("lname").addEventListener("input", validateField);
document.getElementById("email").addEventListener("input", validateField);
document.getElementById("login").addEventListener("input", validateField);
document.getElementById("pass").addEventListener("input", validateField);
document.getElementById("pass2").addEventListener("input", validateField);

// Function to validate individual field
function validateField(event) {
    var fieldId = event.target.id;
    var fieldValue = event.target.value.trim();

    switch (fieldId) {
        case "fname":
            if (fieldValue.length > 0 && fieldValue.length <= 30) {
                clearError("fname");
            }
            break;
        case "lname":
            if (fieldValue.length > 0 && fieldValue.length <= 30) {
                clearError("lname");
            }
            break;
        case "email":
            if (validateEmail(fieldValue)) {
                clearError("email");
            }
            break;
        case "login":
            if (fieldValue.length > 0 && fieldValue.length <= 30) {
                clearError("login");
            }
            break;
        case "pass":
            if (fieldValue.length >= 8) {
                clearError("pass");
            }
            break;
        case "pass2":
            var passValue = document.getElementById("pass").value;
            if (fieldValue === passValue && fieldValue.trim() !== "") {
                clearError("pass2");
            }
            break;
        default:
            break;
    }
}

// Function to clear error message
function clearError(field) {
    var inputField = document.getElementById(field);
    inputField.style.borderColor = "";

    var errorSpan = inputField.parentNode.querySelector(".error-message");
    if (errorSpan) {
        errorSpan.parentNode.removeChild(errorSpan);
    }
}

