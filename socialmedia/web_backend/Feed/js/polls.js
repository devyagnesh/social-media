"use strict"
const getnotifyele = document.getElementById("notifyme");
const counter = document.querySelector(".notify-alert");
window.onload = function () {
    PollNotifications();
};

function PollNotifications() {
    const url = "../includes/pollnotifications.php";
    const Xhr = new XMLHttpRequest();
    Xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.status === 200) {
                try {
                    getnotifyele.innerHTML ="";
                    getnotifyele.insertAdjacentHTML("afterbegin",this.responseText);
                    counter.textContent = document.querySelectorAll(".request_wrapper").length;
                    setTimeout(() => {
                        PollNotifications();
                    }, 2000);
                } catch {
                    PollNotifications();
                }

                if (JSON.status !== true) {
                    // console.log(JSON.error);
                }

            } else {
                PollNotifications();
            }
        }
    };

    Xhr.open('GET', url, true);
    Xhr.setRequestHeader("Content-Type", "application/json");
    Xhr.setRequestHeader("Requested-With","SecuredConnectionOnly");
    Xhr.send();
}