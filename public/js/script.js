const body = document.querySelector("body");

// MENU BURGER
const menuburger = document.querySelector(".menuburger");
const navlinks = document.querySelector(".nav-links");
const line = document.querySelector(".line");
const main = document.querySelector("main");
const logo = document.querySelector(".logo");

function menuChange(x) {
  x.classList.toggle("change");
  navlinks.classList.toggle("mobile-menu");
  line.classList.toggle("line-change");
  main.classList.toggle("blur");
  logo.classList.toggle("blur");
}

// TEXTAREA RESIZE
function textAreaAdjust(element) {
  element.style.height = "1px";
  element.style.height = 25 + element.scrollHeight + "px";
}

//Etape fini modal
const modalEtape = document.getElementById("modal-etape");
const openModalEtape = document.getElementById("open-btn-etape");
const closeModalEtape = document.getElementById("close-btn-etape");

openModalEtape.addEventListener("click", () => {
  body.classList.toggle("blur");
  modalEtape.showModal();
});

closeModalEtape.addEventListener("click", () => {
  body.classList.toggle("blur");
  modalEtape.close();
});

//Post delete modal
const modalPost = document.getElementById("modal-post");
const openModalPost = document.getElementById("open-btn-post");
const closeModalPost = document.getElementById("close-btn-post");

openModalPost.addEventListener("click", () => {
  body.classList.toggle("blur");
  modalPost.showModal();
});

closeModalPost.addEventListener("click", () => {
  body.classList.toggle("blur");
  modalPost.close();
});

//Post reply
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

//Replied-to post color
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
