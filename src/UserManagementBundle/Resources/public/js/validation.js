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
                msg.error = "Must fill this field";
                isValid = false;
            }
            var spanCount = inputs[i].parentNode.children.length;
            for (var j=1; j < spanCount; j++) {
                inputs[i].parentNode.removeChild(inputs[i].parentNode.children[1]);
            }
            var spanElement = document.createElement('span');
            spanElement.setAttribute('class', 'error');
            spanElement.innerHTML = msg.error;
            inputs[i].parentNode.insertBefore(spanElement, inputs[i].nextSibling);
        }
    }
    return isValid;
}
