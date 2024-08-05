function validateNameInput(value){
    return value.length <= 30 && value.length > 0;
}
function validateEmailInput(value){
    const regex = /[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?/i;
    return regex.test(value);
}
function validatePhoneInput(value, phoneInput){
    value = "+" + value;
    const phoneNumber = phoneInput.getNumber();
    const info = document.querySelector(".alert-info");
    info.style.display = "";
    info.innerHTML = `Phone number in E.164 format: <strong>${phoneNumber}</strong>`;
    const regex =  /^\+(?:[0-9] ?){6,14}[0-9]$/;
    return regex.test(value);
}
function validatePositionInput(value){
    return value.length <= 25 && value.length > 0;
}
function validateImageFileInput(myDropzone){
    return myDropzone.files[0] != null;
}
function validateDescriptionInput(value){
    return value.length <= 150 && value.length > 0;
}
