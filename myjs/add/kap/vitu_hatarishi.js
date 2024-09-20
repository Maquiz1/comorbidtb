const vitu_hatarishi = document.getElementById("vitu_hatarishi");
const vitu_hatarishi_other = document.getElementById("vitu_hatarishi_other");

vitu_hatarishi.addEventListener("change", function () {
  if (this.checked) {
    vitu_hatarishi_other.style.display = "block";
  } else {
    vitu_hatarishi_other.style.display = "none";
  }
});

// Initial check
if (vitu_hatarishi.checked) {
  vitu_hatarishi_other.style.display = "block";
} else {
  vitu_hatarishi_other.style.display = "none";
}
