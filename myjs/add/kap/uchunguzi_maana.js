const uchunguzi_maana1 = document.getElementById("uchunguzi_maana1");
const uchunguzi_maana2 = document.getElementById("uchunguzi_maana2");
const uchunguzi_maana3 = document.getElementById("uchunguzi_maana3");
const uchunguzi_maana99 = document.getElementById("uchunguzi_maana99");
const uchunguzi_maana96 = document.getElementById("uchunguzi_maana96");

const uchunguzi_maana_other = document.getElementById("uchunguzi_maana_other");

function toggleElementVisibility() {
  if (uchunguzi_maana96.checked) {
    uchunguzi_maana_other.style.display = "block";
  } else {
    uchunguzi_maana_other.style.display = "none";
  }
}

uchunguzi_maana1.addEventListener("change", toggleElementVisibility);
uchunguzi_maana2.addEventListener("change", toggleElementVisibility);
uchunguzi_maana3.addEventListener("change", toggleElementVisibility);
uchunguzi_maana99.addEventListener("change", toggleElementVisibility);
uchunguzi_maana96.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
