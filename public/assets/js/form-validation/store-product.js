document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("store-product-form");
    const preloader = document.querySelector(".preloader");
    const saveProloader = document.querySelector(".save-loader");
    const submitButton = document.getElementById("submit-button");
    const btnText = document.getElementById("save");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        // productName.disabled = true;
        submitButton.disabled = true;
        // Show the preloader
        preloader.style.display = "inline-block";

        btnText.textContent = "Saving...";
        // Serialize form data
        const formData = new FormData(form);

        // Make an AJAX request
        fetch(form.action, {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (response.ok) {
                    // Hide the preloader (optional)
                    preloader.style.display = "none";
                    saveProloader.style.display = "inline-block";
                    btnText.textContent = "Saved successfully";
                    // Display success message using SweetAlert
                    location.reload();
                } else {
                    // Form submission failed
                    // Hide the preloader
                    preloader.style.display = "none";

                    // Display error message using SweetAlert
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "This product has already been added, Please try another.",
                    }).then(() => {
                        form.reset();
                        btnText.textContent = "Save";
                        submitButton.disabled = false;
                    });

                }
            })
            .catch((error) => {
                // Error occurred during the AJAX request
                console.error("Error:", error);
                // Hide the preloader
                preloader.style.display = "none";
            });
    });
});
