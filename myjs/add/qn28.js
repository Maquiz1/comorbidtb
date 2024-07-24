const qn281 = document.getElementById("qn281");
const qn282 = document.getElementById("qn282");

const qn28_idadi = document.getElementById("qn28_idadi");

function toggleElementVisibility() {
  if (qn281.checked) {
    qn28_idadi.style.display = "block";
    qn28_idadi.setAttribute("required", "required");
  } else {
    qn28_idadi.style.display = "none";
    qn28_idadi.removeAttribute("required");
  }
}

qn281.addEventListener("change", toggleElementVisibility);
qn282.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
