function addField(ulFieldId, liFieldId)
{
    console.log(ulFieldId);
//    liFieldId.length +1;
    var ulField = document.getElementById(ulFieldId);
    console.log(ulField.lastElementChild);
    var id = ulField.lastElementChild.getAttribute('id');
    if (id === null) {
        id = ulField.lastElementChild.children[0].getAttribute('id');
    }
    var count = id[liFieldId.length +1];
    console.log(count);
    count++;
    var fieldWidget = ulField.getAttribute('data-prototype');
    fieldWidget = fieldWidget.replace(/__name__/g,count);
    var newLi = document.createElement("p");
    newLi.innerHTML = fieldWidget;
    var removeButton = document.createElement('input');
    removeButton.setAttribute("type", "button");
    removeButton.setAttribute("value", "x");
    removeButton.setAttribute('class', 'remove_button');
    removeButton.onclick = function() { removeField(this,ulField); };
    newLi.appendChild(removeButton);
    ulField.appendChild(newLi);
    console.log(newLi.children[0].getAttribute('id'));

}

function removeField(removeLink, ulField)
{
    console.log(ulField.children.length, removeLink.parentElement);
//    if (ulField.children.length > 1) {
        removeLink.parentElement.remove();
//    }
}