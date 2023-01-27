let profilPhoto = document.getElementById('profilPhoto');
let hiddenDiv = document.getElementById('hiddenImageDiv');
let cross = document.getElementById('cross');

profilPhoto.addEventListener('click',() => hiddenDiv.style.display = 'flex')
cross.addEventListener('click',() => hiddenDiv.style.display = 'none')