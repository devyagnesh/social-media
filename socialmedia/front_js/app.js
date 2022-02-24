"use strict";
// function will open and close the signup ui box
const SignupOpnerBtnELE = document.getElementById("Btn-Signup");
const SignupEle = document.getElementById("signup-wrapper");
const CloseBtnEle = document.querySelector(".btn-close");
const PassIconEle = document.getElementById("seepass");
const PasswordInputEle = document.getElementById("password");
function OpenSignupUI()
{
    SignupOpnerBtnELE.addEventListener("click",function()
    {
        
        SignupEle.classList.add("display");
        
        CloseSignupUI(SignupEle);
        SeePassword();
        
    });
}

function CloseSignupUI(element)
{

    CloseBtnEle.addEventListener("click",function()
    {
        element.classList.remove("display");
    });
}

function SeePassword()
{
    
    PassIconEle.addEventListener("click",function(){

        if(PasswordInputEle.getAttribute("type") === "password")
        {
            PasswordInputEle.setAttribute("type","text");
            PassIconEle.textContent = "lock_open";
        }

        else if(PasswordInputEle.getAttribute("type") === "text")
        {
            PasswordInputEle.setAttribute("type","password");
            PassIconEle.textContent = "lock";
        }
        
       
    });
    
}



OpenSignupUI();

 
//-------------------------------------------------------------------------------