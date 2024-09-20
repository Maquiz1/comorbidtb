const qn251 = document.getElementById("qn251");
const qn252 = document.getElementById("qn252");

const qn25_idadi = document.getElementById("qn25_idadi");

function toggleElementVisibility() {
  if (qn251.checked) {
    qn25_idadi.style.display = "block";
    qn25_idadi.setAttribute("required", "required");
  } else {
    qn25_idadi.style.display = "none";
    qn25_idadi.removeAttribute("required");
  }
}

qn251.addEventListener("change", toggleElementVisibility);
qn252.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
