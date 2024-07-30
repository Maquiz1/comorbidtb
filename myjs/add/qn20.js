const qn20_1 = document.getElementById("qn201");
const qn20_2 = document.getElementById("qn202");

const qn21_1 = document.getElementById("qn21");
const qn21_1_1 = document.getElementById("qn211");

function toggleElementVisibility() {
  if (qn20_1.checked) {
    qn21_1.style.display = "block";
    qn21_1_1.setAttribute("required", "required");
  } else {
    qn21_1.style.display = "none";
    qn21_1_1.removeAttribute("required");
  }
}

qn20_1.addEventListener("change", toggleElementVisibility);
qn20_2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
