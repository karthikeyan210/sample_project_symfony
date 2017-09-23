 // keep track of how many email fields have been rendered
    var emailCount = '{{ form.emails|length }}';
    console.log(emailCount);
    var addEmail = document.getElementById('add-another-email');
    console.log(addEmail);
    addEmail.onclick = function() { addEmailId(); };
    function addEmailId()
    {
        console.log(emailCount);
        var emailList = document.getElementById('email-fields-list');
        console.log(emailList);
        var emailWidget = emailList.getAttribute('data-prototype');
        console.log(emailWidget);
        emailWidget = emailWidget.replace(/__name__/g,emailCount);
        emailCount++;
        var newLi = document.createElement("li");
        var text = document.createTextNode(emailWidget);
        newLi.appendChild(text);
        console.log(newLi);
        emailList.appendChild(newLi);
        console.log(emailList);     
    }