// @ts-check
'use strict'
    
let ddiv = document.getElementsByClassName("ddiv");
let ddivContent = document.getElementsByClassName("ddivContent");
let imgFleche = document.getElementsByClassName("imgFleche");
let indexDiv = document.getElementById("indexDiv");
let cadenas = document.getElementById("cadenas");
let genQuiz = document.getElementById("genQuiz");
let shop = document.getElementById("shop");
let user = document.getElementById("userimg");
let userContent = document.getElementById("userBlock");

// @ts-ignore
ddiv[0].addEventListener("click", function (e) {
    if (ddiv[0].hasAttribute('true')) {
        ddiv[0].removeAttribute("true")
        // @ts-ignore
        ddivContent[0].style.visibility = "hidden"
        // @ts-ignore
        imgFleche[0].style.transform = "rotate(-90deg)"
    }else{
        ddiv[0].setAttribute('true', 'true')
        // @ts-ignore
        ddivContent[0].style.visibility = "visible"
        // @ts-ignore
        imgFleche[0].style.transform = "rotate(0deg)"
    }
})

// @ts-ignore
genQuiz.addEventListener("click",function (e) {
    // @ts-ignore
    if (cadenas.style.display == 'block' ) {
        alert("Vous devez étre connèctez pour crée un quizz")
    }
})

// @ts-ignore
shop.addEventListener("click",function (e) {
    // @ts-ignore
    if (cadenas.style.display == 'block' ) {
        alert("Vous devez étre connèctez pour accéder aux magasin");
    }
})

// @ts-ignore
user.addEventListener("click",function (e) {
    // @ts-ignore
    if (user.hasAttribute('true')) {
        // @ts-ignore
        user.removeAttribute("true")
        // @ts-ignore
        userContent.style.display = "none"
    }else{
        // @ts-ignore
        user.setAttribute('true', 'true')
        // @ts-ignore
        userContent.style.display = "block"
        // @ts-ignore
        userContent.style.display = "flex"
    }
})

/* 
for (let i = 0; i < ddiv.length ; i++ ) {

    ddiv[i].addEventListener("click", () => ddivshow(i))

} 


function ddivshow(i) {

    for (let index = 0; index < ddiv.length; ) {
        
        if (index === i) {
            if (ddiv[index].hasAttribute('true') == true ) {
                ddivContent[index].style.display = "none"; 
                ddiv[index].removeAttribute("true");
                imgFleche[index].style.transform = "rotate(-90deg)";

            }
            else{
                ddiv[index].setAttribute("true", "true");

                ddivContent[index].style.display = "block"
                imgFleche[index].style.transform = "rotate(0deg)";
            }
           
        }
        else{
            ddiv[index].removeAttribute("true");

            ddivContent[index].style.display = "none"
            imgFleche[index].style.transform = "rotate(-90deg)";

        }
        
        index++
    }
}
*/


