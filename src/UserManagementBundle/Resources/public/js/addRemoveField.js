function addField(ulFieldId)
{
    var ulField = document.getElementById(ulFieldId);
    var fieldCount = ulField.children.length;
    var fieldWidget = ulField.getAttribute('data-prototype');
    console.log(fieldWidget);
    fieldWidget = fieldWidget.replace(/__name__/g,fieldCount);
    fieldCount++;
    var newLi = document.createElement("li");
    newLi.innerHTML = fieldWidget;
    if (fieldCount != 1) {
        var removeButton = document.createElement('input');
        removeButton.setAttribute("type", "button");
        removeButton.setAttribute("value", "X");
        removeButton.setAttribute('class', 'remove_button')
        removeButton.onclick = function() { removeField(this); };
        newLi.appendChild(removeButton);
    }
    ulField.appendChild(newLi);
    console.log(fieldCount);
}

function removeField(removeLink)
{
    console.log(removeLink.parentElement);
    removeLink.parentElement.remove();
}