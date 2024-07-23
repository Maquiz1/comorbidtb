const qn661 = document.getElementById("qn661");
const qn662 = document.getElementById("qn662");

const qn67 = document.getElementById("qn67");


function toggleElementVisibility() {
  if (qn661.checked) {
    qn67.style.display = "block";
  } else {
    qn67.style.display = "none";
  }
}

qn661.addEventListener("change", toggleElementVisibility);
qn662.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();

