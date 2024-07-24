const qn621 = document.getElementById("qn621");
const qn622 = document.getElementById("qn622");

const qn62_i_1 = document.getElementById("qn62_i_1");
const qn62_i = document.getElementById("qn62_i");

function toggleElementVisibility() {
  if (qn621.checked) {
    qn62_i_1.style.display = "block";
    qn62_i.setAttribute("required", "required");
  } else {
    qn62_i_1.style.display = "none";
    qn62_i.removeAttribute("required");
  }
}

qn621.addEventListener("change", toggleElementVisibility);
qn622.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
