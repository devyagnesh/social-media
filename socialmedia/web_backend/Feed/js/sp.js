"use strict";



const SearchInputEle = document.getElementById("searchaction");
const SearchResultContainer = document.querySelector(".search-result-container");

let timer;
let DelayedTime = 1000;


SearchInputEle.addEventListener("keyup", function (event) {
    SearchResultContainer.innerHTML = "";
    if (SearchInputEle.value != "") {
        SearchResultContainer.classList.remove("src-hide");
        const loader = `<?xml version="1.0" encoding="utf-8"?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:10rem auto;display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#2b2b2b" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
        </circle>
        </svg>`;

        SearchResultContainer.insertAdjacentHTML("afterbegin", loader);
        clearTimeout(timer);
        timer = setTimeout(() => {
            nowtyped(event)
        }, DelayedTime);
    } else {
        SearchResultContainer.classList.add("src-hide");
    }
});


function nowtyped(e) {
    PollResults(e);
}

function PollResults(e) {
    const SearchedData = {
        SearchValue: e.target.value,
    };



    const data = JSON.stringify(SearchedData);
    const url = "../includes/searchprofile.php";
    const Options = {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Requested-With': 'SecuredConnectionOnly',
        },
        redirect: 'follow',
        referrerPolicy: 'strict-origin-when-cross-origin',
        body: data
    }

    const Responses = fetch(url, Options);

    Responses.then(function (response) {
        return response.text();
    }).then(function (data) {
        SearchResultContainer.innerHTML = data;
        SendRequests();
    });
}