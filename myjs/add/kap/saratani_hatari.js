const saratani_hatari96 = document.getElementById("saratani_hatari96");
const saratani_hatari_other = document.getElementById("saratani_hatari_other");

saratani_hatari96.addEventListener("change", function () {
  if (this.checked) {
    saratani_hatari_other.style.display = "block";
  } else {
    saratani_hatari_other.style.display = "none";
  }
});

// Initial check
if (saratani_hatari96.checked) {
  saratani_hatari_other.style.display = "block";
} else {
  saratani_hatari_other.style.display = "none";
}
