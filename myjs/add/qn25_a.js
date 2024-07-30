const qn25_a1 = document.getElementById("qn25_a1");
const qn25_a2 = document.getElementById("qn25_a2");

const qn25 = document.getElementById("qn25");
const qn25_1 = document.getElementById("qn251");

const qn26 = document.getElementById("qn26");
const qn26_1 = document.getElementById("qn261");

function toggleElementVisibility() {
  if (qn25_a1.checked) {
    qn25.style.display = "block";
    qn25_1.setAttribute("required", "required");
    qn26.style.display = "block";
    qn26_1.setAttribute("required", "required");
  } else {
    qn25.style.display = "none";
    qn25_1.removeAttribute("required");
    qn26.style.display = "none";
    qn26_1.removeAttribute("required");
  }
}

qn25_a1.addEventListener("change", toggleElementVisibility);
qn25_a2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
