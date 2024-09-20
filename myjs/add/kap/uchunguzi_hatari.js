const uchunguzi_hatari1 = document.getElementById("uchunguzi_hatari1");
const uchunguzi_hatari2 = document.getElementById("uchunguzi_hatari2");
const uchunguzi_hatari99 = document.getElementById("uchunguzi_hatari99");

const saratani_hatari = document.getElementById("saratani_hatari");

function toggleElementVisibility() {
  if (uchunguzi_hatari1.checked) {
    saratani_hatari.style.display = "block";
  } else {
    saratani_hatari.style.display = "none";
  }
}

uchunguzi_hatari1.addEventListener("change", toggleElementVisibility);
uchunguzi_hatari2.addEventListener("change", toggleElementVisibility);
uchunguzi_hatari99.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
