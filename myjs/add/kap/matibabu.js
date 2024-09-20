const matibabu = document.getElementById("matibabu");
const matibabu_other = document.getElementById("matibabu_other");

matibabu.addEventListener("change", function () {
  if (this.checked) {
    matibabu_other.style.display = "block";
  } else {
    matibabu_other.style.display = "none";
  }
});

// Initial check
if (matibabu.checked) {
  matibabu_other.style.display = "block";
} else {
  matibabu_other.style.display = "none";
}





