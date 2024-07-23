const qn661 = document.getElementById("qn661");
const qn67 = document.getElementById("qn67");

qn661.addEventListener("change", function () {
  if (this.checked) {
    qn67.style.display = "block";
  } else {
    qn67.style.display = "none";
  }
});

// Initial check
if (qn661.checked) {
  qn67.style.display = "block";
} else {
  qn67.style.display = "none";
}
