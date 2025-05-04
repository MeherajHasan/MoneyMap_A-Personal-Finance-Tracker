const backToHomeBtn = document.getElementById("back-to-home");

backToHomeBtn.addEventListener("click", function (e) {
  e.preventDefault();
  window.location.href = "../../../public/index.html";
});