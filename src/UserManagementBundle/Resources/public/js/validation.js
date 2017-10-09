$(document).ready(function () {
    $("#myform").validate({
        rules: {
            'user[username]': {
                required: true,
                pattern: /^(\w+)$/,
            },
            'user[firstname]': {
                required: true,
                pattern: /^([a-zA-Z]+)([ \.-][a-zA-Z]+)?$/,
            },
            'user[lastname]': {
                required: false,
                pattern: /^([a-zA-Z]+)([ \.-][a-zA-Z]+)?$/,
            },
            'user[dob]': {
                required: true,
                pattern: /^[\d]{2}[/][\d]{2}[/][\d]{4}$/,
            },
            'user[blood]': {
                 required: true,
             }, 
          },
        messages: {
            'user[username]': {
                required: "Please enter your username",
                pattern: "Please enter valid username"
            },
            'user[firstname]': {
                required: "Please enter your firstname",
                pattern: "Please enter valid firstname"
            },
            'user[lastname]': {
                pattern: "Please enter valid lastname"
            },
            'user[dob]': {
                required: "Please enter your dob",
                pattern: "Please enter valid dob",
            },
            'user[blood]': {
                required: "Please select Blood group",
            }, 
          }        
    });            
    jQuery.validator.addClassRules({
        "email_id": {
            required: true,
            unique: 'email_id',
            pattern: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
        },
        "phone_number": {
            required: true,
            unique: 'phone_number',
            pattern: /^([9|8|7])[\d]{9}$/,
        },
        "education_type": {
            required: true,
        },
        "interest_area": {
            required: true,
        },
        "institute": {
            required: true,
            pattern: /^[A-z]+$/,
        },
    });
});

jQuery.validator.addMethod("unique", function(value, element, params) {
    var prefix = params;
    var selector = jQuery.validator.format("[name!='{0}'][class^='{1}']", element.name, prefix);
    var matches = new Array();
    $(selector).each(function(index, item) {
        if (value == $(item).val()) {
            matches.push(item);
        }
    });
    return matches.length == 0;
}, "Value is not unique.");