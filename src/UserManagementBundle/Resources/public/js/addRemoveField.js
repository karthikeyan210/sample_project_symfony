var count = 1;
function addField(ulFieldId)
{
    var ulField = document.getElementById(ulFieldId);
//    var fieldCount = ulField.children.length;
    var fieldWidget = ulField.getAttribute('data-prototype');
    console.log(fieldWidget);
    fieldWidget = fieldWidget.replace(/__name__/g,count);
    count++;
    var newLi = document.createElement("p");
    newLi.innerHTML = fieldWidget;
    var removeButton = document.createElement('input');
    removeButton.setAttribute("type", "button");
    removeButton.setAttribute("value", "x");
    removeButton.setAttribute('class', 'remove_button')
    removeButton.onclick = function() { removeField(this,ulField); };
    newLi.appendChild(removeButton);
    ulField.appendChild(newLi);
    console.log(count);
}

function removeField(removeLink, ulField)
{
    console.log(ulField.children.length, removeLink.parentElement);
//    if (ulField.children.length > 1) {
        removeLink.parentElement.remove();
//    }
}