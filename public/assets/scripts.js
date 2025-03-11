function toggleEditProfile() {
    let form = document.getElementById("edit-profile-form");
    form.style.display = form.style.display === "none" ? "flex" : "none";
}

const checkFirstname = (firstname) => {
    let inputBox = document.getElementById("firstname");

    const isValid = firstname.length >= 2 && /^[A-Za-z]+(\s[A-Za-z]+)*$/.test(firstname);
    
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkLastname = (lastname) => {
    let inputBox = document.getElementById("lastname");
    const isValid = lastname.length >= 2 && /^[A-Za-z]+(\s[A-Za-z]+)*$/.test(lastname);
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkPassword = (password) => {
    let inputBox = document.getElementById("passwordinput");
    const isValid = password.length >= 8 && /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]).*$/.test(password);
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkConfirmPassword = (confirmPassword, password) => {
    let inputBox = document.getElementById("confirmpasswordinput");
    const isValid = confirmPassword === password;
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkPhone = (phone) => {
    let inputBox = document.getElementById("phonenumber");
    const isValid = isValidPhoneNumber(phone, 'CA');
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkEmail = (email) => {
    let inputBox = document.getElementById("emailinput");
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

const checkMessage = (message) => {
    let inputBox = document.getElementById("message");
    const isValid = message.length >= 10 && message.length <= 300;
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const reasonRadios = document.querySelectorAll("input[name='reason']");
    const productSection = document.querySelector(".pid");

    reasonRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "Product Info") {
                productSection.classList.remove("hidden");
                productSection.classList.add("visible");
            } else {
                productSection.classList.remove("visible");
                productSection.classList.add("hidden");
            }
        });
    });
});

function backToTop(event) {
    // back to top button function
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function displayGreeting() { 
    // day-specific message display
    let today = new Date(); 
    let day = today.getDay();
    let msg = "";

    if (day == 0) {     //if it is sunday
        msg = "Have a Soft & Snuggly Sunday !"; 
    }
    else if (day == 1) { 
        msg = "Have an Marvelously Made Monday!"; 
    }
    else if (day == 2) { 
        msg = "Have a Tangle-Free Tuesday!"; 
    }
    else if (day == 3) { 
        msg = "Have a Whimsy & Wonderful Wednesday!"; 
    }
    else if (day == 4) { 
        msg = "Have a Threaded Thursday!"; 
    }
    else if (day == 5) { 
        msg = "Have a Fluffy & Fun Friday!"; 
    }
    else if (day == 6) { 
        msg = "Have a Snug & Cozy Saturday!"; 
    }
    document.getElementById("deal-subtitle").innerHTML = msg;
}
            
document.addEventListener("DOMContentLoaded", displayGreeting);

const navLinks = document.querySelectorAll('#navbar .menu a');
const currentUrl = window.location.href;

navLinks.forEach(link => {
    if (currentUrl.includes(link.href)) {
        link.classList.add('active');
    } else {
        link.classList.remove('active');
    }
});