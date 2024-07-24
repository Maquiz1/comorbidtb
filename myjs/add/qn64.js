const qn641 = document.getElementById("qn641");
const qn642 = document.getElementById("qn642");

const qn65 = document.getElementById("qn65");
const qn651 = document.getElementById("qn651");

function toggleElementVisibility() {
  if (qn641.checked) {
    qn65.style.display = "block";
    qn651.setAttribute("required", "required");
  } else {
    qn65.style.display = "none";
    qn651.removeAttribute("required");
  }
}

qn641.addEventListener("change", toggleElementVisibility);
qn642.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
