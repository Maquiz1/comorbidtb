const uchunguzi_faida1 = document.getElementById("uchunguzi_faida1");
const uchunguzi_faida2 = document.getElementById("uchunguzi_faida2");
const uchunguzi_faida3 = document.getElementById("uchunguzi_faida3");
const uchunguzi_faida99 = document.getElementById("uchunguzi_faida99");
const uchunguzi_faida96 = document.getElementById("uchunguzi_faida96");

const uchunguzi_faida_other = document.getElementById("uchunguzi_faida_other");

function toggleElementVisibility() {
  if (uchunguzi_faida96.checked) {
    uchunguzi_faida_other.style.display = "block";
  } else {
    uchunguzi_faida_other.style.display = "none";
  }
}

uchunguzi_faida1.addEventListener("change", toggleElementVisibility);
uchunguzi_faida2.addEventListener("change", toggleElementVisibility);
uchunguzi_faida3.addEventListener("change", toggleElementVisibility);
uchunguzi_faida99.addEventListener("change", toggleElementVisibility);
uchunguzi_faida96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
