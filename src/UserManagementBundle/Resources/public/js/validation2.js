$(document).ready(function () {
    $("#myform").validate({
          rules: {
              '{{form.username.vars.full_name}}': {
              required: true,
              pattern: /^(\w+)$/,
            }
          },
          messages: {
            '{{form.username.vars.full_name}}': {
              required: "We need your email address to contact you",
              pattern: "Your email address must be in the format of name@domain.com"
            }
          },        
    });

    $('.email_id').each(function() {
        $(this).rules('add', {
            required: true,
            email: true,
            messages: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"            }
        });
    });
    
    $('.phone_number').each(function() {
        $(this).rules('add', {
            required: true,
            number: true,
            messages: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"            }
        });
    });
});