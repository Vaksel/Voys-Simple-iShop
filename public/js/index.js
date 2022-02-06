function init()
{
    let propertyName = document.getElementById('propertyName').innerHTML;
    let propertyValue = document.getElementById('propertyValue').checked ? 'Выбрана' : 'Не выбрана';

    document.getElementById('propertyValue').addEventListener('click', togglePropertyValue);
    document.getElementById('propertyNameHidden').value = propertyName;
    document.getElementById('propertyValueHidden').value = propertyValue;
}

function togglePropertyValue(e)
{
    document.getElementById('propertyValueHidden').value = e.target.checked ? 'Выбрана' : 'Не выбрана';
}

init();