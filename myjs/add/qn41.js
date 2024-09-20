const qn411 = document.getElementById("qn411");
const qn412 = document.getElementById("qn412");

const qn42 = document.getElementById("qn42");
const qn421 = document.getElementById("qn421");

const qn43 = document.getElementById("qn43");
const qn431 = document.getElementById("qn431");

const qn44 = document.getElementById("qn44");
const qn441 = document.getElementById("qn441");

function toggleElementVisibility() {
  if (qn411.checked) {
    qn42.style.display = "block";
    qn421.setAttribute("required", "required");
    qn43.style.display = "block";
    qn431.setAttribute("required", "required");
    qn44.style.display = "block";
    qn421.setAttribute("required", "required");
  } else {
    qn42.style.display = "none";
    qn421.removeAttribute("required");
    qn43.style.display = "none";
    qn431.removeAttribute("required");
    qn44.style.display = "none";
    qn441.removeAttribute("required");
  }
}

qn411.addEventListener("change", toggleElementVisibility);
qn412.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
