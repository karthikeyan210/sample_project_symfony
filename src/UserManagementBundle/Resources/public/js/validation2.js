//var submitButton = document.getElementById('user_save');
//submitButton.addEventListener("submit", validation);
function validation()
{
    var isValid = true;
    var inputs = document.getElementsByTagName("input");
    console.log(inputs);
    var msg = {error:""};
    for (var i = 0; i < inputs.length; i++) {
        var dataRequired = inputs[i].getAttribute("data-required");
        console.log(inputs[i].value);
        console.log(dataRequired);
        msg.error = "";
        if (dataRequired) {
            if (inputs[i].value === "") {
                msg.error = "This field is required";
                isValid = false;
            }
            var spans = inputs[i].parentNode.getElementsByTagName('span');
            for (var j = 0, l = spans.length; j < l; j++) {
                spans[j].parentNode.removeChild(spans[j]);         
            }
            var spanElement = document.createElement('span');
            spanElement.setAttribute('class', 'error');
            spanElement.innerHTML = msg.error;
            inputs[i].parentNode.insertBefore(spanElement, inputs[i].nextSibling);
        }
    }
    if (isValid === true) {
        var result = validateInput(inputs, msg);
        if(result === false) {
            isValid = false;
        }
    }
    console.log(isValid);
    return isValid;
}


/**
 * To validate all the inputs
 *
 * @param object inputs      All the input tags in the form
 * @param object msg         Message for display the errors
 *
 * @return boolean
 */
function validateInput(inputs, msg)
{
    var isValid = true;
    var usernameRegExp = /^(\w+)$/;
    var nameRegExp = /^([a-zA-Z]+)([ \.-][a-zA-Z]+)?$/;
    var emailRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var mobilenumberRegExp = /^([9|8|7])[\d]{9}$/;
    for (var i = 0; i< inputs.length-1; i++) {
        msg.error = "";
        var fieldType = inputs[i].getAttribute("fieldType");
        console.log(fieldType);
//        var dataRequired = inputs[i].getAttribute("data-required");
        if (fieldType === "username") {
            if (!usernameRegExp.test(inputs[i].value)) {
                msg.error = "Enter valid data";
                isValid = false;
            }
        }
        if (fieldType === "name" && inputs[i].value.length !== 0) {
            if (!nameRegExp.test(inputs[i].value)) {
                msg.error = "Enter valid data";
                isValid = false;
            }
        }
        if (fieldType === "email") {
            if (!emailRegExp.test(inputs[i].value)) {
                msg.error = "Enter valid email";
                isValid = false;
            }
        }
        if (fieldType === "mobilenumber") {
            if (!mobilenumberRegExp.test(inputs[i].value)) {
                msg.error = "Enter valid mobilenumber";
                isValid = false;
            }
        }
        if (fieldType === "dob") {
            var result = validateDob(inputs, i, msg);
            if(result === false) {
                isValid = false;
            }
        }
        console.log(msg.error);
        console.log(inputs[i].parentNode.getElementsByTagName('span').length);
        var spans = inputs[i].parentNode.getElementsByTagName('span');
        for (var j = 0, l = spans.length; j < l; j++) {
            spans[j].parentNode.removeChild(spans[j]);         
        }
        console.log(inputs[i].parentNode.getElementsByTagName('span').length);

        var spanElement = document.createElement('span');
        spanElement.setAttribute('class', 'error');
        spanElement.innerHTML = msg.error;
        inputs[i].parentNode.insertBefore(spanElement, inputs[i].nextSibling);
        console.log(inputs[i].parentNode.getElementsByTagName('span').length);
    }
    alert(isValid);
    return isValid;
}
/**
 * To validate the date of birth
 *
 * @param object inputs All the input tags in the form
 * @param int    index  Index of the inputs
 * @param object msg    Message for display the errors
 *
 * @return boolean
 */
function validateDob(inputs, index, msg)
{
    var isValid = true;
    var dobRegExp = /^[\d]{2}[/][\d]{2}[/][\d]{4}$/;
    var dob = inputs[index].value;
    if (!dobRegExp.test(dob)) {
        msg.error = "Enter valid Date";
        isValid = false;
    } else {
        var dob = dob.split("/");
        var birthDay = parseInt(dob[1]);
        var birthMonth = parseInt(dob[0]);
        var birthYear = parseInt(dob[2]);
        if (birthMonth === 0 || birthMonth >12 || birthDay === 0 || birthDay > 31
            || birthYear < 1970) {          
            msg.error = "Enter valid Date";
            isValid = false;
        }
        var date = new Date();
        var age = date.getFullYear() - birthYear;
        var month = (date.getMonth()+1) - birthMonth;
        var day = date.getDate() - birthDay;
        if (month < 0 || (month === 0 && day < 0)) {
            age--;
        }
        if (age < 0) {
            msg.error = "Enter valid Date of Birth";
            isValid = false;
        }
    }
    console.log(age);
    return isValid;
}
