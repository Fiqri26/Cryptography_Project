const searchBtn = document.getElementById("searchBtn");
const errorAlert = document.getElementById("errorAlert");
const pdfContainer = document.getElementById("pdfContainer");
const closeAlert = document.querySelector(".close-alert");

searchBtn.addEventListener("click", () => {

    const participantName =
        document.getElementById("participantName")
        .value
        .trim()
        .toLowerCase();

    const trainingName =
        document.getElementById("trainingName")
        .value
        .trim()
        .toLowerCase();

    errorAlert.classList.remove("show");
    pdfContainer.classList.remove("show");

    if (
        participantName === "budi" &&
        trainingName === "web development"
    ) {
        pdfContainer.classList.add("show");
    } else {
        errorAlert.classList.add("show");
    }
});

closeAlert.addEventListener("click", () => {
    errorAlert.classList.remove("show");
});
