
let allRep = document.getElementsByClassName("rep");
let reponse = document.getElementsByClassName("inputReponse")
let errortxt = document.getElementsByClassName("error")
let questDiv = document.getElementsByClassName("questionDiv")
let btnSubmit = document.getElementById("sub");
let c = console;
let messEror = 'Choisissez une reponse'

c.log(reponse[0].value)

//Split given array in n array
function sliceArray(arr, n) {
    let transitionArr = [];
    let returnArr = [];

    for (let i = 0; i < arr.length; i+= n) {
        transitionArr = [];

        for (let index = 0; index < n; index++) {
            transitionArr.push(arr[i+index]);
        }

        returnArr.push(transitionArr);
    }
    
    return returnArr
}

function listener() {
    let quizzRep = sliceArray(allRep, 3);

    quizzRep.forEach(function(e,i) {

        e.forEach(element => {

            element.addEventListener('click',function (event) {

                e.forEach( rep=> {
                    rep.style.backgroundColor = "rgb(37,37,37)"
                });

                element.style.backgroundColor = "black";
                
                reponse[i].value = element.textContent
            })
        });
    });


    btnSubmit.addEventListener('click',function (e) {
        c.log(reponse[0].value)
        for (let i = 0; i < reponse.length; i++) {
            if (reponse[i].value === '') {
                c.log(reponse[i].value)
                errortxt[i].textContent = messEror
                e.preventDefault();
            }else{
                errortxt[i].textContent = ''
            }
        }
        
    })
}

listener();




//design

questDiv[0].style.borderTop = 'solid 0px'
questDiv[questDiv.length - 1].style.marginBottom = '2rem'