const storeSelect = document.getElementById("store");
const submitButton = document.getElementById("submit");

storeSelect.onclick = (e) => {
    console.log("selected");
    e.preventDefault();
    if (storeSelect.selectedIndex !== 0) {
        submitButton.disabled = false;
    }
}