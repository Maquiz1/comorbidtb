const qn261 = document.getElementById("qn261");
const qn262 = document.getElementById("qn262");
const qn263 = document.getElementById("qn263");


const qn26_idadi = document.getElementById("qn26_idadi");

function toggleElementVisibility() {
  if (qn261.checked) {
    qn26_idadi.style.display = "block";
    qn26_idadi.setAttribute("required", "required");
  } else {
    qn26_idadi.style.display = "none";
    qn26_idadi.removeAttribute("required");
  }
}

qn261.addEventListener("change", toggleElementVisibility);
qn262.addEventListener("change", toggleElementVisibility);
qn263.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
