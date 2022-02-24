"use strict";

const NotificationButtonEle = document.getElementById("notification-button");
const SettingButtonEle = document.getElementById("settings-button");
const OthersButtonEle = document.getElementById("others-button");
const NodeLists = document.querySelectorAll(".noti-list");
const [item1, item2, item3] = Array.from(NodeLists);


function Playsound()
{
    const audio = new Audio("../Feed/effects/tone.wav");
    audio.play();
}



NotificationButtonEle.addEventListener("click", function (e) {
    e.stopPropagation();
    if (item1.classList.contains("hide")) {

        if (item2.classList.contains("display")) {
            item2.classList.remove("display");
            item2.classList.add("hide");
            SettingButtonEle.classList.add("activated");
            SettingButtonEle.childNodes[1].classList.add("activates");
        } else if (item3.classList.contains("display")) {
            item3.classList.remove("display");
            item3.classList.add("hide");
            OthersButtonEle.classList.remove("activated");
            OthersButtonEle.childNodes[1].classList.remove("activates");
        }

        item1.classList.remove("hide");
        item1.classList.add("display");
        NotificationButtonEle.classList.add("activated");
        NotificationButtonEle.childNodes[1].classList.add("activates");

    } else {
        item1.classList.remove("display");
        item1.classList.add("hide");
        NotificationButtonEle.classList.remove("activated");
        NotificationButtonEle.childNodes[1].classList.remove("activates");
    }
});

SettingButtonEle.addEventListener("click", function (e) {
    e.stopPropagation();
    if (item2.classList.contains("hide")) {

        if (item1.classList.contains("display")) {
            item1.classList.remove("display");
            item1.classList.add("hide");
            NotificationButtonEle.classList.remove("activated");
            NotificationButtonEle.childNodes[1].classList.remove("activates");
        } else if (item3.classList.contains("display")) {
            item3.classList.remove("display");
            item3.classList.add("hide");
            OthersButtonEle.classList.remove("activated");
            OthersButtonEle.childNodes[1].classList.remove("activates");
        }


        item2.classList.remove("hide");
        item2.classList.add("display");
        SettingButtonEle.classList.add("activated");
        SettingButtonEle.childNodes[1].classList.add("activates");

    } else {
        item2.classList.remove("display");
        item2.classList.add("hide");
        SettingButtonEle.classList.remove("activated");
        SettingButtonEle.childNodes[1].classList.remove("activates");
    }
});

OthersButtonEle.addEventListener("click", function (e) {
    e.stopPropagation();
    if (item3.classList.contains("hide")) {

        if (item1.classList.contains("display")) {
            item1.classList.remove("display");
            item1.classList.add("hide");
            NotificationButtonEle.classList.remove("activated");
            NotificationButtonEle.childNodes[1].classList.remove("activates");
        } else if (item2.classList.contains("display")) {
            item2.classList.remove("display");
            item2.classList.add("hide");
            SettingButtonEle.classList.remove("activated");
            SettingButtonEle.childNodes[1].classList.remove("activates");
        }


        item3.classList.remove("hide");
        item3.classList.add("display");
        OthersButtonEle.classList.add("activated");
        OthersButtonEle.childNodes[1].classList.add("activates");

    } else {
        item3.classList.remove("display");
        item3.classList.add("hide");
        OthersButtonEle.classList.remove("activated");
        OthersButtonEle.childNodes[1].classList.remove("activates");
    }
});