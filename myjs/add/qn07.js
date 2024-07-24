const qn071 = document.getElementById("qn071");
const qn072 = document.getElementById("qn072");

const qn07_date_1 = document.getElementById("qn07_date_1");
const qn07_date = document.getElementById("qn07_date");


function toggleElementVisibility() {
  if (qn071.checked) {
    qn07_date_1.style.display = "block";
    qn07_date.setAttribute("required", "required");
  } else {
    qn07_date_1.style.display = "none";
    qn07_date.removeAttribute("required");
  }
}

qn071.addEventListener("change", toggleElementVisibility);
qn072.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
