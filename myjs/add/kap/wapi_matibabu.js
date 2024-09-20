const wapi_matibabu1 = document.getElementById("wapi_matibabu1");
const wapi_matibabu2 = document.getElementById("wapi_matibabu2");
const wapi_matibabu3 = document.getElementById("wapi_matibabu3");
const wapi_matibabu4 = document.getElementById("wapi_matibabu4");
const wapi_matibabu5 = document.getElementById("wapi_matibabu5");
const wapi_matibabu6 = document.getElementById("wapi_matibabu6");
const wapi_matibabu99 = document.getElementById("wapi_matibabu99");
const wapi_matibabu96 = document.getElementById("wapi_matibabu96");

const wapi_matibabu_other = document.getElementById("wapi_matibabu_other");

function toggleElementVisibility() {
  if (wapi_matibabu96.checked) {
    wapi_matibabu_other.style.display = "block";
  } else {
    wapi_matibabu_other.style.display = "none";
  }
}

wapi_matibabu1.addEventListener("change", toggleElementVisibility);
wapi_matibabu2.addEventListener("change", toggleElementVisibility);
wapi_matibabu3.addEventListener("change", toggleElementVisibility);
wapi_matibabu4.addEventListener("change", toggleElementVisibility);
wapi_matibabu5.addEventListener("change", toggleElementVisibility);
wapi_matibabu6.addEventListener("change", toggleElementVisibility);
wapi_matibabu99.addEventListener("change", toggleElementVisibility);
wapi_matibabu96.addEventListener("change", toggleElementVisibility);



// Initial check
toggleElementVisibility();
