const kundi = document.getElementById("kundi");
const kundi_other = document.getElementById("kundi_other");

kundi.addEventListener("change", function () {
  if (this.checked) {
    kundi_other.style.display = "block";
  } else {
    kundi_other.style.display = "none";
  }
});

// Initial check
if (kundi.checked) {
  kundi_other.style.display = "block";
} else {
  kundi_other.style.display = "none";
}


