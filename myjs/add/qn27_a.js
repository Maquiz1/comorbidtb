const qn27_a1 = document.getElementById("qn27_a1");
const qn27_a2 = document.getElementById("qn27_a2");

const qn27 = document.getElementById("qn27");
const qn27_1 = document.getElementById("qn271");

const qn28 = document.getElementById("qn28");
const qn28_1 = document.getElementById("qn281");

function toggleElementVisibility() {
  if (qn27_a1.checked) {
    qn27.style.display = "block";
    qn27_1.setAttribute("required", "required");
    qn28.style.display = "block";
    qn28_1.setAttribute("required", "required");
  } else {
    qn27.style.display = "none";
    qn27_1.removeAttribute("required");
    qn28.style.display = "none";
    qn28_1.removeAttribute("required");
  }
}

qn27_a1.addEventListener("change", toggleElementVisibility);
qn27_a2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
