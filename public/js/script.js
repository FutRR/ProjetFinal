const modal = document.querySelector(".modal");
const openModal = document.querySelector(".open-btn");
const closeModal = document.querySelector(".close-btn");
const body = document.querySelector("body");

openModal.addEventListener("click", () => {
  body.classList.toggle("blur");
  modal.showModal();
});

closeModal.addEventListener("click", () => {
  body.classList.toggle("blur");
  modal.close();
});

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
