import "../styles/main.scss";

const $ = (selector) => document.querySelector(selector);
const create = (element) => document.createElement(element);
const docLoc = "https://raw.githubusercontent.com/codidact/docs/master/User-Help/CodidactMainPageFAQ.md";
const emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

$(".js-email-input").addEventListener("keyup", (e) => {
    const email = e.target.value;
    if (!emailRegex.test(email)) {
        $(".js-form-response").textContent = "Please enter a valid email";
        $(".js-submit-button").disabled = true;
    } else {
        $(".js-form-response").textContent = "";
        $(".js-submit-button").disabled = false;
    }
});

$(".js-form").addEventListener("submit", (ev) => {
    const email = $(".js-email-input").value;
    if (!emailRegex.test(email)) {
        $(".js-form-response").textContent = "Please enter a valid email";
        $(".js-submit-button").disabled = true;
        ev.preventDefault();
        return false;
    } else {
        $(".js-form-response").textContent = "";
        $(".js-submit-button").disabled = false;
        let httpRequest;
        if (window.XMLHttpRequest) {
            httpRequest = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        httpRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                $(".js-form-response").innerHTML = this.responseText;
            }
            $(".loader").style.display = "none";
        };
        httpRequest.open("POST", "subscribe.php", true);
        httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        httpRequest.send("mail_input=" + email);
        $(".loader").style.display = "block";
    }
});

function parseMD(input) {
    const converter = new showdown.Converter();
    return converter.makeHtml(input);
}

const docReq = new XMLHttpRequest();

docReq.onreadystatechange = (data) => {
    if (data.target.readyState !== 4) {
        return;
    }

    let parsed = parseMD(data.target.responseText);
    const parser = new DOMParser();
    let htmlDoc = parser.parseFromString(parsed, "text/html");
    [...htmlDoc.querySelectorAll("h2")].forEach((question) => {
        const faqDiv = $("div#faq");
        const div = create("div");
        div.className = "question";
        const questionHeading = create("h2");
        questionHeading.innerHTML = question.innerHTML;
        questionHeading.className = "heading--secondary";
        const button = create("button");
        const image = create("img");
        image.setAttribute("alt", "Arrow down");
        image.src = "assets/img/3rd-party/arrow.svg";
        button.append(image);
        button.setAttribute("label", "Show answer");
        const answer = create("div");
        answer.className = "question--answer";
        button.addEventListener("click", () => {
            if (answer.classList.contains("show")) {
                answer.classList.remove("show");
                button.classList.remove("opened");
            } else {
                answer.classList.add("show");
                button.classList.add("opened");
            }
        });
        div.append(questionHeading);
        div.append(button);
        answer.innerHTML = `<p> ${question.nextElementSibling.innerHTML} </p>`;
        div.append(answer);
        faqDiv.appendChild(div);
    });
};

docReq.open("GET", docLoc);
docReq.send();
