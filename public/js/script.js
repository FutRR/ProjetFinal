const body = document.querySelector("body");

// MENU BURGER
const menuburger = document.querySelector(".menuburger");
const navlinks = document.querySelector(".nav-links");
const line = document.querySelector(".line");
const main = document.querySelector("main");
const navTitle = document.querySelector(".nav-title");
const logo = document.querySelector(".logo");
let hasToggle = false;

function menuChange(x) {
  x.classList.toggle("change");
  navlinks.classList.toggle("mobile-menu");
  line.classList.toggle("line-change");
  main.classList.toggle("blur");
  logo.classList.toggle("blur");
  if (!hasToggle) {
    setTimeout(() => {
      navTitle.classList.toggle("display");
      hasToggle = !hasToggle;
    }, 1000);
  } else {
    navTitle.classList.toggle("display");
  }
}

// TEXTAREA RESIZE
function textAreaAdjust(element) {
  element.style.height = "1px";
  element.style.height = 25 + element.scrollHeight + "px";
}

//MODAL GESTION
const modals = document.querySelectorAll(".modal");
const openModals = document.querySelectorAll(".open-btn");
const closeModals = document.querySelectorAll(".close-btn");

openModals.forEach((btn, index) => {
  btn.addEventListener("click", function () {
    body.classList.toggle("blur");
    modals[index].showModal();
  });
});

closeModals.forEach((btn, index) => {
  btn.addEventListener("click", () => {
    body.classList.toggle("blur");
    modals[index].close();
  });
});

//POST REPLY
document.addEventListener("DOMContentLoaded", function () {
  const replyButtons = document.querySelectorAll(".reponse-btn");

  replyButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const postId = this.getAttribute("data-post-id");
      const replyForm = document.getElementById(`reponse-form-${postId}`);

      if (replyForm.style.display === "none") {
        replyForm.style.display = "block";
      } else {
        replyForm.style.display = "none";
      }
    });
  });
});

//REPLIED-TO POST COLOR
document.addEventListener("DOMContentLoaded", function () {
  const replyToLink = document.querySelectorAll(".respond-to-link");
  replyToLink.forEach((button) => {
    button.addEventListener("click", function () {
      const replyTo = this.getAttribute("data-reply-id");
      const post = document.getElementById(`${replyTo}`);

      post.classList.add("temp-color");

      setTimeout(() => {
        post.classList.remove("temp-color");
        post.classList.add("reply-link");

        setTimeout(() => {
          post.classList.remove("reply-link");
        }, 1000);
      }, 10);
    });
  });
});
