const qn10_1 = document.getElementById("qn101");
const qn102 = document.getElementById("qn102");

const qn10_miaka_1 = document.getElementById("qn10_miaka_1");
const qn10_miaka = document.getElementById("qn10_miaka");

function toggleElementVisibility() {
  if (qn10_1.checked) {
    qn10_miaka_1.style.display = "block";
    qn10_miaka.setAttribute("required", "required");
  } else {
    qn10_miaka_1.style.display = "none";
    qn10_miaka.removeAttribute("required");
  }
}

qn10_1.addEventListener("change", toggleElementVisibility);
qn102.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
