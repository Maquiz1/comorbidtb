const qn18_1 = document.getElementById("qn18");
const qn18_2 = document.getElementById("qn181");

const qn19 = document.getElementById("qn19");
const qn191 = document.getElementById("qn191");

function toggleElementVisibility() {
  if (qn18_1.checked) {
    qn19.style.display = "block";
    qn191.setAttribute("required", "required");
  } else {
    qn19.style.display = "none";
    qn191.removeAttribute("required");
  }
}

qn18_1.addEventListener("change", toggleElementVisibility);
qn18_2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
