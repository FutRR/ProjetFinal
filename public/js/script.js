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
