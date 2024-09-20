const saratani_vipimo = document.getElementById("saratani_vipimo");
const saratani_vipimo_other = document.getElementById("saratani_vipimo_other");

saratani_vipimo.addEventListener("change", function () {
  if (this.checked) {
    saratani_vipimo_other.style.display = "block";
  } else {
    saratani_vipimo_other.style.display = "none";
  }
});

// Initial check
if (saratani_vipimo.checked) {
  saratani_vipimo_other.style.display = "block";
} else {
  saratani_vipimo_other.style.display = "none";
}





