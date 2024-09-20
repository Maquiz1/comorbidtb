const insurance_name1 = document.getElementById("insurance_name1");
const insurance_name2 = document.getElementById("insurance_name2");
const insurance_name3 = document.getElementById("insurance_name3");
const insurance_name96 = document.getElementById("insurance_name96");
const insurance_name_other = document.getElementById("insurance_name_other");


function toggleElementVisibility() {
  if (insurance_name96.checked) {
    // console.log(insurance_name96);

    insurance_name_other.style.display = "block";
  } else {
    insurance_name_other.style.display = "none";
  }
}

insurance_name1.addEventListener("change", toggleElementVisibility);
insurance_name2.addEventListener("change", toggleElementVisibility);
insurance_name3.addEventListener("change", toggleElementVisibility);
insurance_name96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();