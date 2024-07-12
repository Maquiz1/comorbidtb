const conset1 = document.getElementById("conset1");
const conset2 = document.getElementById("conset2");

const conset_date1 = document.getElementById("conset_date1");
const conset_date = document.getElementById("conset_date");

const adress1 = document.getElementById("adress1");
const adress = document.getElementById("adress");
const region = document.getElementById("region");
const district = document.getElementById("district");
const ward = document.getElementById("ward");

const other_details = document.getElementById("other_details");
const education = document.getElementById("education");
const marital_status = document.getElementById("marital_status");
const occupation = document.getElementById("occupation");

const sex = document.getElementById("sex");
const sex1 = document.getElementById("sex1");
const dob1 = document.getElementById("dob1");
const dob = document.getElementById("dob");

function toggleElementVisibility() {
  if (conset1.checked) {
    conset_date1.style.display = "block";
    conset_date.style.display = "block";
    conset_date.setAttribute("required", "required");
    adress1.style.display = "block";
    adress.style.display = "block";
    region.setAttribute("required", "required");
    district.setAttribute("required", "required");
    ward.setAttribute("required", "required");
    other_details.style.display = "block";
    education.setAttribute("required", "required");
    marital_status.setAttribute("required", "required");
    occupation.setAttribute("required", "required");
    sex.style.display = "block";
    sex1.setAttribute("required", "required");
    dob1.style.display = "block";
    dob.setAttribute("required", "required");
  } else {
    conset_date1.style.display = "none";
    conset_date.style.display = "none";
    conset_date.removeAttribute("required");
    adress1.style.display = "none";
    adress.style.display = "none";
    region.removeAttribute("required");
    district.removeAttribute("required");
    ward.removeAttribute("required");
    other_details.style.display = "none";
    education.removeAttribute("required");
    marital_status.removeAttribute("required");
    occupation.removeAttribute("required");
    sex.removeAttribute("required");
    sex1.style.display = "none";
    dob1.removeAttribute("required");
    dob.style.display = "none";
  }
}

conset1.addEventListener("change", toggleElementVisibility);
conset2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
