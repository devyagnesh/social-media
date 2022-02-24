"use strict";


function SendRequests() {
    const FollowButtonEle = document.querySelectorAll(".btn-add-btn");

    const loader = `<?xml version="1.0" encoding="utf-8"?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:0rem auto;display: block; shape-rendering: auto;" width="20px" height="20px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#f0f2f5" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
        </circle>
        </svg>`;
    FollowButtonEle.forEach(function (elements) {

        elements.addEventListener("click", function (event) {
            elements.innerHTML = `${loader}`;
            setTimeout(function () {
                elements.setAttribute("disabled", true);

                SetRequest(event);
            }, 1000);
        });
    });
}

function SetRequest(event) {

    const SearchedData = {
        personID: event.target.dataset.vals,
    };
    const GetParent = event.target.closest(".btns");
    const data = JSON.stringify(SearchedData);
    const url = "../includes/addfriend.php";
    const Options = {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Requested-With': 'SecuredConnectionOnly',
        },
        redirect: 'follow',
        referrerPolicy: 'strict-origin-when-cross-origin',
        body: data
    }

    const Responses = fetch(url, Options);

    Responses.then(function (response) {
        if (response.status === 200) {
            return response.json()
        }

    }).then(function (data) {

        GetParent.innerHTML = "";
        GetParent.innerHTML = "<p style='font-size:1.2rem;'>" + data + "</p>";
    });
}