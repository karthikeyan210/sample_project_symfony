function addField(ulFieldId)
{
    var ulField = document.getElementById(ulFieldId);
    var fieldCount = ulField.children.length;
    var fieldWidget = ulField.getAttribute('data-prototype');
    console.log(fieldWidget);
    fieldWidget = fieldWidget.replace(/__name__/g,fieldCount);
    fieldCount++;
    var newLi = document.createElement("p");
    newLi.innerHTML = fieldWidget;
    var removeButton = document.createElement('input');
    removeButton.setAttribute("type", "button");
    removeButton.setAttribute("value", "X");
    removeButton.setAttribute('class', 'remove_button')
    removeButton.onclick = function() { removeField(this,ulField); };
    newLi.appendChild(removeButton);
    ulField.appendChild(newLi);
    console.log(fieldCount);
}

function removeField(removeLink, ulField)
{
    console.log(ulField.children.length, removeLink.parentElement);
    if (ulField.children.length > 1) {
        removeLink.parentElement.remove();
    }
}