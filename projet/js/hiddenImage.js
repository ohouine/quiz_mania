//@ts-check
let profilPhoto = document.getElementById('clickable');
let hiddenDiv = document.getElementById('hiddenImageDiv');
let cross = document.getElementById('cross');

console.log(cross)
// @ts-ignore
profilPhoto.addEventListener('click',() => hiddenDiv.style.display = 'flex')
// @ts-ignore
cross.addEventListener('click',() => hiddenDiv.style.display = 'none')