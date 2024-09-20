const qn611 = document.getElementById("qn611");
const qn612 = document.getElementById("qn612");

const qn61_date_1 = document.getElementById("qn61_date_1");
const qn61_date = document.getElementById("qn61_date");

function toggleElementVisibility() {
  if (qn611.checked) {
    qn61_date_1.style.display = "block";
    qn61_date.setAttribute("required", "required");
  } else {
    qn61_date_1.style.display = "none";
    qn61_date.removeAttribute("required");
  }
}

qn611.addEventListener("change", toggleElementVisibility);
qn612.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
