const qn451 = document.getElementById("qn451");
const qn452 = document.getElementById("qn452");

const qn46 = document.getElementById("qn46");
const qn461 = document.getElementById("qn461");

const qn47 = document.getElementById("qn47");
const qn471 = document.getElementById("qn471");

const qn48 = document.getElementById("qn48");
const qn481 = document.getElementById("qn481");

function toggleElementVisibility() {
  if (qn451.checked) {
    qn46.style.display = "block";
    qn461.setAttribute("required", "required");
    qn47.style.display = "block";
    qn471.setAttribute("required", "required");
    qn48.style.display = "block";
    qn461.setAttribute("required", "required");
  } else {
    qn46.style.display = "none";
    qn461.removeAttribute("required");
    qn47.style.display = "none";
    qn471.removeAttribute("required");
    qn48.style.display = "none";
    qn481.removeAttribute("required");
  }
}

qn451.addEventListener("change", toggleElementVisibility);
qn452.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
