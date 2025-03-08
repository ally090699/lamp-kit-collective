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
    const isValid = message.length >= 10 && message.length <= 300;
    if (!isValid){
        inputBox.style.borderColor = "red";
    }
};