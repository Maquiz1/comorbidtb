const qn271 = document.getElementById("qn271");
const qn272 = document.getElementById("qn272");

const qn27_idadi = document.getElementById("qn27_idadi");

function toggleElementVisibility() {
  if (qn271.checked) {
    qn27_idadi.style.display = "block";
    qn27_idadi.setAttribute("required", "required");
  } else {
    qn27_idadi.style.display = "none";
    qn27_idadi.removeAttribute("required");
  }
}

qn271.addEventListener("change", toggleElementVisibility);
qn272.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
