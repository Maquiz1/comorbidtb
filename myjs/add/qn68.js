const qn681 = document.getElementById("qn681");
const qn682 = document.getElementById("qn682");

const qn69 = document.getElementById("qn69");

function toggleElementVisibility() {
  if (qn681.checked) {
    qn69.style.display = "block";
  } else {
    qn69.style.display = "none";
  }
}

qn681.addEventListener("change", toggleElementVisibility);
qn682.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
