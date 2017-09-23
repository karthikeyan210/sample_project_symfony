    // keep track of how many email fields have been rendered
    var emailCount = '{{ form.emails|length }}';

    jQuery(document).ready(function() {
        jQuery('#add-another-email').click(function(e) {
            e.preventDefault();
            console.log(emailCount);

            var emailList = jQuery('#email-fields-list');
            console.log(emailList);
            // grab the prototype template
            var newWidget = emailList.attr('data-prototype');
            console.log(newWidget);
            // replace the "__name__" used in the id and name of the prototype
            // with a number that's unique to your emails
            // end name attribute looks like name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, emailCount);
            emailCount++;

            // create a new list element and add it to the list
            var newLi = jQuery('<li></li>').html(newWidget);
            newLi.appendTo(emailList);
        });
    })
    
    var mobileNumberCount = '{{ form.mobilenumber|length }}';

    jQuery(document).ready(function() {
        jQuery('#add-another-mobilenumber').click(function(e) {
            e.preventDefault();
            console.log(mobilenumberCount);

            var mobilenumberList = jQuery('#mobilenumber-fields-list');
            console.log(mobilenumberList);
            // grab the prototype template
            var newWidget = mobilenumberList.attr('data-prototype');
            console.log(newWidget);
            // replace the "__name__" used in the id and name of the prototype
            // with a number that's unique to your emails
            // end name attribute looks like name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, mobilenumberCount);
            mobilenumberCount++;

            // create a new list element and add it to the list
            var newLi = jQuery('<li></li>').html(newWidget);
            newLi.appendTo(mobilenumberList);
        });
    })