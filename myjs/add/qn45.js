const qn6596 = document.getElementById("qn6596");
const qn65_other1 = document.getElementById("qn65_other1");

qn6596.addEventListener("change", function () {
  if (this.checked) {
    qn65_other1.style.display = "block";
  } else {
    qn65_other1.style.display = "none";
  }
});

// Initial check
if (qn6596.checked) {
  qn65_other1.style.display = "block";
} else {
  qn65_other1.style.display = "none";
}
