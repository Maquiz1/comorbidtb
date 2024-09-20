const ushawishi = document.getElementById("ushawishi");
const ushawishi_other = document.getElementById("ushawishi_other");

ushawishi.addEventListener("change", function () {
  if (this.checked) {
    ushawishi_other.style.display = "block";
  } else {
    ushawishi_other.style.display = "none";
  }
});

// Initial check
if (ushawishi.checked) {
  ushawishi_other.style.display = "block";
} else {
  ushawishi_other.style.display = "none";
}







