jQuery('#add-another-email').click(function(e) {
    e.preventDefault();
    var $emailList = jQuery('#email-fields-list');
    var $liFieldId = "user_emails";
    addTagForm($emailList, $liFieldId);
});
jQuery('#add-another-number').click(function(e) {
    e.preventDefault();
    var $numberList = jQuery('#mobile-numbers-list');
    var $liFieldId = "user_mobileNumbers";
    addTagForm($numberList, $liFieldId);
});

jQuery('#add-another-education').click(function(e) {
    e.preventDefault();
    var $educationList = jQuery('#education-list');
    var $liFieldId = "user_education";
    addTagForm($educationList, $liFieldId);
});

jQuery('#add-another-interest').click(function(e) {
    e.preventDefault();
    var $interestList = jQuery('#interests-list');
    var $liFieldId = "user_interests";
    addTagForm($interestList, $liFieldId);
});
    

function addTagForm($collectionHolder, $liFieldId) {
    var $id = $collectionHolder.children().last().attr('id');
    if ($id === undefined) {
        $id = $collectionHolder.children().last().children().first().attr('id');
    }
    console.log($id);
    var $index = $id[$liFieldId.length +1];
    var prototype = $collectionHolder.data('prototype');
    $index++;
    var newForm = prototype.replace(/__name__/g, $index);
    console.log(newForm);
    var $newFormLi = $('<li></li>').html(newForm);
    $newFormLi.appendTo($collectionHolder);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<input type="button" value="x">');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $tagFormLi.remove();
    });
}